<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 * 
 * Status - 0:Inactive, 1:Active, 2:Ban
 * 
 */


/**
 * Description of ClassAdmin
 *
 * @author Pascal
 */

include 'const.php';

class Admin {
    //put your code here
    

    private $id;
    private $fname;
    private $sname;
    private $usn;
    private $status;
    
    public function getId() {
        return $this->id;
    }

    public function getFname() {
        return $this->fname;
    }

    public function getSname() {
        return $this->sname;
    }

    public function getUsn() {
        return $this->usn;
    }

    public function getStatus() {
        return $this->status;
    }
    
    public function setId($id) {
        $this->id = $id;
    }

    public function setFname($fname) {
        $this->fname = $fname;
    }

    public function setSname($sname) {
        $this->sname = $sname;
    }

    public function setUsn($usn) {
        $this->usn = $usn;
    }

    public function setStatus($status) {
        $this->status = $status;
    }
    
    public static function validate_admin($usn, $pwd){
        try {
          $conn = new PDO('mysql:host='.DB_HOST.';dbname='.DB, DB_USN, DB_PWD);
          $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          $stmt = $conn->prepare('SELECT _usn, _ustatus FROM _usr_tb WHERE _usn = :usn AND _pwd=:pwd');
          $stmt->execute(array('usn' => $usn, 'pwd'=> $pwd));
          $result = $stmt->fetchAll();
          $conn=null;
          return $result;
        
        } catch(PDOException $e) {
            echo 'ERROR: ' . $e->getMessage();
        }
    }
    
    


}

?>
