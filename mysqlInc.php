<?php
$host = "localhost";
$username="root";
$password="";
$database="scrapy";
// $db_server = "localhost";
// $db_user = "nthubigthings";
// $db_passwd = "fu/cj86284g4";
// $db_name = "nthubigthings";


//Connect to database
mysql_connect($host , $username, $password) or die('Error! '.mysql_error());
// if(!@mysql_connect($db_server, $db_user, $db_passwd)){
//         die("無法對資料庫連線");
// }

//Select database
mysql_select_db($database) or die('Error! ' . mysql_error());
mysql_query("SET NAMES utf8");
 
// if(!@mysql_select_db($db_name)){
//         die("無法使用資料庫");
// }

?>
