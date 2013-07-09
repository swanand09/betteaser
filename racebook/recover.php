<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require '\include\top_links.php';
include '\utility\ClassClient.php';
include '\utility\ClassRecoverMail.php';

if(trim($_GET['r'])!=''){
    $auth = explode('-',trim($_GET['r']));
    $cId=base64_decode(urldecode($auth[1]));
    $hash=mysql_real_escape_string($auth[0]);
    
    //check recoverymail id
    $recoverId=  RecoverMail::getRecoveryId($hash, $cId);
    $recoverId=$recoverId[0][_id_recovery];
    
    if($recoverId!=''){
        $clDet=Client::getClUsnById($cId);
        $clUsn=$clDet[0]['_username'];

        $flagErr=0;
        $errString='<h3>ERROR NOTIFICATION</h3><p>Please review the following:</p>';

        if (isset($_POST['rPassBtn'])){
            $pPass=$_POST['rPass'];
            $pCpass=$_POST['rCPass'];

            if ( strlen(trim($pPass)) < 7 ) {
                $flagErr=1;
                $errString.='<p>Please enter a valid password.</p>';
            }
            if (trim($pPass)!=trim($pCpass)) {
                $flagErr=1;
                $errString.='<p>Confirm password does not match with password.</p>';
            }
            if ($flagErr==1){
                $echoError=$errString;
            }
            if ($flagErr==0){
                //update password
                $pwd=sha1(mysql_escape_string($pPass));
                if(Client::updatePwd($pwd, $cId)){
                    //delete recoveryemail
                    $rcover=RecoverMail::deleteRecovery($recoverId);
                    if($rcover){
                        header("Location: ../index.php");
                    }else{
                        echo $rcover;
                    }
                }
            }
        }
    }else{
        header("Location: ../index.php");
    }
    
    
    
}else{
    header("Location: ../index.php");
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
        <script src="js/jQuery.JWslider.js"></script>
        <script src="js/regform.js"></script>
        <script src="js/regform-modal.js"></script>
        
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
                    <div id="slidebanner-right">
                        <img src="images/slide/1.jpg" width="710" height="300" /></li>
                    </div>
                     <div id="slidebanner-left">
                         
                     </div>

             </div><!-- Slider -->
        </div><!-- Slider Stretch -->
        <div id="main-container" class="container">
            <div id="register-container">
                
                
                
                <div id="notice" class="register">
                    <h3>PASSWORD RECOVERY</h3>
                    <p style="text-align: justify; line-height: 17px;">Welcome back, <?php echo $clUsn; ?><br/>Please enter your new password in the fields below. </p>
                    <span id="errNotif"><?php echo $echoError ?></span>
                </div>
                <div id="registration" style="display: block;height: 280px;" class="register">
                    <form action="<?php echo $_SERVER['PHP_SELF'].'?r='.$_GET['r']; ?>" method="POST" autocomplete="off" id="frmRegistration" name="regForm">
                        <fieldset id="personalInfo">
                        <legend>Step 1</legend>
                        <ol>
                            <li>
                                <label for="rPass">Password:</label>
                                <input id="rPass" name=rPass type=password placeholder="" pattern="\w{7,}" required ></input>
                                <span class="form_hint">Enter your desired password for signing in. We recommend password should contain at least 7 characters and a combination of [A-Z], [a-z] and numbers</span>
                            </li>
                            
                            <li>
                                <label for=rCPass>Confirm Password:</label>
                                <input id="rCPass" name=rCPass type=password onfocus="validatePass(document.getElementById('rPass'), this);" 
                                       oninput="validatePass(document.getElementById('rPass'), this);"
                                       onblur="validatePass(document.getElementById('rPass'), this);" required></input>
                                <span class="form_hint">Please re-enter your password. It must be exactly the same as the previous field.</span>
                            </li>
                        </ol>     
                        </fieldset>
                        <fieldset id="step1">
                        <button type=submit name="rPassBtn" id="rPassBtn">Submit</button>
                        </fieldset>
                    </form>
                    <div class="furtherHelp">
                        <h3>HELP</h3>
                        <p>Having difficulty resetting your password?<br/>Contact us at support@betteaser.com, one of our agent will be glad to help you.</p>
                    </div>
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