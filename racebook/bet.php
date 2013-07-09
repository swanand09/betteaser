<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

include("./utility/ClassRace.php");
include("./utility/ClassMeeting.php");
include("./utility/ClassHorse.php");
include("./utility/ClassStable.php");
include("./utility/ClassJockey.php");
include("./utility/ClassHorselist.php");
include("./utility/ClassHorseorigin.php");
include("./utility/ClassHorsetype.php");
include("./utility/ClassHorseruns.php");
include("./utility/ClassHorsenomi.php");
include("./utility/ClassClient.php");
include("./utility/ClassBet.php");
include("./utility/ClassSel.php");
include("./utility/ClassPayoutMgmt.php");
include("./utility/ClassFbpromo.php");

if (trim($_POST['action'])!=''){
    $action=trim($_POST['action']);
}

if($action=='checkEoR'){
    $raceId=trim($_POST['rid']);
    $eor=Race::checkEoR($raceId);
    
    echo $eor[0]['_eor'];
}

if($action=='getTimestamp'){
    $today = date("D j F Y, H:i");
    echo $today;
}

if($action=='getWebOdds'){
    $raceId=trim($_POST['rid']);
    
    $raceOdds=Horse::getBetOddsByRaceId($raceId);
    

    $i=1;
    foreach($raceOdds as $rd){
        
        if($rd['_htype']==1){
            //$rOdds[$rd['_hnum']]=$rd['_hodds'];
            $rOdds[$i]=$rd['_hodds'];
            $i++;
        }
        
    }
    echo json_encode($rOdds);
    
    
}



