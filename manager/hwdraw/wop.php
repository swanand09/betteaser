<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

include("../utility/ClassRace.php");
include("../utility/ClassHorse.php");
include("../utility/ClassBet.php");
include("../utility/ClassSel.php");
include("../utility/ClassClient.php");
include("../utility/ClassManager.php");
include("../utility/ClassFbpromo.php");


$manager = New Manager();
$manager->confirm_Manager();

ini_set('max_execution_time',600);

echo 'Calling page...<br/><br/>';


if($_POST['btnWopdraw']=='refund'){
    foreach($_POST AS $k=>$v) {
        if(preg_match("/^chkWopdraw(.*)$/", $k, $matches)) {
            $chk = $v;
        }
        if(preg_match("/^WoprId(.*)$/", $k, $matches)) {
            $rId = $v;
        }
        if(preg_match("/^WophNum(.*)$/", $k, $matches)) {
            $hNum = $v;
        }
    }
    echo '<br/>rId: '.$rId.' hNum: '.$hNum.'<br/>';
    echo '<br/>rId: '.$rId.' hNum: '.$hNum.'<br/>';
    if($chk=='on'){
        echo '<br/><br/>refunding and replaceing bets<br/>';
        $rh= 'r'.$rId.'h'.$hNum;
        echo $rh;
        
        //Cancelling bets on withdrawn horse for win and place uncoment below
        $bDet=Bet::getBetByRH($rh);
        foreach($bDet as $b){
            $betId=$b['_id_bet'];
            $refClient=$b['_ref_client'];
            $betAmt=$b['_amount'];
            $fold=$b['_fold'];
            
            //Cancel betSel
            if(Sel::refundBetSel($fold, $betId)){
                if(Bet::updateStatus(-2, $betId)){
                    //update client balance
                    $clRec=Client::getClientUsnById($refClient);
                    $clUsn=$clRec[0]['_username'];
                    
                    $clRecBal=Client::checkClientBal($clUsn);
                    $clCurrBal=$clRecBal[0]['_bal'];
                    $newBal=$clCurrBal + $betAmt;
                    Client::updateBal($newBal, $clUsn);
                    
                    //get fbPromo
                    $fbpromo=Fbpromo::getFbpromoByBet($betId);
                    if(Fbpromo::refundPromo(-1, $refClient, $betId)){
                        Client::refundFbpromo($fbpromo[0]['_promocode'], $clUsn);
                    }
                }else{
                    echo 'Error Cancelling bet '.$betId.'<br/>';
                }
            }else{
                echo 'Error Cancelling bet selection '.$betId.'<br/>';
            }
        }
        
        
        //Replacing Bets other than withdrawn horse --  uncoment below
        echo'<br/>Pass Val in getBetLikeR - rId: '.$rId.' rh: '.$rh.'<br/>';
        $bRDet=Bet::getWHrBets($rh);
        echo '<pre>';
        print_r($bRDet);
        echo '</pre>';
        
        //From Result Pool
        
        //Only Single Bets whose _autorep=1 should be replaced
        //Auto replace single place bets
        
        foreach($bRDet as $bR){
            //Bets containing withdrawn horse should be converted 3fold -> 2fold
            $betMul=$bR['_bet'];
            $bAccp=$bR['_betaccp'];
            $betId=$bR['_id_bet'];
            $rfCl=$bR['_ref_client'];
            $bCurr=$bR['_curr'];
            $bAmt=$bR['_amount'];
            $gType=$bR['_gametype'];
            $currFold=$bR['_fold'];
            $bAutoRep=$bR['_autorep'];
            $newFold=$currFold-1;
            
            $nBetDate=date("Y-m-d H:i:s");

            //Getting Bet Sel Details
            $betSel=Sel::getSelByRefBet($betId, $currFold);
            
            if (strpos($betMul, $rh) !== false){
                //String contains withdrawn horse
                //Set current Bet and Betsel status to -1
                
//                Uncomment Here
                if(Bet::updateStatus(-1, $betId)){
                    $rez=Sel::updateSelStatus(-1, $betId, $currFold);
                }
                
                
                foreach($betSel as $bS){
                    $reconBetAcc='';$nBetToPlace='';$nBetRnumToPlace='';$reconRnumBetAcc='';
                    $i=1;$newP=$bAmt;$j=1;
                    $newBetSel=new Sel();
                    
                    while($i<=$currFold){
                        ${'r'.$i}=$bS['_r'.$i];
                        ${'h'.$i}=$bS['_h'.$i];
                        $cond='r'.${'r'.$i}.'h'.${'h'.$i};
                        if($rh!=$cond){
                            ${'r'.$j}=$bS['_r'.$i];
                            ${'h'.$j}=$bS['_h'.$i];
                            ${'_ref_horse'.$j}=$bS['_ref_horse'.$i];
                            ${'_rstatus'.$j}=$bS['_rstatus'.$i];
                            $rnForBAcc=Race::getRNumFromRId(${'r'.$i});
                            if(${'_rstatus'.$j}==0){
                                $nBselRsts='NO';
                            }else{
                                $nBselRsts='S'.${'_rstatus'.$i};
                            }
                            
                            ${'_odds'.$j}=$bS['_odds'.$i];
                            $newP=$newP*(${'_odds'.$j}/100);
                            $reconBetAcc.='r'.${'r'.$j}.'h'.${'h'.$j}.$nBselRsts.'('.${'_odds'.$j}.')';
                            $reconRnumBetAcc.='r'.$rnForBAcc[0]['_rnum'].'h'.${'h'.$j}.$nBselRsts.'('.${'_odds'.$j}.')';
                            $nBetToPlace.='r'.${'r'.$j}.'h'.${'h'.$j};
                            $nBetRnumToPlace.='r'.$rnForBAcc[0]['_rnum'].'h'.${'h'.$j};
                            
                            
                            //Assigning Val to Class var
                            $newBetSel->{"set_r{$j}"}(${'r'.$j});
                            $newBetSel->{"set_h{$j}"}(${'h'.$j});
                            $newBetSel->{"set_rstatus{$j}"}(${'_rstatus'.$j});
                            $newBetSel->{"set_ref_horse{$j}"}(${'_ref_horse'.$j});
                            $newBetSel->{"set_odds{$j}"}(${'_odds'.$j});
                            $j++;
                        }
                        $i++;
                    }
                    if(preg_match('/^\d+\.\d+$/',$newP)){
                        $newP=number_format($newP,2,".","");
                    }
                    $newBetSel->set_ppayout($newP);
                    $newBetSel->set_bamt($bAmt);
                    $newBetSel->set_bselstatus(0);
                    $newBetSel->set_btype($gType);

                    
                    //To Save in _bet_tb
                    //echo '<br/>RefClient: '.$rfCl.' Curr: '.$bCurr.' Amt: '.$bAmt.' Date: '.$nBetDate.' GType: '.$gType.' NewFold: '.$newFold.' Bet: '.$nBetToPlace.' BetRNum: '.$nBetRnumToPlace.' New BetAcc: '.$reconBetAcc.' New Bet Acc Rnum: '.$reconRnumBetAcc.' - New Payout: '.$newP.' AutoRep: '.$bAutoRep;
                    $n_b=new Bet();
                    $n_b->set_ref_client($rfCl);
                    $n_b->set_curr($bCurr);
                    $n_b->set_amount($bAmt);
                    $n_b->set_date($nBetDate);
                    $n_b->set_gametype($gType);
                    $n_b->set_fold($newFold);
                    $n_b->set_bet($nBetToPlace);
                    $n_b->set_betrnum($nBetRnumToPlace);
                    $n_b->set_betaccp($reconBetAcc);
                    $n_b->set_betrnumacc($reconRnumBetAcc);
                    $n_b->set_autorep($bAutoRep);
                    $n_b->set_bstatus(0);
//                    Uncomment Below
                    $newRefBet=$n_b->savBet();
                    $newBetSel->set_ref_bet($newRefBet);
                    $newBetSel->savSel($newFold);
                    
                    Fbpromo::updateRefBet($betId, $newRefBet);
                }
            }
        }
        
    }
}
?>
