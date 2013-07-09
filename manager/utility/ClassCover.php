<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

include 'const.php';

class Cover {
    //put your code here
    private $_id_cover;
    private $_ref_race;
    private $_ref_horse;
    private $_amount;
    private $_odds;
    private $_po;
    private $_date;
    private $_show;
    
    public function get_id_cover() {
        return $this->_id_cover;
    }

    public function set_id_cover($_id_cover) {
        $this->_id_cover = $_id_cover;
    }

    public function get_ref_race() {
        return $this->_ref_race;
    }

    public function set_ref_race($_ref_race) {
        $this->_ref_race = $_ref_race;
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

    public function get_odds() {
        return $this->_odds;
    }

    public function set_odds($_odds) {
        $this->_odds = $_odds;
    }

    public function get_po() {
        return $this->_po;
    }

    public function set_po($_po) {
        $this->_po = $_po;
    }

    public function get_date() {
        return $this->_date;
    }

    public function set_date($_date) {
        $this->_date = $_date;
    }

    public function get_show() {
        return $this->_show;
    }

    public function set_show($_show) {
        $this->_show = $_show;
    }

    function coverBet(){
        try {
            $conn = new PDO('mysql:host='.DB_HOST.';dbname='.DB, DB_USN, DB_PWD);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $conn->prepare('INSERT INTO _cover_tb(_ref_race,_ref_horse,_amount,_odds,_po,_date,_show) VALUES(:refR,:refH,:amount,:odds,:po,:dat,:show)');
            $stmt->execute(array(':refR'=>$this->_ref_race, ':refH'=>$this->_ref_horse, ':amount'=>$this->_amount, ':odds'=>$this->_odds,
                ':po'=>$this->_po, ':dat'=>$this->_date, ':show'=>$this->_show));
            $conn=null;
            return true;
        } catch(PDOException $e) {
          echo $e->getMessage();
        }
        return false;
    }
    public static function getCBetsByRH($refR, $refH){
        try {
          $conn = new PDO('mysql:host='.DB_HOST.';dbname='.DB, DB_USN, DB_PWD);
          $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          $stmt = $conn->prepare("SELECT SUM(_amount) as _amount, SUM(_po) as _po FROM _cover_tb WHERE _ref_race=:refR AND _ref_horse=:refH AND _show=1");
          $stmt->execute(array(':refR'=>$refR,':refH'=>$refH));
          
          $result = $stmt->fetchAll();
          $conn=null;
          return $result;
        
        } catch(PDOException $e) {
            echo 'ERROR: ' . $e->getMessage();
        }
    }
    public static function getSumCBetsByRace($refR){
        try {
          $conn = new PDO('mysql:host='.DB_HOST.';dbname='.DB, DB_USN, DB_PWD);
          $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          $stmt = $conn->prepare("SELECT SUM(_amount) as amt, sum(_po) as po FROM _cover_tb WHERE _ref_race=:refR AND _show=1");
          $stmt->execute(array(':refR'=>$refR));
          $result = $stmt->fetchAll();
          $conn=null;
          return $result;
        
        } catch(PDOException $e) {
            echo 'ERROR: ' . $e->getMessage();
        }
    }
    public static function getAllCovers(){
        try {
          $conn = new PDO('mysql:host='.DB_HOST.';dbname='.DB, DB_USN, DB_PWD);
          $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          $stmt = $conn->prepare("SELECT _id_cover, _rnum, _hname, _amount, _odds, _po, _date, _show FROM _cover_tb, _horse_tb, _race_tb WHERE _ref_horse=_id_horse AND _cover_tb._ref_race=_race_tb._id_race");
          $stmt->execute();
          $result = $stmt->fetchAll();
          $conn=null;
          return $result;
        
        } catch(PDOException $e) {
            echo 'ERROR: ' . $e->getMessage();
        }
    }
    
    public static function updateSts($upShow, $cId){
        try {
            $conn = new PDO('mysql:host='.DB_HOST.';dbname='.DB, DB_USN, DB_PWD);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $conn->prepare('UPDATE _cover_tb SET _show = :show WHERE _id_cover= :covId');
            $stmt->execute(array(
              ':show'=>  $upShow, ':covId'=>$cId
            ));
            $conn=null;
            return true;
        } catch(PDOException $e) {
          return $e->getMessage();
        }
    }
    
}

?>
