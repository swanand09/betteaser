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
include("./utility/ClassTraining.php");


if (trim($_POST['action'])!=''){
    $action=trim($_POST['action']);
}


if($action=='getNomination'){
    $mId=trim($_POST['mid']);
    
    $mName=Meeting::getCurrentMeeting($mId);
    $raceDetail=Race::getRaceMeeting($mId);
    $raceNumber=sizeof($raceDetail);
    
    if($mName[0]['_mname']==''){
        echo 'No Info';
    }else{
        $mee = explode('M0', $mName[0]['_mname']);
        
        //** Caching HERE **
        $fil='cache/nomi.cache'.$mName[0]['_mname'];
        if (file_exists($fil)) {
            readfile($fil);
            //echo 'xx';
            exit();
        }
        ob_start();
        
        
        $tab = "<div id='meetingDetails'>";
        $tab.="<h4 style='float: left; margin-top: 4px;'>Meeting " . $mee[1] . "</h4>";
        $tab.="<br/><br/><br/><a class='viewRacecard' id='sel' href='nomination.php?nomi=".$mId."' >Nomination</a>&nbsp;&nbsp;<a class='viewRacecard' href='racecard.php?rcard=".$mId."' >Racecard</a>&nbsp;&nbsp;<a class='viewRacecard' href='horseform.php?hform=".$mId."' >Horse Form</a>&nbsp;&nbsp;<a class='viewRacecard' href='result.php?rez=".$mId."' >Result</a>&nbsp;&nbsp;<a class='viewRacecard' href='training.php?train=".$mId."' >Training Time</a>&nbsp;&nbsp;<a class='viewRacecard' href='odds.php?odd=".$mId."' >Live Odds</a>&nbsp;&nbsp;<a class='viewRacecard' href='betnow.php?bet=".$mId."' >Bet Now</a><br/><br/>";
        $tab.="</div>";

        $tab.="<ul class='tabs-rnum'>";
        foreach($raceDetail as $rd){
            if($rd['_rnum']==1){
                $tab.="<li title='Race ".$rd['_rnum']."' ><a href='javascript:tabSwitch(".$rd['_rnum'].", ".$raceNumber.");'  id='form_".$rd['_rnum']."' class='active'>".$rd['_rnum']."</a></li>";
            }else{
                $tab.="<li title='Race ".$rd['_rnum']."' ><a href='javascript:tabSwitch(".$rd['_rnum'].", ".$raceNumber.");' id='form_".$rd['_rnum']."'  >".$rd['_rnum']."</a></li>";
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
                $tab.="<table class='racecard'>";
                    $tab.="<tr class='rcHeader'>";
                    $tab.="<td>#</td>";
                    $tab.="<td>Horse</td>";
                    $tab.="<td>Stable</td>";
                    $tab.="<td>Weight</td>";
                    $tab.="<td>Draw</td>";
                    $tab.="</tr>";
                    $hnomi=  Horsenomi::getRaceNomi($rd['_id_race']);
                    foreach($hnomi as $hm){
                        $stable=Stable::getStableName($hm['_ref_stable']);
                        $hname=  Horselist::getHorsenameById($hm['_ref_horselist']);
                        $tab.="<tr>";
                        $tab.="<td>" . $hm['_num'] . " </td>";
                        $tab.="<td>" . $hname[0]['_hname'] . " </td>";
                        $tab.="<td>" . $stable[0]['_sname'] . " </td>";
                        $tab.="<td>" . $hm['_weight'] . " </td>";
                        $tab.="<td>" . $hm['_draw'] . " </td>";
                        $tab.="</tr>";
                    }
                
                $tab.="</table>";
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
                $tab.="<table class='racecard'>";
                    $tab.="<tr class='rcHeader'>";
                    $tab.="<td>#</td>";
                    $tab.="<td>Horse</td>";
                    $tab.="<td>Stable</td>";
                    $tab.="<td>Weight</td>";
                    $tab.="<td>Draw</td>";
                    $tab.="</tr>";
                    $hnomi=  Horsenomi::getRaceNomi($rd['_id_race']);
                    foreach($hnomi as $hm){
                        $stable=Stable::getStableName($hm['_ref_stable']);
                        $hname=  Horselist::getHorsenameById($hm['_ref_horselist']);
                        $tab.="<tr>";
                        $tab.="<td>" . $hm['_num'] . " </td>";
                        $tab.="<td>" . $hname[0]['_hname'] . " </td>";
                        $tab.="<td>" . $stable[0]['_sname'] . " </td>";
                        $tab.="<td>" . $hm['_weight'] . " </td>";
                        $tab.="<td>" . $hm['_draw'] . " </td>";
                        $tab.="</tr>";
                    }
                
                $tab.="</table>";
                
                $tab.="</td></tr>";
                $tab.="</table>";
            }
        }
    
    }
    echo $tab;
    
    //** CACHING HERE **
    $buffer = ob_get_contents();
    ob_end_flush();
    $fp = fopen($fil, 'w');
    fwrite($fp, $buffer);
    fclose($fp);
}

if($action=='getRaceDetails'){
    $mId=trim($_POST['mid']);
    
    $mName=Meeting::getMeetingName($mId);
    $raceDetail=Race::getRaceMeeting($mId);
    
    $mee = explode('M0', $mName[0]['_mname']);
    
    
    $tab="<div id='meetingDetails'>";
    $tab.="<h4 style='float: left; margin-top: 4px;'>Meeting ".$mee[1]."</h4>";
    $tab.="<br/><br/><br/><a class='viewRacecard' href='nomination.php?nomi=".$mId."' >Nomination</a>&nbsp;&nbsp;<a class='viewRacecard' id='sel' href='racecard.php?rcard=".$mId."' >Racecard</a>&nbsp;&nbsp;<a class='viewRacecard' href='horseform.php?hform=".$mId."' >Horse Form</a>&nbsp;&nbsp;<a class='viewRacecard' href='result.php?rez=".$mId."' >Result</a>&nbsp;&nbsp;<a class='viewRacecard' href='training.php?train=".$mId."' >Training</a>&nbsp;&nbsp;<a class='viewRacecard' href='odds.php?odd=".$mId."' >Live Odds</a>&nbsp;&nbsp;<a class='viewRacecard' href='betnow.php?bet=".$mId."' >Bet Now</a><br/><br/>";
    $tab.="</div>";
    
    $tab.='<table>';
    foreach($raceDetail as $rd){
        $tab.="<tr class='rdet'>";
        $tab.="<td>".$rd['_rnum'].". </td>";
        $tab.="<td class='rname'>".$rd['_rname']."</td>";
        $tab.="<td>".$rd['_rdist']."</td>";
        $tab.="<td class='rting'>Rating ".$rd['_rating']."</td>";
        $tab.="<td>".$rd['_rtime']."<br/></td>";
        $tab.="</tr>";
        $tab.="<tr class='analyse'>";
        $tab.="<td colspan='5'><span class='analyseTitle'><br/>".utf8_encode($rd['_analyse_title_en'])."</span><p>".utf8_encode($rd['_analyse_text_en'])."</p><br/></td>";
        $tab.="</tr>";
        $tab.="<tr class='analyse'>";
        $tab.="<td colspan='5'><span class='analyseTitle'>".utf8_encode($rd['_analyse_title_fr'])."</span><p>".utf8_encode($rd['_analyse_text_fr'])."</p><br/></td>";
        $tab.="</tr>";
        
    }
    $tab.="</table>";
    
    echo $tab;
    
}

