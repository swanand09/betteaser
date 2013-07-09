<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

include 'const.php';

class Bet {
    //put your code here
    private $_id_bet;
    private $_ref_client;
    private $_curr;
    private $_amount;
    private $_date;
    private $_gametype;
    private $_fold;
    private $_bet;
    private $_betrnum;
    private $_betaccp;
    private $_betrnumacc;
    private $_autorep;
    private $_bstatus;
    
    public function get_id_bet() {
        return $this->_id_bet;
    }

    public function set_id_bet($_id_bet) {
        $this->_id_bet = $_id_bet;
    }

    public function get_ref_client() {
        return $this->_ref_client;
    }

    public function set_ref_client($_ref_client) {
        $this->_ref_client = $_ref_client;
    }

    public function get_curr() {
        return $this->_curr;
    }

    public function set_curr($_curr) {
        $this->_curr = $_curr;
    }

    public function get_amount() {
        return $this->_amount;
    }

    public function set_amount($_amount) {
        $this->_amount = $_amount;
    }

    public function get_date() {
        return $this->_date;
    }

    public function set_date($_date) {
        $this->_date = $_date;
    }

    public function get_gametype() {
        return $this->_gametype;
    }

    public function set_gametype($_gametype) {
        $this->_gametype = $_gametype;
    }

    public function get_fold() {
        return $this->_fold;
    }

    public function set_fold($_fold) {
        $this->_fold = $_fold;
    }

    public function get_bet() {
        return $this->_bet;
    }

    public function set_bet($_bet) {
        $this->_bet = $_bet;
    }
    
    public function get_betrnum() {
        return $this->_betrnum;
    }

    public function set_betrnum($_betrnum) {
        $this->_betrnum = $_betrnum;
    }

    public function get_betaccp() {
        return $this->_betaccp;
    }

    public function set_betaccp($_betaccp) {
        $this->_betaccp = $_betaccp;
    }
    
    public function get_betrnumacc() {
        return $this->_betrnumacc;
    }

    public function set_betrnumacc($_betrnumacc) {
        $this->_betrnumacc = $_betrnumacc;
    }

    
    public function get_autorep() {
        return $this->_autorep;
    }

    public function set_autorep($_autorep) {
        $this->_autorep = $_autorep;
    }

    public function get_bstatus() {
        return $this->_bstatus;
    }

    public function set_bstatus($_bstatus) {
        $this->_bstatus = $_bstatus;
    }

    function savBet(){
        try {
            $conn = new PDO('mysql:host='.DB_HOST.';dbname='.DB, DB_USN, DB_PWD);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $conn->prepare('INSERT INTO _bet_tb(_ref_client, _curr, _amount, _date, _gametype, 
                _fold, _bet, _betrnum, _betaccp, _betrnumacc, _autorep, _bstatus) VALUES(:ref_client, :curr, :amount, :date, 
                :gametype, :fold, :bet, :betrnum, :betaccp, :betrnumacc, :autorep, :bstatus)');
            $stmt->execute(array(
              ':ref_client'=>$this->_ref_client, ':curr'=>$this->_curr, ':amount'=>$this->_amount, ':date'=>$this->_date,
              ':gametype'=>$this->_gametype, ':fold'=>$this->_fold, ':bet'=>$this->_bet, ':betrnum'=>$this->_betrnum, ':betaccp'=>$this->_betaccp,
              ':betrnumacc'=>$this->_betrnumacc, ':autorep'=>  $this->_autorep, ':bstatus'=>  $this->_bstatus
          ));
            $last_insert_id = $conn->lastInsertId();
            
            $conn=null;
        } catch(PDOException $e) {
          echo $e->getMessage();
        }
        return $last_insert_id;
    }
    
