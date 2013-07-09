<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

include 'const.php';

/**
 * Description of ClassJockey
 *
 * @author Pascal
 */
class Jockey {
    //put your code here
    
    private $_id_jockey;
    private $_jname;
    private $_jcode;
    private $_nationality;
    
    function __construct() {
        
    }
    
    public function get_id_jockey() {
        return $this->_id_jockey;
    }

    public function set_id_jockey($_id_jockey) {
        $this->_id_jockey = $_id_jockey;
    }

    public function get_jname() {
        return $this->_jname;
    }

    public function set_jname($_jname) {
        $this->_jname = $_jname;
    }

    public function get_jcode() {
        return $this->_jcode;
    }

    public function set_jcode($_jcode) {
        $this->_jcode = $_jcode;
    }

    public function get_nationality() {
        return $this->_nationality;
    }

    public function set_nationality($_nationality) {
        $this->_nationality = $_nationality;
    }

    public static function getJockeyIdByName($jName){
        try {
          $conn = new PDO('mysql:host='.DB_HOST.';dbname='.DB, DB_USN, DB_PWD);
          $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          $stmt = $conn->prepare('SELECT _id_jockey FROM _jockey_tb WHERE _jname = :jname');
          $stmt->execute(array(':jname' => $jName));
          $result = $stmt->fetchAll();
          $conn=null;
          return $result;
        
        } catch(PDOException $e) {
            echo 'ERROR: ' . $e->getMessage();
        }
    }
    public static function getJockeyName($jId){
        try {
          $conn = new PDO('mysql:host='.DB_HOST.';dbname='.DB, DB_USN, DB_PWD);
          $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          $stmt = $conn->prepare('SELECT _jname FROM _jockey_tb WHERE _id_jockey = :jId');
          $stmt->execute(array(':jId' => $jId));
          $result = $stmt->fetchAll();
          $conn=null;
          return $result;
        
        } catch(PDOException $e) {
            echo 'ERROR: ' . $e->getMessage();
        }
    }
    public static function getJockeyCodeById($jId){
        try {
          $conn = new PDO('mysql:host='.DB_HOST.';dbname='.DB, DB_USN, DB_PWD);
          $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          $stmt = $conn->prepare('SELECT _jcode FROM _jockey_tb WHERE _id_jockey = :jId');
          $stmt->execute(array(':jId' => $jId));
          $result = $stmt->fetchAll();
          $conn=null;
          return $result;
        
        } catch(PDOException $e) {
            echo 'ERROR: ' . $e->getMessage();
        }
    }
    public static function getAllJockey(){
        try {
          $conn = new PDO('mysql:host='.DB_HOST.';dbname='.DB, DB_USN, DB_PWD);
          $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          $stmt = $conn->prepare('SELECT * FROM _jockey_tb');
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
