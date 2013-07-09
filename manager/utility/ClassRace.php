<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


include 'const.php';

class Race {
    //put your code here
    
    private $_id_race;
    private $_rnum;
    private $_rname;
    private $_rdist;
    private $_rating;
    private $_rtime;
    private $_ref_meeting;
    private $_webstatus;
    private $_eor;
    private $_accept;
    private $_rstatus;
    private $_analyse_text_en;
    private $_analyse_title_en;
    private $_analyse_text_fr;
    private $_analyse_title_fr;
    private $_prize;
    private $_cgears;
    private $_stewardrep;
        
    function __construct() {
        $this->_eor=0;
        $this->_rstatus=0;
        $this->_accept=0;
        $this->_webstatus='racecard';$this->_stewardrep="";
        $this->_analyse_text_en="";$this->_cgears="";
        $this->_analyse_title_en="";$this->_prize="";
        $this->_analyse_text_fr="";$this->_analyse_title_fr="";
    }
    
    
    public function get_rnum() {
        return $this->_rnum;
    }
    public function set_rnum($_rnum) {
        $this->_rnum = $_rnum;
    }
    
    public function get_id_race() {
        return $this->_id_race;
    }

    public function set_id_race($_id_race) {
        $this->_id_race = $_id_race;
    }

    public function get_rname() {
        return $this->_rname;
    }

    public function set_rname($_rname) {
        $this->_rname = $_rname;
    }

    public function get_rdist() {
        return $this->_rdist;
    }

    public function set_rdist($_rdist) {
        $this->_rdist = $_rdist;
    }

    public function get_rating() {
        return $this->_rating;
    }

    public function set_rating($_rating) {
        $this->_rating = $_rating;
    }

    public function get_rtime() {
        return $this->_rtime;
    }

    public function set_rtime($_rtime) {
        $this->_rtime = $_rtime;
    }

    public function get_ref_meeting() {
        return $this->_ref_meeting;
    }

    public function set_ref_meeting($_ref_meeting) {
        $this->_ref_meeting = $_ref_meeting;
    }

    public function get_webstatus() {
        return $this->_webstatus;
    }

    public function set_webstatus($_webstatus) {
        $this->_webstatus = $_webstatus;
    }

    public function get_eor() {
        return $this->_eor;
    }

    public function set_eor($_eor) {
        $this->_eor = $_eor;
    }

    public function get_accept() {
        return $this->_accept;
    }

    public function set_accept($_accept) {
        $this->_accept = $_accept;
    }

    public function get_rstatus() {
        return $this->_rstatus;
    }

    public function set_rstatus($_rstatus) {
        $this->_rstatus = $_rstatus;
    }
    
    public function get_analyse_text_en() {
        return $this->_analyse_text_en;
    }

    public function set_analyse_text_en($_analyse_text_en) {
        $this->_analyse_text_en = $_analyse_text_en;
    }

    public function get_analyse_title_en() {
        return $this->_analyse_title_en;
    }

    public function set_analyse_title_en($_analyse_title_en) {
        $this->_analyse_title_en = $_analyse_title_en;
    }

    public function get_analyse_text_fr() {
        return $this->_analyse_text_fr;
    }

    public function set_analyse_text_fr($_analyse_text_fr) {
        $this->_analyse_text_fr = $_analyse_text_fr;
    }

    public function get_analyse_title_fr() {
        return $this->_analyse_title_fr;
    }

    public function set_analyse_title_fr($_analyse_title_fr) {
        $this->_analyse_title_fr = $_analyse_title_fr;
    }

    public function get_prize() {
        return $this->_prize;
    }

    public function set_prize($_prize) {
        $this->_prize = $_prize;
    }

    public function get_cgears() {
        return $this->_cgears;
    }

    public function set_cgears($_cgears) {
        $this->_cgears = $_cgears;
    }

    public function get_stewardrep() {
        return $this->_stewardrep;
    }

    public function set_stewardrep($_stewardrep) {
        $this->_stewardrep = $_stewardrep;
    }

    

