<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

include 'const.php';

class Horseruns {
    //put your code here
    private $_id_horseruns;
    private $_racedate;
    private $mno_rno;
    private $_going;
    private $_rrating;
    private $_rdist;
    private $_hweight;
    private $_jockey;
    private $_equip;
    private $_weight;
    private $_draw;
    private $_p600;
    private $_p300;
    private $_p100;
    private $_rank;
    private $_winner_sec;
    private $_margin;
    private $_timerace;
    private $_time600;
    private $_time400;
    private $_hrating;
    private $_comment_en;
    private $_comment_fr;
    private $_horsename;
    private $_ref_race;
    private $_ref_horse;
    
    public function get_id_horseruns() {
        return $this->_id_horseruns;
    }

    public function set_id_horseruns($_id_horseruns) {
        $this->_id_horseruns = $_id_horseruns;
    }

    public function get_racedate() {
        return $this->_racedate;
    }

    public function set_racedate($_racedate) {
        $this->_racedate = $_racedate;
    }

    public function getMno_rno() {
        return $this->mno_rno;
    }

    public function setMno_rno($mno_rno) {
        $this->mno_rno = $mno_rno;
    }

    public function get_going() {
        return $this->_going;
    }

    public function set_going($_going) {
        $this->_going = $_going;
    }

    public function get_rrating() {
        return $this->_rrating;
    }

    public function set_rrating($_rrating) {
        $this->_rrating = $_rrating;
    }

    public function get_rdist() {
        return $this->_rdist;
    }

    public function set_rdist($_rdist) {
        $this->_rdist = $_rdist;
    }

    public function get_hweight() {
        return $this->_hweight;
    }

    public function set_hweight($_hweight) {
        $this->_hweight = $_hweight;
    }

    public function get_jockey() {
        return $this->_jockey;
    }

    public function set_jockey($_jockey) {
        $this->_jockey = $_jockey;
    }

    public function get_equip() {
        return $this->_equip;
    }

    public function set_equip($_equip) {
        $this->_equip = $_equip;
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

    public function get_p600() {
        return $this->_p600;
    }

    public function set_p600($_p600) {
        $this->_p600 = $_p600;
    }

    public function get_p300() {
        return $this->_p300;
    }

    public function set_p300($_p300) {
        $this->_p300 = $_p300;
    }

    public function get_p100() {
        return $this->_p100;
    }

    public function set_p100($_p100) {
        $this->_p100 = $_p100;
    }

    public function get_rank() {
        return $this->_rank;
    }

    public function set_rank($_rank) {
        $this->_rank = $_rank;
    }

    public function get_winner_sec() {
        return $this->_winner_sec;
    }

    public function set_winner_sec($_winner_sec) {
        $this->_winner_sec = $_winner_sec;
    }

    public function get_margin() {
        return $this->_margin;
    }

    public function set_margin($_margin) {
        $this->_margin = $_margin;
    }

    public function get_timerace() {
        return $this->_timerace;
    }

    public function set_timerace($_timerace) {
        $this->_timerace = $_timerace;
    }

    public function get_time600() {
        return $this->_time600;
    }

    public function set_time600($_time600) {
        $this->_time600 = $_time600;
    }

    public function get_time400() {
        return $this->_time400;
    }

    public function set_time400($_time400) {
        $this->_time400 = $_time400;
    }

    public function get_hrating() {
        return $this->_hrating;
    }

    public function set_hrating($_hrating) {
        $this->_hrating = $_hrating;
    }

    public function get_comment_en() {
        return $this->_comment_en;
    }

    public function set_comment_en($_comment_en) {
        $this->_comment_en = $_comment_en;
    }

    public function get_comment_fr() {
        return $this->_comment_fr;
    }

    public function set_comment_fr($_comment_fr) {
        $this->_comment_fr = $_comment_fr;
    }

    public function get_horsename() {
        return $this->_horsename;
    }

    public function set_horsename($_horsename) {
        $this->_horsename = $_horsename;
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
    
    function createHorserun(){
        try {
            $conn = new PDO('mysql:host='.DB_HOST.';dbname='.DB, DB_USN, DB_PWD);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $conn->prepare('INSERT INTO _horseruns_tb(_racedate,mno_rno,_going,_rrating,_rdist,_hweight,
                _jockey,_equip,_weight,_draw,_p600,_p300,_p100,_rank,_winner_sec,_margin,_timerace,_time600,
                _time400,_hrating,_comment_en,_comment_fr,_horsename,_ref_race,_ref_horse) VALUES (:racedate,:mnorno,
                :going,:rrating,:rdist,:hweight,:jockey,:equip,:weight,:draw,:p600,:p300,:p100,:rank,:winnersec,
                :margin,:timerace,:time600,:time400,:hrating,:commenten,:commentfr,:horsename,:refrace,:refhorse)');
            $stmt->execute(array(
                ':racedate'=>$this->_racedate,':mnorno'=>  $this->mno_rno,':going'=>$this->_going,
                ':rrating'=>  $this->_rrating,':rdist'=>$this->_rdist,':hweight'=>$this->_hweight,
                ':jockey'=>$this->_jockey,':equip'=>$this->_equip,':weight'=>$this->_weight,':draw'=>$this->_draw,
                ':p600'=>  $this->_p600,':p300'=>$this->_p300,':p100'=>$this->_p100,':rank'=>$this->_rank,
                ':winnersec'=>$this->_winner_sec,':margin'=>$this->_margin,':timerace'=>$this->_timerace,
                ':time600'=>$this->_time600,':time400'=>$this->_time400,':hrating'=>$this->_hrating,
                ':commenten'=>$this->_comment_en,':commentfr'=>$this->_comment_fr,':horsename'=>$this->_horsename,
                ':refrace'=>$this->_ref_race,':refhorse'=>$this->_ref_horse
            ));
            $conn=null;
            return true;
        } catch(PDOException $e) {
          return $e->getMessage();
        }
    }
    public static function getHorseFormbyName($hName,$limit){
        try {
          $conn = new PDO('mysql:host='.DB_HOST.';dbname='.DB, DB_USN, DB_PWD);
          $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          $stmt = $conn->prepare("SELECT * FROM _horseruns_tb WHERE _horsename=:hName ORDER BY str_to_date(_racedate, '%d/%m/%Y') DESC LIMIT :limit");
          $stmt->bindParam(':hName', $hName);
          $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
          $stmt->execute();
          $result = $stmt->fetchAll();
          $conn=null;
          
          return $result;
        
        } catch(PDOException $e) {
            echo 'ERROR: ' . $e->getMessage();
        }
        return false;
    }

}

?>
