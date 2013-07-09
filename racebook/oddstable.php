<?php

include 'utility\ClassRace.php';
include 'utility\ClassMeeting.php';
include 'utility\ClassHorse.php';
include 'utility\ClassStable.php';
include 'utility\ClassJockey.php';





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
if($action=='getOddsTable'){
    $mId=trim($_POST['mid']);
    
    $mName=Meeting::getCurrentMeeting($mId);
    $raceDetail=Race::getRaceMeeting($mId);
    $raceNumber=sizeof($raceDetail);
    
    if($mName[0]['_mname']==''){
        echo 'No Info';
    }else{
        $mee = explode('M0', $mName[0]['_mname']);
        
        //** Caching HERE **
        $fil='cache/oddstable.cache'.$mName[0]['_mname'];
        if (file_exists($fil)) {
            readfile($fil);
            //echo 'xx';
            exit();
        }
        ob_start();
        
        $tab = "<div id='meetingDetails'>";
        $tab.="<h4 style='float: left; margin-top: 4px;'>Meeting " . $mee[1] . "</h4>";
        $tab.="<br/><br/><br/><a class='viewRacecard' href='nomination.php?nomi=".$mId."' >Nomination</a>&nbsp;&nbsp;<a class='viewRacecard' href='racecard.php?rcard=".$mId."' >Racecard</a>&nbsp;&nbsp;<a class='viewRacecard' href='horseform.php?hform=".$mId."' >Horse Form</a>&nbsp;&nbsp;<a class='viewRacecard' href='result.php?rez=".$mId."' >Result</a>&nbsp;&nbsp;<a class='viewRacecard' href='training.php?train=".$mId."' >Training Time</a>&nbsp;&nbsp;<a class='viewRacecard' id='sel' href='odds.php?odd=".$mId."' >Live Odds</a>&nbsp;&nbsp;<a class='viewRacecard' href='betnow.php?bet=".$mId."' >Bet Now</a><br/><br/>";
        $tab.="</div>";
        
        $tab .= "<div id='lastUpdate'></div>";
        foreach ($raceDetail as $rd) {
            $tab .= "<div class='raceTable'>";
            
            $tab.= "<table class='oddsTable".$rd['_id_race']."'>";
            
                    $tab.= "<tr class='hdr'>";
                    $tab.= "<td colspan='2'>Race ".$rd['_rnum']."</td>";
                    $tab.= "<td>Win</td>";
                    $tab.= "<td>Place</td>";
                    $tab.= "</tr>";
            
                $rcard=Horse::getRaceHorses($rd['_id_race']);
                foreach($rcard as $rc){
                    if($rc['_htype']==1){
                        $tab.= "<tr onclick=''>";
                        $tab.= "<td class='hnum'>".$rc['_hnum'].". </td>";
                        $tab.= "<td class='hnam'>".$rc['_hname']."</td>";
                        $tab.= "<td class='wodd'></td>";
                        $tab.= "<td class='podd'></td>";
                        $tab.= "</tr>";
                    }
                    if($rc['_htype']==11){
                        $tab.= "<tr onclick='' class='oddsNR' title='Non Runner'>";
                        $tab.= "<td class='hnum'>".$rc['_hnum'].". </td>";
                        $tab.= "<td class='hnam'>".$rc['_hname']."</td>";
                        $tab.= "<td class='wodd'></td>";
                        $tab.= "<td class='podd'></td>";
                        $tab.= "</tr>";
                    }
                    
                    
                }
            $tab.= "</table>";
            if($rd['_rstatus']==0){
                $tab.= "<div class='rSts'><b>Race Status:&nbsp;</b>Normal</div><div class='rEor".$rd['_id_race']."'></div><br/>";
            }else{
                $tab.= "<div class='rSts'><b>Race Status:&nbsp;</b>Special ".$rd['_rstatus']."</div><div class='rEor".$rd['_id_race']."'></div><br/>";
            }
            
            $tab .= "</div>";
        }
        echo $tab;
        
        //** CACHING HERE **
        $buffer = ob_get_contents();
        ob_end_flush();
        $fp = fopen($fil, 'w');
        fwrite($fp, $buffer);
        fclose($fp);
    }
    
}


?>
