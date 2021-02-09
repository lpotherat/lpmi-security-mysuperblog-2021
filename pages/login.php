<?php
if(!empty($_POST['login']) && !empty($_POST['password'])){
    $context->login($_POST['login'],$_POST['password']);

    if($context->isLoggedIn()){
        header('Location: ?f=home.php&admin=1');
    }

}
?>
<html>
<body>
<h1>Administration du blog</h1>
<h2>Connexion</h2>
<form action="" method="post">
    <label> Nom d'utilisateur : <input name="login" type="text"/></label>
    <label> Mot de passe : <input name="password" type="password"/></label>
    <input type="submit"/>
</form>
</body>
</html>
