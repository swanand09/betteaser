<?php
session_start();
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

//main menu links
//require_once '\utility\ClassMembership.php';
$toplinks = "";
$hdrlinks = "";
$hdrlogo  = "";
$hdrAccountLink = "";
if (isset($_SESSION['status'])&&$_SESSION['status'] != 'authorized') {
    $toplinks = "
                <ul>
                    <li><a href='../'>HOME</a></li>
                    <li><a href='#'>RACEBOOK</a></li>
                    <li><a href='#'>BETTING GUIDE</a></li>
                    <li><a href='#'>PROMOTIONS</a></li>
                    <li><a href='../news/'>NEWS</a></li>
                    <li><a href='../rules.php'>RULES</a></li>
                    <li><a href='../aboutus.php'>ABOUT US</a></li>
                    <li><a href='../contact.php'>CONTACT</a></li>
                </ul>";

//header links
    $hdrlinks = "<ul>
                     <li><a href='login.php'>Sign In</a></li>
                     <li><a href='../register.php'>Register</a></li>
                 </ul>";

//header logo
    $hdrlogo = "<h1><a href='index.php'>BetTeaser</a></h1>";
}else if(isset($_SESSION['clientUsn'])){
    $toplinks = "
                <ul>
                    
                    <li><a href='../'>HOME</a></li>
                    <li><a href='index.php'>RACEBOOK</a></li>
                    <li><a href='#'>DEPOSIT</a></li>
                    <li><a href='#'>WITHDRAWAL</a></li>
                    <li><a href='#'>BETTING GUIDE</a></li>
                    <li><a href='../news/'>NEWS</a></li>
                    <li><a href='../rules.php'>RULES</a></li>
                    <li><a href='../aboutus.php'>ABOUT US</a></li>
                    <li><a href='../contact.php'>CONTACT</a></li>
                </ul>";
    
    $hdrlinks = "<ul><li>Welcome ".$_SESSION['clientUsn']."</li><li><a href='login.php?action=loggedout'>&nbsp;&nbsp;|&nbsp;&nbsp;Sign Out</a></li></ul>";
    
    //header logo
    $hdrlogo = "<h1><a href='index.php'>BetTeaser</a></h1>";
    
    //link for account
    $hdrAccountLink="<ul id='accLink'>
                        <li>Deposit</li> <li>Withdrawal</li> <li>Statement</li></ul>";
}


//Footer Text
$footerText = 'Copyright &copy '.date('Y').' BetTeaser International Ltd<br/><br/>PLEASE BET RESPONSIBLY | 18+ |<br/><br/>
               BetTeaser.com is an online sportsbook and gambling destination, we are a fully licensed sports betting website.';

$raceMenu=<<<RMENU
<ul>
                        <li><a href="#">Horse Rating</a></li>
                        <li><a href="nomination.php">Nomination & Draw</a></li>
                        <li><a href="training.php">Training</a></li>
                        <li><a href="racecard.php">Racecard</a></li>
                        <li><a href="result.php">Result</a></li>
                    </ul>
RMENU;

$betMenu=<<<BMENU
<ul>
                        <li><a href="odds.php">Live Odds</a></li>
                        <li><a href="betnow.php">Bet Now</a></li>
                        <li><a href="#">Betting Guide</a></li>
                        <li><a href="#">Bet Calculator</a></li>
                    </ul>
BMENU;
$serviceMenu=<<<SMENU
<ul>
                        <li><a href="../contact.php">CONTACT US</a></li>
                        <li><a href="#">FAQ</a></li>
                        <li><a href="../rules.php">RULES & REGULATION</a></li>
                        <li><a href="#">Glossary</a></li>
                    </ul>
SMENU;

?>
