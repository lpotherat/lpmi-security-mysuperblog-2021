<?php 
require_once '../repositories/post_repository.php';

$post_repo = new post_repository($context);

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

if(!empty($_POST['title']) && !empty($_POST['content'])){
    
    $post_repo->updatePost($_GET['id'],$_POST);
    header('Location: ?admin=1&f=home.php');    
}
?><html>
<body>
<h1>Modifier un  post : </h1>
<form method="post">
    <input type="hidden" name="authorId" value="<?php echo $post['authorId'] ?>" />
    <label>Status : <select name="status">
        <option value="draft"<?php if($post['status'] == 'draft'){?> selected<?php }?>><?php echo post_repository::statusToView('draft') ?></option>
        <option value="live"<?php if($post['status'] == 'live'){?> selected<?php }?>><?php echo post_repository::statusToView('live') ?></option>
    </select></label><br/>
    <label>Titre : <input name="title" value="<?php echo $post['title']?>" /></label><br/>
    <label>Contenu : <br/>
    <textarea name="content" cols="50" rows="20"><?php echo $post['content']?></textarea>
    </label> <br/> 
    <input type="submit"/>
</form>
</body>
</html>