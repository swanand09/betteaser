<?php 
   
    include("./include/top_links.php");
    include("./utility/ClassMembership.php");
    include("./utility/ClassMeeting.php");
    include("./utility/ClassRace.php");
    include("./utility/ClassBet.php");
    include("./utility/ClassSel.php");

    
    //require_once '\utility\ClassClient.php';
    
    $membership = New Membership();
    $membership->confirm_Member();
    
    $upcomingMeeting=Meeting::getUpcomingMeeting();
    
    $mid=trim($_GET['bet']);
    
    if($mid == ''){
        $mid=$upcomingMeeting[0][_id_meeting];
        header('Location: betnow.php?bet='.$mid);
    }
    
    $raceMeeting=Race::getRaceMeeting($mid);
    $clBal_Curr=  Client::getClientBalByUsn($_SESSION['clientUsn']);
    
    
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
        <script src="js/jquery.currency.js"></script>
        <script src="js/jclock.js"></script>
        <script src="js/jquery.h5validate.js"></script>
        <script src="js/confirm.js"></script>
        <script src="js/bet.js"></script>
        <style>
            .red {

/*                border: 1px solid red;*/
                outline:none;
                border-color:#9ecaed;
                box-shadow:0 0 10px #EB4A3B;
                color:black;

            }

        </style>
        <script>
            $(document).ready(function () {
                $('#betPanel-frm').h5Validate({
                    errorClass:'red'
                });
            });
        </script>
    </head>
    <body>
        <!-- Start Test Modal -->
        <div id="boxes">
            <div style="width:650px;position:fixed;top:50%;left:45%; display: none;" id="dialog" class="window">
                
                <div id="noBet">
                    <h2>Verification Error</h2>
                    <p style="font-weight: bold;">Your bet contain one or more errors. Please check the following:</p>
                    <ul style="font-size: 12px; padding:5px;">
                        <li>-&nbsp;&nbsp;Bet amount should be less or equal to available fund.</li>
                        <li>-&nbsp;&nbsp;Ensure that you have entered a valid bet amount (i.e stake should be greater than zero)</li>
                        <li>-&nbsp;&nbsp;Make sure you have selected at least one horse from the above race tables.</li>
                    </ul>
                    <a href="#" class="close" style="font-weight: bolder;">CLOSE</a>
                </div>
                <div id="confirmBet">
                    <h2 style="text-align: left; float: left; width: 200px; padding: 3px; background-color: #73AD45; color: #fff;">Check Your Bet</h2><h2 style="text-align: left; float: left; width: 200px; padding: 3px; background-color: #EEEEEE; color: #D3D0CA; font-weight: normal;">Bet Confirmation</h2>
                    <div class="clearFloat"></div>
                    <p>Please check your bet and click confirm to place your bet.</p>
                    <form id='frmConfirmBet' method="post" action="<?php echo $PHP_SELF;?>">
                        <label id='cClient'><?php echo $_SESSION['clientUsn']; ?></label>
                        <input type='hidden' name='cBetAmt' id='cBetAmt' />
                        <input type='hidden' name='cBetType' id='cBetType' />
                        <input type='hidden' name='cSelLeg' id='cSelLeg' />
                        <label id='lblBetType' ></label><label id='lblBetAmt' ></label><input type="checkbox" name="cBetReplace" id="cBetReplace" checked /><label onclick="" for="cBetReplace">Replace my bet if another horse is withdrawn.</label>
                        <label id='lblPO'></label><div class="clearFloat"></div>
                        <?php
                            $c="";$l="";
                            $i = 1;
                            foreach ($raceMeeting as $rM) {
                                //$r.="<div class='selContainer'><div style='display:none;' id='sel" . $rM['_id_race'] . "'></div><div style='display:none;' id='sel-hAmt" . $rM['_id_race'] . "'></div><div id='selRace" . $rM['_id_race'] . "'>RACE " . $i . "</div><div id='sel-Hname" . $rM['_id_race'] . "'></div><div id='sel-wOd" . $rM['_id_race'] . "'></div><div id='sel-pOd" . $rM['_id_race'] . "'></div></div>";
                                $c.="<input type='hidden' name='cSel-".$rM['_id_race']."' id='cSel-".$rM['_id_race']."' ><input type='hidden' name='cOdd-".$rM['_id_race']."' id='cOdd-".$rM['_id_race']."' >";
                                //$l.="<label name='lblSel' id='lblSel'></label>";
                                $i++;
                            }
                            echo $c;
                        ?>
                        <input type='hidden' name='cPOut' id='cPOut' />
                        <div class="clearFloat"></div>
                        <label id='lblSel'></label>
                        <div class="clearFloat"></div>
                        <div id="alnCenter" style='width: 100%; text-align: center; margin-left: auto; margin-right: auto; margin-top: 3px; margin-bottom: 2px;'>
                            <button type="submit" id="btnBetConfirm" name="btnBetConfirm" >Confirm Bet</button>
                        </div>
                    </form>

                    <a href="#" class="close" style="font-weight: bolder;">CANCEL</a>
                </div>
                <div id="confirmMessage" style="display:none">
                    <h2 style="text-align: left; float: left; width: 200px; padding: 3px; background-color: #EEEEEE; color: #D3D0CA; font-weight: normal;">Check Your Bet</h2><h2 style="text-align: left; float: left; width: 200px; padding: 3px; background-color: #73AD45; color: #fff;">Bet Confirmation</h2>
                    <div class="clearFloat"></div>
                    <div id="cMsg"></div>
                    <a href="#" id="confirmMsgClose" class="close" style="font-weight: bolder;">CLOSE</a>
                </div>
            </div>
            <!-- Mask to cover the whole screen -->
            <div style="width: 1478px; height: 602px; display: none; opacity: 0.8;" id="mask"></div>
        </div>
        <!-- End Test Modal -->
                            
                            
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
                                    echo "<tr title='View Race Details' id='mting".$mting[_id_meeting]."' style='background-color:#fff; cursor: pointer;'>";
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
                        <noscript>
                        <H1>Please enable your javascript.</h1>
                        </noscript>
                        <div id="raceDetails">
                            
                        </div>
                        
                        <div id="betPanel">
                            <form id="betPanel-frm" method="post">
                                <h3>Bet Type</h3>
                                <input type="radio" name="betType" id="bWin" checked value="win"><label onclick=""  for="bWin">WIN</label>
                                <input type="radio" name="betType" id="bPlace" value="place"><label onclick=""  for="bPlace">PLACE</label>
                                <div id="winPanel">
                                    <p>Bet on the horse that you think will pass the winning post first. You can bet on single or multiple races.<br/>Select the race and horse you want to back from the above table.</p>
                                </div>
                                <div id="placePanel">
                                    <p>Bet on the horse which will be one of the first three or two to pass the winning post.<br/>Select the race and horse you want to back from the above table.</p>
                                </div>
                                
                                <br/><div id="betAmt">Bet Amount: <input type="text" name="txtBetAmt" id="txtBetAmt" autocomplete="off" pattern="^(?:[1-9]\d*(?:\.\d\d?)?|0\.[1-9]\d?|0\.0[1-9])$" required data-h5-errorid="invalid-Amt" /><div id="curr" style="display:inline-block; padding-left: 3px;"><?php echo $clBal_Curr[0]['_currency']; ?></div>
                                        <div style='float: right; margin-top: 5px; margin-right: 10px;' id="yrBal">Current Balance: <?php echo $clBal_Curr[0]['_bal'].' '.$clBal_Curr[0]['_currency']; ?></div>
                                        <?php 
                                            if(trim($clBal_Curr[0]['_promocode'])!=''){
                                                echo "<br/><div style='float: right; margin-top: 5px; margin-right: 10px;' id='promoCode'>Promo Code:&nbsp;<div style='float: right;' id='pcode'>".$clBal_Curr[0]['_promocode']."</div></div>";
                                            }
                                            
                                        ?>
                                        <div id="invalid-Amt" style="display:none; clear: both; color: red; margin-top: 5px; font-weight: bold;">Please enter a valid bet amount.</div>
                                        <div id="lessFund" style="display:none; clear: both; color: red; margin-top: 5px; font-weight: bold;">You don't have enough fund. <br/>You can either deposit more money or decrease your stake.</div>
                                </div><br/>
                                <div id='selTitle'>Your Selection:&nbsp;</div><br/>
                                <div id="betSelection">
                                   
                                <?php
                                    $i=1;
                                    
                                    foreach($raceMeeting as $rM){
                                        
                                        $r.="<div class='selContainer'><div style='display:none;' id='sel".$rM['_id_race']."'></div><div style='display:none;' id='sel-hAmt".$rM['_id_race']."'></div><div id='selRace".$rM['_id_race']."'>RACE ".$i."</div><div id='sel-Hname".$rM['_id_race']."'></div><div id='sel-wOd".$rM['_id_race']."'></div><div id='sel-pOd".$rM['_id_race']."'></div></div>";
                                        $i++;
                                        
                                    }
                                    echo $r;
                                ?>
                                </div>
                                <div class="clearFloat"></div>
                                <div id="pPOut-Text">Potential Payout: </div><div id="ppOut"></div>
                                <div class="clearFloat"></div>
                                <div id="limPO" style="display:none; clear: both; color: #000; margin-top: 5px; font-style: italic;">Limited Payout Bet</div>
                                <div id="replaceBet">
                                    <input type="checkbox" name="betReplace" id="betReplace" value="1" checked /><label onclick="" for="betReplace"><span id="spanReplace">Replace my bet if another horse is withdrawn. Applicable for single win bets. 
                                            <p>For single place bets and accumulators(win & place), bets are replaced automatically.&nbsp;&nbsp;<a id="ruleMoreInfo" href="#">More Info</a></p></span></label>
                                </div><br/><br/><br/>
                                <input type="button" name="btnBetnow" id="btnBetnow" disabled value="Bet Now"/>
                                
                            </form>
                            
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