<?php
//session_start();
ini_set('memory_limit', '-1');
set_time_limit(0);
include("mysqlInc.php");
require_once "CKIPClient-PHP/src/CKIPClient.php";

// change to yours
define("CKIP_SERVER", "140.109.19.104");
define("CKIP_PORT", 1501);
define("CKIP_USERNAME", "nthubigthings");
define("CKIP_PASSWORD", "fu/cj86284g4");

$ckip_client_obj = new CKIPClient(
   CKIP_SERVER,
   CKIP_PORT,
   CKIP_USERNAME,
   CKIP_PASSWORD
);

?>
 
<?php
    //date("Y-m-d H:i:s")
    //replace tab, space, \n as ,
/*    $title = "清大梅塾家教網站";
    $content = "清大梅塾家教網站

係由學生自行開發的家教網站

歡迎學生及家長使用

完全免費

http://140.114.42.11/tutor/meisu/

若有任何問題,請以e-mail 聯絡維護的同學

nthu.meisu@gmail.com";
    $date = date("Y-m-d H:i:s");
    $sql = "INSERT INTO unprocessed_article (url, insertDate, title, content) VALUES ('forTest', '$date', '$title', '$content')";
    mysql_query($sql);
*/  
    // {"content": ["<p>有關102學年度畢業典禮相關訊息，請點選<a href=\"http://academic.web.nthu.edu.tw/files/11-1009-9262.php\">http://academic.web.nthu.edu.tw/files/11-1009-9262.php</a>查看，謝謝。</p>"], "title": ["102學年度畢業典禮相關訊息 - 國立清華大學教務處 "]}
    /////////////////////////////////// above is what parser do
    
    $sql = "SELECT * FROM unprocessed_article";
    $result = mysql_query($sql);
    $there_is_new_article = 1;
    while($row = mysql_fetch_array($result)){
        if($row==null){
            echo "no unprocessed article.";
            $there_is_new_article = 0;
            break;   
        }
        else{
            $url = $row['url'];
            $insertDate = $row['insertDate'];
            $title = $row['title'];
            $content = $row['content'];      
            $content = preg_replace("/<p>|<\/p>/", "", $content);  
            
            $sql = "INSERT INTO article (url, insertDate, title, content) VALUES ('$url', '$insertDate', '$title', '$content')";
            mysql_query($sql);

            $id = mysql_insert_id();
            echo "id: ".$id."\n";

            $regPattern = "/\s\s+/";//spaces
            $content = preg_replace($regPattern, "", $content);
            $content = preg_replace("/<.*?>/", "", $content); // de-tag

            $raw_text = $title.$title.$title.$title.$title.$content;

            $raw_text = str_replace("，", "\n", $raw_text);
            $raw_text = str_replace("。", "\n", $raw_text);
            $raw_text = str_replace(",", "\n", $raw_text);
            $raw_text = str_replace(".", "\n", $raw_text);

            $raw_text_array = explode("\n", $raw_text);
            $raw_text_array = array_filter($raw_text_array);

            $token_result = array();
            $tag_result = array();
            foreach ($raw_text_array as $raw_sentence) {
                $return_text = $ckip_client_obj->send($raw_sentence);
                //print_r($return_text);
                $return_term = $ckip_client_obj->getTerm();
                //print_r($return_term);

                $termNum = count($return_term);
                for ($i = 0; $i < $termNum; $i++) { 
                    //check tag of terms
                    $regPattern = "/^[a-zA-Z]+CATEGORY|^D|^T|^P|^C|^M|^ADV|^FW/";//;punction .etc
                    if (!preg_match($regPattern, $return_term[$i]['tag'])) {
                        $toBig5 = iconv("UTF-8", "Big5", $return_term[$i]['term']);
                        $token_result[] = $toBig5;
                        $toBig5 = iconv("UTF-8", "Big5", $return_term[$i]['tag']);
                        $tag_result[] = $toBig5;
                    } 
                }          
                sleep(5);
            }

            file_put_contents("content.txt", "");
            file_put_contents("output.txt", "");
            $tokenNum = count($token_result);    
            $fp = fopen("content.txt", "a");
            for ($i=0; $i < $tokenNum; $i++) { 
                fwrite($fp, "\t".$token_result[$i]."(".$tag_result[$i].")");
            }
            fclose($fp);   

            $cmd = "CKIPClient-PHP\CountWordFreq\CountWordFreq.exe content.txt output.txt 0";
            //$cmd = "CountWordFreq.exe t.txt output.txt 1 2>&1";
            $shellOutput = shell_exec($cmd); 
            echo trim($shellOutput); 
            //print_r($return_term);


            $homepage = file_get_contents('output.txt');
            $hello = iconv("UTF-16LE", "UTF-8", $homepage);
            $lines = explode("\n",$hello);
            
            $word = array();
            $freq = array();
            
            $num = count($lines);
            for ($i=0; $i < $num; $i++) { 
                //echo $lines[$i]."\n";
                $line = $lines[$i];
                $parts = explode("\t", $line);

                $word[] = $parts[0];
                //print_r($word);
                $freq[] = $parts[1];
                //print_r($freq);
            }
            // echo "freq\n";
            // print_r($word);
            // echo "\n";

            // echo "freq\n";
            // print_r($freq);
            // echo "\n";

            $freqSum = array_sum($freq);
            echo "freqSum: ".$freqSum."\n";
            $tf = array();
            $tf_idf = array();
            /////total article num in DB
            // $sql = "SELECT COUNT(*) FROM article";
            // $result = mysql_query($sql);
            // $row = mysql_fetch_array($result);
            // $total_article_num = $row[0];
            // echo $total_article_num;
            $total_article_num = $id;
            echo "total_article_num: ".$total_article_num."\n";

            ///// update idf of whole words
            $sql = "SELECT MAX(article_num) FROM word";
            $result = mysql_query($sql);
            $row = mysql_fetch_array($result);
            echo "max article num: ".$row[0]."\n";
            $maxArticleNum = $row[0];

            for ($i=1; $i <= $maxArticleNum; $i++) { 
                $new_idf = log(1+($total_article_num/$i));
                $new_idfs[] = $new_idf;
                $sql = "UPDATE word SET idf='$new_idf' where article_num = '$i'";
                mysql_query($sql);
                //echo "article_num: ".$i." idf: ".$new_idfs[$i-1]."\n";
            } 

            $i = $maxArticleNum+1;
            $new_idf = log(1+($i/$total_article_num));
            $new_idfs[] = $new_idf;

            /////total word num in article
            $wordNum = count($word);
            for ($i=0; $i < $wordNum; $i++) { 
                $thisWord = $word[$i];

                $tf[] = $freq[$i] / $freqSum;
                
                $sql = "SELECT * FROM word where word = '$thisWord'";
                $result = mysql_query($sql);
                $row = mysql_fetch_array($result);
                if($row == null){
                    $new_article_num = 1;
                    $new_idf = $new_idfs[$new_article_num-1];
                    $sql = "INSERT INTO word (word, article_num, idf, importance_w, interest_w) VALUES ('$thisWord', '$new_article_num', '$new_idf', '1', '1')";
                    mysql_query($sql);
                    echo "hi";
                }else{
                    $new_article_num = $row['article_num']+1;
                    $new_idf = $new_idfs[$new_article_num-1];

                    $sql = "UPDATE word SET article_num = '$new_article_num', idf = '$new_idf' where word = '$thisWord'";
                    mysql_query($sql);
                    echo "gd";
                }

                /////calculate tf-idf
                $tf_idf[] = $tf[$i]*$new_idf;
                // echo $word[$i]." ".$freq[$i]." ".$tf[$i]." ".$tf_idf[$i];
            }   

            array_multisort($tf_idf, SORT_DESC, SORT_NUMERIC,
                        $word, SORT_DESC, SORT_STRING,
                        $tf, SORT_DESC, SORT_NUMERIC);

            $importance = 0;
            $interest = 0;
            for ($i=0; $i < 5; $i++) {
                $thisWord = $word[$i];
                $thisTf = $tf[$i];
                //$tag .= " ".$thisWord;

                $sql = "INSERT INTO tag (articleId, tag, tf) VALUES ($id, '$thisWord', $thisTf)";
                mysql_query($sql);

                $sql = "SELECT * FROM word where word = '$thisWord'";
                $result = mysql_query($sql);
                $row = mysql_fetch_array($result);

                $importance += $row['importance_w']*$tf_idf[$i];
                $interest += $row['interest_w']*$tf_idf[$i];        
            }
            
            $sql = "UPDATE article SET importance = '$importance', interest = '$interest' where id='$id'";
            mysql_query($sql);

        }
    }
    if($there_is_new_article){
        ///// truncate unprocessed_article table
        $sql = "TRUNCATE TABLE unprocessed_article";
        mysql_query($sql);    
    }  



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