    function createRace(){
        try {
            $conn = new PDO('mysql:host='.DB_HOST.';dbname='.DB, DB_USN, DB_PWD);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $conn->prepare('INSERT INTO _race_tb(_rnum, _rname, _rdist, _rating, _rtime, _ref_meeting, _webstatus, _eor, _accept, _rstatus) VALUES(:rnum, :rname, :rdist, :rating, :rtime, :ref_meeting, :webstatus, :eor, :accept, :rstatus)');
            $stmt->execute(array(':rnum'=>$this->_rnum,
              ':rname'=>$this->_rname, ':rdist'=>$this->_rdist, ':rating'=>$this->_rating, ':rtime'=>  $this->_rtime,
                ':ref_meeting'=>$this->_ref_meeting, ':webstatus'=>  $this->_webstatus, ':eor'=>$this->_eor, ':accept'=>$this->_accept,
                ':rstatus'=>$this->_rstatus
            ));
            $conn=null;
            return true;
        } catch(PDOException $e) {
          echo $e->getMessage();
        }
        return false;
    }
    
    function editRaceDetails(){
        try {
            $conn = new PDO('mysql:host='.DB_HOST.';dbname='.DB, DB_USN, DB_PWD);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $conn->prepare('UPDATE _race_tb SET _rnum = :rnum, _rname = :rname, _rdist = :rdist, _rating=:rating, _rtime=:rtime, 
                _webstatus=:webstatus, _rstatus=:rstatus WHERE _id_race = :rId');
            $stmt->execute(array(
              ':rnum'=>$this->_rnum, ':rname'=>$this->_rname, ':rdist'=>$this->_rdist, ':rating'=>$this->_rating, ':rtime'=>$this->_rtime,
                ':webstatus'=>$this->_webstatus, ':rstatus'=>$this->_rstatus, ':rId'=>  $this->_id_race
            ));
            
            
            $conn=null;
            return true;
        } catch(PDOException $e) {
          echo $e->getMessage();
        }
        return false;
    }
    
    public static function getRaceMeeting($id){
        try {
          $conn = new PDO('mysql:host='.DB_HOST.';dbname='.DB, DB_USN, DB_PWD);
          $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          $stmt = $conn->prepare('SELECT * FROM _race_tb WHERE _ref_meeting = :id');
          $stmt->execute(array(':id' => $id));
          $result = $stmt->fetchAll();
          $conn=null;
          return $result;
        
        } catch(PDOException $e) {
            echo 'ERROR: ' . $e->getMessage();
        }
    }
    public static function getRaceDetailById($id){
        try {
          $conn = new PDO('mysql:host='.DB_HOST.';dbname='.DB, DB_USN, DB_PWD);
          $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          $stmt = $conn->prepare('SELECT * FROM _race_tb WHERE _id_race = :id');
          $stmt->execute(array(':id' => $id));
          $result = $stmt->fetchAll();
          $conn=null;
          return $result;
        
        } catch(PDOException $e) {
            echo 'ERROR: ' . $e->getMessage();
        }
    }
    
    function editRaceEoR(){
        try {
            $conn = new PDO('mysql:host='.DB_HOST.';dbname='.DB, DB_USN, DB_PWD);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $conn->prepare('UPDATE _race_tb SET _eor = :eor WHERE _id_race = :rId');
            $stmt->execute(array(
              ':eor'=>$this->_eor, ':rId'=>  $this->_id_race
            ));
            $conn=null;
            return true;
        } catch(PDOException $e) {
          echo $e->getMessage();
        }
        return false;
    }
    function editAcceptBet(){
        try {
            $conn = new PDO('mysql:host='.DB_HOST.';dbname='.DB, DB_USN, DB_PWD);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $conn->prepare('UPDATE _race_tb SET _accept = :accept WHERE _id_race = :rId');
            $stmt->execute(array(
              ':accept'=>$this->_accept, ':rId'=>  $this->_id_race
            ));
            $conn=null;
            return true;
        } catch(PDOException $e) {
          echo $e->getMessage();
        }
        return false;
    }
    function editRaceStatus(){
        try {
            $conn = new PDO('mysql:host='.DB_HOST.';dbname='.DB, DB_USN, DB_PWD);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $conn->prepare('UPDATE _race_tb SET _rstatus = :rstatus WHERE _id_race = :rId');
            $stmt->execute(array(
              ':rstatus'=>$this->_rstatus, ':rId'=>  $this->_id_race
            ));
            $conn=null;
            return true;
        } catch(PDOException $e) {
          echo $e->getMessage();
        }
        return false;
    }
    function saveWebInfo(){
        try {
            $conn = new PDO('mysql:host='.DB_HOST.';dbname='.DB, DB_USN, DB_PWD);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $conn->prepare('UPDATE _race_tb SET _analyse_text_en = :enText, _analyse_title_en = :enTitle,
               _analyse_text_fr = :frText, _analyse_title_fr = :frTitle, _prize = :prize, _cgears = :cgears,
               _stewardrep = :sRep WHERE _id_race = :rId');
            $stmt->execute(array(
              ':enText'=>$this->_analyse_text_en, ':enTitle'=>$this->_analyse_title_en, 
                ':frText'=>$this->_analyse_text_fr, ':frTitle'=>$this->_analyse_title_fr,
                ':prize'=>$this->_prize, ':cgears'=>$this->_cgears,':sRep'=>$this->_stewardrep, ':rId'=>  $this->_id_race
            ));
            $conn=null;
            return true;
        } catch(PDOException $e) {
          echo $e->getMessage();
        }
        return false;
    }
    


public static function getRNumFromRId($id){
        try {
          $conn = new PDO('mysql:host='.DB_HOST.';dbname='.DB, DB_USN, DB_PWD);
          $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          $stmt = $conn->prepare('SELECT _rnum FROM _race_tb WHERE _id_race = :id');
          $stmt->execute(array(':id' => $id));
          $result = $stmt->fetchAll();
          $conn=null;
          return $result;
        
        } catch(PDOException $e) {
            echo 'ERROR: ' . $e->getMessage();
        }
}
    
    public static function getRaceStatus($id){
        try {
          $conn = new PDO('mysql:host='.DB_HOST.';dbname='.DB, DB_USN, DB_PWD);
          $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          $stmt = $conn->prepare('SELECT _rstatus FROM _race_tb WHERE _id_race = :id');
          $stmt->execute(array(':id' => $id));
          $result = $stmt->fetchAll();
          $conn=null;
          return $result;
        
        } catch(PDOException $e) {
            echo 'ERROR: ' . $e->getMessage();
        }
    }
    
    public static function checkEoRByRnum($rnum,$refM){
        try {
          $conn = new PDO('mysql:host='.DB_HOST.';dbname='.DB, DB_USN, DB_PWD);
          $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          $stmt = $conn->prepare('SELECT _eor, _id_race FROM _race_tb WHERE _rnum = :rnum AND _ref_meeting=:refMeeting');
          $stmt->execute(array(':rnum' => $rnum, ':refMeeting'=>$refM));
          $result = $stmt->fetchAll();
          $conn=null;
          return $result;
        
        } catch(PDOException $e) {
            echo 'ERROR: ' . $e->getMessage();
        }
    }
    public static function getRefMeetingByRid($id){
        try {
          $conn = new PDO('mysql:host='.DB_HOST.';dbname='.DB, DB_USN, DB_PWD);
          $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          $stmt = $conn->prepare('SELECT _ref_meeting FROM _race_tb WHERE _id_race = :id');
          $stmt->execute(array(':id' => $id));
          $result = $stmt->fetchAll();
          $conn=null;
          return $result;
        
        } catch(PDOException $e) {
            echo 'ERROR: ' . $e->getMessage();
        }
    }
    public static function getRefRaceByRnum($rnum, $refM){
        try {
          $conn = new PDO('mysql:host='.DB_HOST.';dbname='.DB, DB_USN, DB_PWD);
          $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          $stmt = $conn->prepare('SELECT _id_race FROM _race_tb WHERE _rnum = :id AND _ref_meeting= :refM');
          $stmt->execute(array(':id' => $id, ':refM' =>$refM));
          $result = $stmt->fetchAll();
          $conn=null;
          return $result;
        
        } catch(PDOException $e) {
            echo 'ERROR: ' . $e->getMessage();
        }
    }


}
?>
