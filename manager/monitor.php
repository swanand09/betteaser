<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

include("./utility/ClassHorse.php");
include("./utility/ClassPayoutMgmt.php");
include("./utility/ClassCover.php");

$action=$_POST['action'];

if($action=='changeOdds'){
    //save odds
    $hOdds=$_POST['newOdd'];
    $refRace=$_POST['refR'];
    $refH=$_POST['refH'];
    
    $chOdd=Horse::saveOddsbyRefH($refH, $hOdds, $refRace);
    if($chOdd){
        echo 'changed';
    }
}
if($action=='addNb'){
    //save odds
    $newNb=$_POST['newNb'];
    $refRace=$_POST['refR'];
    $refH=$_POST['refH'];
    
    $chNb=Horse::saveNbbyRefH($refH, $newNb, $refRace);
    if($chNb){
        echo 'changed';
    }
}
if($action=='remNb'){
    //save odds
    $newNb=$_POST['newNb'];
    $refRace=$_POST['refR'];
    $refH=$_POST['refH'];
    
    $chNb=Horse::saveNbbyRefH($refH, $newNb, $refRace);
    if($chNb){
        echo 'changed';
    }
}

if($action=='getMonitorOdds'){
    $raceId=trim($_POST['rid']);
    
    $raceOdds=Horse::getWebOddsByRaceId($raceId);
    

    
    foreach($raceOdds as $rd){
        
        if($rd['_htype']==1){
            $rOdds[$rd['_hnum']]=$rd['_hodds'];
        }
        if($rd['_htype']==11){
            $rOdds[$rd['_hnum']]=0;
        }
        
       // echo $rOdd.",";
    }
    echo json_encode($rOdds);
}

if($action=='addCover'){
    $refH=$_POST['refH'];
    $refR=$_POST['refR'];
    $amt=$_POST['amt'];
    $bOdd=$_POST['bOdd'];
    $po=$_POST['po'];
    $dat = date("Y-m-d H:i:s"); 
    $show=1;
    
    $cov=new Cover();
    $cov->set_ref_race($refR);$cov->set_ref_horse($refH);$cov->set_date($dat);
    $cov->set_amount($amt);$cov->set_odds($bOdd);$cov->set_po($po);$cov->set_show($show);
    $addRet=$cov->coverBet();
    if($addRet){
        echo 'changed';
    }
    //echo 'refH: '.$refH.' refR: '.$refR.' Amt: '.$amt.' Odd: '.$bOdd.' po: '.$po.' date: '.$dat;
}

if($action=='getMonitorTB'){
    $raceId=trim($_POST['rid']);
    $hId=trim($_POST['hid']);
    
    $poRez=PayoutMgmt::getStakeNpo($raceId,$hId);
    
    $i=0;
    foreach($poRez as $po){
        $rTB[$i]=$po['_amount'];
        $i++;
    }
    echo json_encode($rTB);
}

if($action=='changeCovSts'){
    $upShow=$_POST['upShow'];
    $cId=$_POST['cId'];
    $qryRez=Cover::updateSts($upShow, $cId);
    //echo 'UpShow: '.$upShow.' CoverId: '.$cId;
}


?>
