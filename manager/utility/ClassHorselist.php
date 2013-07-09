<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

include 'const.php';

class Horselist {
    //put your code here
    private $_id_hlist;
    private $_hname;
    private $_pedigree;
    private $_ref_stable;
    private $_hrating;
    private $_origin;
    private $_type;
    private $_hl_status;
    
    public function get_id_hlist() {
        return $this->_id_hlist;
    }

    public function set_id_hlist($_id_hlist) {
        $this->_id_hlist = $_id_hlist;
    }

    public function get_hname() {
        return $this->_hname;
    }

    public function set_hname($_hname) {
        $this->_hname = $_hname;
    }

    public function get_pedigree() {
        return $this->_pedigree;
    }

    public function set_pedigree($_pedigree) {
        $this->_pedigree = $_pedigree;
    }

    public function get_ref_stable() {
        return $this->_ref_stable;
    }

    public function set_ref_stable($_ref_stable) {
        $this->_ref_stable = $_ref_stable;
    }

    public function get_hrating() {
        return $this->_hrating;
    }

    public function set_hrating($_hrating) {
        $this->_hrating = $_hrating;
    }

    public function get_origin() {
        return $this->_origin;
    }

    public function set_origin($_origin) {
        $this->_origin = $_origin;
    }

    public function get_type() {
        return $this->_type;
    }

    public function set_type($_type) {
        $this->_type = $_type;
    }

    public function get_hl_status() {
        return $this->_hl_status;
    }

    public function set_hl_status($_hl_status) {
        $this->_hl_status = $_hl_status;
    }
    
    public static function getHorselistByName($hName){
        try {
          $conn = new PDO('mysql:host='.DB_HOST.';dbname='.DB, DB_USN, DB_PWD);
          $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          $stmt = $conn->prepare('SELECT * FROM _horselist_tb WHERE _hname = :hName');
          $stmt->execute(array(':hName' => $hName));
          $result = $stmt->fetchAll();
          $conn=null;
          return $result;
        
        } catch(PDOException $e) {
            echo 'ERROR: ' . $e->getMessage();
        }
    }
    public static function getHorsenameById($hid){
        try {
          $conn = new PDO('mysql:host='.DB_HOST.';dbname='.DB, DB_USN, DB_PWD);
          $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          $stmt = $conn->prepare('SELECT _hname FROM _horselist_tb WHERE _id_hlist = :hid');
          $stmt->execute(array(':hid' => $hid));
          $result = $stmt->fetchAll();
          $conn=null;
          return $result;
        
        } catch(PDOException $e) {
            echo 'ERROR: ' . $e->getMessage();
        }
    }


}

?>
