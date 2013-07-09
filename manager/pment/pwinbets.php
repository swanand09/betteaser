<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 * 
 * Arr to Sql
 * http://stackoverflow.com/questions/907806/php-mysql-using-an-array-in-where-clause
 * 
 * SQL to Get Losers for Single
 * SELECT * FROM `_sel1_tb` WHERE _btype='w' AND _bselstatus=0 AND _r1=4 AND (_h1=1 OR _h1=3 OR _h1='')
 * 
 * SQL to Get Losers for LP:
 * SELECT * FROM `_sel2_tb` WHERE _btype='w' AND _bselstatus=0 AND ((_r1=7 AND _h1 NOT IN (5)) OR(_r2=8 AND _h2 NOT IN (3)))
 */

include("../utility/ClassManager.php");
include("../utility/ClassRace.php");
include("../utility/ClassHorse.php");
include("../utility/ClassBet.php");
include("../utility/ClassSel.php");
include("../utility/ClassClient.php");
include("../utility/ClassFbpromo.php");
include("../utility/ClassDepo.php");


$manager = New Manager();
$manager->confirm_Manager();

// set the PHP timelimit to 10 minutes
ini_set('max_execution_time',600);

$rId=$_POST['txtWRId'];
$rnum=$_POST['txtWRNum'];

echo 'Race Number: '.$rnum;
echo ' Race Id: '.$rId;
//check if race is over and result is available for running horses

//Get Ref Meeting
$refMeeting=Race::getRefMeetingByRid($rId);
$refMeeting=$refMeeting[0]['_ref_meeting'];
echo ' RefMeeting: '.$refMeeting;

 $flEor=0; $flRez=1;
for($i=$rnum;($i>=$rnum)&&($flEor==0);$i--){
    
    $tmpEor=Race::checkEoRByRnum($rnum,$refMeeting);
    $tmpChkRez=Horse::checkInputRez($tmpEor[0]['_id_race']);
    if($tmpEor[0]['_eor']==0){
        $flEor=1;
    }
    $chk1=0;
    foreach($tmpChkRez as $rez){
        if(($rez['_hrank'])==1){
            $chk1=1;
        }
        
    }
    if($chk1==1){
        $flRez=1;
    }else{
        $flRez=0;
    }
}

