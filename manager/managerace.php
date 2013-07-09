<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
// include 'include\header.php';
include("./include/leftlink.php");
include("./utility/ClassRace.php");
include("./utility/ClassHorse.php");
include("./utility/ClassManager.php");



$manager = New Manager();
$manager->confirm_Manager();

$raceId=$_GET['id'];
$raceDetails=Race::getRaceDetailById($raceId);
$raceHorse=Horse::getRaceHorses($raceId);

if($raceDetails[0]['_rstatus']==0){
    $rStatus='NO';
}else{
    $rStatus='S'.$raceDetails[0]['_rstatus'];
}
?>

<html>
    <head>
        <title>Welcome Admin</title>
        <link rel="stylesheet" href="../css/reset.css"/>
        <link rel="stylesheet" href="css/style.css"/>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
        <script src="js/managerace.js" ></script>
    </head>
    <body>
        <?php include 'include\header.php'; ?>
        <div id="content">
            <div id="leftmenu">
                <?php echo $leftlink; ?>
            </div><!-- End Left Menu -->
            <div id="rightcontent">
                <a href=<?php echo $_SERVER['HTTP_REFERER']; ?>>Manage Race Meeting</a><br/><br/>
                <div id="displayRaceDetail">
                    <h3>Manage Race</h3>
                    <table id="raceBasicDetail">
                        <tr>
                           <td class="rtitle">Race Number:</td> 
                           <td><?php echo $raceDetails[0]['_rnum']; ?></td>
                        </tr>
                        <tr>
                           <td class="rtitle">Name:</td> 
                           <td><?php echo $raceDetails[0]['_rname']; ?></td> 
                        </tr>
                        <tr>
                           <td class="rtitle">Time:</td> 
                           <td><?php echo $raceDetails[0]['_rtime']; ?></td> 
                        </tr>
                        <tr>
                           <td class="rtitle">Distance:</td> 
                           <td><?php echo $raceDetails[0]['_rdist']; ?></td> 
                        </tr>
                        <tr>
                           <td class="rtitle">Rating:</td> 
                           <td><?php echo $raceDetails[0]['_rating']; ?></td> 
                        </tr>
                        <tr>
                           <td class="rtitle">Web Status:</td> 
                           <td><?php echo $raceDetails[0]['_webstatus']; ?></td> 
                        </tr>
                        <tr>
                           <td class="rtitle">Race Status:</td> 
                           <td><?php echo $rStatus; ?></td> 
                        </tr>
                    </table>
                </div><!-- END displayRaceDetail -->
                <div id="bookMessage">
                    <h3>Imposed Conditions:</h3>
                    <p>The Upper Limit of the sum total of the odds, for a book of Rs 500,
                        should be as follows:<br/>
                        -  Race with 5 or less horses: Rs 650<br/>
                        -  Race with more than 5 horses: Rs 750<br/><br/>
                    </p><p>The lower limit should be Rs 575</p>
                </div>
                <div class="clearFloat"></div>
                <br/><br/>
               <form id="frmAccept">
                        <fieldset>
                            <ol>
                                <label for=acceptBets><h3>Accept Bets</h3></label>
                                <input id=acceptBets name=acceptBets type="checkbox"  <?php if($raceDetails[0]['_accept']){echo 'checked=checked';} ?>/>
                                &nbsp;&nbsp;&nbsp;&nbsp;<button type=submit name="saveAccept" id="saveAccept" value="acceptBet">Save</button>
                            </ol>
                        </fieldset>
                </form>
                <form id="frmEoR">
                        <fieldset>
                            <ol>
                                <li>
                                <input id=EoR name=EoR type="checkbox" <?php if($raceDetails[0]['_eor']){echo 'checked=checked';} ?>/><label for=EoR><h3>Race Ended</h3></label>
                                &nbsp;&nbsp;&nbsp;&nbsp;<button type=submit name="saveEoR" id="saveEoR" value="EndRace">Save</button>
                                </li>
                            </ol>
                        </fieldset>
                </form>
                <br/>
                <div id="runningHorses">
                <h3>Running Horses</h3>
                <form id="frmRunningHorse">
                <table id="tblRunningHorse">
                        <thead>
                            <tr class="header">
                                <td>#</td>
                                <td>Place</td>
                                <td class=rezRank>Rank</td>
                                <td>Name</td>
                                <td>JocSt</td>
                                <td>Extra</td>
                                <td>NB</td>
                                <td>Odds</td>
                            </tr></thead>
                            <?php
                                $flagRank=0;$flagPRate=0;$horseAmt=sizeof($raceHorse); $runningHorse=0; $oddsAvg=0;
                                
                                
                                foreach($raceHorse as $rH){
                                    if($rH[_hrank]!=0){
                                        $flagRank=1;
                                    }
                                    if($rH[_hplacerate]!=0){
                                        $flagPRate=1;
                                    }
                                }
                                foreach($raceHorse as $rH){
                                    if($rH[_htype]==1){
                                        $runningHorse+=1;
                                    }
                                }
                                
                                echo "<p class=hAmt>".$horseAmt."</p>";
                                
                                
                                foreach($raceHorse as $rH){
                                    if($rH[_htype]==1){
                                        
                                        $oddsAvg+=50000/$rH[_hodds];
                                        echo "<tr>";
                                        echo "<td>".$rH[_hnum]."</td>";
                                        echo "<td class=selPlace><input type=text id=txtPlace".$rH[_hnum]." name=txtPlace".$rH[_hnum]." value=".$rH[_hplacerate]." autocomplete=off></td>";
                                        echo "<td>";
                                            $rez.="<select id=selRez".$rH[_hnum]." name=selRez".$rH[_hnum].">";
                                            if($flagPRate) {
                                                for ($i = 0; $i <= $runningHorse ; $i++) {
                                                    if($i==$rH[_hrank]){
                                                        if($i==0){
                                                            $rez.="<option value = '".$i."' selected=selected>NA</option>";
                                                        }else{
                                                            $rez.="<option value = '".$rH[_hrank]."' selected=selected>$rH[_hrank]</option>";
                                                        }
                                                    }else{
                                                        if($i==0){
                                                            $rez.="<option value = '".$i."' selected=selected>NA</option>";
                                                        }else{
                                                            $rez.="<option value = '".$i."' >$i</option>"; 
                                                        }
                                                    }
                                                }
                                                
                                            }else{
                                                for ($i = 0; $i < $runningHorse + 1; $i++) {
                                                    if($i==0){
                                                        $rez.="<option value = '".$i."' selected=selected>NA</option>";
                                                    }else{
                                                        $rez.="<option value = '".$i."' >$i</option>";
                                                    }
                                                }
                                            }
                                            $rez.="</select>";
                                            if($rH[_hchances]=='-'){
                                                $chance='';
                                            }else{
                                                $chance=$rH[_hchances];
                                            }
                                            echo $rez;
                                        echo "</td>";
                                        echo "<td>".$rH[_hname]."</td>";
                                        echo "<td>".$rH[_h_stjoc]."</td>";
                                        echo "<td>".$rH[_hdraw].$chance."</td>";
                                        echo "<td>".$rH[_hnb]."</td>";

                                        echo "<td><input autocomplete=off type=text id=txtOdds".$rH[_hnum]." name=txtOdds".$rH[_hnum]." value=".$rH[_hodds]."></input></td>";
                                        echo "</tr>";

                                        $rez="";
                                    }
                                }
                                
                                echo "<p class='hidden' id='tmpOddsAvg'>".floor($oddsAvg)."</p>"

                            ?>
                        <tr >
                            <td style="border:none;">&nbsp;</td>
                            <td style="border:none;">&nbsp;</td>
                            <td style="border:none;">&nbsp;</td>
                            <td style="border:none;">&nbsp;</td>
                            <td style="border:none;">&nbsp;</td>
                            <td style="border:none;">&nbsp;</td>
                            <td style="border:none;">&nbsp;</td>
                            <td class="oddsAvg"></td>
                        </tr>
                </table><br/>
                    <button type=submit name="saveRunHorse" id="saveRunHorse" value="saveRunHorse">Save</button>
                </form><br/><br/>
               </div><!-- END runningHorses -->
               <div id="eaHorses">
                <!-- EA Horses -->
                <h3>Emergency Horses</h3>
                <table id="tblEAHorse">
                        <thead>
                            <tr class="header">
                                <td>#</td>
                                <td>Name</td>
                                <td>Extra</td>
                            </tr></thead>
                        <?php 
                            foreach($raceHorse as $rH){
                                    if($rH[_htype]==2){
                                        echo "<tr>";
                                        echo "<td>".$rH[_hnum]."</td>";
                                        echo "<td>".$rH[_hname]."</td>";
                                        echo "<td>".$rH[_hchances]."</td>";
                                        echo "</tr>";
                                    }
                            }
                        ?>
                </table><br/>
                <h3>Withdrawn Horses</h3>
                <form id="frmRefund_Replace" method="post" action="hwdraw/wrfundrplace.php" target="_blank" >
                    <fieldset>
                            <ol>
                <table id="tblNRHorse">
                        <thead>
                            <tr class="header">
                                <td>#</td>
                                <td>Name</td>
                                <td>Extra</td>
                            </tr></thead>
                        <?php 
                            foreach($raceHorse as $rH){
                                    if($rH[_htype]==11){
                                        echo "<tr>";
                                        echo "<td>".$rH[_hnum]."</td>";
                                        echo "<td>".$rH[_hname]."</td>";
                                        echo "<td>".$rH[_hchances]."</td>";
                                        echo "<td><input id=chkWdraw".$rH[_hnum]." name=chkWdraw".$rH[_hnum]." type='checkbox'/>";
                                        echo "<input id=rId".$rH[_ref_race]." name=rId".$rH[_ref_race]." type='hidden' value='".$rH[_ref_race]."' />";
                                        echo "<input id=hNum".$rH[_hnum]." name=hNum".$rH[_hnum]." type='hidden' value='".$rH[_hnum]."' /></td>";
                                        echo "</tr>";
                                    }
                            }
                        ?>
                </table>
                
                        
                                <br/><button type=submit name="btnWdraw" id="btnWdraw" value="refund_replace">Refund & Replace</button>
                            </ol>
                        </fieldset>
                </form>
                <br/>
                <h3>Withdrawal on Pitch</h3>
                <form id="frmRefund_Replace" method="post" action="hwdraw/wop.php" target="_blank" >
                    <fieldset>
                            <ol>
                <table id="tblWoPHorse">
                        <thead>
                            <tr class="header">
                                <td>#</td>
                                <td>Name</td>
                                <td>Rate</td>
                            </tr></thead>
                        <?php 
                            foreach($raceHorse as $rH){
                                    if($rH[_htype]==12){
                                        echo "<tr>";
                                        echo "<td>".$rH[_hnum]."</td>";
                                        echo "<td>".$rH[_hname]."</td>";
                                        echo "<td>".$rH[_hWopRate]."</td>";
                                        echo "<td><input id=chkWopdraw".$rH[_hnum]." name=chkWopdraw".$rH[_hnum]." type='checkbox'/>";
                                        echo "<input id=WoprId".$rH[_ref_race]." name=WoprId".$rH[_ref_race]." type='hidden' value='".$rH[_ref_race]."' />";
                                        echo "<input id=WophNum".$rH[_hnum]." name=WophNum".$rH[_hnum]." type='hidden' value='".$rH[_hnum]."' /></td>";
                                        echo "</tr>";
                                    }
                            }
                        ?>
                </table>
                                <br/><button type=submit name="btnWopdraw" id="btnWopdraw" value="refund">Refund</button>
                            </ol>
                        </fieldset>
                </form><br/>
               </div><!-- END EA Horses -->
               
               <form id="frmPayWin" method="post" action="pment/pwinbets.php" target="_blank">
                        <fieldset>
                            <ol>
                                <input type="hidden" name="txtWRId" id="txtWRId" value="<?php echo $raceId; ?>" />
                                <input type="hidden" name="txtWRNum" id="txtWRId" value="<?php echo $raceDetails[0]['_rnum']; ?>" />
                                <button type=submit name="payWin" id="payWin" value="payWin">PAY WIN BETS</button>
                            </ol>
                        </fieldset>
                </form>
               <br/><br/><br/>
               <form id="frmPayPlace" method="post" action="pment/pplbets.php" target="_blank">
                        <fieldset>
                            <ol>
                                <input type="hidden" name="txtPRId" id="txtPRId" value="<?php echo $raceId; ?>" />
                                <input type="hidden" name="txtPRNum" id="txtPRId" value="<?php echo $raceDetails[0]['_rnum']; ?>" />
                                <button type=submit name="payPlace" id="payPlace" value="payPlace">PAY PLACE BETS</button>
                            </ol>
                        </fieldset>
                </form>
               <div class="clearFloat"></div>
               
               
        </div><!-- End Right Content -->
        </div><!-- End Div Content -->
    </body>
</html>