if($action=='fetchBettingProg'){
    $mId=trim($_POST['mid']);
    
    $mName=Meeting::getCurrentMeeting($mId);
    $raceDetail=Race::getRaceMeeting($mId);
    $raceNumber=sizeof($raceDetail);
    
    if($mName[0]['_mname']==''){
        echo 'No Info';
    }else{
        $mee = explode('M0', $mName[0]['_mname']);
        $firstId;
        
        //** Caching HERE **
//        $fil='cache/betprog.cache'.$mName[0]['_mname'];
//        if (file_exists($fil)) {
//            readfile($fil);
//           // echo 'xx';
//            exit();
//        }
//        ob_start();
        
        $tab = "<div id='meetingDetails'>";
        $tab.="<h4 style='float: left; margin-top: 4px;'>Meeting " . $mee[1] . "</h4>";
        $tab.="<br/><br/><br/><a class='viewRacecard' href='nomination.php?nomi=".$mId."' >Nomination</a>&nbsp;&nbsp;<a class='viewRacecard' href='racecard.php?rcard=".$mId."' >Racecard</a>&nbsp;&nbsp;<a class='viewRacecard' href='horseform.php?hform=".$mId."' >Horse Form</a>&nbsp;&nbsp;<a class='viewRacecard' href='result.php?rez=".$mId."' >Result</a>&nbsp;&nbsp;<a class='viewRacecard' href='training.php?train=".$mId."' >Training Time</a>&nbsp;&nbsp;<a class='viewRacecard' href='odds.php?odd=".$mId."' >Live Odds</a>&nbsp;&nbsp;<a class='viewRacecard' id='sel' href='betnow.php?bet=".$mId."' >Bet Now</a><br/><br/>";
        $tab.="</div>";
        $tab .= "<div id='lastUpdate'></div>";

        $tab.="<ul class='tabs-rnum'>";
        foreach($raceDetail as $rd){
            if($rd['_rnum']==1){
                $firstId=$rd['_id_race'];
                $tab.="<li title='Race ".$rd['_rnum']."' ><a href='javascript:tabSwitch(".$rd['_rnum'].", ".$raceNumber.", ".$rd['_id_race'].");'  id='form_".$rd['_rnum']."' class='active'>".$rd['_rnum']."</a><div id='tab-rId".$rd['_rnum']."' style='display: none;'>".$rd['_id_race']."</div></li>";
            }else{
                $tab.="<li title='Race ".$rd['_rnum']."' ><a href='javascript:tabSwitch(".$rd['_rnum'].", ".$raceNumber.", ".$rd['_id_race'].");' id='form_".$rd['_rnum']."'  >".$rd['_rnum']."</a><div id='tab-rId".$rd['_rnum']."' style='display: none;'>".$rd['_id_race']."</div></li>";
            }
            
        }
        $tab.="</ul>";
        
        foreach ($raceDetail as $rd) {
            if($rd['_rnum']==1){
                
                $tab.="<table style='display:block' id='hform_".$rd['_rnum']."' class='hform_content'>";
                $tab.="<tr class='rdet'>";
                $tab.="<td>" . $rd['_rnum'] . ". </td>";
                $tab.="<td class='rname'>" . $rd['_rname'] . "</td>";
                $tab.="<td>" . $rd['_rdist'] . "</td>";
                $tab.="<td class='rting'>Rating " . $rd['_rating'] . "</td>";
                $tab.="<td>" . $rd['_rtime'] . "<br/></td>";
                $tab.="</tr>";
                $tab.="<tr><td colspan='5'>";
                    $tab.="<table class='betprogCard".$rd['_id_race']."'>";
                    $tab.="<tr class='rcHeader'>";
                    $tab.="<td>#</td>";
                    $tab.="<td>Horse</td>";
                    $tab.="<td>Perf</td>";
                    $tab.="<td style='text-align: center;'>Eq.</td>";
                    $tab.="<td>Stable</td>";
                    $tab.="<td>Weight</td>";
                    $tab.="<td>Draw</td>";
                    $tab.="<td>Jockey</td>";
                    $tab.="<td>Win</td>";
                    $tab.="<td>Place</td>";
                    $tab.="</tr>";

                    $rcard=Horse::getRaceHorses($rd['_id_race']);
                    foreach($rcard as $rc){
                        $stable=Stable::getStableName($rc['_ref_stable']);
                        $jockey=Jockey::getJockeyName($rc['_ref_jockey']);
                        if($rc['_hequip']==''){ $eq='-'; } else { $eq=$rc['_hequip']; } 
                        if($rc['_htype']==1){
                            $tab.="<tr onclick='' id='rn' class='rner'>";
                            $tab.="<td style='width: 15px;'>" . $rc['_hnum'] . " </td>";
                            $tab.="<td style='width: 155px;'>" . $rc['_hname'] . " </td>";
                            $tab.="<td style='width: 85px;'>" . $rc['_hperf'] . " </td>";
                            $tab.="<td style='text-align: center; width: 35px;'>" . $eq. " </td>";
                            $tab.="<td style='width: 85px;'>" . $stable[0]['_sname'] . " </td>";
                            $tab.="<td style='width: 65px;'>" . $rc['_weight'] . " </td>";
                            $tab.="<td style='text-align: center;'>" . $rc['_hdraw'] . " </td>";
                            $tab.="<td style='width: 120px;'>" . $jockey[0]['_jname'] . " </td>";
                            $tab.= "<td class='wodd'>-</td>";
                            $tab.= "<td class='podd'>-</td>";
                            $tab.="</tr>";
                        }
//                        if($rc['_htype']==11){
//                            $tab.="<tr class='oddsNR' id='rn' title='Non Runner'>";
//                            $tab.="<td style='width: 15px;'>" . $rc['_hnum'] . " </td>";
//                            $tab.="<td style='width: 155px;'>" . $rc['_hname'] . " </td>";
//                            $tab.="<td style='width: 85px;'>" . $rc['_hperf'] . " </td>";
//                            $tab.="<td style='text-align: center; width: 35px;'>" . $eq. " </td>";
//                            $tab.="<td style='width: 85px;'>" . $stable[0]['_sname'] . " </td>";
//                            $tab.="<td style='width: 65px;'>" . $rc['_weight'] . " </td>";
//                            $tab.="<td style='text-align: center;'>" . $rc['_hdraw'] . " </td>";
//                            $tab.="<td style='width: 120px;'>" . $jockey[0]['_jname'] . " </td>";
//                            $tab.= "<td class='wodd'></td>";
//                            $tab.= "<td class='podd'></td>";
//                            $tab.="</tr>";
//                        }
                        
                    }
                    $tab.='</table>';
                    if($rd['_rstatus']==0){
                        $tab.= "<div class='rSts'><b>Race Status:&nbsp;</b>Normal</div><div class='rEor".$rd['_id_race']."'></div><br/>";
                    }else{
                        $tab.= "<div class='rSts'><b>Race Status:&nbsp;</b>Special ".$rd['_rstatus']."</div><div class='rEor".$rd['_id_race']."'></div><br/>";
                    }
                $tab.="</td></tr>";
                $tab.="</table>";
                
                
            }else{
                $tab.="<table style='display:none' id='hform_".$rd['_rnum']."' class='hform_content'>";
                $tab.="<tr class='rdet'>";
                $tab.="<td>" . $rd['_rnum'] . ". </td>";
                $tab.="<td class='rname'>" . $rd['_rname'] . "</td>";
                $tab.="<td>" . $rd['_rdist'] . "</td>";
                $tab.="<td class='rting'>Rating " . $rd['_rating'] . "</td>";
                $tab.="<td>" . $rd['_rtime'] . "<br/></td>";
                $tab.="</tr>";
                $tab.="<tr><td colspan='5'>";
                    $tab.="<table class='betprogCard".$rd['_id_race']."'>";
                    $tab.="<tr class='rcHeader'>";
                    $tab.="<td>#</td>";
                    $tab.="<td>Horse</td>";
                    $tab.="<td>Perf</td>";
                    $tab.="<td style='text-align: center;'>Eq.</td>";
                    $tab.="<td>Stable</td>";
                    $tab.="<td>Weight</td>";
                    $tab.="<td>Draw</td>";
                    $tab.="<td>Jockey</td>";
                    $tab.="<td>Win</td>";
                    $tab.="<td>Place</td>";
                    $tab.="</tr>";

                    $rcard=Horse::getRaceHorses($rd['_id_race']);
                    foreach($rcard as $rc){
                        $stable=Stable::getStableName($rc['_ref_stable']);
                        $jockey=Jockey::getJockeyName($rc['_ref_jockey']);
                        if($rc['_hequip']==''){ $eq='-'; } else { $eq=$rc['_hequip']; } 
                        if($rc['_htype']==1){
                            $tab.="<tr onclick='' class='rner' id='rn'>";
                            $tab.="<td style='width: 15px;'>" . $rc['_hnum'] . " </td>";
                            $tab.="<td style='width: 155px;'>" . $rc['_hname'] . " </td>";
                            $tab.="<td style='width: 85px;'>" . $rc['_hperf'] . " </td>";
                            $tab.="<td style='text-align: center; width: 35px;'>" . $eq. " </td>";
                            $tab.="<td style='width: 85px;'>" . $stable[0]['_sname'] . " </td>";
                            $tab.="<td style='width: 65px;'>" . $rc['_weight'] . " </td>";
                            $tab.="<td style='text-align: center;'>" . $rc['_hdraw'] . " </td>";
                            $tab.="<td style='width: 120px;'>" . $jockey[0]['_jname'] . " </td>";
                            $tab.= "<td class='wodd'>-</td>";
                            $tab.= "<td class='podd'>-</td>";
                            $tab.="</tr>";
                        }
//                        if($rc['_htype']==11){
//                            $tab.="<tr class='oddsNR' id='rn' title='Non Runner'>";
//                            $tab.="<td style='width: 15px;'>" . $rc['_hnum'] . " </td>";
//                            $tab.="<td style='width: 155px;'>" . $rc['_hname'] . " </td>";
//                            $tab.="<td style='width: 85px;'>" . $rc['_hperf'] . " </td>";
//                            $tab.="<td style='text-align: center; width: 35px;'>" . $eq. " </td>";
//                            $tab.="<td style='width: 85px;'>" . $stable[0]['_sname'] . " </td>";
//                            $tab.="<td style='width: 65px;'>" . $rc['_weight'] . " </td>";
//                            $tab.="<td style='text-align: center;'>" . $rc['_hdraw'] . " </td>";
//                            $tab.="<td style='width: 120px;'>" . $jockey[0]['_jname'] . " </td>";
//                            $tab.= "<td class='wodd'></td>";
//                            $tab.= "<td class='podd'></td>";
//                            $tab.="</tr>";
//                        }
                    }
                    $tab.='</table>';
                    if($rd['_rstatus']==0){
                        $tab.= "<div style='display:block' class='rSts'><b>Race Status:&nbsp;</b>Normal</div><div style='display:block' class='rEor".$rd['_id_race']."'></div><br/>";
                    }else{
                        $tab.= "<div style='display:block' class='rSts'><b>Race Status:&nbsp;</b>Special ".$rd['_rstatus']."</div><div style='display:block' class='rEor".$rd['_id_race']."'></div><br/>";
                    }
                $tab.="</td></tr>";
                
                
                $tab.="</table>";
                
                
                
            }
            
        }
        
        $tab.="<div id='rId' style='display:none;'>".$firstId."</div>";

        echo $tab;
        
        
        //** CACHING HERE **
//        $buffer = ob_get_contents();
//        ob_end_flush();
//        $fp = fopen($fil, 'w');
//        fwrite($fp, $buffer);
//        fclose($fp);
    
    }
}

