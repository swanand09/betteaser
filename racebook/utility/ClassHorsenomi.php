<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

include 'const.php';


class Horsenomi {
    //put your code here
    private $_id_nomi;
    private $_ref_race;
    private $_ref_horselist;
    private $_ref_stable;
    private $_num;
    private $_weight;
    private $_draw;
    
    public function get_id_nomi() {
        return $this->_id_nomi;
    }

    public function set_id_nomi($_id_nomi) {
        $this->_id_nomi = $_id_nomi;
    }

    public function get_ref_race() {
        return $this->_ref_race;
    }

    public function set_ref_race($_ref_race) {
        $this->_ref_race = $_ref_race;
    }

    public function get_ref_horselist() {
        return $this->_ref_horselist;
    }

    public function set_ref_horselist($_ref_horselist) {
        $this->_ref_horselist = $_ref_horselist;
    }

    public function get_ref_stable() {
        return $this->_ref_stable;
    }

    public function set_ref_stable($_ref_stable) {
        $this->_ref_stable = $_ref_stable;
    }

    public function get_num() {
        return $this->_num;
    }

    public function set_num($_num) {
        $this->_num = $_num;
    }

    public function get_weight() {
        return $this->_weight;
    }

    public function set_weight($_weight) {
        $this->_weight = $_weight;
    }

    public function get_draw() {
        return $this->_draw;
    }

    public function set_draw($_draw) {
        $this->_draw = $_draw;
    }

    function createNomination(){
        try {
            $conn = new PDO('mysql:host='.DB_HOST.';dbname='.DB, DB_USN, DB_PWD);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $conn->prepare('INSERT INTO _nomi_tb(_ref_race, _ref_horselist, _ref_stable, _num, _weight, _draw) VALUES(:refrace, :hlist, :stab, :num, :wei, :draw)');
            $stmt->execute(array(':refrace'=>$this->_ref_race,':hlist'=>$this->_ref_horselist, ':stab'=>$this->_ref_stable,
                ':num'=>$this->_num, ':wei'=>  $this->_weight, ':draw'=>$this->_draw
            ));
            $conn=null;
            return true;
        } catch(PDOException $e) {
          echo $e->getMessage();
        }
        return false;
    }
    
        public static function getRaceNomi($refrace){
        try {
          $conn = new PDO('mysql:host='.DB_HOST.';dbname='.DB, DB_USN, DB_PWD);
          $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          $stmt = $conn->prepare('SELECT * FROM _nomi_tb WHERE _ref_race = :refrace');
          $stmt->execute(array(':refrace' => $refrace));
          $result = $stmt->fetchAll();
          $conn=null;
          return $result;
        
        } catch(PDOException $e) {
            echo 'ERROR: ' . $e->getMessage();
        }
    }
}

?>
