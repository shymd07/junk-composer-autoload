<?php 

$autoloader = require 'vendor/autoload.php';
// require 'app/controller/UserController.php';

// dump autoload setting.
echo "<h3>psr-4 가 컴포져를 통해 어떤 파일을 읽고있는지 는 확인</h3>";
echo "<pre>";
echo json_encode($autoloader->getPrefixesPsr4(), JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES) . PHP_EOL;


$userController = new \App\Controller\UserController();
$userController->test();
