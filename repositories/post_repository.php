<?php
require_once 'base_repository.php';

class post_repository extends base_repository{

    public function getLastPost():?array{
        return $this->queryToSingle('SELECT * FROM post ORDER BY id DESC LIMIT 1');
    }

    public function getAllPosts():array{
        return $this->queryToArray('SELECT * FROM post ORDER BY id ASC');
    }

    public function getById($id):?array{
        return $this->queryToSingle("SELECT * FROM post WHERE id = $id");
    }

    public function addPost(array $post):?int{
        return $this->insert('post',$post) ?? null;
    }
    public function updatePost(int $id,array $post):?int{
        return $this->update('post',$id,$post) ?? null;
    }
    public function deletePost(int $id):void{
        $this->delete('post',$id);
    }

    public static function statusToView(string $status){
        switch ($status){
            case 'draft':return 'Brouillon';
            case 'live':return 'Publié';
            default:return 'Inconnu';
        }
    }

}