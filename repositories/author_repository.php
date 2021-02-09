<?php
require_once 'base_repository.php';

class author_repository extends base_repository{

    public function checkLogin($login,$password):int{
        return intval($this->queryToSingle("SELECT id FROM author WHERE login = '$login' AND password = '$password'")[0] ?? 0);
    }


    public function getById($id):?array{
        return $this->queryToSingle("SELECT * FROM author WHERE id = '$id'");
    }

}