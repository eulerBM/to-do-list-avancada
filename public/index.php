<?php
require_once './setup.php';
require_once __DIR__ . '/routes.php';

$setup = new Setup();
$setup->init();

handleRoutes();

?>

<link rel="stylesheet" href="./css/style.css">

