<?php
session_start();
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

//main menu links
//require_once '\utility\ClassMembership.php';
 $toplinks = "
                    <ul>
                        <li><a href='/betteaser'>HOME</a></li>
                        <li><a href='/betteaser/racebook/'>RACEBOOK</a></li>
                        <li><a href='#'>BETTING GUIDE</a></li>
                        <li><a href='#'>PROMOTIONS</a></li>
                        <li><a href='/betteaser/news'>NEWS</a></li>
                        <li><a href='rules.php'>RULES</a></li>
                        <li><a href='aboutus.php'>ABOUT US</a></li>
                        <li><a href='contact.php'>CONTACT</a></li>
                    </ul>";

    //header links
        $hdrlinks = "<ul>
                         <li><a href='racebook/login.php'>Sign In</a></li>
                         <li><a href='register.php'>Register</a></li>
                     </ul>";

    //header logo
        $hdrlogo = "<h1><a href='index.php'>BetTeaser</a></h1>";
if(isset($_SESSION['status'])&&isset($_SESSION['clientUsn'])){
    if ($_SESSION['status'] != 'authorized') {
        $toplinks = "
                    <ul>
                        <li><a href='/betteaser'>HOME</a></li>
                        <li><a href='/betteaser/racebook/'>RACEBOOK</a></li>
                        <li><a href='#'>BETTING GUIDE</a></li>
                        <li><a href='#'>PROMOTIONS</a></li>
                        <li><a href='/betteaser/news'>NEWS</a></li>
                        <li><a href='rules.php'>RULES</a></li>
                        <li><a href='aboutus.php'>ABOUT US</a></li>
                        <li><a href='contact.php'>CONTACT</a></li>
                    </ul>";

    //header links
        $hdrlinks = "<ul>
                         <li><a href='racebook/login.php'>Sign In</a></li>
                         <li><a href='register.php'>Register</a></li>
                     </ul>";

    //header logo
        $hdrlogo = "<h1><a href='index.php'>BetTeaser</a></h1>";
    }else{
        $toplinks = "
                    <ul>
                        <li><a href='/betteaser'>HOME</a></li>
                        <li><a href='/betteaser/racebook/'>RACEBOOK</a></li>
                        <li><a href='#'>DEPOSIT</a></li>
                        <li><a href='#'>WITHDRAWAL</a></li>
                        <li><a href='#'>BETTING GUIDE</a></li>
                        <li><a href='/betteaser/news'>NEWS</a></li>
                        <li><a href='rules.php'>RULES</a></li>
                        <li><a href='aboutus.php'>ABOUT US</a></li>
                        <li><a href='contact.php'>CONTACT</a></li>
                    </ul>";

        //$hdrlinks = "<ul><li>Welcome ".$_SESSION['clientUsn']."&nbsp;&nbsp;|&nbsp;&nbsp;</li><li> <a href='login.php?action=loggedout'> Sign Out</a></li></ul>";
        $hdrlinks = "<ul><li>Welcome ".$_SESSION['clientUsn']."</li><li><a href='login.php?action=loggedout'>&nbsp;&nbsp;|&nbsp;&nbsp;Sign Out</a></li></ul>";

        //header logo
        $hdrlogo = "<h1><a href='index.php'>BetTeaser</a></h1>";
    }
}

//Footer Text
$footerText = '
Copyright &copy '. date("Y").' BetTeaser International Ltd<br/><br/>PLEASE BET RESPONSIBLY | 18+ |<br/><br/>
               BetTeaser.com is an online sportsbook and gambling destination, we are a fully licensed sports betting website.';
?>
