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
$comments = $comment_repo->getAllComments();

?><html>
<body>
<a href="?f=post.php&id=<?php echo $_GET['id']?>">Retour au post</a>
<h1>Commentaires sur "<?php echo $post['title']?>" : </h1>
<?php if(!empty($comments)){ ?>
<table>
<thead>
    <tr>
        <th>Actions</th>
        <th>Auteur</th>
        <th>Commentaire</th>
    </tr>
</thead>
<tbody>
<?php 
    foreach($comments as $comment){
?>
    <tr>
        <td>
        <a href="?admin=1&f=comment_delete.php&id=<?php echo $comment['id']?>">Supprimer</a>
        <?php if (!$comment['approved']){?>
        <a href="?admin=1&f=comment_accept.php&id=<?php echo $comment['id']?>">Approuver</a>
        <?php } ?>
        </td>
        <td><?php echo $comment['commenter'] ?></td>
        <td><?php echo $comment['content'] ?></td>
    </tr>
<?php
    }
} else {
    ?><tr><td>Il n'y a aucun commentaire !</td></tr><?php
}
?>
</tbody>
</table>
</body>
</html>