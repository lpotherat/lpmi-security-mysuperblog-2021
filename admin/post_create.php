<?php 
require_once '../repositories/post_repository.php';
if(!empty($_POST['title']) && !empty($_POST['content'])){
    $post_repo = new post_repository($context);
    $postId = $post_repo->addPost($_POST);
    if(!empty($postId)){
        header('Location: ?admin=1&f=home.php');
        exit();
    } 
}
?><html>
<body>
<h1>Nouveau post : </h1>
<form method="post">
    <input type="hidden" name="authorId" value="<?php echo $_SESSION['author']['id'] ?>" />
    <label>Status : <select name="status">
        <option value="draft"><?php echo post_repository::statusToView('draft') ?></option>
        <option value="live"><?php echo post_repository::statusToView('live') ?></option>
    </select></label><br/>
    <label>Titre : <input name="title" /></label><br/>
    <label>Contenu : <br/>
    <textarea name="content" cols="50" rows="20"></textarea>
    </label> <br/>
    <input type="submit"/>
</form>
</body>
</html>