<?php

include("./include/leftlink.php");
include("./utility/ClassRace.php");
include("./utility/ClassHorse.php");
include("./utility/ClassSel.php");
include("./utility/ClassPayoutMgmt.php");
include("./utility/ClassManager.php");

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
                    
                    //** Caching HERE **
                    $fil='cache/allmonitor.cache'.$mid;
                    if (file_exists($fil)) {
                        readfile($fil);
                        //echo 'xx';
                        exit();
                    }
                    ob_start();
                    
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
                            
                            foreach($rcard as $rH){
                               
                                if($rH['_htype']==1){
                                        
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
                                        $tab.="<td style='display:none' class='hidHid'>".$rH[_id_horse]."</td>";
                                        $tab.="<td style='display:none' class='hidRid'>".$rH[_ref_race]."</td>";
                                        $tab.="<td>".$hnam.' - '.$rH[_h_stjoc]."<br/>".$rH[_hdraw].$rH[_hchances]."</td>";
                                        $tab.="<td class='tbAmt'></td>";
                                        $tab.="<td class='ppb'></td>";
                                        $tab.="<td class='odd'></td>";
                                        $tab.="<td style='display:none' class='hidNb'></td>";
                                        $tab.="<td class='hPo'></td>";
                                        $tab.="<td class='pl'></td>";
                                        $tab.="<td  class='covH'></td>";
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
                            $tab.="<td class='totBetAmt'></td>";
                            $tab.="<td class='totApB'></td>";
                            $tab.="<td class='totOdds'></td>";
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
                            <a href="coveredbets.php">Covered Bets</a>
                        </div>
                        <a href="#" class="close">CLOSE</a>
                    </div>
                    <!-- Mask to cover the whole screen -->
                    <div style="width: 1478px; height: 602px; display: none; opacity: 0.3;" id="mask"></div>
                </div>
                <!-- End Test Modal -->
                
        
    </body>
</html>

<?php
//** CACHING HERE **
                    $buffer = ob_get_contents();
                    ob_end_flush();
                    $fp = fopen($fil, 'w');
                    fwrite($fp, $buffer);
                    fclose($fp);
?>