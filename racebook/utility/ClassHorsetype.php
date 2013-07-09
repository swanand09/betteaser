<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

include 'const.php';

class Horsetype {
    //put your code here
    private $_id_htype;
    private $_type;
    
    public function get_id_htype() {
        return $this->_id_htype;
    }

    public function set_id_htype($_id_htype) {
        $this->_id_htype = $_id_htype;
    }

    public function get_type() {
        return $this->_type;
    }

    public function set_type($_type) {
        $this->_type = $_type;
    }
    
    public static function getHorseType($id){
        try {
          $conn = new PDO('mysql:host='.DB_HOST.';dbname='.DB, DB_USN, DB_PWD);
          $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          $stmt = $conn->prepare('SELECT _type FROM _htype_tb WHERE _id_htype = :id');
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
