<?php
require_once 'base_repository.php';

class comment_repository extends base_repository{

    public function getCommentsOfPost($postId):?array{
        return $this->queryToArray("SELECT * FROM comment WHERE postId = '$postId' ORDER BY dateAdded DESC");
    }

    public function getApprovedCommentsOfPost($postId):?array{
        return $this->queryToArray("SELECT * FROM comment WHERE postId = '$postId' AND approved = 1 ORDER BY dateAdded DESC");
    }

    public function getAllComments():array{
        return $this->queryToArray('SELECT * FROM comment ORDER BY dateAdded DESC');
    }
    public function getAllApprovedComments():array{
        return $this->queryToArray('SELECT * FROM comment WHERE approved = 1 ORDER BY dateAdded DESC');
    }

    public function getById(int $id):?array{
        return $this->queryToSingle("SELECT * FROM comment WHERE id = $id");
    }

    public function addComment(array $comment):?int{
        return $this->insert('comment',$comment) ?? null;
    }

    public function approveComment(int $id):void{
        $this->queryToSingle("UPDATE comment SET approved = 1 WHERE id = $id");
    }

    public function deleteComment(int $id):void{
        $this->delete('comment',$id);
    }

}