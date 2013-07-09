<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

include 'const.php';

class RecoverMail {
    //put your code here
    private $_id_recovery;
    private $_ref_client;
    private $_key;
    private $_datetime;
    
    public function get_id_recovery() {
        return $this->_id_recovery;
    }

    public function set_id_recovery($_id_recovery) {
        $this->_id_recovery = $_id_recovery;
    }

    public function get_ref_client() {
        return $this->_ref_client;
    }

    public function set_ref_client($_ref_client) {
        $this->_ref_client = $_ref_client;
    }

    public function get_key() {
        return $this->_key;
    }

    public function set_key($_key) {
        $this->_key = $_key;
    }

    public function get_datetime() {
        return $this->_datetime;
    }

    public function set_datetime($_datetime) {
        $this->_datetime = $_datetime;
    }

    public static function checkPendingRecovery($refCl){
        try {
          $conn = new PDO('mysql:host='.DB_HOST.';dbname='.DB, DB_USN, DB_PWD);
          $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          $stmt = $conn->prepare('SELECT _id_recovery FROM `_recoveryemail` WHERE _datetime > CURDATE() AND _ref_client=:refCl');
          $stmt->execute(array(':refCl' => $refCl));
          $result = $stmt->fetchAll();
          $conn=null;
          if ( count($result) ) {
            return true;
            
          } else {
            return false;
          }
        
          
        } catch(PDOException $e) {
            echo 'ERROR: ' . $e->getMessage();
        }
    }
    
    public static function deleteRecovery($recoverId){
        try {
            $conn = new PDO('mysql:host='.DB_HOST.';dbname='.DB, DB_USN, DB_PWD);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $conn->prepare('DELETE FROM _recoveryemail WHERE _id_recovery = :rId');
            $stmt->execute(array(':rId'=>$recoverId));
            $conn=null;
            return true;
        } catch(PDOException $e) {
          return $e->getMessage();
        }
    }
    
    public static function getRecoveryId($hash, $clId){
        try {
          $conn = new PDO('mysql:host='.DB_HOST.';dbname='.DB, DB_USN, DB_PWD);
          $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          $stmt = $conn->prepare('SELECT _id_recovery FROM _recoveryemail WHERE _ref_client = :clId AND _key = :key');
          $stmt->execute(array(':clId'=>$clId,':key'=>  $hash));
          $result = $stmt->fetchAll();
          $conn=null;
          return $result;
        
        } catch(PDOException $e) {
            echo 'ERROR: ' . $e->getMessage();
        }
    }
    
}

?>
