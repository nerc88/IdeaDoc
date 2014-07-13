<?php

$dbhost="localhost";
$db="u7363843_billing";
$dbuser="u7363843";
$dbpassword="m7HJOUYo";




$connect = mysql_connect($dbhost,$dbuser,$dbpassword) or die(mysql_error());
$db = mysql_select_db($db) or die(mysql_error());
 mysql_query("set names utf8");
?>