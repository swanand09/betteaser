<?php

/* Time Limit
set_time_limit(0);
set_time_limit(30); 
*/


include 'utility/const.php';
include 'utility/ClassStable.php';

//update pedigree, origin, type, status

function updateHorselist_status(){
        try {
            $conn = new PDO('mysql:host='.DB_HOST.';dbname='.DB, DB_USN, DB_PWD);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $conn->prepare('UPDATE _horselist_tb SET _hl_status = 0');
            $stmt->execute();
            $conn=null;
            return true;
        } catch(PDOException $e) {
          return $e->getMessage();
        }
}


function updateHorselist($refstable, $hrating,$hname){
        try {
            $conn = new PDO('mysql:host='.DB_HOST.';dbname='.DB, DB_USN, DB_PWD);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $conn->prepare('UPDATE _horselist_tb SET _ref_stable = :refstable, _hrating = :hrating, _hl_status = 1 WHERE _hname= :hname');
            $stmt->execute(array(':refstable' => $refstable, ':hrating'=>$hrating, ':hname'=>$hname));
            $conn=null;
            return true;
        } catch(PDOException $e) {
          return $e->getMessage();
        }
}

function getHorseIn($hname){
        try {
          $conn = new PDO('mysql:host='.DB_HOST.';dbname='.DB, DB_USN, DB_PWD);
          $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          $stmt = $conn->prepare('SELECT _hname FROM _horselist_tb WHERE _hname = :hname');
          $stmt->execute(array(':hname' => $hname));
          $result = $stmt->fetchAll();
          $conn=null;
          return $result;
        
        } catch(PDOException $e) {
            echo 'ERROR: ' . $e->getMessage();
        }
}

function createHorselist($refstable, $hrating, $hname){
        try {
            $conn = new PDO('mysql:host='.DB_HOST.';dbname='.DB, DB_USN, DB_PWD);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $conn->prepare('INSERT INTO _horselist_tb(_hname, _pedigree, _ref_stable, _hrating, _origin, _type, 
                _hl_status) VALUES(:hname, :pedigree, :refStable, :hrating, :origin, :type, :hlstatus)');
            $stmt->execute(array(
                ':hname'=>  $hname, ':pedigree'=>'-', ':refStable'=>$refstable, 
                ':hrating'=>$hrating, ':origin'=>'0', ':type'=>'0', 
                ':hlstatus'=>'1'
            ));
            $conn=null;
            return true;
        } catch(PDOException $e) {
          return $e->getMessage();
        }
}


//$refHorse=getAllRefHorse();

//Get All horse in horselist
//set status = 0
//get stable id and update horselist(ref_stable, rating, status=1)
set_time_limit(0);
    if(trim($_POST['txtEffectif'])!=''){
        $effectif=$_POST['txtEffectif'];
        $rows=explode("\n", $effectif);
        
        $eff=explode('~', $rows[0]);
        if(sizeof($eff)==3){
            updateHorselist_status();
        }
        
        foreach ($rows as $ro){
            $eff=explode('~', $ro);
            if(sizeof($eff)==3){
                $stableId=Stable::getStableIdByName(trim($eff[0]));
                $sId=$stableId[0]['_id_stable'];
                $hname=strtoupper(trim($eff[1]));
                $hrating=trim($eff[2]);
                //echo 'Stable Id: '.$sId.' Horse: '.$hname.' Rating: '.$hrating.'<br/>';
                $getHname=getHorseIn($hname);
                
                
                if($getHname[0]['_hname']==''){
                    echo 'New Horse - '.$hname.'<br/>';
                    createHorselist($sId, $hrating, $hname);
                    
                    
                }else{
                    echo $getHname[0]['_hname'].'<br/>';
                    updateHorselist($sId, $hrating,$hname);
                }

                
            }
         }
        
        
    }

set_time_limit(30);
?>
<html>
    <head>
        <title></title>
    </head>
    <body>
        <h3>Update Horse List</h3>
        <form method="POST" action="<?php echo $PHP_SELF; ?>" >
            <textarea id="txtEffectif" cols="55" rows="10" name="txtEffectif"></textarea><br/>
            <button type="submit" name="btnSaveEffectif">Update Effectif</button>
        </form>
    </body>
</html>