if($action=='confirmBet'){
    $sel=trim($_POST['sel']);
    $odd=trim($_POST['odd']);
    $bAmt=trim($_POST['bAmt']);
    $bType=trim($_POST['bType']);
    $bLeg=trim($_POST['bLeg']);
    $bPO=trim($_POST['bPO']);
    $cl=trim($_POST['cl']);
    $rep=trim($_POST['rep']);
    $curr=trim($_POST['curr']);
    $fbCode=trim($_POST['fbCode']);
    
    //uncomment when uploading
//    $sel=str_replace('\"', '"', $sel);
//    $odd=str_replace('\"', '"', $odd);
    
    $sel_decode= json_decode($sel);
    $odd_decode= json_decode($odd);
    
    //echo $sel.' - '.$odd;
    
    $ss='';$od='';
    foreach($sel_decode as $s){
        $ss[]=$s;
    }
    foreach($odd_decode as $o){
        $od[]=$o;
    }
    
    //echo 'Bet Amt: '.$bAmt.' Bet Type: '.$bType.' Leg: '.$bLeg.' PO: '.$bPO.' Client: '.$cl.' Replace Bet: '.$rep;
    
    //STEPS
    //Check Accept Bets
    $accStatus=checkSelectionAcc($bLeg, $ss);
    if($accStatus==0){
        //Check if Race has ended
        $eorStatus=checkSelectionEoR($bLeg, $ss);
        if($eorStatus==0){
            //Check Balance of Client
            $chkBal=checkClientBalance($cl, $bAmt);
            if($chkBal==0){
                //Find Selection Odds
                $accBet='';
                $accBRnum='';
                $bet='';$betRnum='';
                $pO=$bAmt;
                
                $bSel=new Sel();
                $bSel->set_bamt($bAmt);
                $bSel->set_bselstatus(0);
                $bSel->set_btype($bType);
                $i=1;
                
                foreach($ss as $s){
                    $accBet.=trim($s);
                    $bet.=trim($s);
                    $tmpId=explode('h',$s);
                    $hnum=$tmpId[1];
                    $rId=explode('r', $tmpId[0]);
                    $rNum=Race::getRNumFromRId($rId[1]);
                    
                    $betRnum.=trim('r'.$rNum[0]['_rnum'].'h'.$hnum);
                    $accBRnum.=trim('r'.$rNum[0]['_rnum'].'h'.$hnum);
                    
                    $s_od=findSelOdds($rId[1], $hnum);
                    $rStat=Race::getRaceStatus($rId[1]);
                    if($rStat[0]['_rstatus']==0){
                        $accBet.='NO';
                        $accBRnum.='NO';
                        $bStat=0;
                    }else{
                        $bStat=$rStat[0]['_rstatus'];
                        $accBet.='S'.$rStat[0]['_rstatus'];
                        $accBRnum.='S'.$rStat[0]['_rstatus'];
                    }
                    if($bType=='w'){
                        $serverOdd[]=$s_od;
                        $bSel->{"set_odds{$i}"}($s_od);
                        $accBet.='('.$s_od.')';
                        $accBRnum.='('.$s_od.')';
                        $pO=$pO*($s_od/100);
                    }
                    if($bType=='p'){
                        $plOdd= pl((($s_od-100)/6)+100);
                        $serverOdd[]=$plOdd;
                        $bSel->{"set_odds{$i}"}($plOdd);
                        $accBet.='('.$plOdd.')';
                        $accBRnum.='('.$plOdd.')';
                        $pO=$pO*($plOdd/100);
                    }
                    $refH=Horse::getHorseId($rId[1],$hnum);
                    
                    $bSel->{"set_r{$i}"}($rId[1]);
                    $bSel->{"set_h{$i}"}($hnum);
                    $bSel->{"set_ref_horse{$i}"}($refH[0]['_id_horse']);
                    $bSel->{"set_rstatus{$i}"}($bStat);
                    
                    
                    $i++;
                }
                $pO=number_format($pO,2,".","");
                $clId=Client::getClientBalByUsn($cl);
                
                //echo 'Client: '.$cl.' BetAmt: '.$bAmt.' GameType: '.$bType.' Fold: '.$bLeg.' Curr: '.$curr.' Potential Payout: '.$pO;
                
                //Save data in _bet_tb & _sel_tb
                $b= new Bet();
                $b->set_ref_client($clId[0]['_id_client']); 
                $b->set_amount($bAmt); $b->set_gametype($bType);
                $b->set_fold($bLeg); $b->set_curr($curr); $b->set_bet($bet); 
                $b->set_betrnum($betRnum); $b->set_betaccp($accBet);
                $b->set_betrnumacc($accBRnum);
                $b->set_autorep($rep); $b->set_bstatus(0);
                $bDate=date("Y-m-d H:i:s");
                $b->set_date($bDate);
                $refBet=$b->savBet();
                
                
                
                if($refBet != ''){
                    $bSel->set_ref_bet($refBet);
                    $bSel->set_ppayout($pO);
                    $betSelId=$bSel->savSel($bLeg);
                    if(($betSelId != '') OR ($betSelId!=0)){
                        //Update Balance
                        $currBal=Client::checkClientBal($cl);
                        $newBal=$currBal[0]['_bal']-$bAmt;
                        
                        
                        $z=$i-1;
                        $poMg=PayoutMgmt::getPObyHorse($bSel->{"get_ref_horse{$z}"}());
                        $cRate=PayoutMgmt::getCurrRate($curr);
                        $cRate=$cRate[0]['_rate'];
                        $totAmt=0;$totPO=0;
                        if($poMg[0]['_ref_horse']!=''){
                            $totAmt=$poMg[0]['_amount']+($bAmt*$cRate);
                            $totPO=$poMg[0]['_payout']+($pO*$cRate);
                        }
                        
                        PayoutMgmt::savPoMg($poMg[0]['_ref_horse'], $totAmt, $totPO);
                        if($fbCode!=''){
                            $fbPromoCode=New Fbpromo();
                            $fbPromoCode->set_promocode($fbCode);
                            $fbPromoCode->set_ref_bet($refBet);
                            $fbPromoCode->set_ref_client($clId[0]['_id_client']);
                            $fbPromoCode->set_status(0);
                            $fbPromoCode->savfbPromo();
                            Client::updatePromocode($clId[0]['_id_client']);
                        }
                        
                        
                        if(Client::updateBal($newBal, $cl)){
                            echo '<p>Your bet has been confirmed successfully.</p>';
                        }else{
                            echo '<p>An error has occured while saving your bet. Please contact helpdesk(support@betteaser.com) for more information.</p>';
                        }
                    }
                }
                
                //echo ' r1: '.$bSel->get_r1().' h1: '.$bSel->get_h1().' ref_h1: '.$bSel->get_ref_horse1().' rstatus1: '.$bSel->get_rstatus1().' refBet: '.$bSel->get_ref_bet();
                
            }else{
                echo "You don't have enough fund.";
            }
        }else{
            echo 'Race '.$eorStatus.' has ended. Your bet has not been placed.';
        }
    }else{
        echo 'Race '.$accStatus.' is paused. Please choose another selection in the meantime. You can place this bet later.';
    }
            
    
    
    
    
    
}

