<?php 
    require '\include\top_links.php';
    $_SESSION['url']='';
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Welcome to BetTeaser</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" href="css/reset.css"/>
        <link rel="stylesheet" href="css/style.css"/>
        <link rel="stylesheet" href="css/JWslider.css"/>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
<!--        <script src="js/jQuery.JWslider.js"></script>-->
        <script type="text/javascript" src="js/mocha.js"></script>
        <!--[if IE]>
            <style>
                #next{
                    top:-48px;
                }
            </style>
        <![endif]-->
    </head>
    <body>
        <div id="header-stretch">
             <div id="header" class="container">
                 <?php echo $hdrlogo; ?>
                 <?php echo $hdrlinks; ?>
             </div><!-- header -->
        </div><!-- header stretch -->
        <div id="menu-stretch">
            <div id="menu" class="container">
                 <?php echo $toplinks; ?>
            </div>
        </div><!-- Menu stretch-->
        <div id="slider-stretch">
             <div id="slider" class="container">
                    <div id="slidebanner-right" class="slider">
                        <img src="images/sl/r/1.jpg" width="710" height="300" />
                        <img src="images/sl/r/2.jpg" width="710" height="300" />
                        <img src="images/sl/r/3.jpg" width="710" height="300" />
                        <img src="images/sl/r/4.jpg" width="710" height="300" />
                     </div>
                     <div id="slidebanner-left" class="sliderR">
                         <img src="images/sl/s/11.jpg" />
                         <img src="images/sl/s/22.jpg" />
                         <img src="images/sl/s/33.jpg" />
                         <img src="images/sl/s/44.jpg" />
                     </div>
                     <a href="#" id="next"></a>
              </div><!-- Slider -->
        </div><!-- Slider Stretch -->
        <div id="main-container" class="container">
            <div id="features" >
                <a href="racebook/">
                    <div id="racebook" class="feature">
                        <h3>Image</h3>
                        <p>Enter to get the thrill of Mauritius national sport.</p>
                    </div>
                </a>
                <a href="#">
                    <div id="bettypes" class="feature">
                        <h2>Bet Types</h2>
                        <h3>Image</h3>
                        <p>Learn our wide bet types and enjoy the Champ de Mars fever.</p>
                    </div>
                </a>
                <a href="news/">
                    <div id="latestnews" class="feature">
                        <h2>News</h2>
                        <h3>Image</h3>
                        <p>Read the latest news and tips from our racing experts.</p>
                    </div>
                </a>
                <a href="promo.php">
                    <div id="promo" class="feature">
                        <h2>Promo</h2>
                        <h3>Image</h3>
                        <p>Click here to learn the latest available promotions.</p>
                    </div>
                </a>
            </div><!-- features -->
            <img src="images/paymethods.gif" alt="payment"/>
        </div><!-- main container -->

        
        <div id="footer-stretch">
            <div id="footer" class="container">
               <?php echo $footerText; ?>
            </div><!-- footer -->
        </div><!-- footer-stretch -->
    </body>
</html>