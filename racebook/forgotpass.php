<?php 
    //session_start();
        
    require '\include\top_links.php';
    include 'utility\ClassCountry.php';
    include '\utility\ClassClient.php';
    
    
    if ($_SESSION['status'] == 'authorized'){
        header("location: index.php");
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
                    <p style="text-align: justify;">You can use this form to recover your password if you have forgotten it. Because your password is securely kept in our database, it is impossible actually to recover your password. We will however email you a link that will allow you to reset your password. Enter either your username or your email address below to get started.</p>
                </div>
                <div id="registration" style="display: block;height: 280px;" class="register">
                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" autocomplete="off" id="frmRegistration" name="regForm">
                        <fieldset id="personalInfo">
                        <legend>Step 1</legend>
                        <ol>
                            <li>
                                <label for="rUname">Username:</label>
                                <input id="rUname" name=rUname type=text placeholder="" ></input>
                            </li>
                            <p style="text-align: left; margin-bottom: 10px; margin-left: 15px; font-size: 11px; font-style: italic;">- OR -</p>
                            <li>
                                <label for=rEmail>Email:</label>
                                <input id="rEmail" name=rEmail type=text></input>
                                
                            </li>
                            <p class="err" id="errStep1" style="display:none;">The information entered does not match with our database.</p>
                        </ol>     
                        </fieldset>
                        <fieldset id="step1">
                        <button type=submit name="rPass" id="rPass">Submit</button>
                        </fieldset>
                    </form>
                    <div class="furtherHelp">
                        <h3>HELP</h3>
                        <p>Having difficulty resetting your password?<br/>Contact us at support@betteaser.com, one of our agent will be glad to help you.</p>
                    </div>
                </div>
                <div id="seqQues" style="display: none;height: 280px;" class="register">
                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" autocomplete="off" id="seqQues" name="seqQues">
                        <fieldset id="seqQuesInfo">
                        <legend>Step 2</legend>
                        <ol>
                            <li>
                                <p id="ques">Question:<span id="seqQ"></span></p>
                                
                            </li><br/>
                            <li>
                                <label for=rAnswer>Answer:</label>
                                <input id="rAnswer" name=rAnswer type=text></input>
                                
                            </li>
                            <p class="err" id="errStep2" style="display: none;">The answer does not match the information you have put when registering.</p>
                        </ol>     
                        </fieldset>
                        <fieldset id="step2">
                        <button type=submit name="rAnsSubmit" id="rAnsSubmit">Submit</button>
                        </fieldset>
                    </form><br/><br/><br/><br/>
                    <div class="furtherHelp">
                        <h3>HELP</h3>
                        <p>Having difficulty resetting your password?<br/>Contact us at support@betteaser.com, one of our agent will be glad to help you.</p>
                    </div>
                </div>
                <div id="step3" style="display: none;height: 280px;" class="register">
                    <p id="msgStep3">An email has been sent to you with instructions on how to reset your password.<br/><br/>
                    <a href="login.php">Return</a> to the login page.</p>
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