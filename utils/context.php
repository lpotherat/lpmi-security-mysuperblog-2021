<?php 
require_once __DIR__.'/../repositories/author_repository.php';

/**
 * Contexte d'execution de l'application
 * 
 */
class context {
    /**
     * Connecteur de base de données
     * @var PDO $db 
     */
    public $db;
    
    /**
     * Initialise l'application avec les paramètres de configuration $config
     */
    public function initApp(array $config):void{
        if(!is_dir($config['session.save_path'])){
            mkdir($config['session.save_path'],0755);
        }
        ini_set('session.save_path', $config['session.save_path']);
        $this->connectDb($config['db-filename']);
    }

    /**
     * Connecte la base données
     */
    private function connectDb($connectionString):void{
        //Open database connection
        $db = new \PDO($connectionString);
        //Check database version
        $dbVersion = intval($db->query('PRAGMA user_version')->fetchColumn());

        if($dbVersion < 1){
            try {
                $db->query('CREATE TABLE "category" (
                    "id"	INTEGER NOT NULL,
                    "name"	TEXT,
                    PRIMARY KEY("id" AUTOINCREMENT)
                );');
                $db->query('CREATE TABLE "author" (
                    "id"	INTEGER NOT NULL,
                    "login" TEXT NOT NULL,
                    "password" TEXT NOT NULL,
                    "firstname"	TEXT NOT NULL,
                    "lastname"	TEXT NOT NULL,
                    "role"	TEXT NOT NULL,
                    PRIMARY KEY("id" AUTOINCREMENT)
                )');
                $db->query ('CREATE TABLE "post" (
                    "id"	INTEGER NOT NULL,
                    "title"	TEXT,
                    "content"	TEXT,
                    "status"	TEXT,
                    "authorId"	INTEGER NOT NULL,
                    "categoryId"	INTEGER DEFAULT NULL,
                    PRIMARY KEY("id" AUTOINCREMENT)
                )');
                $db->query ('CREATE TABLE "comment" (
                    "id"	INTEGER NOT NULL,
                    "dateAdded"	INTEGER,
                    "commenter" TEXT,
                    "content"	TEXT,
                    "approved"	INTEGER NOT NULL DEFAULT 0,
                    "postId"	INTEGER NOT NULL,
                    PRIMARY KEY("id" AUTOINCREMENT)
                )');

                $db->query('INSERT INTO author (login,password,firstname,lastname,role) VALUES ("admin","admin","Administrator","","admin")');

                $db->query('PRAGMA user_version = 1');
            } catch (\Throwable $th) {
                error_log($th->__toString());
                exit('impossible de créer la base de données');
            }
        }
        $this->db = $db;
    }

    /**
     * Vérifie si la session et démarrée, et la démarre si nécessaire
     */
    private function checkSession(){
        if(session_status() != PHP_SESSION_ACTIVE){
            session_start();
        }
    }

    /**
     * Indique si l'utilisateur est connecté
     */
    public function isLoggedIn(){
        $this->checkSession();
        return !empty($_SESSION['is_logged_in']);
    }

    /**
     * Connecte l'utilisateur
     */
    public function login($login,$password){
        $this->checkSession();
        
        $author_repo = new author_repository($this);
        $author_id = $author_repo->checkLogin($_POST['login'],$_POST['password']);
        $ok = !empty($author_id);
        if($ok){
            $_SESSION['is_logged_in'] = !empty($author_id);
            $_SESSION['author'] = $author_repo->getById($author_id);
        }
        return $ok;
    }

    /**
     * Déconnecte l'utilisateur
     */
    public function logout(){
        $this->checkSession();
        unset($_SESSION['author']);
        unset($_SESSION['is_logged_in']);
    }
}