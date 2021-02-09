<?php 
if(!empty($_GET['id'])){
    require_once '../repositories/comment_repository.php';
    $comment_repo = new comment_repository($context);
    $comment_repo->approveComment(intval($_GET['id']));
    
    $comment = $comment_repo->getById(intval($_GET['id']));

    header('Location: ?admin=1&f=post_review_comments.php&id='.$comment['postId']);
    exit(); 
} else {
    header("HTTP/1.0 400 Bad Request");
    exit(); 
}
