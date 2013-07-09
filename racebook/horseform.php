<?php 
    
    include("./include/top_links.php");
    include("./utility/ClassMembership.php");
    include("./utility/ClassMeeting.php");
    include("./utility/ClassRace.php");
    include("./utility/ClassBet.php");
    include("./utility/ClassSel.php");
    
    $membership = New Membership();
    $membership->confirm_Member();
    
    $upcomingMeeting=Meeting::getUpcomingMeeting();
    $clBal_Curr=  Client::getClientBalByUsn($_SESSION['clientUsn']);
    
    $mid=$_GET['hform'];
    if($mid == ''){
        $mid=$upcomingMeeting[0][_id_meeting];
        header('Location: horseform.php?hform='.$mid);
    }

    
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Welcome to BetTeaser</title>
        <link rel="shortcut icon" type="image/x-icon" href="favicon.ico"/>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" href="css/reset.css"/>
        <link rel="stylesheet" href="css/style.css"/>
        <link rel="stylesheet" href="css/JWslider.css"/>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
        <script src="js/jQuery.JWslider.js"></script>
        <script src="js/zweatherfeed.min.js"></script>
        <script src="js/jclock.js"></script>
        <script src="js/hform.js"></script>
    </head>
    <body>
        <div id="header-stretch">
             <div id="header" class="container">
                 <?php echo $hdrlogo; ?>
                 <?php echo $hdrlinks; ?>

             </div>
             
            <!-- header -->
        </div><!-- header stretch -->
        <div id="menu-stretch">
            <div id="menu" class="container">
                 <?php echo $toplinks; ?>
            </div>
        </div><!-- Menu stretch-->
        <div id="slider-stretch">
             <div id="slider" class="container">
                    <div id="slidebanner-right">
                        <ul class="slider">
                            <li><img src="images/slide/1.jpg" width="710" height="300" /></li>
                            <li><img src="images/slide/2.jpg" width="710" height="300" /></li>
                            <li><img src="images/slide/3.jpg" width="710" height="300" /></li>
                            <li><img src="images/slide/4.jpg" width="710" height="300" /></li>
                        </ul>
                         
                     </div>
                     <div id="slidebanner-left">
                         <div id="betSlip">
                             <div id="slipTitle"><h2>PENDING BETS</h2></div>
                             <?php
                                $clId=Client::getClientBalByUsn($_SESSION['clientUsn']);
                                $bSlipBet=Bet::getBetForBSlip(1,$clId[0]['_id_client']);
                                $rh=array("r", "h", "NO", "S1", "S2", "S3", "S4", "S5");
                                $newCarac=array(" ", "-", "", "", "", "", "", "");
                                $i=0; $length=22;$end='…'; $tableBetSlip='<table id="tblBSlip-small"><tr class="hdr"><td>Stake</td><td>Selection</td><td>P.Payout</td></tr>';
                                foreach($bSlipBet as $bSB){
                                    $i=1;
                                    $playedDate=date("d M Y H:i", strtotime($bSB['_date']));
                                    $strAccBet= str_replace($rh, $newCarac, $bSB['_betrnumacc']);
                                    $string=$strAccBet;
                                    if (strlen($string) > $length)
                                    {
                                        $length -= strlen($end);
                                        $string  = substr($strAccBet, 0, $length);
                                        $string .= $end;
                                    }
                                    
                                    $ppo=Sel::getSelPO($bSB['_id_bet'], $bSB['_fold']);
                                    if($bSB['_gametype']==w){
                                        $ty='Win';
                                    }else{
                                        $ty='Place';
                                    }
                                    $tableBetSlip.='<tr title="Bet Type: '.$ty.'&#13;Stake: '.$bSB['_amount'].' '.$bSB['_curr'].'  Potential Payout: '.$ppo[0]['_ppayout'].' '.$bSB['_curr'].'&#13;Selection: '.$strAccBet.'&#13;Played on '.$playedDate.'(MU)"><td style="text-align: right;">'.$bSB['_amount'].'</td><td>'.$string.'</td><td style="text-align: right;">'.$ppo[0]['_ppayout'].'</td></tr>';
                                    
                                    $length=22;
                                }
                                $tableBetSlip.='</table><div class="sp"></div><div id="stment"><a href="betstatement.php">Bet List</a><div class="sp"></div><div class="sp"></div><a href="statement.php">Statement</a></div>';
                                if($i==0){
                                    echo '<p>Your bet slip is empty at the moment.</p><p>To start betting go to betnow and select one or more horses from the different races.</p>';
                                }else{
                                    echo $tableBetSlip;
                                }
                             ?>
                             
                         </div>
                         <div id="fund">
                             <a href="#"><div id="depo">DEPOSIT</div></a>
                             <a href="#"><div id="withdraw">WITHDRAWAL</div></a>
                         </div>
                     </div>

             </div><!-- Slider -->
        </div><!-- Slider Stretch -->
        <div id="main-container" class="container">
            <div id="rbook-leftcontainer" >
                <div id="comingMeeting" class="rbookBox">
                    <h2>FIXTURES</h2>
