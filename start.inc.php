<?php
require_once 'utils/context.php';
$context = new context();
$config = json_decode(file_get_contents(__DIR__.'/config/config.json'),true);
$context->initApp($config);
return $context;