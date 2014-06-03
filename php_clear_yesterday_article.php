<?php
    ///// clear yesterday article1
    ini_set('memory_limit', '-1');
    set_time_limit(0);
    include("mysqlInc.php");
?>

 
<?php
    ///// record article1 num
    $sql = "SELECT MAX(id) FROM article1";
    $result = mysql_query($sql);
    $row = mysql_fetch_array($result);

    $article_num = $row[0];
    echo $article_num;

    ///// truncate article1 table
    $sql = "TRUNCATE TABLE article1";
    mysql_query($sql);

    ///// set id to the old value
    $sql = "ALTER TABLE article1 AUTO_INCREMENT = $article_num";
    mysql_query($sql);
    

?>
<!-- 
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link type="text/css" href="Stylesheets/theme/the_index.css" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Ubuntu' rel='stylesheet' type='text/css'>
    <script type="text/javascript" src="jquery-2.1.0.min.js"></script>
    <title>TEST</title>
</head>
    <body>

    </body>
</html>
 -->