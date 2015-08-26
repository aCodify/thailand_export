<?php
$dbhost							= "localhost";
$dbuser							= "root";
$dbpass							= "password";
$dbname							= "facebook-login";

$conn = mysql_connect($dbhost, $dbuser, $dbpass) or die ("Error connecting to database");
$charset = mysql_query('SET NAMES UTF8');
mysql_select_db($dbname);
?>