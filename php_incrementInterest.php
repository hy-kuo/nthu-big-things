<?php
include("mysqlInc.php");
?>

<?php
                if($_GET['title']!=NULL){
                    ///// record article1 num
                    $title = mysql_real_escape_string($_GET['title']);
                    $sql = "SELECT tag FROM article WHERE title = '$title'";
                    $result = mysql_query($sql);
                    $row = mysql_fetch_array($result);

                    $tags = explode(" ", $row[0]);
                    for ($i=0; $i < 5; $i++) {
                        $tag = $tags[$i];
                        $sql = "UPDATE word SET interest_w = interest_w+1 WHERE word = '$tag'";
                        $result = mysql_query($sql);
                    }   
                }
            ?>