<?php
include("mysqlInc.php");

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="images/favicon.ico" type="image/x-icon" />

    <title>清華大事</title>

    <!-- Bootstrap core CSS -->
    <link href="./dist/css/bootstrap.css" rel="stylesheet">

    <!-- Add custom CSS here -->
    <link href="./css/full-slider.css" rel="stylesheet">
    <link href="./css/weather.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="./dist/js/bootstrap.js"></script>


</head>

<body>
    <!-- Script to Activate the Carousel -->
    <script type="text/javascript">
    $('.carousel').carousel({
        interval: 5000 //changes the speed
    })
    </script>

    <div id="myCarousel" class="carousel slide">
        <!-- Indicators -->

        <ol class="carousel-indicators">

            <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
            <li data-target="#myCarousel" data-slide-to="1"></li>
            <li data-target="#myCarousel" data-slide-to="2"></li>
        </ol>

        <!-- Wrapper for slides -->
        <div class="carousel-inner">
            <div class="item active">

                <div class="banner" >
                    <img src="./images/banner-white.png" sytle="opacity:0.5;">
                </div>

                <div class="fill" style=""></div>

                <div class="carousel-caption" style="top:100px;">
                    <?php
                        echo '<div class="panel-group" id="accordion">';
                        $sql = "SELECT * FROM article ORDER BY importance DESC LIMIT 10";
                        $result = mysql_query($sql);
                        $collapseN = 'collapse';
                        $i='1';
                        while($row = mysql_fetch_array($result)){
                            $tags = explode(" ", $row['tag']);
                            echo '<div class="panel panel-default"><div class="panel-heading">
                                <h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion" href="#'.$collapseN.$i.'">';
                            echo '<b>'.$row['title'].'</b></a></h4></div>';
                            echo '<div id="'.$collapseN.$i.'" class="panel-collapse collapse"><div class="panel-body">'.$row['content'].'</div>';
                            echo '<a href="index.php?keyword='.$tags[0].'">'.$tags[0].'</a> ';
                            echo '<a href="index.php?keyword='.$tags[1].'">'.$tags[1].'</a> ';
                            echo '<a href="index.php?keyword='.$tags[2].'">'.$tags[2].'</a> ';
                            echo '<a href="index.php?keyword='.$tags[3].'">'.$tags[3].'</a> ';
                            echo '<a href="index.php?keyword='.$tags[4].'">'.$tags[4].'</a> ';
                            echo '</div></div>';
                            $i++;
                            }
                        echo'</div>';
                        
                    ?>
                </div>
            </div>
            <!-- 第二頁 -->
            <div class="item">
                <div class="banner" >
                    <img src="./images/banner-interesting.png">
                </div>

                <div class="fill" style=""></div>
                <div class="carousel-caption" style="top:100px;">
                    <?php
                        echo '<div class="panel-group" id="accordion1">';
                        $sql = "SELECT * FROM article ORDER BY interest DESC LIMIT 10";
                        $result = mysql_query($sql);
                        $collapseN = 'collapse';
                        $i='11';
                        while($row = mysql_fetch_array($result)){
                            $tags = explode(" ", $row['tag']);
                            echo '<div class="panel panel-default"><div class="panel-heading">
                                <h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion1" href="#'.$collapseN.$i.'">';
                            echo '<b>'.$row['title'].'</b></a></h4></div>';
                            echo '<div id="'.$collapseN.$i.'" class="panel-collapse collapse"><div class="panel-body">'.$row['content'].'</div>';
                            echo '<a href="index.php?keyword='.$tags[0].'">'.$tags[0].'</a> ';
                            echo '<a href="index.php?keyword='.$tags[1].'">'.$tags[1].'</a> ';
                            echo '<a href="index.php?keyword='.$tags[2].'">'.$tags[2].'</a> ';
                            echo '<a href="index.php?keyword='.$tags[3].'">'.$tags[3].'</a> ';
                            echo '<a href="index.php?keyword='.$tags[4].'">'.$tags[4].'</a> ';
                            echo '</div></div>';
                            $i++;
                            }
                        echo'</div>';
                        
                    ?>

                </div>
            </div>
            <!---第三頁-->
            <div class="item">
                <div class="fill" style="">
                    <div id="weather" >

                        <ul id="scroller">
                            <!-- The forecast items will go here -->
                        </ul>

                        <a href="#" class="arrow previous">Previous</a>
                        <a href="#" class="arrow next">Next</a>
                    <p class="location"></p>

                    </div>

                <script type="text/javascript">
                    function goToSlide(number) {
                       $("#myCarousel").carousel(number);
                    }
                </script>
                </div>
                <div class="carousel-caption" id ="searchResult" style="display:block; top:100px;"> 
                    <div >
                        <form  action="index.php" method="GET" class="navbar-form navbar-left" style="margin-left:35%;">
                            <div class="form-group">
                                <input type="text" name="keyword" class="form-control" placeholder="搜尋校內公告關鍵字">
                            </div>
                            <button type="submit" id="submitBtn" class="btn btn-default" >Submit</button>
                        </form>
                     </br>
                 </br></br>
                    </div>
                <script type="text/javascript">
                </script>;
             

             <?php
                if($_GET['keyword']!=NULL){
                    ///// record article1 num
                    $keyword = mysql_real_escape_string($_GET['keyword']);
                    $keyword = "%".$keyword."%";

                    echo '<div class="panel-group" id="accordion2">';
                    $sql = "SELECT * FROM article WHERE title LIKE BINARY '$keyword'";
                    $result = mysql_query($sql);
                    $collapseN = 'collapse';
                    $i='21';
                    $no_row = 1;
                    while($row = mysql_fetch_array($result)){
                        $no_row = 0;
                        $tags = explode(" ", $row['tag']);
                        echo '<div class="panel panel-default"><div class="panel-heading">
                            <h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion2" href="#'.$collapseN.$i.'">';
                        echo '<b>'.$row['title'].'</b></a></h4></div>';
                        echo '<div id="'.$collapseN.$i.'" class="panel-collapse collapse"><div class="panel-body">'.$row['content'].'</div>';
                        echo '<a href="index.php?keyword='.$tags[0].'">'.$tags[0].'</a> ';
                        echo '<a href="index.php?keyword='.$tags[1].'">'.$tags[1].'</a> ';
                        echo '<a href="index.php?keyword='.$tags[2].'">'.$tags[2].'</a> ';
                        echo '<a href="index.php?keyword='.$tags[3].'">'.$tags[3].'</a> ';
                        echo '<a href="index.php?keyword='.$tags[4].'">'.$tags[4].'</a> ';
                        echo '</div></div>';
                        $i++;
                    }
                    if($no_row){echo "<b style=\"color:#FFFFFF;font-size:32px;\">SORRY!</b>";}
                    echo'</div>';
                    echo "<script>goToSlide(2);</script>";
                }
            ?>
               

                </div>
            </div>
        </div>

        <!-- Controls -->
        <a class="left carousel-control" href="#myCarousel" data-slide="prev">
            <span class="glyphicon glyphicon glyphicon-chevron-left"></span>
        </a>
        <a class="right carousel-control" href="#myCarousel" data-slide="next">
            <span class="glyphicon glyphicon glyphicon-chevron-right"></span>
        </a>
    </div>

    <div class="container">
    </div>
    <!-- /.container -->


</body>
        <!-- JavaScript -->
    <script type="text/javascript" src="http://www.google.com/jsapi"></script>
    <script src="./dist/js/stopAutoScroll.js"></script>
    <script src="http://cdnjs.cloudflare.com/ajax/libs/moment.js/2.0.0/moment.min.js"></script>
    <script src="./dist/js/weather.js"></script>
    <script src="./dist/js/slideEvent.js"></script>
</html>
