<?php

session_start();

//require_once 'classes\ClassMembership.php';
require '\include\top_links.php';
include '\utility\ClassMembership.php';

$membership = new Membership();
//$membership->confirm_Member();
    
    
    if (isset($_POST['login']) && !empty($_POST['username']) && !empty($_POST['password'])){
        $pUsn=strtolower($_POST['username']);
        $pUsn=mysql_real_escape_string($pUsn);
        $pPwd=$_POST['password'];
        $pPwd=mysql_real_escape_string($pPwd);
        
        $msg=$membership->validate_user($pUsn, $pPwd);
    }
    
    // If the user clicks the "Log Out" link on the index page.
    if(isset($_GET['action']) && $_GET['action'] == 'loggedout') {
            $membership->log_User_Out();
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Welcome to BetTeaser</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" href="../css/reset.css"/>
        <link rel="stylesheet" href="../css/style.css"/>
        <link rel="stylesheet" href="../css/JWslider.css"/>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
        <script src="../js/jQuery.JWslider.js"></script>

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
                        <img src="../images/slide/1.jpg" width="710" height="300" /></li>
                    </div>
                     <div id="slidebanner-left">
                         
                     </div>

             </div><!-- Slider -->
        </div><!-- Slider Stretch -->
        <div id="main-container" class="container">
            <div id="register-container">
                
                <div id="login">
                    <form id="login" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" autocomplete="off">
                        <h1>Log In</h1>
                        <fieldset id="inputs">
                            <input id="username" name="username" type="text" placeholder="Username" autofocus required autocomplete="off" />   
                            <input id="password" name="password" type="password" placeholder="Password" required autocomplete="off" />
                        </fieldset>
                        <fieldset id="actions">
                            <button type="submit" id="submit" name="login">Log in</button>
                        </fieldset>
                        <?php echo $msg; ?>
                        <br/>
                        <a href="">Forgot your password?</a>&nbsp;&nbsp;<a href="register.php">Register</a>
                        
                    </form>
                    
                        
                </div>
                <div id="regRight">
                        
                </div>
            </div><!-- features -->
            
            
        </div><!-- main container -->

        
        <div id="footer-stretch">
            <div id="footer" class="container">
               <?php echo $footerText; ?>
            </div><!-- footer -->
        </div><!-- footer-stretch -->
    </body>
</html>