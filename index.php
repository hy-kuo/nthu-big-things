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

    <title>清華大事</title>

    <!-- Bootstrap core CSS -->
    <link href="./dist/css/bootstrap.css" rel="stylesheet">

    <!-- Add custom CSS here -->
    <link href="./css/full-slider.css" rel="stylesheet">
    <link href="./css/weather.css" rel="stylesheet">

</head>

<body>


    <div id="myCarousel" class="carousel slide">
        <!-- Indicators -->

        <ol class="carousel-indicators">
             <div >all right dfjaiwej djfais<div>

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

                            echo '<div class="panel panel-default"><div class="panel-heading">
                                <h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion" href="#'.$collapseN.$i.'">';
                            echo $row['title'].'</a></h4></div>';
                            echo '<div id="'.$collapseN.$i.'" class="panel-collapse collapse"><div class="panel-body">'.$row['content'].'</div>';
                            echo $row['tag'].'</div></div>';
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

                            echo '<div class="panel panel-default"><div class="panel-heading">
                                <h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion1" href="#'.$collapseN.$i.'">';
                            echo $row['title'].'</a></h4></div>';
                            echo '<div id="'.$collapseN.$i.'" class="panel-collapse collapse"><div class="panel-body">'.$row['content'].'</div>';
                            echo $row['tag'].'</div></div>';
                            $i++;
                            }
                        echo'</div>';
                        
                    ?>

                </div>
            </div>
            <div class="item">
                <div class="fill" style=""></div>
                <div class="carousel-caption">

                    <div id="weather">

                        <ul id="scroller">
                            <!-- The forecast items will go here -->
                        </ul>

                        <a href="#" class="arrow previous">Previous</a>
                        <a href="#" class="arrow next">Next</a>

                    </div>
                    <p class="location"></p>
        


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

    <!-- JavaScript -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="./dist/js/bootstrap.js"></script>
    <script type="text/javascript" src="http://www.google.com/jsapi"></script>
    <script src="./dist/js/stopAutoScroll.js"></script>
    <script src="http://cdnjs.cloudflare.com/ajax/libs/moment.js/2.0.0/moment.min.js"></script>
    <script src="./dist/js/weather.js"></script>

    <!-- Script to Activate the Carousel -->
    <script>
    $('.carousel').carousel({
        interval: 5000 //changes the speed
    })
    </script>
</body>

</html>
