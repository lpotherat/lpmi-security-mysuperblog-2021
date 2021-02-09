<?php
require_once '../repositories/post_repository.php';
require_once '../repositories/comment_repository.php';
$post_repo = new post_repository($context);
$comment_repo = new comment_repository($context);

if(!empty($_GET['id'])){
    $post = $post_repo->getById($_GET['id']);
    if(empty($post)){
        header('HTTP/1.0 404 Not Found');
        exit();
    }
} else {
    header('HTTP/1.0 400 Bad Request');
    exit();
}

if(!empty($_POST['commenter']) && !empty($_POST['content'])){
    $comment_repo->addComment($_POST);
    header('Location: ?f=post.php&id='.$_GET['id']);
    exit();
}

$comments = $comment_repo->getApprovedCommentsOfPost($_GET['id']);

?>
<html>
<body></body>
<a href="?f=home.php">Retour à l'accueil</a><br/>
<h1><?php echo $post['title'] ?></h1>
<p><?php echo $post['content'] ?></p>
<hr/>
<h2>Comments</h2>
<?php 
if(empty($comments)){
?>Il n'y a pas encore de commentaires :( <br/> Soit le premier !<?php
}
foreach($comments as $comment){
?>
<div style="border-bottom:1px black dotted">
<span>De la part de : <?php echo htmlentities($comment['commenter'])?> le <?php echo $comment['dateAdded'] ?></span>
<p><?php echo htmlentities($comment['content'])?></p>
</div>
<?php
}
?>
<h3>Ajoute ton commentaire !</h3>
<form method="post">
<input type="hidden" name="dateAdded" value="<?php echo date('Y-m-d H:i:s')?>"/>
<input type="hidden" name="postId" value="<?php echo $_GET['id']?>"/>
<input placeholder="Ton nom" name="commenter" /><br/>
<textarea name="content" placeholder="Ton avis !"></textarea><br/>
<input type="submit"/>
</form>
</html>