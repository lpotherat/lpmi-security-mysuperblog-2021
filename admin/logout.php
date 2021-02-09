<?php 

if($context->isLoggedIn()){
    $context->logout();
}
header('Location: ?f=home.php');
exit();