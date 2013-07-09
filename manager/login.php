<?php

session_start();

include '\utility\ClassManager.php';

$manager = new Manager();

    
    
    if (isset($_POST['login']) && !empty($_POST['username']) && !empty($_POST['password'])){
        $pUsn=strtolower($_POST['username']);
        $pUsn=mysql_real_escape_string($pUsn);
        $pPwd=$_POST['password'];
        $pPwd=mysql_real_escape_string($pPwd);
        
        $msg=$manager->validate_manager($pUsn, $pPwd);
        //echo $pUsn.' '.$pPwd.'<br/>';
    }
    
    // If the user clicks the "Log Out" link on the index page.
    if(isset($_GET['action']) && $_GET['action'] == 'loggedout') {
            $manager->log_Admin_Out();
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
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
        <script src="../js/jQuery.JWslider.js"></script>

    </head>
    <body>
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
                    </form>
                    
                        
                </div>
                
            </div><!-- features -->
            
            
        </div><!-- main container -->

    </body>
</html>