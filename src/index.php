<?php

$autoloader = require 'vendor/autoload.php';

echo "<h3>psr-4 가 컴포져를 통해 어떤 파일을 읽고있는지 는 확인</h3>";
echo "<pre>";

$AppController = new \App\Controller\AppController();
$AppController->test();

