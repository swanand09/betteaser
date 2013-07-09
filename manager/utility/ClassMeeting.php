<?php

include 'const.php';

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


class Meeting {
    //put your code here

    private $_id_meeting;
    private $_mname;
    private $_mdate;
    private $_mstatus;
    private $_comment;
    private $_pitch;
    private $_falserail;
    private $_display;
    private $_current;
    
    function __construct() {
        $this->_current = 0;
        $this->_pitch=0.0;
        $this->_falserail=0.00;
        $this->_display=0;
        $this->_comment="";
    }

    
    public function get_current() {
        return $this->_current;
    }

    public function set_current($_current) {
        $this->_current = $_current;
    }

        public function get_comment() {
        return $this->_comment;
    }

    public function set_comment($_comment) {
        $this->_comment = $_comment;
    }

    public function get_pitch() {
        return $this->_pitch;
    }

    public function set_pitch($_pitch) {
        $this->_pitch = $_pitch;
    }

    public function get_falserail() {
        return $this->_falserail;
    }

    public function set_falserail($_falserail) {
        $this->_falserail = $_falserail;
    }

    public function get_display() {
        return $this->_display;
    }

    public function set_display($_display) {
        $this->_display = $_display;
    }

        public function get_id_meeting() {
        return $this->_id_meeting;
    }

    public function set_id_meeting($_id_meeting) {
        $this->_id_meeting = $_id_meeting;
    }

    public function get_mname() {
        return $this->_mname;
    }

    public function set_mname($_mname) {
        $this->_mname = $_mname;
    }

    public function get_mdate() {
        return $this->_mdate;
    }

    public function set_mdate($_mdate) {
        $this->_mdate = $_mdate;
    }

    public function get_mstatus() {
        return $this->_mstatus;
    }

    public function set_mstatus($_mstatus) {
        $this->_mstatus = $_mstatus;
    }

    public static function getMeeting(){
        try {
          $conn = new PDO('mysql:host='.DB_HOST.';dbname='.DB, DB_USN, DB_PWD);
          $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          $stmt = $conn->prepare('SELECT * FROM _meeting_tb');
          $stmt->execute();
          $result = $stmt->fetchAll();
          $conn=null;
          
          return $result;
        
        } catch(PDOException $e) {
            echo 'ERROR: ' . $e->getMessage();
        }
    }
    
    function createMeeting(){
        try {
            $conn = new PDO('mysql:host='.DB_HOST.';dbname='.DB, DB_USN, DB_PWD);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $conn->prepare('INSERT INTO _meeting_tb(_mname, _mdate, _mstatus, _comment, _pitch, _falserail, _display, _current) VALUES(:mname, :mdate, :mstatus, :comment, :pitch, :falserail, :display, :current)');
            $stmt->execute(array(
              ':mname'=>$this->_mname, ':mdate'=>$this->_mdate, ':mstatus'=>$this->_mstatus, ':comment'=>$this->_comment,
                ':pitch'=>$this->_pitch, ':falserail'=>$this->_falserail, ':display'=>$this->_display, ':current'=>$this->_current
            ));
            $conn=null;
            return true;
        } catch(PDOException $e) {
          echo $e->getMessage();
        }
        return false;
    }
    
    function editMeeting(){
        try {
            $conn = new PDO('mysql:host='.DB_HOST.';dbname='.DB, DB_USN, DB_PWD);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $conn->prepare('UPDATE _meeting_tb SET _mname = :mname, _mdate = :mdate, _mstatus = :mstatus, _comment = :comment, _pitch = :pitch, _falserail = :falserail, _display = :display, _current=:current WHERE _id_meeting = :eid');
            $stmt->execute(array(
              ':mname'=>$this->_mname, ':mdate'=>$this->_mdate, ':mstatus'=>$this->_mstatus, ':comment'=>$this->_comment, 
               ':pitch'=>$this->_pitch, ':falserail'=>$this->_falserail, ':display'=>$this->_display, ':current'=>$this->_current, ':eid'=>  $this->_id_meeting
            ));
            
            
            $conn=null;
            return true;
        } catch(PDOException $e) {
          echo $e->getMessage();
        }
        return false;
    }
    
    public static function getMeetingName($id){
        try {
          $conn = new PDO('mysql:host='.DB_HOST.';dbname='.DB, DB_USN, DB_PWD);
          $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          $stmt = $conn->prepare('SELECT _mname FROM _meeting_tb WHERE _id_meeting = :id');
          $stmt->execute(array(':id' => $id));
          $result = $stmt->fetchAll();
          $conn=null;
          return $result;
        
        } catch(PDOException $e) {
            echo 'ERROR: ' . $e->getMessage();
        }
    }
    public static function getUpcomingMeeting($display){
        try {
          $conn = new PDO('mysql:host='.DB_HOST.';dbname='.DB, DB_USN, DB_PWD);
          $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          $stmt = $conn->prepare("SELECT * FROM _meeting_tb WHERE _display=1 LIMIT 4");
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
