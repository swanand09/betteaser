<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

    require '\include\top_links.php';
    
    $flagErr=0;
    $errString='<h3>ERROR NOTIFICATION</h3><p>Please review the following:</p>';
    
    if(isset($_POST['rPassBtn'])){
        $pName=$_POST['cName'];
        $pEmail=strtolower($_POST['cEmail']);
        $pSubject=$_POST['cSubject'];
        $pMsg=$_POST['cMessage'];
        
        if ( !preg_match("/^[À-ÿA-Za-z\\-\\., \']{3,20}+$/", $pName) ) {
            $flagErr=1;
            $errString.='<p>Field name contain errors.</p>';
        }
        if ( !filter_var($pEmail,FILTER_VALIDATE_EMAIL) ) {
            $flagErr=1;
            $errString.='<p>You have entered an invalid email address.</p>';
        }
        if($flagErr==1){
            //alert errors
        }else{
            if(Client::contactus_copy($pName,$pEmail,$pSubject,$pMsg)){
                Client::contactus($pName,$pEmail,$pSubject,$pMsg);
            }
            
        }
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
                
                
                
                
                <div id="registration" style="display: block;height: 280px; border-top: 1px solid #C0C0C0;" class="register">
                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" autocomplete="off" id="frmRegistration" name="regForm">
                        <fieldset id="personalInfo">
                        <legend>Contact Us</legend>
                        <ol>
                            <li>
                                <label for="cName">Name:</label>
                                <input id="cName" name=cName type=text placeholder="" pattern="[a-zA-ZÀ-ÿ ]{3,25}" required ></input>
                                <span class="form_hint">Enter your name.</span>
                            </li>
                            <li>
                                <label for="cEmail">Email:</label>
                                <input id="cEmail" name=cEmail type=text placeholder="" pattern="^([0-9a-zA-Z]([-.\w]*[0-9a-zA-Z])*@([0-9a-zA-Z][-\w]*[0-9a-zA-Z]\.)+[a-zA-Z]{2,9})$" required ></input>
                                <span class="form_hint">Enter your email.</span>
                            </li>
                            
                            <li>
                                <label for="cSubject">Subject:</label>
                                <input id="cSubject" name=cSubject type=text required></input>
                            </li>
                            <li>
                                <label for="cMessage">Message:</label>
                                <textarea id="cMessage" name="cMessage" rows="4" cols="50" required></textarea>
                            </li>
                        </ol>     
                        </fieldset>
                        <fieldset id="step1" style="margin-top: -15px;">
                        <button type=submit name="rPassBtn" id="rPassBtn">Submit</button>
                        </fieldset>
                    </form>
                    
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