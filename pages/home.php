<?php

require_once '../repositories/post_repository.php';

$post_repo = new post_repository($context);

$lastPost = $post_repo->getLastPost();
$posts = $post_repo->getAllPosts();

?><html>
<body>
<h1>Bienvenue sur mon super blog !</h1>
<form method="get"><input name="search" placeholder="rechercher"/>
<input type="hidden" name="f" value="search.php"/>
<input value="Go!" type="submit"/></form>
<?php if($lastPost != null){
    ?>
<h2>Dernier post : </h2>
<h4><?php echo $lastPost['title'];?></h4>
<p><?php echo $lastPost['content']?></p>
<hr/>
<h2>Tous les posts</h2>
<?php 
    foreach($posts as $post){
?>
<a href="?f=post.php&id=<?php echo $post['id']?>"><?php echo $post['title']?></a><br/>
<?php
    }
} else {
?>
Il n'y a encore aucun post, <a href="?admin=1&f=post_create.php">créez en un ici</a> !
<?php
}
?>
<a href="?admin=1&f=home.php" style="position:absolute;bottom:0;right:0;color:#eee">Admin</a>
</body>
</html>