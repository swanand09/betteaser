<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 * 
 * 1. Get Horselist
 * 2. Check with tmptable if horse exists
 */

include 'utility/const.php';
include 'utility/ClassHorseruns.php';

function getHorseList(){
        try {
          $conn = new PDO('mysql:host='.DB_HOST.';dbname='.DB, DB_USN, DB_PWD);
          $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          $stmt = $conn->prepare('SELECT _id_hlist, _hname FROM _horselist_tb');
          $stmt->execute();
          $result = $stmt->fetchAll();
          $conn=null;
          return $result;
        
        } catch(PDOException $e) {
            echo 'ERROR: ' . $e->getMessage();
        }
}
function getTmpTable($hname){
        try {
          $conn = new PDO('mysql:host='.DB_HOST.';dbname='.DB, DB_USN, DB_PWD);
          $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          $stmt = $conn->prepare('SELECT * FROM tmptable WHERE _horse=:horse');
          $stmt->execute(array(':horse'=>$hname));
          $result = $stmt->fetchAll();
          $conn=null;
          return $result;
        
        } catch(PDOException $e) {
            echo 'ERROR: ' . $e->getMessage();
        }
}

set_time_limit(0);

$hlist=getHorseList();
echo 'Number of Horses: '.sizeof($hlist).'<br/><br/>';
foreach ($hlist as $hl){
    $hrunDetails=getTmpTable($hl['_hname']);
    $refHorse=$hl['_id_hlist'];
    echo $refHorse.' - '.$hl['_hname'].'<br/>';
    
    if(sizeof($hrunDetails)==0){
        echo 'No Details';
    }else{
        foreach($hrunDetails as $hrun){
            if($hrun['_date']!='0000-00-00'){
                $raceDate=date("d/m/Y", strtotime($hrun['_date']));
                $mno_rno=$hrun['race_reference'];
                $going=$hrun['going'];
                $rrating=$hrun['rating'];
                $dist=$hrun['distance'];
                $hweight=$hrun['horse_weight'];
                $joc=$hrun['jockey'];
                $equip=$hrun['equipment'];
                $weight=$hrun['weight'];
                $draw=$hrun['draw'];
                $p600=$hrun['pos_600'];
                $p300=$hrun['pos_400'];
                $p100=$hrun['pos_200'];
                $rank=$hrun['rank'];
                $winnerSec=$hrun['winner_second'];
                $margin=$hrun['margin'];
                $timerace=$hrun['race_time'];
                $time600=$hrun['time_last_600'];
                $time400='-';
                $hrating=$hrun['horse_rating'];
                $commentEn=utf8_encode($hrun['comment']);
                $commentFr=utf8_encode($hrun['comment_fr']);
                $refRace=0;

                $hRuns= new Horseruns();
                $hRuns->set_racedate($raceDate);$hRuns->setMno_rno($mno_rno);$hRuns->set_going($going);
                $hRuns->set_rrating($rrating);$hRuns->set_rdist($dist);$hRuns->set_hweight($hweight);
                $hRuns->set_jockey($joc);$hRuns->set_equip($equip);$hRuns->set_weight($weight);
                $hRuns->set_draw($draw);$hRuns->set_p600($p600);$hRuns->set_p300($p300);$hRuns->set_p100($p100);
                $hRuns->set_rank($rank);$hRuns->set_winner_sec($winnerSec);$hRuns->set_margin($margin);
                $hRuns->set_timerace($timerace);$hRuns->set_time600($time600);$hRuns->set_time400($time400);
                $hRuns->set_hrating($hrating);$hRuns->set_comment_en($commentEn);$hRuns->set_comment_fr($commentFr);
                $hRuns->set_ref_race($refRace);$hRuns->set_ref_horse($refHorse);$hRuns->set_horsename($hl['_hname']);
                //$valCreate=$hRuns->createHorserun();
                
                echo 'RaceDate: '.$hRuns->get_racedate().' - MnoRno: '.$hRuns->getMno_rno().' - Going: '.$hRuns->get_going().' - RRating: '.$hRuns->get_rrating().' - Dist: '.$hRuns->get_rdist().' - HWeight: '.$hRuns->get_hweight().' - Jockey: '.$hRuns->get_jockey().' - Equip: '.
                    $hRuns->get_equip().' - Weight: '.$hRuns->get_weight().' - Draw: '.$hRuns->get_draw().' - P600: '.$hRuns->get_p600().' - P300: '.$hRuns->get_p300().' - P100: '.$hRuns->get_p100().' - Rank: '.$hRuns->get_rank().' - WinnerSec: '.$hRuns->get_winner_sec().' - Margin: '.
                    $hRuns->get_margin().' - TimeRace: '.$hRuns->get_timerace().' - T600: '.$hRuns->get_time600().' - T400: '.$hRuns->get_time400().' - HRating: '.$hRuns->get_hrating().' - CommentEN: '.$hRuns->get_comment_en().' - CommentFR: '.$hRuns->get_comment_fr().' - RefRace: '.
                    $hRuns->get_ref_race().' - RefHorse: '.$hRuns->get_ref_horse().' ValCreate: '.$valCreate.'<br/>';
            }
        
        }
    
    }
    echo '<br/><br/>';
}

set_time_limit(30);
?>
