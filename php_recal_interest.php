<?php
include("mysqlInc.php");
?>

<?php
    $sql = "SELECT * FROM article";
    $result = mysql_query($sql);
    while($row = mysql_fetch_array($result)){
        $new_interest_w = 0;
        
        $articleId = $row['id'];
        $innerSql = "SELECT * FROM tag WHERE articleId = $articleId";
        $innerResult = mysql_query($innerSql);
        while($innerRow = mysql_fetch_array($innerResult)){
            
            $tf = $innerRow['tf'];
            $tag = $innerRow['tag'];

            $iw_sql = "SELECT interest_w,idf FROM word where word = '$tag'";
            $iw_result = mysql_query($iw_sql);
            $iw_row = mysql_fetch_array($iw_result);
            $new_interest_w += $tf*$iw_row[0]*$iw_row[1];

        }
        $sql = "UPDATE article SET interest = '$new_interest_w' where id = '$articleId'";
        mysql_query($sql);
    }
    
?>