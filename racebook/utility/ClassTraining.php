<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

include 'const.php';

class Training {
    //put your code here
    private $_id_training;
    private $_ref_horse;
    private $_stable;
    private $_rating;
    private $_jockey;
    private $_equip;
    private $_1000p;
    private $_800p;
    private $_600p;
    private $_400p;
    private $_200p;
    private $_2400p;
    private $_2200p;
    private $_1000m;
    private $_800m;
    private $_600m;
    private $_400m;
    private $_200m;
    private $_comments_fr;
    private $_comments_en;
    private $_tdate;
    
    public function get_id_training() {
        return $this->_id_training;
    }

    public function set_id_training($_id_training) {
        $this->_id_training = $_id_training;
    }

    public function get_ref_horse() {
        return $this->_ref_horse;
    }

    public function set_ref_horse($_ref_horse) {
        $this->_ref_horse = $_ref_horse;
    }

    public function get_stable() {
        return $this->_stable;
    }

    public function set_stable($_stable) {
        $this->_stable = $_stable;
    }

    public function get_rating() {
        return $this->_rating;
    }

    public function set_rating($_rating) {
        $this->_rating = $_rating;
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

    public function get_1000p() {
        return $this->_1000p;
    }

    public function set_1000p($_1000p) {
        $this->_1000p = $_1000p;
    }

    public function get_800p() {
        return $this->_800p;
    }

    public function set_800p($_800p) {
        $this->_800p = $_800p;
    }

    public function get_600p() {
        return $this->_600p;
    }

    public function set_600p($_600p) {
        $this->_600p = $_600p;
    }

    public function get_400p() {
        return $this->_400p;
    }

    public function set_400p($_400p) {
        $this->_400p = $_400p;
    }

    public function get_200p() {
        return $this->_200p;
    }

    public function set_200p($_200p) {
        $this->_200p = $_200p;
    }

    public function get_2400p() {
        return $this->_2400p;
    }

    public function set_2400p($_2400p) {
        $this->_2400p = $_2400p;
    }

    public function get_2200p() {
        return $this->_2200p;
    }

    public function set_2200p($_2200p) {
        $this->_2200p = $_2200p;
    }

    public function get_1000m() {
        return $this->_1000m;
    }

    public function set_1000m($_1000m) {
        $this->_1000m = $_1000m;
    }

    public function get_800m() {
        return $this->_800m;
    }

    public function set_800m($_800m) {
        $this->_800m = $_800m;
    }

    public function get_600m() {
        return $this->_600m;
    }

    public function set_600m($_600m) {
        $this->_600m = $_600m;
    }

    public function get_400m() {
        return $this->_400m;
    }

    public function set_400m($_400m) {
        $this->_400m = $_400m;
    }

    public function get_200m() {
        return $this->_200m;
    }

    public function set_200m($_200m) {
        $this->_200m = $_200m;
    }

    public function get_comments_fr() {
        return $this->_comments_fr;
    }

    public function set_comments_fr($_comments_fr) {
        $this->_comments_fr = $_comments_fr;
    }

    public function get_comments_en() {
        return $this->_comments_en;
    }

    public function set_comments_en($_comments_en) {
        $this->_comments_en = $_comments_en;
    }
    
    public function get_tdate() {
        return $this->_tdate;
    }

    public function set_tdate($_tdate) {
        $this->_tdate = $_tdate;
    }

        
    function createTraining(){
        try {
            $conn = new PDO('mysql:host='.DB_HOST.';dbname='.DB, DB_USN, DB_PWD);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $conn->prepare('INSERT INTO _training_tb(_ref_horse, _stable, _rating, _jockey, _equip, _1000p, 
                _800p, _600p, _400p, _200p, _2400p, _2200p, _1000m, _800m, _600m, _400m, 
                _200m, _comments_fr, _comments_en, _tdate) VALUES(:ref_horse, :stable, :rating, :jockey, :equip, :1000p, 
                :800p, :600p, :400p, :200p, :2400p, :2200p, :1000m, :800m, :600m, :400m, 
                :200m, :comments_fr, :comments_en, :tdate)');
            $stmt->execute(array(
              ':ref_horse'=>  $this->_ref_horse, ':stable'=>$this->_stable, ':rating'=>$this->_rating, 
                ':jockey'=>$this->_jockey, ':equip'=>$this->_equip, ':1000p'=>$this->_1000p, 
                ':800p'=>$this->_800p, ':600p'=>$this->_600p, ':400p'=>  $this->_400p, 
                ':200p'=>$this->_200p, ':2400p'=>$this->_2400p, ':2200p'=>$this->_2200p, 
                ':1000m'=>$this->_1000m, ':800m'=>$this->_800m, ':600m'=>$this->_600m, 
                ':400m'=>$this->_400m, ':200m'=>$this->_200m, ':comments_fr'=>$this->_comments_fr,
                ':comments_en'=>$this->_comments_en, ':tdate'=>$this->_tdate
            ));
            $conn=null;
            return true;
        } catch(PDOException $e) {
          return $e->getMessage();
        }
        
    }
    
    public static function getTrainingByRefHorse($id){
        try {
          $conn = new PDO('mysql:host='.DB_HOST.';dbname='.DB, DB_USN, DB_PWD);
          $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          $stmt = $conn->prepare('SELECT * FROM _training_tb WHERE _ref_horse = :id');
          $stmt->execute(array(':id' => $id));
          $result = $stmt->fetchAll();
          $conn=null;
          return $result;
        
        } catch(PDOException $e) {
            echo 'ERROR: ' . $e->getMessage();
        }
    }
    
    public static function get7Training($refHorse){
        $limit=5;
        try {
          $conn = new PDO('mysql:host='.DB_HOST.';dbname='.DB, DB_USN, DB_PWD);
          $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          $stmt = $conn->prepare("SELECT * FROM _training_tb WHERE _ref_horse=:refHorse ORDER BY _tdate DESC LIMIT :limit");
          $stmt->bindParam(':refHorse', $refHorse);
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
