<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
include 'const.php';
include '\utility\ClassSel.php';

class ClientStatement {
    public static function getStatement($clId){
        $st=array();
        //Getting opening Balance
        try {
          $conn = new PDO('mysql:host='.DB_HOST.';dbname='.DB, DB_USN, DB_PWD);
          $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          $stmt = $conn->prepare('SELECT _opBal, _opBal_date FROM _client_tb WHERE _id_client = :clId');
          $stmt->execute(array(':clId' => $clId));
          $result = $stmt->fetchAll();
          $st[]=array('dat'=>$result[0]['_opBal_date'],'desc'=>'Opening Balance','bstatus'=>'-','amount'=>$result[0]['_opBal'],'ppout'=>'-','pout'=>'-','bal'=>'');
          $result = null; 
          
          $stmt = $conn->prepare('SELECT * FROM _depo_tb WHERE _ref_client = :clId');
          $stmt->execute(array(':clId' => $clId));
          $result = $stmt->fetchAll();
          foreach($result as $depo){
              $st[]=array('dat'=>$depo['_depodat'],'desc'=>'Deposit','bstatus'=>'-','amount'=>$depo['_amount'],'ppout'=>'-','pout'=>'-','bal'=>'');
          }
          $result = null;
          
          $stmt = $conn->prepare('SELECT * FROM _withdraw_tb WHERE _ref_client = :clId');
          $stmt->execute(array(':clId' => $clId));
          $result = $stmt->fetchAll();
          foreach($result as $wdraw){
              $st[]=array('dat'=>$wdraw['_wdrawdat'],'desc'=>'Withdrawal','bstatus'=>'-','amount'=>$wdraw['_amount'],'ppout'=>'-','pout'=>'-','bal'=>'');
          }
          $result = null;
          
          
          $stmt = $conn->prepare("SELECT _id_bet, _amount, _date, _fold, _curr, _betaccp, _betrnumacc, _gametype, _bstatus FROM `_bet_tb` WHERE _ref_client= :clId ORDER BY _date ASC");
          $stmt->execute(array(':clId' => $clId));
          $result = $stmt->fetchAll();
          $rh=array("r", "h");
          $newCarac=array(" ", "-");
          foreach($result as $b){
              if($b['_gametype']=='w'){
                  $btype='Win';
              }else{
                  $btype='Place';
              }
              if ($b['_bstatus'] == -3) {
                    $sts = 'Cancelled';
                }
                if ($b['_bstatus'] == -2) {
                    $sts = 'Refunded';
                }
                if ($b['_bstatus'] == -1) {
                    $sts = 'Replaced';
                }
                if ($b['_bstatus'] == 0) {
                    $sts = 'Pending';
                }
                if ($b['_bstatus'] == 1) {
                    $sts = 'Won';
                }
                if ($b['_bstatus'] == 2) {
                    $sts = 'Lost';
                }
                
                $ppo=Sel::getSelPO($b['_id_bet'], $b['_fold']);
                if($ppo[0]['_winamount']!=0){
                    $po=$ppo[0]['_winamount'];
                } else {
                    $po="-";
                }
              $st[]=array('dat'=>$b['_date'],'desc'=>$btype.' - '.str_replace($rh, $newCarac, $b['_betrnumacc']),'bstatus'=>$sts,'amount'=>$b['_amount'],'ppout'=>$ppo[0]['_ppayout'],'pout'=>$po,'bal'=>'');
          }
          $result = null;
          
          $stmt = $conn->prepare('SELECT _bal FROM _client_tb WHERE _id_client = :clId');
          $stmt->execute(array(':clId' => $clId));
          $result = $stmt->fetchAll();
          $st[]=array('dat'=>date("Y-m-d H:i:s"), 'desc'=>'Current Balance','bstatus'=>'','amount'=>'','ppout'=>'','pout'=>'','bal'=>$result[0]['_bal']);
          $result = null;
          
          foreach ($st as $key => $row) {
             $date[$key] = $row['dat'];
          }
          
          if (sizeof($st) > 0) {
             array_multisort($date, $st);
          }
          
          return $st;
          
        } catch(PDOException $e) {
            echo 'ERROR: ' . $e->getMessage();
        }
        
    }
}

?>
