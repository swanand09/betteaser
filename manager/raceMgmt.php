<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

    include("./utility/ClassRace.php");
    include("./utility/ClassJockey.php");
    include("./utility/ClassStable.php");
    include("./utility/ClassHorse.php");
    include("./utility/ClassHorsenomi.php");
    include("./utility/ClassHorselist.php");
    include("./utility/ClassManager.php");
    
    $manager = New Manager();
    $manager->confirm_Manager();
    
    $btn=$_POST['btn'];
    $action=$_POST['action'];
    
    if($btn=='create'){
        $mId=$_POST['mId'];
    
        if(trim($mId)==''){
            header('Location: index.php');
        }else{
            $rnum=trim($_POST['rnum']);
            $rname=trim(utf8_decode($_POST['rname']));
            $rtime=trim($_POST['rtime']);
            $rdist=trim($_POST['rdist']);
            $rating=trim($_POST['rating']);
            
            $r=New Race();
            $r->set_rnum($rnum);
            $r->set_rname($rname);
            $r->set_rtime($rtime);
            $r->set_rdist($rdist);
            $r->set_rating($rating);
            $r->set_ref_meeting($mId);
            
            if(!$r->createRace()){
               echo 'Race not created';
            }
        }
    }
    
    if($btn=='edit'){
        $rId=$_POST['rId'];
    
        if(trim($rId)==''){
            header('Location: index.php');
        }else{
            $ernum=trim($_POST['ernum']);
            $ername=trim(utf8_decode($_POST['ername']));
            $ertime=trim($_POST['ertime']);
            $erdist=trim($_POST['erdist']);
            $erating=trim($_POST['erating']);
            $wstatus=trim($_POST['wstatus']);
            $rstatus=trim($_POST['rstatus']);
            
            $edRace=New Race();
            $edRace->set_id_race($rId);
            $edRace->set_rnum($ernum);
            $edRace->set_rname($ername);
            $edRace->set_rtime($ertime);
            $edRace->set_rdist($erdist);
            $edRace->set_rating($erating);
            $edRace->set_webstatus($wstatus);
            $edRace->set_rstatus($rstatus);
            
            if(!$edRace->editRaceDetails()){
                echo 'Race not updated';
            }
            
        }
        //echo 'Edit Race<br/>RaceId: '.$rId.' Name: '.$ername.' Num: '.$ernum.' Time: '.$ertime.' Status: '.$wstatus;
    }
    
    if($action=='getHorseList'){
        $i=0;
        $raceId=$_POST['rId'];
        $horseType='';
        //echo "<p class=hl>".$raceId."</p>";
        
        //get race horses
        $raceHorse=Horse::getRaceHorses($raceId);
        //echo $raceHorse[0][_hnum];
        
        
        if(!$raceHorse){
            echo "<p class=hl>We have no horses in this race.</p>";
        }else{
            echo "<table class=hl>";
            echo "<tr class='header'>
                    <td>#</td><td>Horse</td><td>Ch.</td><td>HWeight</td><td>Joc & St</td><td>Perf</td><td>Age</td>
                    <td>Eq</td><td>W</td><td>Draw</td><td>Time Factor</td><td>Type</td><td style='display:none;'>rId</td><td>Edit</td>
                  </tr>";
            foreach ($raceHorse as $rh){
                
                if($rh[_htype]==1){
                    $hType='NO';
                }
                if($rh[_htype]==2){
                    $hType='EA';
                }
                if($rh[_htype]==11){
                    $hType='NR';
                }
                if($rh[_htype]==12){
                    $hType='WoP';
                }
                //$stable=Stable::getStableName($rh[_ref_stable]);
                //$joc=Jockey::getJockeyName($rh[_ref_jockey]);
                
                if ($i % 2 == 0) {
                    echo "<tr id='h".$rh[_id_horse]."'>";
                }else{
                    echo "<tr class='hlight' id='h".$rh[_id_horse]."'>";
                }
                
                echo "<td>".$rh[_hnum]."</td>";
                echo "<td>".$rh[_hname]."</td>";
                echo "<td>".$rh[_hchances]."</td>";
                echo "<td>".$rh[_hweight]."</td>";
                echo "<td>".$rh[_h_stjoc]."</td>";
                echo "<td>".$rh[_hperf]."</td>";
                echo "<td>".$rh[_hage]."</td>";
                echo "<td>".$rh[_hequip]."</td>";
                echo "<td>".$rh[_weight]."</td>";
                echo "<td>".$rh[_hdraw]."</td>";
                echo "<td>".$rh[_htfactor]."</td>";
                echo "<td>".$hType."</td>";
                echo "<td style='display:none;'>".$raceId."</td>";
                echo "<td style='display:none;'>".$rh[_htype]."</td>";
                echo "<td style='display:none;'>".$rh[_hWopRate]."</td>";
                echo "<td style='display:none;'>".utf8_encode($rh[_comments_en])."</td>";
                echo "<td style='display:none;'>".utf8_encode($rh[_comments_fr])."</td>";
                echo "<td style='display:none;'>".$rh[_trainingnote]."</td>";
                echo "<td style='display:none;'>".$rh[_formnote]."</td>";
                echo "<td style='display:none;'>".utf8_encode($rh[_owners])."</td>";
                echo "<td style='display:none;'>".$rh[_trainingshot]."</td>";
                echo "<td style='display:none;'>".$rh[_selectionbox]."</td>";
                echo "<td style='display:none;'>".$rh[_casak]."</td>";
                echo "<td><a href=editHorse.php?id=" .$rh[_id_horse]. " class='editHorses' >Edit</a></td>";
                echo "</tr>";
                
                $i++;
            }
            echo "</table>";
        }
    }
    
    if ($action=='importHorses'){
        $hData=trim($_POST['hdata']);
        $refR=trim($_POST['rId']);
        $i=1;$testPrint=" ";
        
        $rows=explode("\n", $hData);
        foreach ($rows as $ro){
            $horse=explode('~', $ro);
            if(sizeof($horse)==11){
                $hType=1;
                
                $horNum=trim($horse[0]);
                
                if($horNum=='EA'){
                    $horNum=$i;$hType=2;
                }
                
                $hname=trim($horse[1]);
                $hweight=trim($horse[2]);
                $stableCode= trim($horse[3]);
                $stableId=Stable::getStableIdByCode($stableCode);
                $stableId=$stableId[0]['_id_stable'];
                
                $perf=trim($horse[4]);
                $age=trim($horse[5]);
                $eq=trim($horse[6]);
                $w=trim($horse[7]);
                
                $jocId=  Jockey::getJockeyIdByName(trim($horse[8]));
                $jocId=$jocId[0]['_id_jockey'];
                
                $jocCode=  Jockey::getJockeyCodeById($jocId);
                $jocCode=$jocCode[0]['_jcode'];
                
                $draw=trim($horse[9]);
                $tfactor=trim($horse[10]);
                $jocStable=strtolower($jocCode).'|'.trim($horse[3]);
            }
            
            
            
            $hor=new Horse();
            $hor->set_ref_race($refR);
            $hor->set_hnum($horNum);
            $hor->set_hname($hname);
            $hor->set_htype($hType);
            $hor->set_ref_stable($stableId);
            $hor->set_ref_jockey($jocId);
            $hor->set_hperf($perf);
            $hor->set_hage($age);
            $hor->set_hequip($eq);
            $hor->set_weight($w);
            $hor->set_hweight($hweight);
            $hor->set_hdraw($draw);
            $hor->set_htfactor($tfactor);
            $hor->set_h_stjoc($jocStable);
            
            
            $rez=$hor->createHorse();
            
//            if($rez){
//                $testPrint.="Rez ".$i." - ".$rez." ";
//            }else{
//                $testPrint.="FALSE ";
//            }
            
            
            
            
//            $testPrint.="Row ".$i." - Num: ".$hor->get_hnum()." Hname: ".$hor->get_hname()." RefRace: ".$hor->get_ref_race()." Type: "
//                    .$hor->get_htype()." Odds: ".$hor->get_hodds()." RefStable: ".$hor->get_ref_stable()." RefJoc: ".$hor->get_ref_jockey()." Perf: "
//                    .$hor->get_hperf()." Age: ".$hor->get_hage()." Rating: ".$hor->get_hrating()." Eq: ".$hor->get_hequip()." W: "
//                    .$hor->get_weight()." HWeight: ".$hor->get_hweight()." Draw: ".$hor->get_hdraw()." Tfactor: ".$hor->get_htfactor()." Ch: "
//                    .$hor->get_hchances()." NB: ".$hor->get_hnb()." JocSt: ".$hor->get_h_stjoc()."<br/>";

            

            $i++;
        }
        
        
        echo $testPrint;
        //echo "Good";
    }
    
    if ($action=='popJoc'){
        $joc=$_POST['joc'];
        
        $jockeyList=Jockey::getAllJockey();
        $op="";
        foreach($jockeyList as $jc){
            if (strtolower($jc['_jcode'])==$joc){
                $op.="<option selected value=".$jc['_jcode'].">".$jc['_jname']."</option>";
                
            }else{
                $op.="<option value=".$jc['_jcode'].">".$jc['_jname']."</option>";
            }
        }
        echo $op;
    }
    if ($action=='popStab'){
        $stab=$_POST['stab'];
        
        $stableList=Stable::getAllStable();
        $op="";
        foreach($stableList as $st){
            if ($st['_scode']==$stab){
                $op.="<option selected value=".$st['_scode'].">".$st['_sname']."</option>";
                
            }else{
                $op.="<option value=".$st['_scode'].">".$st['_sname']."</option>";
            }
        }
        echo $op;
    }
    if ($action=='saveEditHorse'){
        $rId=$_POST['rId'];
        $Eor=Race::getRaceDetailById($rId);
        $Eor=$Eor[0]['_eor'];
        if($Eor!=1){
            $hId=$_POST['hId'];
            $hNum=$_POST['hNum'];
            $hNam=strtoupper($_POST['hNam']);
            $pChances=$_POST['pChances'];
            $hWeight=$_POST['hWeight'];
            $stab=$_POST['stab'];
            $jocK=$_POST['jocK'];
            $jocCod=strtolower($_POST['jocCode']);
            $hPerf=$_POST['hPerf'];
            $hAge=$_POST['hAge'];
            $hEquip=$_POST['hEquip'];
            $wei=$_POST['wei'];
            $hDraw=$_POST['hDraw'];
            $hTfactor=$_POST['hTfactor'];
            $hType=$_POST['hType'];
            $hWopRate=$_POST['hWopRate'];
            $webChances=$_POST['webChances'];
            $hCommentEn=utf8_decode($_POST['hCommentEn']);
            $hCommentFr=utf8_decode($_POST['hCommentFr']);
            $hTNote=$_POST['hTNote'];
            $hFormNote=$_POST['hFormNote'];
            $hOwners=utf8_decode($_POST['hOwners']);
            $chkTrainShot=$_POST['chkTrainShot'];
            $hSelBox=$_POST['hSelBox'];
            $hCasak=$_POST['hCasak'];
            
            $stabId=Stable::getStableIdByCode($stab);
            $jocId=Jockey::getJockeyIdByName($jocK);
            $jocSt=$jocCod.'|'.$stab;

            $h=New Horse();
            $h->set_id_horse($hId);$h->set_hnum($hNum);$h->set_hname($hNam);$h->set_hchances($pChances);
            $h->set_hweight($hWeight);$h->set_ref_stable($stabId[0]['_id_stable']);$h->set_ref_jockey($jocId[0]['_id_jockey']);$h->set_hperf($hPerf);
            $h->set_hage($hAge);$h->set_hequip($hEquip);$h->set_weight($wei);$h->set_hdraw($hDraw);$h->set_htfactor($hTfactor);
            $h->set_htype($hType);$h->set_h_stjoc($jocSt);$h->set_hWopRate($hWopRate);$h->set_webchances($webChances);
            $h->set_comments_en($hCommentEn);$h->set_comments_fr($hCommentFr);$h->set_trainingnote($hTNote);$h->set_formnote($hFormNote);
            $h->set_owners($hOwners);$h->set_trainingshot($chkTrainShot);$h->set_selectionbox($hSelBox);$h->set_casak($hCasak);
            $h->updateHorseBasic();
        }
        
        
        
        //echo 'Horse Id: '.$hId.' Horse Num: '.$hNum.' Horse Name: '.$hNam.' Chances: '.$pChances.' Horse Weight: '.$hWeight.' Stable: '.$stabId[0]['_id_stable'].' Jockey: '.$jocId[0]['_id_jockey'].' Type: '.$hType;
    }
    if($action=='changeRaceStatus'){
        $raceId=$_POST['rId'];
        $rDet=Race::getRaceDetailById($raceId);
        $currStat=$rDet[0]['_rstatus'];
        $Eor=$rDet[0]['_eor'];
        
        if($Eor!=1){
            $currStat+=1;
            $r=new Race();
            $r->set_id_race($raceId);
            $r->set_rstatus($currStat);
            $r->editRaceStatus();
        }
    }
    
    if($action=='importHorsesWeight'){
        //$rows=explode("\n", $hData);
        $radVal=$_POST['radVal'];
        $hWeightData=$_POST['hWeight'];
        $raceId=$_POST['rId'];
        $numOfHorses=Horse::getRaceHorses($raceId);
        
                
        if($radVal=='hWeight'){
          $rows=explode("\n", $hWeightData);
          if(sizeof($numOfHorses)==sizeof($rows)){
              foreach ($rows as $ro){
                  $hW=explode('~', $ro);
                  if(sizeof($hW)==2){
                        $hNum=trim($hW[0]);
                        $hWei=trim($hW[1]);
                        Horse::addHorseWeight($hNum, $hWei, $raceId);
                   }
              }
          }
        }
        if($radVal=='hTFactor'){
            $rows=explode("\n", $hWeightData);
            if(sizeof($numOfHorses)==sizeof($rows)){
              foreach ($rows as $ro){
                  $hT=explode('~', $ro);
                  if(sizeof($hT)==2){
                        $hNum=trim($hT[0]);
                        $hTime=trim($hT[1]);
                        Horse::addHorseTime($hNum, $hTime, $raceId);
                   }
              }
            }
        }
        if($radVal=='hWeiTime'){
            $rows=explode("\n", $hWeightData);
            if(sizeof($numOfHorses)==sizeof($rows)){
              foreach ($rows as $ro){
                  $hWT=explode('~', $ro);
                  if(sizeof($hWT)==3){
                      $hNum=trim($hWT[0]);
                      $hWei=trim($hWT[1]);
                      $hTime=trim($hWT[2]);
                      Horse::addHorse_WeightTime($hNum, $hTime, $hWei, $raceId);
                  }
              }
            }
        }
        
        if($radVal=='hOwnerNCasak'){
          $rows=explode("\n", $hWeightData);
            if(sizeof($numOfHorses)==sizeof($rows)){
              foreach ($rows as $ro){
                  $hOwNCa=explode('~', $ro);
                  if(sizeof($hOwNCa)==3){
                      $hNum=trim($hOwNCa[0]);
                      $hOwner=trim(utf8_decode($hOwNCa[1]));
                      $hCasak=trim($hOwNCa[2]);
                      Horse::addHorse_OwnerCasak($hNum, $hOwner, $hCasak, $raceId);
                      //$rez.='Hnum: '.$hNum.' Howner: '.$hOwner.' Cazak: '.$hCasak.'<br/>';
                     
                  }
              }
            }
            
        }
        
    }
    if ($action=='getWebInfo'){
        
        $rId=$_POST['rId'];

        $webInfo=Race::getRaceDetailById($rId);
        
        $prize=$webInfo[0]['_prize'];
        $enTitle=utf8_encode($webInfo[0]['_analyse_title_en']);
        $enText=utf8_encode($webInfo[0]['_analyse_text_en']);
        $frTitle=utf8_encode($webInfo[0]['_analyse_title_fr']);
        $frText=utf8_encode($webInfo[0]['_analyse_text_fr']);
        $cGears=$webInfo[0]['_cgears'];
        $sReport=utf8_encode($webInfo[0]['_stewardrep']);
        
        echo json_encode(array('prize'=>$prize,'enTitle'=>$enTitle,'enText'=>$enText,'frTitle'=>$frTitle,'frText'=>$frText,'cGears'=>$cGears,'sReport'=>$sReport));
    }
    
    if($action=='saveWebInfo'){
        
        $raceId=$_POST['rId'];
        $prize=$_POST['prize'];
        $enTitle=utf8_decode($_POST['enTitle']);
        $enText=utf8_decode($_POST['enText']);
        $frTitle=utf8_decode($_POST['frTitle']);
        $frText=utf8_decode($_POST['frText']);
        $cGears=$_POST['cGears'];
        $sReport=utf8_decode($_POST['sReport']);
        
        $race=new Race();
        $race->set_id_race($raceId);
        $race->set_prize($prize);
        $race->set_analyse_title_en($enTitle);
        $race->set_analyse_text_en($enText);
        $race->set_analyse_title_fr($frTitle);
        $race->set_analyse_text_fr($frText);
        $race->set_cgears($cGears);
        $race->set_stewardrep($sReport);
        $race->saveWebInfo();
    }
    
    
    if($action=='importNomination'){
        $raceId=$_POST['rId'];
        $nomi=$_POST['hNomi'];
        
        $rows=explode("\n", $nomi);
            
              foreach ($rows as $ro){
                  $hNom=explode('~', $ro);
                  if(sizeof($hNom)==6){
                      $hNum=trim($hNom[1]);
                      $hName=trim($hNom[2]);
                      $hStab=trim($hNom[3]);
                      $hWei=trim($hNom[4]);
                      $hDraw=trim($hNom[5]);
                      
                      $stab=Stable::getStableIdByName($hStab);
                      $hlist=Horselist::getHorselistByName($hName);
                      
                      $newNomi=new Horsenomi();
                      $newNomi->set_ref_stable($stab[0]['_id_stable']);
                      $newNomi->set_ref_horselist($hlist[0]['_id_hlist']);
                      $newNomi->set_draw($hDraw);
                      $newNomi->set_num($hNum);
                      $newNomi->set_weight($hWei);
                      $newNomi->set_ref_race($raceId);
                      
                      $newNomi->createNomination();
                     
                  }
                  //$t.='Num: '.$hNum.' Name: '.$hlist[0]['_id_hlist'].' Stab: '.$stab[0]['_id_stable'].' Weight: '.$hWei.' Draw: '.$hDraw.'\n';
              }
              
              //echo $t;
//              print_r($rows);
            
    }

?>
