<?php

include 'const.php';

class Fbpromo {
    //put your code here
    private $_id_fbpromo;
    private $_promocode;
    private $_ref_bet;
    private $_ref_client;
    private $_status;
    
    public function get_id_fbpromo() {
        return $this->_id_fbpromo;
    }

    public function set_id_fbpromo($_id_fbpromo) {
        $this->_id_fbpromo = $_id_fbpromo;
    }

    public function get_promocode() {
        return $this->_promocode;
    }

    public function set_promocode($_promocode) {
        $this->_promocode = $_promocode;
    }

    public function get_ref_bet() {
        return $this->_ref_bet;
    }

    public function set_ref_bet($_ref_bet) {
        $this->_ref_bet = $_ref_bet;
    }

    public function get_ref_client() {
        return $this->_ref_client;
    }

    public function set_ref_client($_ref_client) {
        $this->_ref_client = $_ref_client;
    }

    public function get_status() {
        return $this->_status;
    }

    public function set_status($_status) {
        $this->_status = $_status;
    }
    
    function savfbPromo(){
        try {
            $conn = new PDO('mysql:host='.DB_HOST.';dbname='.DB, DB_USN, DB_PWD);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $conn->prepare('INSERT INTO _fbpromo_tb(_promocode, _ref_bet, _ref_client, _status) VALUES(:promocode, :refB, :refC, :status)');
            $stmt->execute(array(
              ':promocode'=>$this->_promocode, ':refB'=>$this->_ref_bet, ':refC'=>$this->_ref_client, ':status'=>$this->_status
          ));
            $last_insert_id = $conn->lastInsertId();
            
            $conn=null;
        } catch(PDOException $e) {
          echo $e->getMessage();
        }
        return $last_insert_id;
    }
    
    public static function refundPromo($sts, $refC, $refB){
        try {
            $conn = new PDO('mysql:host='.DB_HOST.';dbname='.DB, DB_USN, DB_PWD);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $conn->prepare('UPDATE _fbpromo_tb SET _status = :sts WHERE _ref_client= :refC AND _ref_bet =:refB');
            $stmt->execute(array(':sts'=>  $sts, ':refC'=>$refC, ':refB'=>$refB));
            $conn=null;
            return true;
        } catch(PDOException $e) {
          return $e->getMessage();
        }
    }


    
}

?>
