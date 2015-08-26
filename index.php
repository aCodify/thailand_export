<?php  

define('DATABASE_HOSTNAME', 'localhost');
define('DATABASE_USERNAME', 'root');
define('DATABASE_PASSWORD', 'password');
define('DATABASE_NAM', 'AAA');

include 'inc/database/DB.php';
include 'inc/model.php';

header('Content-Type: text/html; charset=utf-8');


$olx->thailand_export();

