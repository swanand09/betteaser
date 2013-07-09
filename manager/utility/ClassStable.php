<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

include 'const.php';

/**
 * Description of ClassStable
 *
 * @author Pascal
 */
class Stable {
    //put your code here
    private $_id_stable;
    private $_sname;
    private $_scode;
    
    function __construct() {
        
    }

    public function get_id_stable() {
        return $this->_id_stable;
    }

    public function set_id_stable($_id_stable) {
        $this->_id_stable = $_id_stable;
    }

    public function get_sname() {
        return $this->_sname;
    }

    public function set_sname($_sname) {
        $this->_sname = $_sname;
    }

    public function get_scode() {
        return $this->_scode;
    }

    public function set_scode($_scode) {
        $this->_scode = $_scode;
    }

    public static function getStableIdByCode($sCode){
        try {
          $conn = new PDO('mysql:host='.DB_HOST.';dbname='.DB, DB_USN, DB_PWD);
          $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          $stmt = $conn->prepare('SELECT _id_stable FROM _stable_tb WHERE _scode = :sCode');
          $stmt->execute(array(':sCode' => $sCode));
          $result = $stmt->fetchAll();
          $conn=null;
          return $result;
        
        } catch(PDOException $e) {
            echo 'ERROR: ' . $e->getMessage();
        }
    }
    public static function getStableIdByName($sName){
        try {
          $conn = new PDO('mysql:host='.DB_HOST.';dbname='.DB, DB_USN, DB_PWD);
          $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          $stmt = $conn->prepare('SELECT _id_stable FROM _stable_tb WHERE _sname = :sName');
          $stmt->execute(array(':sName' => $sName));
          $result = $stmt->fetchAll();
          $conn=null;
          return $result;
        
        } catch(PDOException $e) {
            echo 'ERROR: ' . $e->getMessage();
        }
    }
    public static function getStableName($sId){
        try {
          $conn = new PDO('mysql:host='.DB_HOST.';dbname='.DB, DB_USN, DB_PWD);
          $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          $stmt = $conn->prepare('SELECT _sname FROM _stable_tb WHERE _id_stable = :sId');
          $stmt->execute(array(':sId' => $sId));
          $result = $stmt->fetchAll();
          $conn=null;
          return $result;
        
        } catch(PDOException $e) {
            echo 'ERROR: ' . $e->getMessage();
        }
    }
    public static function getAllStable(){
        try {
          $conn = new PDO('mysql:host='.DB_HOST.';dbname='.DB, DB_USN, DB_PWD);
          $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          $stmt = $conn->prepare('SELECT * FROM _stable_tb');
          $stmt->execute();
          $result = $stmt->fetchAll();
          $conn=null;
          return $result;
        
        } catch(PDOException $e) {
            echo 'ERROR: ' . $e->getMessage();
        }
    }

    
}

?>
