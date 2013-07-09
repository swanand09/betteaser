<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


class PayoutMgmt {
    //put your code here
    private $_id_payout;
    private $_ref_horse;
    private $_amount;
    private $_payout;
    private $_ref_race;
    
    public function get_ref_race() {
        return $this->_ref_race;
    }

    public function set_ref_race($_ref_race) {
        $this->_ref_race = $_ref_race;
    }

        
    public function get_id_payout() {
        return $this->_id_payout;
    }

    public function set_id_payout($_id_payout) {
        $this->_id_payout = $_id_payout;
    }

    public function get_ref_horse() {
        return $this->_ref_horse;
    }

    public function set_ref_horse($_ref_horse) {
        $this->_ref_horse = $_ref_horse;
    }

    public function get_amount() {
        return $this->_amount;
    }

    public function set_amount($_amount) {
        $this->_amount = $_amount;
    }

    public function get_payout() {
        return $this->_payout;
    }

    public function set_payout($_payout) {
        $this->_payout = $_payout;
    }

    public static function checkIfEmpty($refR){
        try {
          $conn = new PDO('mysql:host='.DB_HOST.';dbname='.DB, DB_USN, DB_PWD);
          $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          $stmt = $conn->prepare("SELECT COUNT(*) AS totH FROM _payout_tb WHERE _ref_race=:refR");
          $stmt->execute(array(':refR'=>$refR)); 
          $conn=null;
          $result = $stmt->fetchAll();
          return $result;
        
        } catch(PDOException $e) {
            echo 'ERROR: ' . $e->getMessage();
        }
    }
    public static function getPObyHorse($refH){
        try {
          $conn = new PDO('mysql:host='.DB_HOST.';dbname='.DB, DB_USN, DB_PWD);
          $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          $stmt = $conn->prepare("SELECT * FROM _payout_tb WHERE _ref_horse=:refH");
          $stmt->execute(array(':refH' => $refH)); 
         
          $result = $stmt->fetchAll();
          $conn=null;
          return $result;
        
        } catch(PDOException $e) {
            echo 'ERROR: ' . $e->getMessage();
        }
    }
    
    public static function savPoMg($refH,$amt,$po){
        try {
            $conn = new PDO('mysql:host='.DB_HOST.';dbname='.DB, DB_USN, DB_PWD);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $conn->prepare('UPDATE _payout_tb SET _amount=:amt, _payout=:po WHERE _ref_horse=:refH');
            $stmt->execute(array(':refH'=>$refH, ':amt'=>$amt, ':po'=>$po));
            $conn=null;
        } catch(PDOException $e) {
          echo $e->getMessage();
        }
        
    }
    public static function populatePO($refH,$refR){
        try {
            $conn = new PDO('mysql:host='.DB_HOST.';dbname='.DB, DB_USN, DB_PWD);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $conn->prepare('INSERT INTO _payout_tb (_ref_race, _ref_horse, _amount, _payout) VALUES (:refR, :refH, 0, 0)');
            $stmt->execute(array(':refH'=>$refH, ':refR'=>$refR));
            $conn=null;
        } catch(PDOException $e) {
          echo $e->getMessage();
        }
        
    }
    public static function getCurrRate($cCode){
        try {
          $conn = new PDO('mysql:host='.DB_HOST.';dbname='.DB, DB_USN, DB_PWD);
          $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          $stmt = $conn->prepare("SELECT _rate FROM _extrate_tb WHERE _curr=:curr");
          $stmt->execute(array(':curr' => $cCode)); 
         
          $result = $stmt->fetchAll();
          $conn=null;
          return $result;
        
        } catch(PDOException $e) {
            echo 'ERROR: ' . $e->getMessage();
        }
    }
}

?>
