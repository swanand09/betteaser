<?php 
    require 'include\top_links.php';
    
    if ($_SESSION['clientUsn'] == '') {
        $_SESSION['url'] = $_SERVER['REQUEST_URI'];
        header('Location: ../racebook/login.php');
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <title><?php bloginfo('name'); ?><?php wp_title(); ?></title>
        <link rel="pingback" href="<?php bloginfo('pingback url'); ?>" /> 
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" media="all" href="<?php bloginfo('template_directory'); ?>/css/reset.css" />
        <link rel="stylesheet" media="all" href="<?php bloginfo('stylesheet_url'); ?>"/>
        <link rel="shortcut icon" type="image/x-icon" href="<?php bloginfo('template_directory'); ?>/images/favicon.ico"/>
        <link rel="stylesheet" media="all" href="<?php bloginfo('template_directory'); ?>/css/JWslider.css" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
        <script type="text/javascript" src="../js/mocha.js"></script>
        <!--[if IE]>
            <style>
                #next{
                    top:-48px;
                }
            </style>
        <![endif]-->
        <style type="text/css">
        @-moz-document url-prefix() {
            #header-stretch { margin-top: -30px; }
        }
        </style>
        <?php wp_head(); ?>
    </head>
    <?php echo is_single() ? "<body class='single'>" : "<body>" ?>
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
                        <img src="<?php echo bloginfo('template_directory').'/images/sl/r/1.jpg' ?>" width="710" height="300" />
                        <img src="<?php echo bloginfo('template_directory').'/images/sl/r/2.jpg' ?>" width="710" height="300" />
                        <img src="<?php echo bloginfo('template_directory').'/images/sl/r/3.jpg' ?>" width="710" height="300" />
                        <img src="<?php echo bloginfo('template_directory').'/images/sl/r/4.jpg' ?>" width="710" height="300" />
                     </div>
                     <div id="slidebanner-left" class="sliderR">
                         <img src="<?php echo bloginfo('template_directory').'/images/sl/s/11.jpg' ?>" />
                         <img src="<?php echo bloginfo('template_directory').'/images/sl/s/22.jpg' ?>" />
                         <img src="<?php echo bloginfo('template_directory').'/images/sl/s/33.jpg' ?>" />
                         <img src="<?php echo bloginfo('template_directory').'/images/sl/s/44.jpg' ?>" />
                     </div>
                     <a href="#" id="next"></a>
              </div><!-- Slider -->
        </div><!-- Slider Stretch -->