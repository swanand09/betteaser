<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

include 'const.php';

class Horseorigin {
    //put your code here
    private $_id_horigin;
    private $_origin;
    
    public function get_id_horigin() {
        return $this->_id_horigin;
    }

    public function set_id_horigin($_id_horigin) {
        $this->_id_horigin = $_id_horigin;
    }

    public function get_origin() {
        return $this->_origin;
    }

    public function set_origin($_origin) {
        $this->_origin = $_origin;
    }
    
    public static function getHorseOrigin($id){
        try {
          $conn = new PDO('mysql:host='.DB_HOST.';dbname='.DB, DB_USN, DB_PWD);
          $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          $stmt = $conn->prepare('SELECT _origin FROM _horigin_tb WHERE _id_horigin = :id');
          $stmt->execute(array(':id' => $id));
          $result = $stmt->fetchAll();
          $conn=null;
          return $result;
        
        } catch(PDOException $e) {
            echo 'ERROR: ' . $e->getMessage();
        }
    }


}

?>
