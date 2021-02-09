<?php 
if(!empty($_GET['id'])){
    require_once '../repositories/post_repository.php';
    $post_repo = new post_repository($context);
    $post_repo->deletePost(intval($_GET['id']));
    
    header('Location: ?admin=1&f=home.php');
    exit(); 
} else {
    header("HTTP/1.0 400 Bad Request");
    exit(); 
}
