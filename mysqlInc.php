<?php
$host = "localhost";
$username="root";
$password="ja1521";
$database="scrapy";


//Connect to database
mysql_connect($host , $username, $password) or die('Error! '.mysql_error());

mysql_query("SET NAMES utf8");

//Select database
mysql_select_db($database) or die('Error! ' . mysql_error());

?>