<!--                    <div id='penetro' style='display:none'>nil</div>
                    <div id='falserail' style='display:none'>nil</div>-->
                    
                    
                        <?php
                            foreach($upcomingMeeting as $mting){
                                if($mting[_mstatus]=='racecard'){
                                    echo "<div id='penetro' style='display:none'>".$mting[_pitch]."</div>";
                                    if($mting[_falserail]=='0.00'){
                                        $falseRail='nil';
                                    }else{
                                        $falseRail=$mting[_falserail];
                                    }
                                    echo "<div id='falserail' style='display:none'>".$falseRail."</div>";
                                }
                                
                            }
                        ?>

                    <table id="tblMeeting">
                        <?php
                            $i=1;
                            foreach($upcomingMeeting as $mting){
                                if(($mting[_current]=='1')&&($mting[_id_meeting]==$mid)){
                                    echo "<tr title='View Race Details' id='mting".$mting[_id_meeting]."' style='background-color:#CEFFB6; cursor: pointer;'>";
                                    $meetingId=$mting[_id_meeting];
                                    
                                }elseif(($mting[_current]=='1')){
                                    echo "<tr title='View Race Details'  id='mting".$mting[_id_meeting]."' style='background-color:#fff; cursor: pointer;'>";
                                }
                                else{
                                    echo "<tr id='mting".$mting[_id_meeting]."' >";
                                }
                                $dat = str_replace('/', '-', $mting[_mdate]);
                                echo "<td>".$mting[_mname]."</td>";
                                echo "<td style='display: none'>".$mting[_current]."</td>";
                                echo "<td style='display: none'>".$mting[_id_meeting]."</td>";
                                echo "<td>".date("d M Y", strtotime($dat))."</td>";
                                echo "<td>".$mting[_mstatus]."</td>";
                                echo "<td>".$mting[_comment]."</td>";
                                echo "<tr>";
                                
                                $i++;
                            }
                        ?>
                    </table>
                    
                </div>
                <div id="raceMenu" class="rbookBox">
                    <h2>RACE MENU</h2>
                    <?php echo $raceMenu; ?>
                </div>
                <div id="betMenu" class="rbookBox">
                    <h2>BET NOW</h2>
                    <?php echo $betMenu; ?>
                </div>
                <div id="weatherMenu" class="rbookBox">
                    <h2>WEATHER</h2>
                    <div id="wforecast"></div>
                    <div id="pitch"></div>
                </div>
                <div id="servicesMenu" class="rbookBox">
                    <h2>SERVICES</h2>
                    <?php echo $serviceMenu; ?>
                </div>
            </div><!-- rbook-leftcontainer -->
            <div id="rbook-rightcontainer">
                <div id="mauTime"></div>
                <div id="racebookContent">
                    <div id="testRace">
                        
                        <div id="raceDetails">
                            <div id="clBal">Current Balance: <?php echo $clBal_Curr[0]['_bal'].' '.$clBal_Curr[0]['_currency']; ?>&nbsp;|&nbsp;</div>
                        </div>
                        
                    </div>
                </div>
                
            </div><!-- rbook-rightcontainer -->
            <div class="clearFloat"></div>
            <br/><img src="images/paymethods.gif" alt="payment"/>
        </div><!-- main container -->

        
        <div id="footer-stretch">
            <div id="footer" class="container">
               <?php echo $footerText; ?>
            </div><!-- footer -->
        </div><!-- footer-stretch -->
    </body>
</html>