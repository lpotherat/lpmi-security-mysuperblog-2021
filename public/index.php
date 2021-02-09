<?php 
/**
 * @var context $context
 */
$context  = include '../start.inc.php';

$admin = boolval($_GET['admin'] ?? false);
$file = $_GET['f'] ?? null;

$folder = $admin ? '../admin/' : '../pages/';
if($file && is_file($folder.$file)){

    if($admin && !$context->isLoggedIn()){
        header("HTTP/1.0 401 Unauthorized");
        header("Location: ?f=login.php");
        exit();
    }

    include $folder.$file;
} else {
    header("HTTP/1.0 404 Not Found");
    exit();
}