if($flEor==1){
    echo '<br/>A race has not ended yet';
}else{
    if($flRez==1){
        echo '<br/>Starting Processing Win Payment (Single & LP)';
        
        
        for($i=1;$i<=$rnum;$i++){
                echo '<br/>Losers of Race '.$i;
                $endedRaceRez=Race::checkEoRByRnum($rnum,$refMeeting);
                $endedRaceId=$endedRaceRez[0]['_id_race'];
                
                $lostHorseRez=Horse::getLossHorses($endedRaceId);
                $lostHorseId=array();
                foreach($lostHorseRez as $lHR){
                    $lostHorseId[]=$lHR['_id_horse'];
                }
                
                $lostRefHorse=array();
                for($j=1;$j<=9;$j++){
                    for($k=1;$k<=$j;$k++){
                        $lostRefHorse[]='_ref_horse'.$k.' IN ('.implode(',',$lostHorseId).')';
                    }
                    $mergedLostHorse=implode(" OR ", $lostRefHorse);
                    $qryUpLostHorse="UPDATE _sel".$j."_tb SET _bselstatus=2, _winamount=0 WHERE _btype='w' AND _bselstatus=0 AND (".$mergedLostHorse.")";
                    //echo "<br/>".$qryUpLostHorse;
                    Sel::execUpdate($qryUpLostHorse);
                    
                    //Update lost bets in _bet_tb
                    $lostRefBet=Sel::getRefBetForLostSel($j);
                    foreach($lostRefBet as $rfB){
                        Bet::updateStatus(2, $rfB['_ref_bet']);
                    }
                }
        }
        

        $qryFold=array();
        for($a=1;$a<=$rnum;$a++){
            echo '<br/>Winners of Race '.$a;
            $EorRez=Race::checkEoRByRnum($a,$refMeeting);
            $r1Id = $EorRez[0]['_id_race']; //raceId
            $tmpWinRez1 = Horse::getResultForWPO($r1Id);
            $winHorseId1 = array();
            foreach ($tmpWinRez1 as $wHR1) {
                $winHorseId1[] = $wHR1['_id_horse'];
            }
            $winHorseAmt1 = count($winHorseId1);

            $rezWop1 = Horse::getWOPRate($r1Id);
            $totWop1 = 0;
            foreach ($rezWop1 as $rW1) {
                $totWop1+=$rW1['_hWopRate'];
            }
            $WopFactor1 = (100 - $totWop1) / 100;
            
            $qryFold['1f']['w'][]=" _ref_horse1 IN (".implode(',',$winHorseId1).") ";
            $qryFold['1f']['po'][]=" _ppayout/".$winHorseAmt1."*".$WopFactor1;
        
            for($b=$a+1;$b<=$rnum;$b++){
                $EorRez=Race::checkEoRByRnum($b,$refMeeting);
                $r2Id = $EorRez[0]['_id_race']; //raceId
                $tmpWinRez2 = Horse::getResultForWPO($r2Id);
                $winHorseId2 = array();
                foreach ($tmpWinRez2 as $wHR2) {
                    $winHorseId2[] = $wHR2['_id_horse'];
                }
                $winHorseAmt2 = count($winHorseId2);

                $rezWop2 = Horse::getWOPRate($r2Id);
                $totWop2 = 0;
                foreach ($rezWop2 as $rW2) {
                    $totWop2+=$rW2['_hWopRate'];
                }
                $WopFactor2 = (100 - $totWop2) / 100;
                $qryFold['2f']['w'][]=" _ref_horse1 IN (".implode(',',$winHorseId1).") AND _ref_horse2 IN (".implode(',',$winHorseId2).") ";
                $qryFold['2f']['po'][]=" _ppayout/".($winHorseAmt1*$winHorseAmt2)."*".($WopFactor1*$WopFactor2);
            
                for($c=$b+1;$c<=$rnum;$c++){
                    $EorRez=Race::checkEoRByRnum($c,$refMeeting);
                    $r3Id = $EorRez[0]['_id_race']; //raceId
                    $tmpWinRez3 = Horse::getResultForWPO($r3Id);
                    $winHorseId3 = array();
                    foreach ($tmpWinRez3 as $wHR3) {
                        $winHorseId3[] = $wHR3['_id_horse'];
                    }
                    $winHorseAmt3 = count($winHorseId3);

                    $rezWop3 = Horse::getWOPRate($r3Id);
                    $totWop3 = 0;
                    foreach ($rezWop3 as $rW3) {
                        $totWop3+=$rW3['_hWopRate'];
                    }
                    $WopFactor3 = (100 - $totWop3) / 100;
                    $qryFold['3f']['w'][]=" _ref_horse1 IN (".implode(',',$winHorseId1).") AND _ref_horse2 IN (".implode(',',$winHorseId2).") AND _ref_horse3 IN (".implode(',',$winHorseId3).") ";
                    $qryFold['3f']['po'][]=" _ppayout/".($winHorseAmt1*$winHorseAmt2*$winHorseAmt3)."*".($WopFactor1*$WopFactor2*$WopFactor3);
                
                    for($d=$c+1;$d<=$rnum;$d++){
                        $EorRez=Race::checkEoRByRnum($d,$refMeeting);
                        $r4Id = $EorRez[0]['_id_race']; //raceId
                        $tmpWinRez4 = Horse::getResultForWPO($r4Id);
                        $winHorseId4 = array();
                        foreach ($tmpWinRez4 as $wHR4) {
                            $winHorseId4[] = $wHR4['_id_horse'];
                        }
                        $winHorseAmt4 = count($winHorseId4);

                        $rezWop4 = Horse::getWOPRate($r4Id);
                        $totWop4 = 0;
                        foreach ($rezWop4 as $rW4) {
                            $totWop4+=$rW4['_hWopRate'];
                        }
                        $WopFactor4 = (100 - $totWop4) / 100;
                        $qryFold['4f']['w'][]=" _ref_horse1 IN (".implode(',',$winHorseId1).") AND _ref_horse2 IN (".implode(',',$winHorseId2).") AND _ref_horse3 IN (".implode(',',$winHorseId3).")  AND _ref_horse4 IN (".implode(',',$winHorseId4).") ";
                        $qryFold['4f']['po'][]=" _ppayout/".($winHorseAmt1*$winHorseAmt2*$winHorseAmt3*$winHorseAmt4)."*".($WopFactor1*$WopFactor2*$WopFactor3*$WopFactor4);
                    
                        for($e=$d+1;$e<=$rnum;$e++){
                            $EorRez=Race::checkEoRByRnum($e,$refMeeting);
                            $r5Id = $EorRez[0]['_id_race']; //raceId
                            $tmpWinRez5 = Horse::getResultForWPO($r5Id);
                            $winHorseId5 = array();
                            foreach ($tmpWinRez5 as $wHR5) {
                                $winHorseId5[] = $wHR5['_id_horse'];
                            }
                            $winHorseAmt5 = count($winHorseId5);

                            $rezWop5 = Horse::getWOPRate($r5Id);
                            $totWop5 = 0;
                            foreach ($rezWop5 as $rW5) {
                                $totWop5+=$rW5['_hWopRate'];
                            }
                            $WopFactor5 = (100 - $totWop5) / 100;
                            $qryFold['5f']['w'][]=" _ref_horse1 IN (".implode(',',$winHorseId1).") AND _ref_horse2 IN (".implode(',',$winHorseId2).") AND _ref_horse3 IN (".implode(',',$winHorseId3).") AND _ref_horse4 IN (".implode(',',$winHorseId4).")  AND _ref_horse5 IN (".implode(',',$winHorseId5).") ";
                            $qryFold['5f']['po'][]=" _ppayout/".($winHorseAmt1*$winHorseAmt2*$winHorseAmt3*$winHorseAmt4*$winHorseAmt5)."*".($WopFactor1*$WopFactor2*$WopFactor3*$WopFactor4*$WopFactor5);
                        
                            for($f=$e+1;$f<=$rnum;$f++){
                                $EorRez=Race::checkEoRByRnum($f,$refMeeting);
                                $r6Id = $EorRez[0]['_id_race']; //raceId
                                $tmpWinRez6 = Horse::getResultForWPO($r6Id);
                                $winHorseId6 = array();
                                foreach ($tmpWinRez6 as $wHR6) {
                                    $winHorseId6[] = $wHR6['_id_horse'];
                                }
                                $winHorseAmt6 = count($winHorseId6);

                                $rezWop6 = Horse::getWOPRate($r6Id);
                                $totWop6 = 0;
                                foreach ($rezWop6 as $rW6) {
                                    $totWop6+=$rW6['_hWopRate'];
                                }
                                $WopFactor6 = (100 - $totWop6) / 100;
                                $qryFold['6f']['w'][]=" _ref_horse1 IN (".implode(',',$winHorseId1).") AND _ref_horse2 IN (".implode(',',$winHorseId2).") AND _ref_horse3 IN (".implode(',',$winHorseId3).") AND _ref_horse4 IN (".implode(',',$winHorseId4).")  AND _ref_horse5 IN (".implode(',',$winHorseId5).") AND _ref_horse6 IN (".implode(',',$winHorseId6).") ";
                                $qryFold['6f']['po'][]=" _ppayout/".($winHorseAmt1*$winHorseAmt2*$winHorseAmt3*$winHorseAmt4*$winHorseAmt5*$winHorseAmt6)."*".($WopFactor1*$WopFactor2*$WopFactor3*$WopFactor4*$WopFactor5*$WopFactor6);
                            
                                for($g=$f+1;$g<=$rnum;$g++){
                                    $EorRez=Race::checkEoRByRnum($g,$refMeeting);
                                    $r7Id = $EorRez[0]['_id_race']; //raceId
                                    $tmpWinRez7 = Horse::getResultForWPO($r7Id);
                                    $winHorseId7 = array();
                                    foreach ($tmpWinRez7 as $wHR7) {
                                        $winHorseId7[] = $wHR7['_id_horse'];
                                    }
                                    $winHorseAmt7 = count($winHorseId7);

                                    $rezWop7 = Horse::getWOPRate($r7Id);
                                    $totWop7 = 0;
                                    foreach ($rezWop7 as $rW7) {
                                        $totWop7+=$rW7['_hWopRate'];
                                    }
                                    $WopFactor7 = (100 - $totWop7) / 100;
                                    $qryFold['7f']['w'][]=" _ref_horse1 IN (".implode(',',$winHorseId1).") AND _ref_horse2 IN (".implode(',',$winHorseId2).") AND _ref_horse3 IN (".implode(',',$winHorseId3).") AND _ref_horse4 IN (".implode(',',$winHorseId4).")  AND _ref_horse5 IN (".implode(',',$winHorseId5).") AND _ref_horse6 IN (".implode(',',$winHorseId6).") AND _ref_horse7 IN (".implode(',',$winHorseId7).") ";
                                    $qryFold['7f']['po'][]=" _ppayout/".($winHorseAmt1*$winHorseAmt2*$winHorseAmt3*$winHorseAmt4*$winHorseAmt5*$winHorseAmt6*$winHorseAmt7)."*".($WopFactor1*$WopFactor2*$WopFactor3*$WopFactor4*$WopFactor5*$WopFactor6*$WopFactor7);
                                
                                    for($h=$g+1;$h<=$rnum;$h++){
                                        $EorRez=Race::checkEoRByRnum($h,$refMeeting);
                                        $r8Id = $EorRez[0]['_id_race']; //raceId
                                        $tmpWinRez8 = Horse::getResultForWPO($r8Id);
                                        $winHorseId8 = array();
                                        foreach ($tmpWinRez8 as $wHR8) {
                                            $winHorseId8[] = $wHR8['_id_horse'];
                                        }
                                        $winHorseAmt8 = count($winHorseId8);

                                        $rezWop8 = Horse::getWOPRate($r8Id);
                                        $totWop8 = 0;
                                        foreach ($rezWop8 as $rW8) {
                                            $totWop8+=$rW8['_hWopRate'];
                                        }
                                        $WopFactor8 = (100 - $totWop8) / 100;
                                        $qryFold['8f']['w'][]=" _ref_horse1 IN (".implode(',',$winHorseId1).") AND _ref_horse2 IN (".implode(',',$winHorseId2).") AND _ref_horse3 IN (".implode(',',$winHorseId3).") AND _ref_horse4 IN (".implode(',',$winHorseId4).")  AND _ref_horse5 IN (".implode(',',$winHorseId5).") AND _ref_horse6 IN (".implode(',',$winHorseId6).") AND _ref_horse7 IN (".implode(',',$winHorseId7).")  AND _ref_horse8 IN (".implode(',',$winHorseId8).") ";
                                        $qryFold['8f']['po'][]=" _ppayout/".($winHorseAmt1*$winHorseAmt2*$winHorseAmt3*$winHorseAmt4*$winHorseAmt5*$winHorseAmt6*$winHorseAmt7*$winHorseAmt8)."*".($WopFactor1*$WopFactor2*$WopFactor3*$WopFactor4*$WopFactor5*$WopFactor6*$WopFactor7*$WopFactor8);
                                    
                                        for($l=$h+1;$l<=$rnum;$l++){
                                            $EorRez=Race::checkEoRByRnum($l,$refMeeting);
                                            $r9Id = $EorRez[0]['_id_race']; //raceId
                                            $tmpWinRez9 = Horse::getResultForWPO($r9Id);
                                            $winHorseId9 = array();
                                            foreach ($tmpWinRez9 as $wHR9) {
                                                $winHorseId9[] = $wHR9['_id_horse'];
                                            }
                                            $winHorseAmt9 = count($winHorseId9);

                                            $rezWop9 = Horse::getWOPRate($r9Id);
                                            $totWop9 = 0;
                                            foreach ($rezWop9 as $rW9) {
                                                $totWop9+=$rW9['_hWopRate'];
                                            }
                                            $WopFactor9 = (100 - $totWop9) / 100;
                                            $qryFold['9f']['w'][]=" _ref_horse1 IN (".implode(',',$winHorseId1).") AND _ref_horse2 IN (".implode(',',$winHorseId2).") AND _ref_horse3 IN (".implode(',',$winHorseId3).") AND _ref_horse4 IN (".implode(',',$winHorseId4).")  AND _ref_horse5 IN (".implode(',',$winHorseId5).") AND _ref_horse6 IN (".implode(',',$winHorseId6).") AND _ref_horse7 IN (".implode(',',$winHorseId7).")  AND _ref_horse8 IN (".implode(',',$winHorseId8).") AND _ref_horse9 IN (".implode(',',$winHorseId9).") ";
                                            $qryFold['9f']['po'][]=" _ppayout/".($winHorseAmt1*$winHorseAmt2*$winHorseAmt3*$winHorseAmt4*$winHorseAmt5*$winHorseAmt6*$winHorseAmt7*$winHorseAmt8*$winHorseAmt9)."*".($WopFactor1*$WopFactor2*$WopFactor3*$WopFactor4*$WopFactor5*$WopFactor6*$WopFactor7*$WopFactor8*$WopFactor9);
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
//        echo '<pre>';
//        print_r($qryFold);
//        echo '</pre>';
        
        for($i=1;$i<=$rnum;$i++){
            echo '<br/>Updating Winners '.$i;
            $winDate=date("Y-m-d H:i:s");
            $numQry=count($qryFold[$i.'f']['po']);
            for($j=0;$j<$numQry;$j++){
                $qryUpd="UPDATE _sel".$i."_tb SET _bselstatus=1, _windate='".$winDate."', _winamount=round(".$qryFold[$i.'f']['po'][$j].",2) WHERE ".$qryFold[$i.'f']['w'][$j]." AND _bselstatus=0 AND _btype='w'";
                echo '<br/>'.$qryUpd;
                //Uncomment below
                Sel::execUpdate($qryUpd);
                
                $qrySelWinBets="SELECT _ref_bet, _winamount FROM _sel".$i."_tb WHERE ".$qryFold[$i.'f']['w'][$j]." AND _bselstatus=1 AND _btype='w' AND _windate='".$winDate."'";
                echo '<br/>'.$qrySelWinBets;
                //Uncomment below
                $rezWinBets=Sel::execSelect($qrySelWinBets);
                foreach($rezWinBets as $rWB){
                       //update _bet_tb
                       $qryUpdWinBets="UPDATE _bet_tb SET _bstatus=1 WHERE _id_bet=".$rWB['_ref_bet'];
                       Sel::execUpdate($qryUpdWinBets);
                       
                       //update client balance
                       $clId=Bet::getClientByBetId($rWB['_ref_bet']);
                       $clId=$clId[0]['_ref_client'];
                       
                       $cbal=Client::checkClientBalById($clId);
                       $cbal=$cbal[0]['_bal'];
                       $newBal=$cbal+$rWB['_winamount'];
                       
                       Client::updateBalById($newBal, $clId);
                }
            }
        }
        
        $lBets= Fbpromo::getFbLostBet();
        
        
        foreach($lBets as $lb){

            $amt=10;

            //deposit 10Curr in cl account
            $pPromo=new Depo();
            $pPromo->set_ref_client($lb['_ref_client']);
            $pPromo->set_amount($amt);
            $pPromo->set_depodat(date("Y-m-d H:i:s"));
            $pPromo->deposit();

            $bal=Client::checkClientBalById($lb['_ref_client']);
            $nbal=$bal[0]['_bal']+$amt;
            
            Client::updateBalById($nbal, $lb['_ref_client']);

            //update status
            Fbpromo::refundPromo(1, $lb['_ref_client'], $lb['_ref_bet']);
            unset($pPromo);
        }

        $wBets = Fbpromo::getFbWonBet();
        foreach($wBets as $wb){
            //update status
            Fbpromo::refundPromo(2, $lb['_ref_client'], $lb['_ref_bet']);
        }

        
    }else{
        echo '<br/>Missing result for 1 or more races';
    }
    
}




function getCombinations($array)
{
	$length=sizeof($array);
	$combocount=pow(2,$length);
	for ($i = 0;$i<=$combocount;$i++)
	{
	    $binary=decextbin($i,$length);
		$combination='';
		for($j=0;$j<$length;$j++)
		{
			if($binary[$j]=="1")
				$combination.=$array[$j];
		}
		$combinationsarray[]=$combination;
		//echo $combination."&lt;br&gt;";
	}
	return $combinationsarray;
}

function decextbin($decimalnumber,$bit)
{
    $maxval = 1;
    $sumval = 1;
    for($i=1;$i< $bit;$i++)
    {
        $maxval = $maxval * 2;
        $sumval = $sumval + $maxval;
    }
 
    if ($sumval < $decimalnumber) return 'ERROR - Not enough bits to display this figure in binary.';
    for($bitvalue=$maxval;$bitvalue>=1;$bitvalue=$bitvalue/2)
    {
        if (($decimalnumber/$bitvalue) >= 1) $thisbit = 1; else $thisbit = 0;
        if ($thisbit == 1) $decimalnumber = $decimalnumber - $bitvalue;
    $binarynumber .= $thisbit;
    }
	return $binarynumber;
}


// set the PHP timelimit to 10 minutes
ini_set('max_execution_time',30);

?>
