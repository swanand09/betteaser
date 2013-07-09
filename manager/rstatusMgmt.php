<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


include("./utility/ClassRace.php");
include("./utility/ClassHorse.php");
include("./utility/ClassPayoutMgmt.php");

$action = $_POST['action'];

if($action=='checkEoR'){
    $rId=$_POST['rId'];
    $rEoR=$_POST['eorStatus'];
    
    $r=new Race();
    $r->set_eor($rEoR);
    $r->set_id_race($rId);
    $r->editRaceEoR();
    unset($r);
//    echo $rId.' '.$rEoR;
}

if($action=='checkAcceptBet'){
    $rId=$_POST['rId'];
    $rAccept=$_POST['accept'];
    
    $r=new Race();
    $r->set_id_race($rId);
    $r->set_accept($rAccept);
    $r->editAcceptBet();
    unset($r);
//        echo 'RaceId: '.$rId.', Accept: '.$rAccept;
    
    //generate payout to be used in chart
    $rezPO=PayoutMgmt::checkIfEmpty($rId);
    if($rezPO[0]['totH']==0){
        //get horse ids for race
        $hId=Horse::getRaceHorses($rId);
        foreach($hId as $h){
            PayoutMgmt::populatePO($h['_id_horse'],$rId);
        }
        
    }
    
}

if($action=='saveRaceOdds'){
    $rId=$_POST['rId'];$hnum=$_POST['hnum'];$odds=$_POST['odds'];
    Horse::saveOdds($hnum, $rId, $odds);
}

if ($action=='saveRaceRez'){
    $rId=$_POST['rId'];$hnum=$_POST['hnum'];$place=$_POST['place'];$rank=$_POST['rank'];
    Horse::saveRez_Place($hnum, $rId, $place, $rank);
}
?>
