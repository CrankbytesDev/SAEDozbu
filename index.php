<?php

require 'config/Database.php';
require 'config/Session.php';
require 'config/Config.php';
require 'functions.php';

$request = array_merge($_GET, $_POST);
$config = new Config('local');
$controller = new ApplicationController();


echo $controller->run();
//print_r($_SESSION);
//echo'<br />';
//print_r($_FILES);