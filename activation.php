<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require '\include\top_links.php';
include 'utility\ClassClient.php';

if(trim($_GET['auth'])!=''){
    $auth = explode('-',trim($_GET['auth']));
    $cId=mysql_real_escape_string($auth[0]-20101);
    $hash=mysql_real_escape_string($auth[1]);
}else{
    header("Location: index.php");
}


$accRez=Client::validate_activation($hash, $cId);

$clId=$accRez[0]['_id_client'];
$clUsn=$accRez[0]['_username'];

if($clId!=''){
    $accRez=Client::clientActivation($cId);
    if($accRez==true){
        $msg="Your account has been activated. To start playing please see the deposit options and the upcomming race program.";
        $_SESSION['clientUsn']=$clUsn;
        $_SESSION['status'] = 'authorized';
    }
}else{
    $msg="Your account has already been activated or you have entered an invalid address. Please follow the steps sent to you in your registration mail.";
}

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
                <script src="js/regform-modal.js"></script>
        <!--[if IE]>
            <style>
                #next{
                    top:-43px;
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
            <!-- Start Test Modal -->
                <div id="boxes">
                    <div style="top: 199.5px; left: 451.5px; display: block;" id="dialog" class="window">
                        <h2>Client Activation</h2>
                        <?php 
                            echo '<p>'.$msg.'</p>';
                        ?>
                        <a href="#" class="close">CLOSE</a>
                    </div>
                    <!-- Mask to cover the whole screen -->
                    <div style="width: 100%; height: 150%; display: block; opacity: 0.8;" id="mask"></div>
                </div>
                <!-- End Test Modal -->
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
                <a href="#">
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