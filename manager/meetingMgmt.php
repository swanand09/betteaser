<?php

    include 'utility\ClassMeeting.php';
    include 'utility\ClassHorselist.php';
    include 'utility\ClassTraining.php';

    
    $btn=$_POST['btn'];
    
    //echo $btn;
    
    if($btn=='create'){
        $name=$_POST['mname'];
        $dat=$_POST['mdate'];
        $stat=$_POST['mstatus'];
        $coment=$_POST['mcomment'];

        
        if((trim($name)!='')&&(trim($dat)!='')&&(trim($stat)!='')){
            
            $meeting = New Meeting();
            $meeting->set_mname($name);
            $meeting->set_mdate($dat);
            $meeting->set_mstatus($stat);
            $meeting->set_comment($coment);
            
            //$meeting->set_current(0);
            
            $meeting->createMeeting();
            
            //echo $meeting->get_mname().' '.$meeting->get_mdate().' '.$meeting->get_mstatus().' '.$meeting->get_comment().' '.$meeting->get_pitch().' '.$meeting->get_f;
//            if($meeting->createMeeting()){
//                 header('Location: index.php');
//            }else{
//                echo 'Meeting not created';
//            }
        }
        
    }
    
    
    if($btn=='edit'){
        $eid=$_POST[eid];
        $ename=$_POST[ename];
        $edate=$_POST[edate];
        $estatus=$_POST[estatus];
        $ecomment=$_POST[ecomment];
        $epitch=$_POST[epitch];
        $efalserail=$_POST[efalserail];
        $chkDisplay=$_POST[chkDisplay];
        $chkCurrent=$_POST[chkCurrent];
        
        
        
        if((trim($ename)!='')&&(trim($edate)!='')&&(trim($estatus)!='')){
                
            $meeting = New Meeting();
            $meeting->set_id_meeting($eid);
            $meeting->set_mname($ename);
            $meeting->set_mdate($edate);
            $meeting->set_mstatus($estatus);
            $meeting->set_comment($ecomment);
            $meeting->set_pitch($epitch);
            $meeting->set_falserail($efalserail);
            $meeting->set_display($chkDisplay);
            $meeting->set_current($chkCurrent);
            //echo 'Meeting Id: '.$meeting->get_id_meeting().' name: '.$ename.' date: '.$edate.' status: '.$estatus.' btn: '.$btn.' comment: '.$ecomment.' pitch: '.$epitch.' falserail: '.$efalserail.' Display: '.$chkDisplay;
            
            
            if($meeting->editMeeting()){
                 header('Location: index.php');
                //echo 'updated';
            }else{
                echo 'Meeting not updated';
            }
        }
    }
    
    if($btn=='uploadTraining'){
        $tDate=$_POST[tdate];
        $tData=$_POST[trainingData];
        
        $tDat=date( 'Y-m-d', strtotime($tDate ));
        
        $rows=explode("\n", $tData);
        foreach ($rows as $ro){
            $thorse=explode('~', $ro);
            if(sizeof($thorse)==18){
                $hname=trim($thorse[0]);
                
                $ref_horse=Horselist::getHorselistByName($hname);
                $ref_horse=trim($ref_horse[0]['_id_hlist']);
                if($ref_horse!=''){
                    $sname=trim($thorse[1]);
                    $rat=trim($thorse[2]);
                    $joc=trim($thorse[3]);
                    $eq=trim($thorse[4]);
                    $p1000=trim($thorse[5]);
                    $p800=trim($thorse[6]);
                    $p600=trim($thorse[7]);
                    $p400=trim($thorse[8]);
                    $p200=trim($thorse[9]);
                    $p2400=trim($thorse[10]);
                    $p2200=trim($thorse[11]);
                    $m1000=trim($thorse[12]);
                    $m800=trim($thorse[13]);
                    $m600=trim($thorse[14]);
                    $m400=trim($thorse[15]);
                    $m200=trim($thorse[16]);
                    //$comFr=trim($thorse[17]);
                    
                    $abrev = array("lib", "leg", "acc", "bàb", "ext", "encie", "d'", "de", "en main", "cravache");
                    $fullTextFr   = array("Librement", "Légère", "accélération", "botte à botte", "extérieure", "en compagnie","d'","de","en main", "cravache");
                    $fullTextEn   = array("Freely ", "Slight ", "acceleration", "running with", "external", "accompanied"," by ","by","in hand", "whip");

                    $comFr = str_replace($abrev, $fullTextFr, strtolower($thorse[17]));
                    $comEn = str_replace($abrev, $fullTextEn, strtolower($thorse[17]));
                    
                    
                    $tr=new Training();
                    $tr->set_ref_horse($ref_horse);
                    $tr->set_stable($sname);
                    $tr->set_rating($rat);
                    $tr->set_jockey($joc);
                    $tr->set_equip($eq);
                    $tr->set_1000p($p1000);
                    $tr->set_800p($p800);
                    $tr->set_600p($p600);
                    $tr->set_400p($p400);
                    $tr->set_200p($p200);
                    $tr->set_2400p($p2400);
                    $tr->set_2200p($p2200);
                    $tr->set_1000m($m1000);
                    $tr->set_800m($m800);
                    $tr->set_600m($m600);
                    $tr->set_400m($m400);
                    $tr->set_200m($m200);
                    $tr->set_comments_fr(utf8_decode($comFr));
                    $tr->set_comments_en($comEn);
                    $tr->set_tdate($tDat);
                    
                    $tr->createTraining();
                    
                }else{
                    echo $hname.' - Does not exist';
                }
                
            }
        }
        
        //echo $tDate.' '.$tData;
    }
    
    
    
    
?>