if($action=='getRacecard'){
    $mId=trim($_POST['mid']);
    
    $mName=Meeting::getCurrentMeeting($mId);
    $raceDetail=Race::getRaceMeeting($mId);
    $raceNumber=sizeof($raceDetail);
    
    if($mName[0]['_mname']==''){
        echo 'No Info';
    }else{
        $mee = explode('M0', $mName[0]['_mname']);
        
        //** Caching HERE **
        $fil='cache/rcard.cache'.$mName[0]['_mname'];
        if (file_exists($fil)) {
            readfile($fil);
           // echo 'xx';
            exit();
        }
        ob_start();
        
        $tab = "<div id='meetingDetails'>";
        $tab.="<h4 style='float: left; margin-top: 4px;'>Meeting " . $mee[1] . "</h4>";
        $tab.="<br/><br/><br/><a class='viewRacecard' href='nomination.php?nomi=".$mId."' >Nomination</a>&nbsp;&nbsp;<a class='viewRacecard' id='sel' href='racecard.php?rcard=".$mId."' >Racecard</a>&nbsp;&nbsp;<a class='viewRacecard' href='horseform.php?hform=".$mId."' >Horse Form</a>&nbsp;&nbsp;<a class='viewRacecard' href='result.php?rez=".$mId."' >Result</a>&nbsp;&nbsp;<a class='viewRacecard' href='training.php?train=".$mId."' >Training Time</a>&nbsp;&nbsp;<a class='viewRacecard' href='odds.php?odd=".$mId."' >Live Odds</a>&nbsp;&nbsp;<a class='viewRacecard' href='betnow.php?bet=".$mId."' >Bet Now</a><br/><br/>";
        $tab.="</div>";

        $tab.="<ul class='tabs-rnum'>";
        foreach($raceDetail as $rd){
            if($rd['_rnum']==1){
                $tab.="<li title='Race ".$rd['_rnum']."' ><a href='javascript:tabSwitch(".$rd['_rnum'].", ".$raceNumber.");'  id='form_".$rd['_rnum']."' class='active'>".$rd['_rnum']."</a></li>";
            }else{
                $tab.="<li title='Race ".$rd['_rnum']."' ><a href='javascript:tabSwitch(".$rd['_rnum'].", ".$raceNumber.");' id='form_".$rd['_rnum']."'  >".$rd['_rnum']."</a></li>";
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
                    $tab.="<table class='racecard'>";
                    $tab.="<tr class='rcHeader'>";
                    $tab.="<td>#</td>";
                    $tab.="<td>Horse</td>";
                    $tab.="<td>Perf</td>";
                    $tab.="<td>Age</td>";
                    $tab.="<td style='text-align: center;'>Eq.</td>";
                    $tab.="<td>Stable</td>";
                    $tab.="<td>Weight</td>";
                    $tab.="<td>Draw</td>";
                    $tab.="<td>Jockey</td>";
                    $tab.="<td>Time Factor</td>";
                    $tab.="</tr>";

                    $rcard=Horse::getRaceHorses($rd['_id_race']);
                    foreach($rcard as $rc){
                        $stable=Stable::getStableName($rc['_ref_stable']);
                        $jockey=Jockey::getJockeyName($rc['_ref_jockey']);
                        if($rc['_hequip']==''){ $eq='-'; } else { $eq=$rc['_hequip']; } 
                        if($rc['_htype']==1){
                            $tab.="<tr>";
                            $tab.="<td style='width: 15px;'>" . $rc['_hnum'] . " </td>";
                            $tab.="<td style='width: 155px;'>" . $rc['_hname'] . " </td>";
                            $tab.="<td style='width: 85px;'>" . $rc['_hperf'] . " </td>";
                            $tab.="<td style='text-align: center;'>" . $rc['_hage'] . " </td>";
                            $tab.="<td style='text-align: center; width: 35px;'>" . $eq. " </td>";
                            $tab.="<td style='width: 85px;'>" . $stable[0]['_sname'] . " </td>";
                            $tab.="<td style='width: 65px;'>" . $rc['_weight'] . " </td>";
                            $tab.="<td style='text-align: center;'>" . $rc['_hdraw'] . " </td>";
                            $tab.="<td style='width: 120px;'>" . $jockey[0]['_jname'] . " </td>";
                            $tab.="<td>" . $rc['_htfactor'] . " </td>";
                            $tab.="</tr>";
                        }
                        if($rc['_htype']==11){
                            $tab.="<tr class='oddsNR' title='Non Runner'>";
                            $tab.="<td style='width: 15px;'>" . $rc['_hnum'] . " </td>";
                            $tab.="<td style='width: 155px;'>" . $rc['_hname'] . " </td>";
                            $tab.="<td style='width: 85px;'>" . $rc['_hperf'] . " </td>";
                            $tab.="<td style='text-align: center;'>" . $rc['_hage'] . " </td>";
                            $tab.="<td style='text-align: center; width: 35px;'>" . $eq. " </td>";
                            $tab.="<td style='width: 85px;'>" . $stable[0]['_sname'] . " </td>";
                            $tab.="<td style='width: 65px;'>" . $rc['_weight'] . " </td>";
                            $tab.="<td style='text-align: center;'>" . $rc['_hdraw'] . " </td>";
                            $tab.="<td style='width: 120px;'>" . $jockey[0]['_jname'] . " </td>";
                            $tab.="<td>" . $rc['_htfactor'] . " </td>";
                            $tab.="</tr>";
                        }
                        if($rc['_htype']==2){
                            $tab.="<tr>";
                            $tab.="<td style='width: 15px;'>EA </td>";
                            $tab.="<td style='width: 155px;'>" . $rc['_hname'] . " </td>";
                            $tab.="<td style='width: 85px;'>" . $rc['_hperf'] . " </td>";
                            $tab.="<td style='text-align: center;'>" . $rc['_hage'] . " </td>";
                            $tab.="<td style='text-align: center; width: 35px;'>" . $eq. " </td>";
                            $tab.="<td style='width: 85px;'>" . $stable[0]['_sname'] . " </td>";
                            $tab.="<td style='width: 65px;'>" . $rc['_weight'] . " </td>";
                            $tab.="<td style='text-align: center;'>" . $rc['_hdraw'] . " </td>";
                            $tab.="<td style='width: 120px;'>" . $jockey[0]['_jname'] . " </td>";
                            $tab.="<td>" . $rc['_htfactor'] . " </td>";
                            $tab.="</tr>";
                        }
                        
                    }
                    $tab.='</table>';
                $tab.="</td></tr>";
                
                $tab.="<tr class='analyse'>";
                $tab.="<td colspan='5'><span class='analyseTitle'><br/>".utf8_encode($rd['_analyse_title_en'])."</span><p>".utf8_encode($rd['_analyse_text_en'])."</p><br/></td>";
                $tab.="</tr>";
                $tab.="<tr class='analyse'>";
                $tab.="<td colspan='5'><span class='analyseTitle'>".utf8_encode($rd['_analyse_title_fr'])."</span><p>".utf8_encode($rd['_analyse_text_fr'])."</p><br/></td>";
                $tab.="</tr>";
                
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
                    $tab.="<table class='racecard'>";
                    $tab.="<tr class='rcHeader'>";
                    $tab.="<td>#</td>";
                    $tab.="<td>Horse</td>";
                    $tab.="<td>Perf</td>";
                    $tab.="<td>Age</td>";
                    $tab.="<td style='text-align: center;'>Eq.</td>";
                    $tab.="<td>Stable</td>";
                    $tab.="<td>Weight</td>";
                    $tab.="<td>Draw</td>";
                    $tab.="<td>Jockey</td>";
                    $tab.="<td>Time Factor</td>";
                    $tab.="</tr>";

                    $rcard=Horse::getRaceHorses($rd['_id_race']);
                    foreach($rcard as $rc){
                        $stable=Stable::getStableName($rc['_ref_stable']);
                        $jockey=Jockey::getJockeyName($rc['_ref_jockey']);
                        if($rc['_hequip']==''){ $eq='-'; } else { $eq=$rc['_hequip']; } 
                        if($rc['_htype']==1){
                            $tab.="<tr>";
                            $tab.="<td style='width: 15px;'>" . $rc['_hnum'] . " </td>";
                            $tab.="<td style='width: 155px;'>" . $rc['_hname'] . " </td>";
                            $tab.="<td style='width: 85px;'>" . $rc['_hperf'] . " </td>";
                            $tab.="<td style='text-align: center;'>" . $rc['_hage'] . " </td>";
                            $tab.="<td style='text-align: center; width: 35px;'>" . $eq. " </td>";
                            $tab.="<td style='width: 85px;'>" . $stable[0]['_sname'] . " </td>";
                            $tab.="<td style='width: 65px;'>" . $rc['_weight'] . " </td>";
                            $tab.="<td style='text-align: center;'>" . $rc['_hdraw'] . " </td>";
                            $tab.="<td style='width: 120px;'>" . $jockey[0]['_jname'] . " </td>";
                            $tab.="<td>" . $rc['_htfactor'] . " </td>";
                            $tab.="</tr>";
                        }
                        if($rc['_htype']==11){
                            $tab.="<tr class='oddsNR' title='Non Runner'>";
                            $tab.="<td style='width: 15px;'>" . $rc['_hnum'] . " </td>";
                            $tab.="<td style='width: 155px;'>" . $rc['_hname'] . " </td>";
                            $tab.="<td style='width: 85px;'>" . $rc['_hperf'] . " </td>";
                            $tab.="<td style='text-align: center;'>" . $rc['_hage'] . " </td>";
                            $tab.="<td style='text-align: center; width: 35px;'>" . $eq. " </td>";
                            $tab.="<td style='width: 85px;'>" . $stable[0]['_sname'] . " </td>";
                            $tab.="<td style='width: 65px;'>" . $rc['_weight'] . " </td>";
                            $tab.="<td style='text-align: center;'>" . $rc['_hdraw'] . " </td>";
                            $tab.="<td style='width: 120px;'>" . $jockey[0]['_jname'] . " </td>";
                            $tab.="<td>" . $rc['_htfactor'] . " </td>";
                            $tab.="</tr>";
                        }
                        if($rc['_htype']==2){
                            $tab.="<tr>";
                            $tab.="<td style='width: 15px;'>EA&nbsp;</td>";
                            $tab.="<td style='width: 155px;'>" . $rc['_hname'] . " </td>";
                            $tab.="<td style='width: 85px;'>" . $rc['_hperf'] . " </td>";
                            $tab.="<td style='text-align: center;'>" . $rc['_hage'] . " </td>";
                            $tab.="<td style='text-align: center; width: 35px;'>" . $eq. " </td>";
                            $tab.="<td style='width: 85px;'>" . $stable[0]['_sname'] . " </td>";
                            $tab.="<td style='width: 65px;'>" . $rc['_weight'] . " </td>";
                            $tab.="<td style='text-align: center;'>" . $rc['_hdraw'] . " </td>";
                            $tab.="<td style='width: 120px;'>" . $jockey[0]['_jname'] . " </td>";
                            $tab.="<td>" . $rc['_htfactor'] . " </td>";
                            $tab.="</tr>";
                        }
                    }
                    $tab.='</table>';
                $tab.="</td></tr>";
                
                $tab.="<tr class='analyse'>";
                $tab.="<td colspan='5'><span class='analyseTitle'><br/>".utf8_encode($rd['_analyse_title_en'])."</span><p>".utf8_encode($rd['_analyse_text_en'])."</p><br/></td>";
                $tab.="</tr>";
                $tab.="<tr class='analyse'>";
                $tab.="<td colspan='5'><span class='analyseTitle'>".utf8_encode($rd['_analyse_title_fr'])."</span><p>".utf8_encode($rd['_analyse_text_fr'])."</p><br/></td>";
                $tab.="</tr>";
                
                $tab.="</table>";
            }
            
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

if($action=='getHorseform'){
        $mId=trim($_POST['mid']);

        $mName=Meeting::getCurrentMeeting($mId);
        $raceDetail=Race::getRaceMeeting($mId);
        $raceNumber=sizeof($raceDetail);
        

        if($mName[0]['_mname']==''){
        echo 'No Info';
    }else{
        
        $mee = explode('M0', $mName[0]['_mname']);
        
        //** Caching HERE **
        $fil='cache/hform.cache'.$mName[0]['_mname'];
        if (file_exists($fil)) {
            readfile($fil);
            exit();
        }
        ob_start();
        
        $tab = "<div id='meetingDetails'>";
        $tab.="<h4 style='float: left; margin-top: 4px;'>Meeting " . $mee[1] . "</h4>";
        $tab.="<br/><br/><br/><a class='viewRacecard' href='nomination.php?nomi=".$mId."' >Nomination</a>&nbsp;&nbsp;<a class='viewRacecard' href='racecard.php?rcard=".$mId."' >Racecard</a>&nbsp;&nbsp;<a class='viewRacecard' id='sel' href='horseform.php?hform=".$mId."' >Horse Form</a>&nbsp;&nbsp;<a class='viewRacecard' href='result.php?rez=".$mId."' >Result</a>&nbsp;&nbsp;<a class='viewRacecard' href='training.php?train=".$mId."' >Training Time</a>&nbsp;&nbsp;<a class='viewRacecard' href='odds.php?odd=".$mId."' >Live Odds</a>&nbsp;&nbsp;<a class='viewRacecard' href='betnow.php?bet=".$mId."' >Bet Now</a><br/><br/>";
        $tab.="</div>";
        
        $tab.="<ul class='tabs-rnum'>";
        foreach($raceDetail as $rd){
            if($rd['_rnum']==1){
                $tab.="<li title='Race ".$rd['_rnum']."' ><a href='javascript:tabSwitch(".$rd['_rnum'].", ".$raceNumber.");'  id='form_".$rd['_rnum']."' class='active'>".$rd['_rnum']."</a></li>";
            }else{
                $tab.="<li title='Race ".$rd['_rnum']."' ><a href='javascript:tabSwitch(".$rd['_rnum'].", ".$raceNumber.");' id='form_".$rd['_rnum']."'  >".$rd['_rnum']."</a></li>";
            }
            
        }
        $tab.="</ul>";
        
        foreach($raceDetail as $rd){
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
                
                $rcard=Horse::getRaceHorses($rd['_id_race']);
                $numHorses=sizeof($rcard);
                if($numHorses<7){
                    $limit=10;
                }elseif(($numHorses>7)&&($numHorses<10)){
                    $limit=7;
                }elseif($numHorses>10){
                    $limit=5;
                }else{
                    $limit=4;
                }
                foreach ($rcard as $rc){
                    
                    $stable=Stable::getStableName($rc['_ref_stable']);
                    $jockey=Jockey::getJockeyName($rc['_ref_jockey']);
                    $horseDetail = Horselist::getHorselistByName($rc['_hname']);
                    $hOrigin=  Horseorigin::getHorseOrigin($horseDetail[0]['_origin']);
                    $hType=  Horsetype::getHorseType($horseDetail[0]['_type']);
                    $ch=$rc['_webchances'];
                    if($ch=='x'){
                        $chImg="<img src='images/ch1.png' alt='BetTeaser Chance' />";
                    }elseif($ch=='xx'){
                        $chImg="<img src='images/ch2.png' alt='BetTeaser Chance' />";
                    }elseif($ch=='xxx'){
                        $chImg="<img src='images/ch3.png' alt='BetTeaser Chance' />";
                    }
                    else{
                        $chImg='-';
                    }
                    if($rc['_hequip']==''){
                        $eq='-';
                    }else{
                        $eq=$rc['_hequip'];
                    }
                    
                    
                    if($rc['_htype']==1){
                        $tab.="<table class='hform-runhorse'>";
                        $tab.="<tr class='rcHeader'>";
                        $tab.="<td class='hnum'  rowspan='3'><br/>".$rc['_hnum']."</td>";
                        $tab.="<td class='hname'>".$rc['_hname']."</td>";
                        $tab.="<td class='hwei'>".$rc['_hweight']."</td>";
                        $tab.="<td class='joc' rowspan='1'><b>Jockey</b><br/>".$jockey[0]['_jname']."</td>";
                        $tab.="<td class='stab' rowspan='1'><b>Stable</b><br/>".$stable[0]['_sname']."</td>";
                        $tab.="<td class='ch' rowspan='3'><b>Chances</b><br/>".$chImg."</td>";
                        $tab.="<td class='eq' rowspan='1'><b>Equip.</b><br/>".$eq."</td>";
                        $tab.="<td class='ch' rowspan='1'><b>Rating</b><br/>".$horseDetail[0]['_hrating']."</td>";
                        $tab.="<td class='weight' rowspan='1'><b>Weight</b><br/>".$rc['_weight']."</td>";
                        $tab.="<td class='ch' rowspan='1'><b>Draw</b><br/>".$rc['_hdraw']."</td>";
                        $tab.="</tr>";
                        $tab.="<tr>";
                        $tab.="<td class='hInfo' colspan='4' style='border-right: 1px gainsboro solid;' >".$hType[0]['_type']." ".$hOrigin[0]['_origin']." ".$rc['_hage']." years by ".$horseDetail[0]['_pedigree']." </td>";

                        $tab.="<td colspan='4' rowspan='2' class='tform'><br/><b>Training: </b>".$rc['_trainingnote']."/10<b>&nbsp;Form: </b>".$rc['_formnote']."/10</td>";
                        $tab.="</tr>";
                        $tab.="<tr>";
                        $tab.="<td class='owner' style='border-right: 1px gainsboro solid;' colspan='4' >".utf8_encode($rc['_owners'])."</td>";
                        $tab.="</tr>";
                    }
                    if($rc['_htype']==11){
                        $tab.="<table class='hform-runhorse' id='hformNR' title='Non Runner'>";
                        $tab.="<tr class='rcHeader' >";
                        $tab.="<td class='hnum'  rowspan='3'><br/>".$rc['_hnum']."</td>";
                        $tab.="<td class='hname'>".$rc['_hname']."</td>";
                        $tab.="<td class='hwei'>".$rc['_hweight']."</td>";
                        $tab.="<td class='joc' rowspan='1'><b>Jockey</b><br/>".$jockey[0]['_jname']."</td>";
                        $tab.="<td class='stab' rowspan='1'><b>Stable</b><br/>".$stable[0]['_sname']."</td>";
                        $tab.="<td class='ch' rowspan='3'><b>Chances</b><br/>".$chImg."</td>";
                        $tab.="<td class='eq' rowspan='1'><b>Equip.</b><br/>".$eq."</td>";
                        $tab.="<td class='ch' rowspan='1'><b>Rating</b><br/>".$horseDetail[0]['_hrating']."</td>";
                        $tab.="<td class='weight' rowspan='1'><b>Weight</b><br/>".$rc['_weight']."</td>";
                        $tab.="<td class='ch' rowspan='1'><b>Draw</b><br/>".$rc['_hdraw']."</td>";
                        $tab.="</tr>";
                        $tab.="<tr id='hformNR'>";
                        $tab.="<td class='hInfo' colspan='4' style='border-right: 1px gainsboro solid;' >".$hType[0]['_type']." ".$hOrigin[0]['_origin']." ".$rc['_hage']." years by ".$horseDetail[0]['_pedigree']." </td>";

                        $tab.="<td colspan='4' rowspan='2' class='tform'><br/><b>Training: </b>".$rc['_trainingnote']."/10<b>&nbsp;Form: </b>".$rc['_formnote']."/10</td>";
                        $tab.="</tr>";
                        $tab.="<tr id='hformNR'>";
                        $tab.="<td class='owner' style='border-right: 1px gainsboro solid;' colspan='4' >".utf8_encode($rc['_owners'])."</td>";
                        $tab.="</tr>";
                    }
                    if($rc['_htype']==2){
                        $tab.="<table class='hform-runhorse'>";
                        $tab.="<tr class='rcHeader'>";
                        $tab.="<td class='hnum'  rowspan='3'><br/>EA</td>";
                        $tab.="<td class='hname'>".$rc['_hname']."</td>";
                        $tab.="<td class='hwei'>".$rc['_hweight']."</td>";
                        $tab.="<td class='joc' rowspan='1'><b>Jockey</b><br/>".$jockey[0]['_jname']."</td>";
                        $tab.="<td class='stab' rowspan='1'><b>Stable</b><br/>".$stable[0]['_sname']."</td>";
                        $tab.="<td class='ch' rowspan='3'><b>Chances</b><br/>".$chImg."</td>";
                        $tab.="<td class='eq' rowspan='1'><b>Equip.</b><br/>".$eq."</td>";
                        $tab.="<td class='ch' rowspan='1'><b>Rating</b><br/>".$horseDetail[0]['_hrating']."</td>";
                        $tab.="<td class='weight' rowspan='1'><b>Weight</b><br/>".$rc['_weight']."</td>";
                        $tab.="<td class='ch' rowspan='1'><b>Draw</b><br/>".$rc['_hdraw']."</td>";
                        $tab.="</tr>";
                        $tab.="<tr>";
                        $tab.="<td class='hInfo' colspan='4' style='border-right: 1px gainsboro solid;' >".$hType[0]['_type']." ".$hOrigin[0]['_origin']." ".$rc['_hage']." years by ".$horseDetail[0]['_pedigree']." </td>";

                        $tab.="<td colspan='4' rowspan='2' class='tform'><br/><b>Training: </b>".$rc['_trainingnote']."/10<b>&nbsp;Form: </b>".$rc['_formnote']."/10</td>";
                        $tab.="</tr>";
                        $tab.="<tr>";
                        $tab.="<td class='owner' style='border-right: 1px gainsboro solid;' colspan='4' >".utf8_encode($rc['_owners'])."</td>";
                        $tab.="</tr>";
                    }
                    
                    
                    $tab.="<tr><td colspan='10'>";
                    
                    //Horse form goes here
                    $hruns=  Horseruns::getHorseFormbyName($rc['_hname'], $limit);
                    $tab.="<table class='tbhHruns'>";
                        $tab.="<tr class='tbhHruns-hdr'>";
                        $tab.="<td title='Race Date(dd/mm/yyyy)'>Date</td>";
                        $tab.="<td>Ref.</td>";
                        $tab.="<td>Dist. - Div.</td>";
                        $tab.="<td>Eq.</td>";
                        $tab.="<td>W.</td>";
                        $tab.="<td>Draw</td>";
                        $tab.="<td title='Position at 600m from winning post'>P600</td>";
                        $tab.="<td title='Position at 300m from winning post'>P300</td>";
                        $tab.="<td title='Position at 100m from winning post'>P100</td>";
                        $tab.="<td title='Rank of horse'>Rank</td>";
                        $tab.="<td title='Margin from winner'>Margin</td>";
                        $tab.="<td title='Winner or Second'>Winner (Second<sup>*</sup>)</td>";
                        $tab.="<td>Time Race</td>";
                        $tab.="<td>Time 600m</td>";
                        $tab.="<td>Time 400m</td>";
                        $tab.="<td>Pitch</td>";
                        $tab.="<td>Horse Weight</td>";
                        $tab.="<td>Rating</td>";
                        $tab.="<td>Comments</td>";
                        $tab.="</tr>";
                    foreach($hruns as $hr){
                        if ($hr[_rank]==1){
                            $star="<span class='star'><sup>*</sup></span>";
                        }else{
                            $star="<span class='star'>&nbsp;</span>";
                        }
                        $tab.="<tr>";
                        $tab.="<td title='Race Date(dd/mm/yyyy)'>".$hr['_racedate']."</td>";
                        $tab.="<td title='Meeting & Race Number'>".$hr['mno_rno']."</td>";
                        $tab.="<td title='Distance and Division'>".$hr['_rdist']."m (".$hr['_rrating'].")</td>";
                        $tab.="<td title='Equipment'>".$hr['_equip']."</td>";
                        $tab.="<td title='Jockey Weight'>".$hr['_weight']."</td>";
                        $tab.="<td title='Horse Draw'>".$hr['_draw']."</td>";
                        $tab.="<td title='Position at 600m from winning post'>".$hr['_p600']."</td>";
                        $tab.="<td title='Position at 300m from winning post'>".$hr['_p300']."</td>";
                        $tab.="<td title='Position at 100m from winning post'>".$hr['_p100']."</td>";
                        $tab.="<td title='Horse Rank'>".$hr['_rank']."</td>";
                        $tab.="<td title='Margin from winner or second*'>".$hr['_margin']."</td>";
                        $tab.="<td title='Winner or Second*'>".ucwords (strtolower($hr['_winner_sec']))." ".$star."</td>";
                        $tab.="<td title='Duration of race'>".$hr['_timerace']."</td>";
                        $tab.="<td title='Time for last 600m'>".$hr['_time600']."</td>";
                        $tab.="<td title='Time for last 400m'>".$hr['_time400']."</td>";
                        $tab.="<td title='Pitch measure'>".$hr['_going']."</td>";
                        $tab.="<td title='Horse Weight'>".$hr['_hweight']."kg </td>";
                        $tab.="<td title='Horse Rating'>".$hr['_hrating']."</td>";
                        //$tab.="<td title='Comments En & Fr'>".utf8_decode($hr['_comment_en'])."<hr/>".utf8_decode($hr['_comment_fr'])."</td>";
                        $tab.="<td title='Comments En & Fr'>".$hr['_comment_en']."<hr/>".$hr['_comment_fr']."</td>";
                        $tab.="</tr>";
                        
                    }
                    $tab.="</table>";
                    $tab.="</td></tr>";
                    
                    
                    $tab.="<tr>";
                    $tab.="<td class='coment' colspan='10'>".utf8_encode($rc['_comments_en'])."</td>";
                    $tab.="</tr>";
                    $tab.="<tr>";
                    $tab.="<td style='padding-bottom: 20px;' class='coment' colspan='10'>".utf8_encode($rc['_comments_fr'])."</td>";
                    $tab.="</tr>";
                    
                    $tab.="</table>";
                }
                
                
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
                
                
                $rcard=Horse::getRaceHorses($rd['_id_race']);
                foreach ($rcard as $rc){
                    $stable=Stable::getStableName($rc['_ref_stable']);
                    $jockey=Jockey::getJockeyName($rc['_ref_jockey']);
                    $horseDetail = Horselist::getHorselistByName($rc['_hname']);
                    $hOrigin=  Horseorigin::getHorseOrigin($horseDetail[0]['_origin']);
                    $hType=  Horsetype::getHorseType($horseDetail[0]['_type']);
                    $ch=$rc['_webchances'];
                    if($ch=='x'){
                        $chImg="<img src='images/ch1.png' alt='BetTeaser Chance' />";
                    }elseif($ch=='xx'){
                        $chImg="<img src='images/ch2.png' alt='BetTeaser Chance' />";
                    }elseif($ch=='xxx'){
                        $chImg="<img src='images/ch3.png' alt='BetTeaser Chance' />";
                    }
                    else{
                        $chImg='-';
                    }
                    if($rc['_hequip']==''){
                        $eq='-';
                    }else{
                        $eq=$rc['_hequip'];
                    }
                    
                    $tab.="<table class='hform-runhorse'>";
                    if($rc['_htype']==1){
                        $tab.="<tr class='rcHeader'>";
                        $tab.="<td class='hnum'  rowspan='3'><br/>".$rc['_hnum']."</td>";
                        $tab.="<td class='hname'>".$rc['_hname']."</td>";
                        $tab.="<td class='hwei'>".$rc['_hweight']."</td>";
                        $tab.="<td class='joc' rowspan='1'><b>Jockey</b><br/>".$jockey[0]['_jname']."</td>";
                        $tab.="<td class='stab' rowspan='1'><b>Stable</b><br/>".$stable[0]['_sname']."</td>";
                        $tab.="<td class='ch' rowspan='3'><b>Chances</b><br/>".$chImg."</td>";
                        $tab.="<td class='eq' rowspan='1'><b>Equip.</b><br/>".$eq."</td>";
                        $tab.="<td class='ch' rowspan='1'><b>Rating</b><br/>".$horseDetail[0]['_hrating']."</td>";
                        $tab.="<td class='weight' rowspan='1'><b>Weight</b><br/>".$rc['_weight']."</td>";
                        $tab.="<td class='ch' rowspan='1'><b>Draw</b><br/>".$rc['_hdraw']."</td>";
                        $tab.="</tr>";
                        $tab.="<tr>";
                        $tab.="<td class='hInfo' colspan='4' style='border-right: 1px gainsboro solid;' >".$hType[0]['_type']." ".$hOrigin[0]['_origin']." ".$rc['_hage']." years by ".$horseDetail[0]['_pedigree']." </td>";

                        $tab.="<td colspan='4' rowspan='2' class='tform'><br/><b>Training: </b>".$rc['_trainingnote']."/10<b>&nbsp;Form: </b>".$rc['_formnote']."/10</td>";
                        $tab.="</tr>";
                        $tab.="<tr>";
                        $tab.="<td class='owner' style='border-right: 1px gainsboro solid;' colspan='4' >".utf8_encode($rc['_owners'])."</td>";
                        $tab.="</tr>";
                    }
                    if($rc['_htype']==11){
                        $tab.="<tr class='rcHeader' id='hformNR' title='Non Runner'>";
                        $tab.="<td class='hnum'  rowspan='3'><br/>".$rc['_hnum']."</td>";
                        $tab.="<td class='hname'>".$rc['_hname']."</td>";
                        $tab.="<td class='hwei'>".$rc['_hweight']."</td>";
                        $tab.="<td class='joc' rowspan='1'><b>Jockey</b><br/>".$jockey[0]['_jname']."</td>";
                        $tab.="<td class='stab' rowspan='1'><b>Stable</b><br/>".$stable[0]['_sname']."</td>";
                        $tab.="<td class='ch' rowspan='3'><b>Chances</b><br/>".$chImg."</td>";
                        $tab.="<td class='eq' rowspan='1'><b>Equip.</b><br/>".$eq."</td>";
                        $tab.="<td class='ch' rowspan='1'><b>Rating</b><br/>".$horseDetail[0]['_hrating']."</td>";
                        $tab.="<td class='weight' rowspan='1'><b>Weight</b><br/>".$rc['_weight']."</td>";
                        $tab.="<td class='ch' rowspan='1'><b>Draw</b><br/>".$rc['_hdraw']."</td>";
                        $tab.="</tr>";
                        $tab.="<tr id='hformNR'>";
                        $tab.="<td class='hInfo' colspan='4' style='border-right: 1px gainsboro solid;' >".$hType[0]['_type']." ".$hOrigin[0]['_origin']." ".$rc['_hage']." years by ".$horseDetail[0]['_pedigree']." </td>";

                        $tab.="<td colspan='4' rowspan='2' class='tform'><br/><b>Training: </b>".$rc['_trainingnote']."/10<b>&nbsp;Form: </b>".$rc['_formnote']."/10</td>";
                        $tab.="</tr>";
                        $tab.="<tr id='hformNR'>";
                        $tab.="<td class='owner' style='border-right: 1px gainsboro solid;' colspan='4' >".utf8_encode($rc['_owners'])."</td>";
                        $tab.="</tr>";
                    }
                    if($rc['_htype']==2){
                        $tab.="<tr class='rcHeader'>";
                        $tab.="<td class='hnum'  rowspan='3'><br/>EA</td>";
                        $tab.="<td class='hname'>".$rc['_hname']."</td>";
                        $tab.="<td class='hwei'>".$rc['_hweight']."</td>";
                        $tab.="<td class='joc' rowspan='1'><b>Jockey</b><br/>".$jockey[0]['_jname']."</td>";
                        $tab.="<td class='stab' rowspan='1'><b>Stable</b><br/>".$stable[0]['_sname']."</td>";
                        $tab.="<td class='ch' rowspan='3'><b>Chances</b><br/>".$chImg."</td>";
                        $tab.="<td class='eq' rowspan='1'><b>Equip.</b><br/>".$eq."</td>";
                        $tab.="<td class='ch' rowspan='1'><b>Rating</b><br/>".$horseDetail[0]['_hrating']."</td>";
                        $tab.="<td class='weight' rowspan='1'><b>Weight</b><br/>".$rc['_weight']."</td>";
                        $tab.="<td class='ch' rowspan='1'><b>Draw</b><br/>".$rc['_hdraw']."</td>";
                        $tab.="</tr>";
                        $tab.="<tr>";
                        $tab.="<td class='hInfo' colspan='4' style='border-right: 1px gainsboro solid;' >".$hType[0]['_type']." ".$hOrigin[0]['_origin']." ".$rc['_hage']." years by ".$horseDetail[0]['_pedigree']." </td>";

                        $tab.="<td colspan='4' rowspan='2' class='tform'><br/><b>Training: </b>".$rc['_trainingnote']."/10<b>&nbsp;Form: </b>".$rc['_formnote']."/10</td>";
                        $tab.="</tr>";
                        $tab.="<tr>";
                        $tab.="<td class='owner' style='border-right: 1px gainsboro solid;' colspan='4' >".utf8_encode($rc['_owners'])."</td>";
                        $tab.="</tr>";
                    }
                    
                    
                    $tab.="<tr><td colspan='10'>";
                    
                    //Horse form goes here
                    $hruns=  Horseruns::getHorseFormbyName($rc['_hname'], $limit);
                    $tab.="<table class='tbhHruns'>";
                        $tab.="<tr class='tbhHruns-hdr'>";
                        $tab.="<td title='Race Date(dd/mm/yyyy)'>Date</td>";
                        $tab.="<td>Ref.</td>";
                        $tab.="<td>Dist. - Div.</td>";
                        $tab.="<td>Eq.</td>";
                        $tab.="<td>W.</td>";
                        $tab.="<td>Draw</td>";
                        $tab.="<td title='Position at 600m from winning post'>P600</td>";
                        $tab.="<td title='Position at 300m from winning post'>P300</td>";
                        $tab.="<td title='Position at 100m from winning post'>P100</td>";
                        $tab.="<td title='Rank of horse'>Rank</td>";
                        $tab.="<td title='Margin from winner'>Margin</td>";
                        $tab.="<td title='Winner or Second'>Winner (Second<sup>*</sup>)</td>";
                        $tab.="<td>Time Race</td>";
                        $tab.="<td>Time 600m</td>";
                        $tab.="<td>Time 400m</td>";
                        $tab.="<td>Pitch</td>";
                        $tab.="<td>Horse Weight</td>";
                        $tab.="<td>Rating</td>";
                        $tab.="<td>Comments</td>";
                        $tab.="</tr>";
                    foreach($hruns as $hr){
                        if ($hr[_rank]==1){
                            $star="<span class='star'><sup>*</sup></span>";
                        }else{
                            $star="<span class='star'>&nbsp;</span>";
                        }
                        $tab.="<tr>";
                        $tab.="<td title='Race Date(dd/mm/yyyy)'>".$hr['_racedate']."</td>";
                        $tab.="<td title='Meeting & Race Number'>".$hr['mno_rno']."</td>";
                        $tab.="<td title='Distance and Division'>".$hr['_rdist']."m (".$hr['_rrating'].")</td>";
                        $tab.="<td title='Equipment'>".$hr['_equip']."</td>";
                        $tab.="<td title='Jockey Weight'>".$hr['_weight']."</td>";
                        $tab.="<td title='Horse Draw'>".$hr['_draw']."</td>";
                        $tab.="<td title='Position at 600m from winning post'>".$hr['_p600']."</td>";
                        $tab.="<td title='Position at 300m from winning post'>".$hr['_p300']."</td>";
                        $tab.="<td title='Position at 100m from winning post'>".$hr['_p100']."</td>";
                        $tab.="<td title='Horse Rank'>".$hr['_rank']."</td>";
                        $tab.="<td title='Margin from winner or second'>".$hr['_margin']."</td>";
                        $tab.="<td title='Winner or Second*'>".ucwords (strtolower($hr['_winner_sec']))." ".$star."</td>";
                        $tab.="<td title='Duration of race'>".$hr['_timerace']."</td>";
                        $tab.="<td title='Time for last 600m'>".$hr['_time600']."</td>";
                        $tab.="<td title='Time for last 400m'>".$hr['_time400']."</td>";
                        $tab.="<td title='Pitch measure'>".$hr['_going']."</td>";
                        $tab.="<td title='Horse Weight'>".$hr['_hweight']."kg </td>";
                        $tab.="<td title='Horse Rating'>".$hr['_hrating']."</td>";
                        //$tab.="<td title='Comments En & Fr'>".utf8_decode($hr['_comment_en'])."<hr/>".utf8_decode($hr['_comment_fr'])."</td>";
                        $tab.="<td title='Comments En & Fr'>".$hr['_comment_en']."<hr/>".$hr['_comment_fr']."</td>";
                        $tab.="</tr>";
                        
                    }
                    $tab.="</table>";
                    $tab.="</td></tr>";
                    
                    
                    
                    $tab.="<tr>";
                    $tab.="<td class='coment' colspan='10'>".utf8_encode($rc['_comments_en'])."</td>";
                    $tab.="</tr>";
                    $tab.="<tr>";
                    $tab.="<td style='padding-bottom: 20px;' class='coment' colspan='10'>".utf8_encode($rc['_comments_fr'])."</td>";
                    $tab.="</tr>";
                    
                    
                    $tab.="</table>";
                }
                
                $tab.="</table>";
            }
            
        }
        $tab.="<br/><a id='up' href='javascript:goUp();'>Go Up</a>";

        echo $tab;
        
        //** CACHING HERE **
        $buffer = ob_get_contents();
        ob_end_flush();
        $fp = fopen($fil, 'w');
        fwrite($fp, $buffer);
        fclose($fp);
    }
        
}

if($action=='getResult'){
    $mId=trim($_POST['mid']);
    
    $mName=Meeting::getCurrentMeeting($mId);
    $raceDetail=Race::getRaceMeeting($mId);
    $raceNumber=sizeof($raceDetail);
    
    if($mName[0]['_mname']==''){
        echo 'No Info';
    }else{
        $mee = explode('M0', $mName[0]['_mname']);
        
        $tab = "<div id='meetingDetails'>";
        $tab.="<h4 style='float: left; margin-top: 4px;'>Meeting " . $mee[1] . "</h4>";
        $tab.="<br/><br/><br/><a class='viewRacecard' href='nomination.php?nomi=".$mId."' >Nomination</a>&nbsp;&nbsp;<a class='viewRacecard' href='racecard.php?rcard=".$mId."' >Racecard</a>&nbsp;&nbsp;<a class='viewRacecard' href='horseform.php?hform=".$mId."' >Horse Form</a>&nbsp;&nbsp;<a class='viewRacecard' id='sel' href='result.php?rez=".$mId."' >Result</a>&nbsp;&nbsp;<a class='viewRacecard' href='training.php?train=".$mId."' >Training Time</a>&nbsp;&nbsp;<a class='viewRacecard' href='odds.php?odd=".$mId."' >Live Odds</a>&nbsp;&nbsp;<a class='viewRacecard' href='betnow.php?bet=".$mId."' >Bet Now</a><br/><br/>";
        $tab.="</div>";

        $tab.="<ul class='tabs-rnum'>";
        foreach($raceDetail as $rd){
            if($rd['_rnum']==1){
                $tab.="<li title='Race ".$rd['_rnum']."' ><a href='javascript:tabSwitch(".$rd['_rnum'].", ".$raceNumber.");'  id='form_".$rd['_rnum']."' class='active'>".$rd['_rnum']."</a></li>";
            }else{
                $tab.="<li title='Race ".$rd['_rnum']."' ><a href='javascript:tabSwitch(".$rd['_rnum'].", ".$raceNumber.");' id='form_".$rd['_rnum']."'  >".$rd['_rnum']."</a></li>";
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
                $tab.="<table class='racecard'>";
                    $tab.="<tr class='rcHeader'>";
                    $tab.="<td>Rank</td>";
                    $tab.="<td>#</td>";
                    $tab.="<td>Horse</td>";
                    $tab.="<td>Jockey</td>";
                    $tab.="<td>Stable</td>";
                    $tab.="<td>Draw</td>";
                    $tab.="</tr>";
                    $rRez=Horse::getRaceRez($rd['_id_race']);
                    $f=0;
                    foreach($rRez as $hm){
                        if($hm['_hrank']!=0){
                            $stable=Stable::getStableName($hm['_ref_stable']);
                            $hname=  Horselist::getHorsenameById($hm['_ref_horse']);
                            $jockey=Jockey::getJockeyName($hm['_ref_jockey']);
                            $tab.="<tr>";
                            $tab.="<td>" . $hm['_hrank'] . " </td>";
                            $tab.="<td>" . $hm['_hnum'] . " </td>";
                            $tab.="<td>" . $hm['_hname'] . " </td>";
                            $tab.="<td>" . $jockey[0]['_jname'] . " </td>";
                            $tab.="<td>" . $stable[0]['_sname'] . " </td>";
                            $tab.="<td>" . $hm['_hdraw'] . " </td>";
                            $tab.="</tr>";
                        }
                    }
                
                $tab.="</table>";
                $tab.="</td></tr>";
//                $tab.="<tr>";
//                $tab.="<td colspan=6><img src='http://www.mauritiusturfclub.com/images/photo_finish/2011-".$mee[1].$rd['_rnum'].".jpg' width=690 height=257 /></td>";
//                $tab.="</tr>";
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
                $tab.="<table class='racecard'>";
                    $tab.="<tr class='rcHeader'>";
                    $tab.="<td>Rank</td>";
                    $tab.="<td>#</td>";
                    $tab.="<td>Horse</td>";
                    $tab.="<td>Jockey</td>";
                    $tab.="<td>Stable</td>";
                    $tab.="<td>Draw</td>";
                    $tab.="</tr>";
                    $rRez=Horse::getRaceRez($rd['_id_race']);
                    $f=0;
                    foreach($rRez as $hm){
                        if($hm['_hrank']!=0){
                            $stable=Stable::getStableName($hm['_ref_stable']);
                            $hname=  Horselist::getHorsenameById($hm['_ref_horse']);
                            $jockey=Jockey::getJockeyName($hm['_ref_jockey']);
                            $tab.="<tr>";
                            $tab.="<td>" . $hm['_hrank'] . " </td>";
                            $tab.="<td>" . $hm['_hnum'] . " </td>";
                            $tab.="<td>" . $hm['_hname'] . " </td>";
                            $tab.="<td>" . $jockey[0]['_jname'] . " </td>";
                            $tab.="<td>" . $stable[0]['_sname'] . " </td>";
                            $tab.="<td>" . $hm['_hdraw'] . " </td>";
                            $tab.="</tr>";
                        }
                    }
                
                $tab.="</table>";
                $tab.="</td></tr>";
//                $tab.="<tr>";
//                $tab.="<td colspan=6><img src='http://www.mauritiusturfclub.com/images/photo_finish/2011-".$mee[1].$rd['_rnum'].".jpg' width=690 height=257 /></td>";
//                $tab.="</tr>";
                $tab.="</table>";
            }
        }
    
    }
    echo $tab;
}


if($action=='getTraining'){
        $mId=trim($_POST['mid']);

        $mName=Meeting::getCurrentMeeting($mId);
        $raceDetail=Race::getRaceMeeting($mId);
        $raceNumber=sizeof($raceDetail);
        

        if($mName[0]['_mname']==''){
        echo 'No Info';
    }else{
        
        $mee = explode('M0', $mName[0]['_mname']);
        
        //** Caching HERE **
        $fil='cache/train.cache'.$mName[0]['_mname'];
        if (file_exists($fil)) {
            readfile($fil);
            //echo 'xx';
            exit();
        }
        ob_start();
        
        $tab = "<div id='meetingDetails'>";
        $tab.="<h4 style='float: left; margin-top: 4px;'>Meeting " . $mee[1] . "</h4>";
        $tab.="<br/><br/><br/><a class='viewRacecard' href='nomination.php?nomi=".$mId."' >Nomination</a>&nbsp;&nbsp;<a class='viewRacecard' href='racecard.php?rcard=".$mId."' >Racecard</a>&nbsp;&nbsp;<a class='viewRacecard' href='horseform.php?hform=".$mId."' >Horse Form</a>&nbsp;&nbsp;<a class='viewRacecard' href='result.php?rez=".$mId."' >Result</a>&nbsp;&nbsp;<a class='viewRacecard' id='sel' href='training.php?train=".$mId."' >Training Time</a>&nbsp;&nbsp;<a class='viewRacecard' href='odds.php?odd=".$mId."' >Live Odds</a>&nbsp;&nbsp;<a class='viewRacecard' href='betnow.php?bet=".$mId."' >Bet Now</a><br/><br/>";
        $tab.="</div>";
        
        $tab.="<ul class='tabs-rnum'>";
        foreach($raceDetail as $rd){
            if($rd['_rnum']==1){
                $tab.="<li title='Race ".$rd['_rnum']."' ><a href='javascript:tabSwitch(".$rd['_rnum'].", ".$raceNumber.");'  id='form_".$rd['_rnum']."' class='active'>".$rd['_rnum']."</a></li>";
            }else{
                $tab.="<li title='Race ".$rd['_rnum']."' ><a href='javascript:tabSwitch(".$rd['_rnum'].", ".$raceNumber.");' id='form_".$rd['_rnum']."'  >".$rd['_rnum']."</a></li>";
            }
            
        }
        $tab.="</ul>";
        
        foreach($raceDetail as $rd){
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
                
                $rcard=Horse::getRaceHorses($rd['_id_race']);
                $numHorses=sizeof($rcard);
                if($numHorses<7){
                    $limit=10;
                }elseif(($numHorses>7)&&($numHorses<10)){
                    $limit=7;
                }elseif($numHorses>10){
                    $limit=5;
                }else{
                    $limit=4;
                }
                foreach ($rcard as $rc){
                    
                    $stable=Stable::getStableName($rc['_ref_stable']);
                    $jockey=Jockey::getJockeyName($rc['_ref_jockey']);
                    $horseDetail = Horselist::getHorselistByName($rc['_hname']);
                    $hOrigin=  Horseorigin::getHorseOrigin($horseDetail[0]['_origin']);
                    $hType=  Horsetype::getHorseType($horseDetail[0]['_type']);
                    $ch=$rc['_webchances'];
                    if($ch=='x'){
                        $chImg="<img src='images/ch1.png' alt='BetTeaser Chance' />";
                    }elseif($ch=='xx'){
                        $chImg="<img src='images/ch2.png' alt='BetTeaser Chance' />";
                    }elseif($ch=='xxx'){
                        $chImg="<img src='images/ch3.png' alt='BetTeaser Chance' />";
                    }
                    else{
                        $chImg='-';
                    }
                    if($rc['_hequip']==''){
                        $eq='-';
                    }else{
                        $eq=$rc['_hequip'];
                    }
                    
                    
                    if($rc['_htype']==1){
                        $tab.="<table class='hform-runhorse'>";
                        $tab.="<tr class='rcHeader'>";
                        $tab.="<td class='hnum'  rowspan='3'><br/>".$rc['_hnum']."</td>";
                        $tab.="<td class='hname'>".$rc['_hname']."</td>";
                        $tab.="<td class='hwei'>".$rc['_hweight']."</td>";
                        $tab.="<td class='joc' rowspan='1'><b>Jockey</b><br/>".$jockey[0]['_jname']."</td>";
                        $tab.="<td class='stab' rowspan='1'><b>Stable</b><br/>".$stable[0]['_sname']."</td>";
                        $tab.="<td class='ch' rowspan='3'><b>Chances</b><br/>".$chImg."</td>";
                        $tab.="<td class='eq' rowspan='1'><b>Equip.</b><br/>".$eq."</td>";
                        $tab.="<td class='ch' rowspan='1'><b>Rating</b><br/>".$horseDetail[0]['_hrating']."</td>";
                        $tab.="<td class='weight' rowspan='1'><b>Weight</b><br/>".$rc['_weight']."</td>";
                        $tab.="<td class='ch' rowspan='1'><b>Draw</b><br/>".$rc['_hdraw']."</td>";
                        $tab.="</tr>";
                        $tab.="<tr>";
                        $tab.="<td class='hInfo' colspan='4' style='border-right: 1px gainsboro solid;' >".$hType[0]['_type']." ".$hOrigin[0]['_origin']." ".$rc['_hage']." years by ".$horseDetail[0]['_pedigree']." </td>";

                        $tab.="<td colspan='4' rowspan='2' class='tform'><br/><b>Training: </b>".$rc['_trainingnote']."/10<b>&nbsp;Form: </b>".$rc['_formnote']."/10</td>";
                        $tab.="</tr>";
                        $tab.="<tr>";
                        $tab.="<td class='owner' style='border-right: 1px gainsboro solid;' colspan='4' >".utf8_encode($rc['_owners'])."</td>";
                        $tab.="</tr>";
                    }
                    if($rc['_htype']==11){
                        $tab.="<table class='hform-runhorse' id='hformNR' title='Non Runner'>";
                        $tab.="<tr class='rcHeader' >";
                        $tab.="<td class='hnum'  rowspan='3'><br/>".$rc['_hnum']."</td>";
                        $tab.="<td class='hname'>".$rc['_hname']."</td>";
                        $tab.="<td class='hwei'>".$rc['_hweight']."</td>";
                        $tab.="<td class='joc' rowspan='1'><b>Jockey</b><br/>".$jockey[0]['_jname']."</td>";
                        $tab.="<td class='stab' rowspan='1'><b>Stable</b><br/>".$stable[0]['_sname']."</td>";
                        $tab.="<td class='ch' rowspan='3'><b>Chances</b><br/>".$chImg."</td>";
                        $tab.="<td class='eq' rowspan='1'><b>Equip.</b><br/>".$eq."</td>";
                        $tab.="<td class='ch' rowspan='1'><b>Rating</b><br/>".$horseDetail[0]['_hrating']."</td>";
                        $tab.="<td class='weight' rowspan='1'><b>Weight</b><br/>".$rc['_weight']."</td>";
                        $tab.="<td class='ch' rowspan='1'><b>Draw</b><br/>".$rc['_hdraw']."</td>";
                        $tab.="</tr>";
                        $tab.="<tr id='hformNR'>";
                        $tab.="<td class='hInfo' colspan='4' style='border-right: 1px gainsboro solid;' >".$hType[0]['_type']." ".$hOrigin[0]['_origin']." ".$rc['_hage']." years by ".$horseDetail[0]['_pedigree']." </td>";

                        $tab.="<td colspan='4' rowspan='2' class='tform'><br/><b>Training: </b>".$rc['_trainingnote']."/10<b>&nbsp;Form: </b>".$rc['_formnote']."/10</td>";
                        $tab.="</tr>";
                        $tab.="<tr id='hformNR'>";
                        $tab.="<td class='owner' style='border-right: 1px gainsboro solid;' colspan='4' >".utf8_encode($rc['_owners'])."</td>";
                        $tab.="</tr>";
                    }
                    if($rc['_htype']==2){
                        $tab.="<table class='hform-runhorse'>";
                        $tab.="<tr class='rcHeader'>";
                        $tab.="<td class='hnum'  rowspan='3'><br/>EA</td>";
                        $tab.="<td class='hname'>".$rc['_hname']."</td>";
                        $tab.="<td class='hwei'>".$rc['_hweight']."</td>";
                        $tab.="<td class='joc' rowspan='1'><b>Jockey</b><br/>".$jockey[0]['_jname']."</td>";
                        $tab.="<td class='stab' rowspan='1'><b>Stable</b><br/>".$stable[0]['_sname']."</td>";
                        $tab.="<td class='ch' rowspan='3'><b>Chances</b><br/>".$chImg."</td>";
                        $tab.="<td class='eq' rowspan='1'><b>Equip.</b><br/>".$eq."</td>";
                        $tab.="<td class='ch' rowspan='1'><b>Rating</b><br/>".$horseDetail[0]['_hrating']."</td>";
                        $tab.="<td class='weight' rowspan='1'><b>Weight</b><br/>".$rc['_weight']."</td>";
                        $tab.="<td class='ch' rowspan='1'><b>Draw</b><br/>".$rc['_hdraw']."</td>";
                        $tab.="</tr>";
                        $tab.="<tr>";
                        $tab.="<td class='hInfo' colspan='4' style='border-right: 1px gainsboro solid;' >".$hType[0]['_type']." ".$hOrigin[0]['_origin']." ".$rc['_hage']." years by ".$horseDetail[0]['_pedigree']." </td>";

                        $tab.="<td colspan='4' rowspan='2' class='tform'><br/><b>Training: </b>".$rc['_trainingnote']."/10<b>&nbsp;Form: </b>".$rc['_formnote']."/10</td>";
                        $tab.="</tr>";
                        $tab.="<tr>";
                        $tab.="<td class='owner' style='border-right: 1px gainsboro solid;' colspan='4' >".utf8_encode($rc['_owners'])."</td>";
                        $tab.="</tr>";
                    }
                    
                    
                    $tab.="<tr><td colspan='10'>";
                    
                    //Horse form goes here
                    $hlId=Horselist::getHorselistByName($rc['_hname']);
                    $hlId=$hlId[0]['_id_hlist'];
                    
                    $hTraining=  Training::get7Training($hlId);
                    $tab.="<table class='tbhHruns'>";
                        $tab.="<tr class='tbhHruns-hdr'>";
                        $tab.="<td title='Training Date(dd/mm/yyyy)'>Date</td>";
                        $tab.="<td>Rating</td>";
                        $tab.="<td>Jockey</td>";
                        $tab.="<td>Eq.</td>";
                        $tab.="<td>P1000</td>";
                        $tab.="<td>P800</td>";
                        $tab.="<td>P600</td>";
                        $tab.="<td>P400</td>";
                        $tab.="<td>P200</td>";
                        $tab.="<td>P2400</td>";
                        $tab.="<td>P2200</td>";
                        $tab.="<td>1000m</td>";
                        $tab.="<td>800m</td>";
                        $tab.="<td>600m</td>";
                        $tab.="<td>400m</td>";
                        $tab.="<td>200m</td>";
                        $tab.="<td>Comments</td>";
                        $tab.="</tr>";
                    foreach($hTraining as $hr){
                        $tab.="<tr>";
                        $tab.="<td title='Training Date(dd/mm/yyyy)'>".date("D - d M Y",strtotime($hr['_tdate']))."</td>";
                        $tab.="<td title='Rating'>".$hr['_rating']."</td>";
                        $tab.="<td title='Jockey'>".$hr['_jockey']."</td>";
                        $tab.="<td title='Equipment'>".$hr['_equip']."</td>";
                        $tab.="<td title='Time 1000m from winning post'>".$hr['_1000p']."</td>";
                        $tab.="<td title='Time 800m from winning post'>".$hr['_800p']."</td>";
                        $tab.="<td title='Time 600m from winning post'>".$hr['_600p']."</td>";
                        $tab.="<td title='Time 400m from winning post'>".$hr['_400p']."</td>";
                        $tab.="<td title='Time 200m from winning post'>".$hr['_200p']."</td>";
                        $tab.="<td title='Time 2400m from winning post'>".$hr['_2400p']."</td>";
                        $tab.="<td title='Time 2200m from winning post'>".$hr['_2200p']."</td>";
                        $tab.="<td title='Time for last 1000m'>".$hr['_1000m']."</td>";
                        $tab.="<td title='Time for last 800m'>".$hr['_800m']."</td>";
                        $tab.="<td title='Time for last 600m'>".$hr['_600m']."</td>";
                        $tab.="<td title='Time for last 400m'>".$hr['_400m']."</td>";
                        $tab.="<td title='Time for last 200m'>".$hr['_200m']."</td>";
                        $tab.="<td title='Comments En & Fr'>".utf8_encode($hr['_comments_en'])."<hr/>".utf8_encode($hr['_comments_fr'])."</td>";
                        $tab.="</tr>";
                        
                    }
                    $tab.="</table>";
                    $tab.="</td></tr>";
                    
                    $tab.="<tr>";
                    $tab.="<td class='coment' colspan='10'>&nbsp;</td>";
                    $tab.="</tr>";
                    
                    $tab.="</table>";
                }
                
                
                
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
                
                
                $rcard=Horse::getRaceHorses($rd['_id_race']);
                foreach ($rcard as $rc){
                    $stable=Stable::getStableName($rc['_ref_stable']);
                    $jockey=Jockey::getJockeyName($rc['_ref_jockey']);
                    $horseDetail = Horselist::getHorselistByName($rc['_hname']);
                    $hOrigin=  Horseorigin::getHorseOrigin($horseDetail[0]['_origin']);
                    $hType=  Horsetype::getHorseType($horseDetail[0]['_type']);
                    $ch=$rc['_webchances'];
                    if($ch=='x'){
                        $chImg="<img src='images/ch1.png' alt='BetTeaser Chance' />";
                    }elseif($ch=='xx'){
                        $chImg="<img src='images/ch2.png' alt='BetTeaser Chance' />";
                    }elseif($ch=='xxx'){
                        $chImg="<img src='images/ch3.png' alt='BetTeaser Chance' />";
                    }
                    else{
                        $chImg='-';
                    }
                    if($rc['_hequip']==''){
                        $eq='-';
                    }else{
                        $eq=$rc['_hequip'];
                    }
                    
                    $tab.="<table class='hform-runhorse'>";
                    if($rc['_htype']==1){
                        $tab.="<tr class='rcHeader'>";
                        $tab.="<td class='hnum'  rowspan='3'><br/>".$rc['_hnum']."</td>";
                        $tab.="<td class='hname'>".$rc['_hname']."</td>";
                        $tab.="<td class='hwei'>".$rc['_hweight']."</td>";
                        $tab.="<td class='joc' rowspan='1'><b>Jockey</b><br/>".$jockey[0]['_jname']."</td>";
                        $tab.="<td class='stab' rowspan='1'><b>Stable</b><br/>".$stable[0]['_sname']."</td>";
                        $tab.="<td class='ch' rowspan='3'><b>Chances</b><br/>".$chImg."</td>";
                        $tab.="<td class='eq' rowspan='1'><b>Equip.</b><br/>".$eq."</td>";
                        $tab.="<td class='ch' rowspan='1'><b>Rating</b><br/>".$horseDetail[0]['_hrating']."</td>";
                        $tab.="<td class='weight' rowspan='1'><b>Weight</b><br/>".$rc['_weight']."</td>";
                        $tab.="<td class='ch' rowspan='1'><b>Draw</b><br/>".$rc['_hdraw']."</td>";
                        $tab.="</tr>";
                        $tab.="<tr>";
                        $tab.="<td class='hInfo' colspan='4' style='border-right: 1px gainsboro solid;' >".$hType[0]['_type']." ".$hOrigin[0]['_origin']." ".$rc['_hage']." years by ".$horseDetail[0]['_pedigree']." </td>";

                        $tab.="<td colspan='4' rowspan='2' class='tform'><br/><b>Training: </b>".$rc['_trainingnote']."/10<b>&nbsp;Form: </b>".$rc['_formnote']."/10</td>";
                        $tab.="</tr>";
                        $tab.="<tr>";
                        $tab.="<td class='owner' style='border-right: 1px gainsboro solid;' colspan='4' >".utf8_encode($rc['_owners'])."</td>";
                        $tab.="</tr>";
                    }
                    if($rc['_htype']==11){
                        $tab.="<tr class='rcHeader' id='hformNR' title='Non Runner'>";
                        $tab.="<td class='hnum'  rowspan='3'><br/>".$rc['_hnum']."</td>";
                        $tab.="<td class='hname'>".$rc['_hname']."</td>";
                        $tab.="<td class='hwei'>".$rc['_hweight']."</td>";
                        $tab.="<td class='joc' rowspan='1'><b>Jockey</b><br/>".$jockey[0]['_jname']."</td>";
                        $tab.="<td class='stab' rowspan='1'><b>Stable</b><br/>".$stable[0]['_sname']."</td>";
                        $tab.="<td class='ch' rowspan='3'><b>Chances</b><br/>".$chImg."</td>";
                        $tab.="<td class='eq' rowspan='1'><b>Equip.</b><br/>".$eq."</td>";
                        $tab.="<td class='ch' rowspan='1'><b>Rating</b><br/>".$horseDetail[0]['_hrating']."</td>";
                        $tab.="<td class='weight' rowspan='1'><b>Weight</b><br/>".$rc['_weight']."</td>";
                        $tab.="<td class='ch' rowspan='1'><b>Draw</b><br/>".$rc['_hdraw']."</td>";
                        $tab.="</tr>";
                        $tab.="<tr id='hformNR'>";
                        $tab.="<td class='hInfo' colspan='4' style='border-right: 1px gainsboro solid;' >".$hType[0]['_type']." ".$hOrigin[0]['_origin']." ".$rc['_hage']." years by ".$horseDetail[0]['_pedigree']." </td>";

                        $tab.="<td colspan='4' rowspan='2' class='tform'><br/><b>Training: </b>".$rc['_trainingnote']."/10<b>&nbsp;Form: </b>".$rc['_formnote']."/10</td>";
                        $tab.="</tr>";
                        $tab.="<tr id='hformNR'>";
                        $tab.="<td class='owner' style='border-right: 1px gainsboro solid;' colspan='4' >".utf8_encode($rc['_owners'])."</td>";
                        $tab.="</tr>";
                    }
                    if($rc['_htype']==2){
                        $tab.="<tr class='rcHeader'>";
                        $tab.="<td class='hnum'  rowspan='3'><br/>EA</td>";
                        $tab.="<td class='hname'>".$rc['_hname']."</td>";
                        $tab.="<td class='hwei'>".$rc['_hweight']."</td>";
                        $tab.="<td class='joc' rowspan='1'><b>Jockey</b><br/>".$jockey[0]['_jname']."</td>";
                        $tab.="<td class='stab' rowspan='1'><b>Stable</b><br/>".$stable[0]['_sname']."</td>";
                        $tab.="<td class='ch' rowspan='3'><b>Chances</b><br/>".$chImg."</td>";
                        $tab.="<td class='eq' rowspan='1'><b>Equip.</b><br/>".$eq."</td>";
                        $tab.="<td class='ch' rowspan='1'><b>Rating</b><br/>".$horseDetail[0]['_hrating']."</td>";
                        $tab.="<td class='weight' rowspan='1'><b>Weight</b><br/>".$rc['_weight']."</td>";
                        $tab.="<td class='ch' rowspan='1'><b>Draw</b><br/>".$rc['_hdraw']."</td>";
                        $tab.="</tr>";
                        $tab.="<tr>";
                        $tab.="<td class='hInfo' colspan='4' style='border-right: 1px gainsboro solid;' >".$hType[0]['_type']." ".$hOrigin[0]['_origin']." ".$rc['_hage']." years by ".$horseDetail[0]['_pedigree']." </td>";

                        $tab.="<td colspan='4' rowspan='2' class='tform'><br/><b>Training: </b>".$rc['_trainingnote']."/10<b>&nbsp;Form: </b>".$rc['_formnote']."/10</td>";
                        $tab.="</tr>";
                        $tab.="<tr>";
                        $tab.="<td class='owner' style='border-right: 1px gainsboro solid;' colspan='4' >".utf8_encode($rc['_owners'])."</td>";
                        $tab.="</tr>";
                    }
                    
                    
                    $tab.="<tr><td colspan='10'>";
                    
                    //Horse form goes here
                    
                    $hlId=Horselist::getHorselistByName($rc['_hname']);
                    $hlId=$hlId[0]['_id_hlist'];
                    
                    $hTraining=  Training::get7Training($hlId);
                    
                    $tab.="<table class='tbhHruns'>";
                        $tab.="<tr class='tbhHruns-hdr'>";
                        $tab.="<td title='Training Date(dd/mm/yyyy)'>Date</td>";
                        $tab.="<td>Rating</td>";
                        $tab.="<td>Jockey</td>";
                        $tab.="<td>Eq.</td>";
                        $tab.="<td>P1000</td>";
                        $tab.="<td>P800</td>";
                        $tab.="<td>P600</td>";
                        $tab.="<td>P400</td>";
                        $tab.="<td>P200</td>";
                        $tab.="<td>P2400</td>";
                        $tab.="<td>P2200</td>";
                        $tab.="<td>1000m</td>";
                        $tab.="<td>800m</td>";
                        $tab.="<td>600m</td>";
                        $tab.="<td>400m</td>";
                        $tab.="<td>200m</td>";
                        $tab.="<td>Comments</td>";
                        $tab.="</tr>";
                    foreach($hTraining as $hr){
                        $tab.="<tr>";
                        $tab.="<td title='Training Date(dd/mm/yyyy)'>".date("D - d M Y",strtotime($hr['_tdate']))."</td>";
                        $tab.="<td title='Rating'>".$hr['_rating']."</td>";
                        $tab.="<td title='Jockey'>".$hr['_jockey']."</td>";
                        $tab.="<td title='Equipment'>".$hr['_equip']."</td>";
                        $tab.="<td title='Time 1000m from winning post'>".$hr['_1000p']."</td>";
                        $tab.="<td title='Time 800m from winning post'>".$hr['_800p']."</td>";
                        $tab.="<td title='Time 600m from winning post'>".$hr['_600p']."</td>";
                        $tab.="<td title='Time 400m from winning post'>".$hr['_400p']."</td>";
                        $tab.="<td title='Time 200m from winning post'>".$hr['_200p']."</td>";
                        $tab.="<td title='Time 2400m from winning post'>".$hr['_2400p']."</td>";
                        $tab.="<td title='Time 2200m from winning post'>".$hr['_2200p']."</td>";
                        $tab.="<td title='Time for last 1000m'>".$hr['_1000m']."</td>";
                        $tab.="<td title='Time for last 800m'>".$hr['_800m']."</td>";
                        $tab.="<td title='Time for last 600m'>".$hr['_600m']."</td>";
                        $tab.="<td title='Time for last 400m'>".$hr['_400m']."</td>";
                        $tab.="<td title='Time for last 200m'>".$hr['_200m']."</td>";
                        $tab.="<td title='Comments En & Fr'>".utf8_encode($hr['_comments_en'])."<hr/>".utf8_encode($hr['_comments_fr'])."</td>";
                        $tab.="</tr>";
                        
                    }
                    $tab.="</table>";
                    $tab.="</td></tr>";
                    
                    
                    
                    $tab.="<tr>";
                    $tab.="<td class='coment' colspan='10'>&nbsp;</td>";
                    $tab.="</tr>";
                    
                    $tab.="</table>";
                }
                
                $tab.="</table>";
            }
            
        }
        $tab.="<br/><a id='up' href='javascript:goUp();'>Go Up</a>";

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
