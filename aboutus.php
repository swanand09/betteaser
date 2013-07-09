<?php
require '\include\top_links.php';
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Welcome to BetTeaser</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" href="css/reset.css"/>
        <link rel="stylesheet" href="css/style.css"/>
        <link rel="stylesheet" href="css/JWslider.css"/>
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
        <script type="text/javascript" src="js/mocha.js"></script>

        
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
            <div id="register-container">
                
                
                
                
                <div id="aboutus" style="display: block;" class="register">
                    <h3>About Us</h3>
                    <p>With several years of experience in the field of sports betting and gambling at the Champ de Mars race course, we continue to innovate. Now punters around the world can play and enjoy Mauritius’s most exciting sport.</p>
                    <p>BetTeaser offers you a pleasant and worry-free online betting experience by bringing Mauritius racing industry closer to you. To enjoy your experience fully, we give you the opportunity to choose between different types of bets along with the best available odds as at the Champ de Mars to increase your winnings.</p>
                    <p>At BetTeaser, we also stand for integrity and this is why our team is dedicated to provide you with the best customer services.  Our goal is to ensure that you entertain yourself and make your betting experience worth it. By choosing BetTeaser, you are choosing a secure way to enjoy this experience. Our practice of ethics is founded on transparency, truthfulness and social responsibility in giving the best services to our customers.</p>
                    <p>We are proud to say that we are a trusted brand, acting legally for the well being of Mauritius racing industry, so do join us to get the thrill and enjoy Mauritius horse racing.</p>
                </div>
                
                
                <div id="regRight">
                        
                </div>
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