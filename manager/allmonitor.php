<?php

include("./include/leftlink.php");
include("./utility/ClassRace.php");
include("./utility/ClassHorse.php");
include("./utility/ClassSel.php");
include("./utility/ClassPayoutMgmt.php");
include("./utility/ClassManager.php");
include("./utility/ClassCover.php");

$manager = New Manager();
$manager->confirm_Manager();

$raceId=$_GET['id'];
$mid=$_GET['m'];

if($raceId=='all'){
    //get total races
    $raceDetail=Race::getRaceMeeting($mid);
}


?>

<html>
    <head>
        <title>Welcome Admin</title>
        <link rel="stylesheet" href="../css/reset.css"/>
        <link rel="stylesheet" href="css/style.css"/>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
        <script src="js/wpmonitor.js" ></script>
        <script src="js/oddDialog.js" ></script>
        
    </head>
    <body>
        <?php include("./include/header.php"); ?>
        <div id="content">
            <div id="rightcontent">
                <a href=<?php echo $_SERVER['HTTP_REFERER']; ?>>Manage Race Meeting</a><br/><br/>
                <?php 
                if($raceId!='all'){
                    echo 'load single';
                    
                }else{
                    $i=0;
                    foreach ($raceDetail as $rd) {
                        if($rd['_rstatus']==0){
                            $rS='NO';
                        }else{
                            $rS='S'.$rd['_rstatus'];
                        }
                        if($i%3==0){
                            $i=0;
                            $tab .="<div id='clFloat' style='clear: both;'></div>";
                            $tab .= "<div style='float:left;' class='raceTableC'>";
                            $i++;
                        }else{
                           $i++; 
                           $tab .= "<div  style='float:left;' class='raceTableC'>";
                        }
                        
                        
                        
                        $tab.= "<table  class='raceTable".$rd['_id_race']."'>";
                        
                        

                                $tab.="<thead><tr class='header'>";
                                $tab.="<td>".$rS."</td><td>Race".$rd['_rnum']." [".$rd['_rdist']."] - ".$rd['_rtime'];
                                $tab.="</td><td class=rezRank>TB</td><td>APB</td><td>Odds</td><td>NB</td><td>P/L</td><td>CV</td></tr></thead>";

                            $rcard=Horse::getRaceHorses($rd['_id_race']);
                            $totPoMg=PayoutMgmt::getTotStakeNpo($rd['_id_race']);
                            $totBamt=$totPoMg[0]['_totAmt'];
                            //$totPo=$totPoMg[0]['_totPo'];
                            $margin=$totBamt*0.1;
                            $avgOd=0;
                            
                            $totCBetAmt=0;$totCPO=0;
                            $totCRez=Cover::getSumCBetsByRace($rd['_id_race']);
                            if($totCRez[0]['amt']!=''){
                               $totCBetAmt=$totCRez[0]['amt'];
                               $totCPO=$totCRez[0]['po'];
                            }
                            
                            
                            foreach($rcard as $rH){
                                $apb=0;
                                $poRez=PayoutMgmt::getStakeNpo($rd['_id_race'],$rH['_id_horse']);
                                $cBets=Cover::getCBetsByRH($rd['_id_race'],$rH['_id_horse']);
                                
                                $betAmt=$poRez[0]['_amount'];
                                $poAmt=$poRez[0]['_payout'];
                                
                                
                                if($cBets[0]['_po']!=''){
                                    $profit=($totBamt-$poAmt)-$totCBetAmt+$cBets[0]['_po'];
                                    $apb=round(($cBets[0]['_amount']/1.1)/($cBets[0]['_po']/500));
                                }else{
                                    $profit=($totBamt-$poAmt)-$totCBetAmt;
                                }
                                
                                //$profit=($totalbets[$idrace]-($rh[$row['_id_horse']]['po']))-$ttbcover+$pocover;
                                //$margin=($totalbets[$idrace]-$ttbcover)*0.1;
                                
                                
                                if($rH['_htype']==1){
                                        $avgOd=(50000/$rH[_hodds])+$avgOd;
                                        
                                        $ppb=round($betAmt/($poAmt/500));
                                        
                                        $hnameSplit= explode(' ', $rH[_hname]);
                                        if(sizeof($hnameSplit)>1){
                                            $hnam=$hnameSplit[0][0].'. '.$hnameSplit[sizeof($hnameSplit)-1];
                                        }else{
                                            $hnam=$rH[_hname];
                                        }
                                        
                                        $tab.="<tr>";
                                        $tab.="<td>".$rH[_hnum]."</td>";
                                        $tab.="<td class='hidden'>".$rH[_hname]."</td>";
                                        $tab.="<td class='hidden'>".$rd['_rnum']."-".$rH[_hnum]."</td>";
                                        $tab.="<td class='hidden'>".$rH[_id_horse]."</td>";
                                        $tab.="<td class='hidden'>".$rH[_ref_race]."</td>";
                                        $tab.="<td>".$hnam.' - '.$rH[_h_stjoc]."<br/>".$rH[_hdraw].$rH[_hchances]."</td>";
                                        $tab.="<td>".number_format($betAmt)."<br/>".number_format($rH[_hnb])."</td>";
                                        $tab.="<td>".$ppb."<br/>".round($cBets[0]['_po']/500)."/".$apb."</td>";
                                        $tab.="<td>".$rH[_hodds]."</td>";
                                        $tab.="<td class='hidden'>".$rH[_hnb]."</td>";
                                        
                                        if($poAmt - 100 > $rH[_hnb]){
                                            $tab.="<td style='background-color: #EB1924'>".$poAmt."</td>";
                                        }else{
                                            $tab.="<td>".$poAmt."</td>";
                                        }
                                        
                                        
                                        if($profit > $margin){
                                            $tab.="<td style='background-color: #00FF33'>".number_format($profit)."</td>";
                                        }elseif($profit < 0){
                                            $tab.="<td style='background-color: #EB1924;'>".number_format($profit)."</td>";
                                        }else{
                                            $tab.="<td style='background-color: #FFFF00'>".number_format($profit)."</td>";
                                        }
                                        if($cBets[0]['_amount']!=''){
                                            $tab.="<td>".number_format($cBets[0]['_amount'])."<br/>".number_format($cBets[0]['_po'])."</td>";
                                        }else{
                                            $tab.="<td>0<br/>0</td>";
                                        }
                                        
                                        $tab.="</tr>";
                                    }
                                    if($rH['_htype']==11){
                                        
                                        $hnameSplit= explode(' ', $rH[_hname]);
                                        if(sizeof($hnameSplit)>1){
                                            $hnam=$hnameSplit[0][0].'. '.$hnameSplit[sizeof($hnameSplit)-1];
                                        }else{
                                            $hnam=$rH[_hname];
                                        }
                                        
                                        $tab.="<tr style='background-color: #FFFF00'>";
                                        $tab.="<td>".$rH[_hnum]."</td>";
                                        $tab.="<td class='hidden'>--".$rH[_hname]."</td>";
                                        $tab.="<td>".$hnam.' - '.$rH[_h_stjoc]."<br/>".$rH[_hdraw].$rH[_hchances]."</td>";
                                        $tab.="<td>-<br/>-</td>";
                                        $tab.="<td>-<br/>x</td>";
                                        $tab.="<td>-</td>";
                                        $tab.="<td>-</td>";
                                        $tab.="<td>0</td>";
                                        $tab.="<td>-</td>";
                                        $tab.="</tr>";
                                    }
                                


                            }
                        $tab.="<tr class='tot'>";
                            $tab.="<td></td>";
                            $tab.="<td>--Total: </td>";
                            $tab.="<td>".$totBamt."</td>";
                            $tab.="<td>x</td>";
                            $tab.="<td>".round($avgOd)."</td>";
                            $tab.="<td>&nbsp;</td>";
                            $tab.="<td>&nbsp;</td>";
                        $tab.="</tr>";
                        $tab.= "</table>";
                        
                        $tab .= "</div>";
                    }
                    echo $tab;
                }
                ?>
            </div><!-- End Right Content -->
            <br/><br/>
        </div><!-- End Div Content -->
        <div id="clFloat" style="clear: both;"></div>
        <!-- Start Test Modal -->
                <div id="boxes">
                    <div style="top: 199.5px; left: 551.5px; display: none;" id="dialog" class="window">
                        <div id="drag"><h2>CHANGE ODDS</h2></div>
                        <div id="fChangeOdds">
                            <form id="frmChangeOdds">
                                <label for="txtNewOdds" id="hname">xx</label>
                                <input type="hidden" name="txtrefHorse" id="txtrefHorse"></input>
                                <input type="hidden" name="txtrefRace" id="txtrefRace"></input>
                                <input type="text" name="txtNewOdds" id="txtNewOdds" autocomplete="off"></input>
                                <button type="submit" id="btnSaveOdd">Save</button>
                            </form>
                            
                        </div>
                        <div id="nbLim">
                            <div id="addNb">
                                <h4>Add NB:</h4>
                                <a href="#" class="addNb">500</a>&nbsp;&nbsp;|&nbsp;&nbsp;
                                <a href="#" class="addNb">1000</a>&nbsp;&nbsp;|&nbsp;&nbsp;
                                <a href="#" class="addNb" >2500</a>&nbsp;&nbsp;|&nbsp;&nbsp;
                                <a href="#" class="addNb" >5000</a>
                                <input type="hidden" id="currHnb" name="currHnb"></input>
                            </div>
                            <div id="remNb">
                                <h4>Subtract NB:</h4>
                                <a href="#" class="remNb">500</a>&nbsp;&nbsp;|&nbsp;&nbsp;
                                <a href="#" class="remNb">1000</a>&nbsp;&nbsp;|&nbsp;&nbsp;
                                <a href="#" class="remNb">2500</a>&nbsp;&nbsp;|&nbsp;&nbsp;
                                <a href="#" class="remNb">5000</a>
                            </div>
                        </div>
                        <div id='clFloat' style='clear: both;'></div>
                        <div id="divCover">
                            <h4>Cover Horse</h4>
                            <form id="frmCover">
                                <label for="txtBAmt">Amount / Odds</label>
                                <input type="text" name="txtBAmt" id="txtBAmt" placeholder="Bet Amt" autocomplete="off"></input>
                                <input type="text" name="txtBOdds" id="txtBOdds" placeholder="Odds" autocomplete="off"></input>
                                <button type="submit" id="btnSaveCover">Save</button>
                            </form>
                            <a href="coveredbets.php" target="_blank">Covered Bets</a>
                        </div>
                        <a href="#" class="close">CLOSE</a>
                    </div>
                    <!-- Mask to cover the whole screen -->
                    <div style="width: 1478px; height: 602px; display: none; opacity: 0.3;" id="mask"></div>
                </div>
                <!-- End Test Modal -->
                
        
    </body>
</html>

