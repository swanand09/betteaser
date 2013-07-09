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

<!--        <script type="text/javascript" src="js/mocha.js"></script>-->
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
                        <img src="images/promo/fpromo.jpg" width="710" height="300" />
                        
                     </div>
                     <div id="slidebanner-left" class="sliderR">
                         <img src="images/promo/sCacc.jpg" />
                         <img src="images/promo/sbet.jpg" />
                         <img src="images/promo/sbonus.jpg" />
                     </div>
              </div><!-- Slider -->
        </div><!-- Slider Stretch -->
        <div id="main-container" class="container">
            <div id="features" >
                
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