<?php

require_once '../repositories/post_repository.php';

$post_repo = new post_repository($context);

$posts = $post_repo->getAllPosts();

?><html>
<body>
<h1>Administration</h1>
<a href="?f=home.php">Retour au site</a><br/>
<a href="?admin=1&f=logout.php">Déconnexion</a><br/>
<a href="?admin=1&f=post_create.php">Créer un post</a><br/>
<hr/>
<?php if(!empty($posts)){ ?>
<table>
<thead>
    <tr>
        <th>Actions</th>
        <th>Id</th>
        <th>Titre</th>
        <th>Status</th>
    </tr>
</thead>
<tbody>
<?php 
    foreach($posts as $post){
?>
    <tr>
        <td>
        <a href="?admin=1&f=post_delete.php&id=<?php echo $post['id']?>">Supprimer</a>
        <a href="?admin=1&f=post_edit.php&id=<?php echo $post['id']?>">Modifier</a>
        <a href="?admin=1&f=post_review_comments.php&id=<?php echo $post['id']?>">Commentaires</a>
        </td>
        <td><?php echo $post['id'] ?></td>
        <td><?php echo $post['title'] ?></td>
        <td><?php echo post_repository::statusToView($post['status']) ?></td>
    </tr>
<?php
    }
} else {
    ?><tr><td>Il n'y a aucun post !</td></tr><?php
}
?>
</tbody>
</table>

</body>
</html>