function checkSelectionEoR($leg, $sel){
    $i=0;$testPrint='';
    while($i<$leg){
        $tmpId=explode('h',$sel[$i]);
        $rId=explode('r', $tmpId[0]);
        $eor=Race::checkEoR($rId[1]);
        if($eor[0]['_eor']==1){
            return $i+1;
        }
        
        $i++;
    }
    return 0;
}

function checkSelectionAcc($leg, $sel){
    $i=0;
    while($i<$leg){
        $tmpId=explode('h',$sel[$i]);
        $rId=explode('r', $tmpId[0]);
        $eor=Race::checkAcceptBet($rId[1]);
        if($eor[0]['_accept']==0){
            return $i+1;
        }
        
        $i++;
    }
    return 0;
}

function checkClientBalance($client, $betAmt){
    $bal=Client::checkClientBal($client);
    if($betAmt > $bal[0]['_bal']){
        return 1;
    }
    return 0;
}

function findSelOdds($r, $h){
    $hOdd=Horse::getBetOddsByRH($r, $h);
    
    return $hOdd[0]['_hodds'];
}

function pl($pOdd) {
    if ($pOdd % 5 > 0) {
        $pOdd = $pOdd + (5 - ($pOdd % 5));
    }
    $pOdd = floor($pOdd);
    return $pOdd;
}

?>