    public static function getBetForBSlip($lim, $rClient){
        try {
          $conn = new PDO('mysql:host='.DB_HOST.';dbname='.DB, DB_USN, DB_PWD);
          $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          if($lim==1){
              $stmt = $conn->prepare("SELECT _id_bet, _amount, _date, _fold, _curr, _betaccp, _betrnumacc, _gametype FROM `_bet_tb` WHERE _ref_client= :rClient AND _bstatus=0 ORDER BY _date DESC LIMIT 10");
              $stmt->execute(array(':rClient' => $rClient));
         }else{
            $stmt = $conn->prepare("SELECT _id_bet, _amount, _date, _fold, _curr, _betaccp, _betrnumacc, _gametype, _bstatus FROM `_bet_tb` WHERE _ref_client= :rClient ORDER BY _date DESC");
              $stmt->execute(array(':rClient' => $rClient)); 
         }
          
          $result = $stmt->fetchAll();
          $conn=null;
          return $result;
        
        } catch(PDOException $e) {
            echo 'ERROR: ' . $e->getMessage();
        }
    }
    public static function getBetByRH($rh){
        try {
          $conn = new PDO('mysql:host='.DB_HOST.';dbname='.DB, DB_USN, DB_PWD);
          $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          $stmt = $conn->prepare("SELECT _id_bet, _ref_client, _amount, _fold FROM `_bet_tb` WHERE _bet= :rh AND _bstatus=0");
          $stmt->execute(array(':rh' => $rh)); 
          $result = $stmt->fetchAll();
          $conn=null;
          return $result;
        
        } catch(PDOException $e) {
            echo 'ERROR: ' . $e->getMessage();
        }
    }
    
    public static function getBetLikeR($rId, $rh){
        try {
          $conn = new PDO('mysql:host='.DB_HOST.';dbname='.DB, DB_USN, DB_PWD);
          $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          $stmt = $conn->prepare("SELECT * FROM `_bet_tb` WHERE _bet LIKE :rId AND _bet != :rh AND _bstatus=0");
          $stmt->execute(array(':rId'=> '%r'.$rId.'%' , ':rh' => $rh)); 
          $result = $stmt->fetchAll();
          $conn=null;
          return $result;
        
        } catch(PDOException $e) {
            echo 'ERROR: ' . $e->getMessage();
        }
    }
    public static function getWHrBets($rh){
        try {
          $conn = new PDO('mysql:host='.DB_HOST.';dbname='.DB, DB_USN, DB_PWD);
          $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          $stmt = $conn->prepare("SELECT * FROM `_bet_tb` WHERE _bet LIKE :rh AND _fold > 1 AND _bstatus=0");
          $stmt->execute(array(':rh'=> '%'.$rh.'%')); 
          $result = $stmt->fetchAll();
          $conn=null;
          return $result;
        
        } catch(PDOException $e) {
            echo 'ERROR: ' . $e->getMessage();
        }
    }
    
    public static function updateStatus($sts, $betId){
        try {
            $conn = new PDO('mysql:host='.DB_HOST.';dbname='.DB, DB_USN, DB_PWD);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $conn->prepare('UPDATE _bet_tb SET _bstatus = :sts WHERE _id_bet= :betId');
            $stmt->execute(array(
              ':sts'=>  $sts, ':betId'=>$betId
            ));
            $conn=null;
            return true;
        } catch(PDOException $e) {
          return $e->getMessage();
        }
    }
    
    public static function updateLostBet($betId){
        try {
            $conn = new PDO('mysql:host='.DB_HOST.';dbname='.DB, DB_USN, DB_PWD);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $conn->prepare('UPDATE _bet_tb SET _bstatus = :sts WHERE _id_bet= :betId');
            $stmt->execute(array(
              ':sts'=>  $sts, ':betId'=>$betId
            ));
            $conn=null;
            return true;
        } catch(PDOException $e) {
          return $e->getMessage();
        }
    }
    
    public static function getClientByBetId($bId){
        try {
          $conn = new PDO('mysql:host='.DB_HOST.';dbname='.DB, DB_USN, DB_PWD);
          $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          $stmt = $conn->prepare("SELECT _ref_client FROM `_bet_tb` WHERE _id_bet =:bId");
          $stmt->execute(array(':bId' => $bId)); 
          $result = $stmt->fetchAll();
          $conn=null;
          return $result;
        
        } catch(PDOException $e) {
            echo 'ERROR: ' . $e->getMessage();
        }
    }
    
}

?>
