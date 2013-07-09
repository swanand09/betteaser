<?php


include("../utility/ClassRace.php");
include("../utility/ClassHorse.php");
include("../utility/ClassBet.php");
include("../utility/ClassSel.php");
include("../utility/ClassClient.php");
include("../utility/ClassManager.php");
include("../utility/ClassFbpromo.php");


$manager = New Manager();
$manager->confirm_Manager();
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 * 
 * Test Case: Withdraw 1-5
 * Steps:
 * Set new odds.
 * Get Win bet-type (_gametype = w)
 *  - set _bstatus=-2 for single bets 1-5
 *  - replace bets for singles LIKE '%r1h%' AND NOT LIKE '%r1h5%'
 *  - replace bets for folds with new odds LIKE '%r1h%' AND NOT LIKE '%r1h5%'
 * 
 * Get Place bet-type (_gametype = p)
 * 
 */

// set the PHP timelimit to 10 minutes
ini_set('max_execution_time',600);

echo 'Calling page...<br/><br/>';

if($_POST['btnWdraw']=='refund_replace'){
    foreach($_POST AS $k=>$v) {
        if(preg_match("/^chkWdraw(.*)$/", $k, $matches)) {
            $chk = $v;
        }
        if(preg_match("/^rId(.*)$/", $k, $matches)) {
            $rId = $v;
        }
        if(preg_match("/^hNum(.*)$/", $k, $matches)) {
            $hNum = $v;
        }
    }
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
        $bRDet=Bet::getBetLikeR($rId, $rh);
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
            
            }else{
                
//                Uncomment Here
                if(Bet::updateStatus(-1, $betId)){
                    $rez=Sel::updateSelStatus(-1, $betId, $currFold);
                }
                
                $fARep=0;
                if(($currFold==1)&&($bAutoRep==0)&&($gType=='w')){
                        $fARep=1;
                }
                if($fARep==0){
                    foreach($betSel as $bS){
                        $reconBetAcc='';$nBetToPlace='';$nBetRnumToPlace='';$reconRnumBetAcc='';
                        $i=1;$newP=$bAmt;
                        $newBetSel=new Sel();


                        while($i<=$currFold){
                            ${'r'.$i}=$bS['_r'.$i];
                            ${'h'.$i}=$bS['_h'.$i];
                            ${'_ref_horse'.$i}=$bS['_ref_horse'.$i];

                            $rnForBAcc=Race::getRNumFromRId(${'r'.$i});
                            if($bS['_r'.$i]==$rId){
                                $nSts=Race::getRaceStatus($rId);
                                ${'_rstatus'.$i}=$nSts[0]['_rstatus'];

                                $nOdds=Horse::getBetOddsByRH($rId, ${'h'.$i});
                                ${'_odds'.$i}=$nOdds[0]['_hodds'];
                                if($gType=='p'){
                                    $nOdds= pl((($nOdds[0]['_hodds']-100)/6)+100);
                                    ${'_odds'.$i}=$nOdds;
                                }

                            }else{
                                ${'_rstatus'.$i}=$bS['_rstatus'.$i];
                                ${'_odds'.$i}=$bS['_odds'.$i];
                            }

                            if(${'_rstatus'.$i}==0){
                               $nBselRsts='NO';
                            }else{
                               $nBselRsts='S'.${'_rstatus'.$i};
                            }


                            $newP=$newP*(${'_odds'.$i}/100);
                            $reconBetAcc.='r'.${'r'.$i}.'h'.${'h'.$i}.$nBselRsts.'('.${'_odds'.$i}.')';
                            $reconRnumBetAcc.='r'.$rnForBAcc[0]['_rnum'].'h'.${'h'.$i}.$nBselRsts.'('.${'_odds'.$i}.')';
                            $nBetToPlace.='r'.${'r'.$i}.'h'.${'h'.$i};
                            $nBetRnumToPlace.='r'.$rnForBAcc[0]['_rnum'].'h'.${'h'.$i};

                            $newBetSel->{"set_r{$i}"}(${'r'.$i});
                            $newBetSel->{"set_h{$i}"}(${'h'.$i});
                            $newBetSel->{"set_rstatus{$i}"}(${'_rstatus'.$i});
                            $newBetSel->{"set_ref_horse{$i}"}(${'_ref_horse'.$i});
                            $newBetSel->{"set_odds{$i}"}(${'_odds'.$i});

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
                        $n_b->set_fold($currFold);
                        $n_b->set_bet($nBetToPlace);
                        $n_b->set_betrnum($nBetRnumToPlace);
                        $n_b->set_betaccp($reconBetAcc);
                        $n_b->set_betrnumacc($reconRnumBetAcc);
                        $n_b->set_autorep($bAutoRep);
                        $n_b->set_bstatus(0);
    //                    Uncomment Below
                        $newRefBet=$n_b->savBet();
                        $newBetSel->set_ref_bet($newRefBet);
                        $newBetSel->savSel($currFold);

                        Fbpromo::updateRefBet($betId, $newRefBet);
                        echo '<br/>RefClient: '.$rfCl.' Curr: '.$bCurr.' Amt: '.$bAmt.' Date: '.$nBetDate.' GType: '.$gType.' CurrFold: '.$currFold.' Bet: '.$nBetToPlace.' BetRNum: '.$nBetRnumToPlace.' New BetAcc: '.$reconBetAcc.' New Bet Acc Rnum: '.$reconRnumBetAcc.' - New Payout: '.$newP.' AutoRep: '.$bAutoRep;
                    }
                }
            }
                
        }
        
        
        
    }
    
}

function pl($pOdd) {
    if ($pOdd % 5 > 0) {
        $pOdd = $pOdd + (5 - ($pOdd % 5));
    }
    $pOdd = floor($pOdd);
    return $pOdd;
}


// set the PHP timelimit to 10 minutes
ini_set('max_execution_time',30);
?>
