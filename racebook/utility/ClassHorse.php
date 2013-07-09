<?php

/*
 * Emergency Acceptor should be of type: 2, Withdrawn Horses: Type 11
 * 
 */

include 'const.php';

class Horse {
    
    private $_id_horse;
    private $_ref_race;
    private $_hnum;
    private $_hname;
    private $_htype;
    private $_hodds;
    private $_ref_stable;
    private $_ref_jockey;
    private $_hperf;
    private $_hage;
    private $_hrating;
    private $_hequip;
    private $_weight;
    private $_hweight;
    private $_hdraw;
    private $_htfactor;
    private $_hchances;
    private $_hnb;
    private $_h_stjoc;
    private $_hrank;
    private $_hplacerate;
    private $_hWopRate;
    private $_comments_en;
    private $_comments_fr;
    private $_webchances;
    private $_trainingnote;
    private $_formnote;
    private $_owners;
    private $_trainingshot;
    private $_selectionbox;
    private $_casak;
    
        
        //put your code here
    function __construct() {
        $this->_hnb=200;
        $this->_hrating=0;
        $this->_hchances='-';
        $this->_htype=1;
        $this->_hodds=0;
        $this->_hrank=0;
        $this->_hplacerate=0;
        $this->_hWopRate=0;
        $this->_comments_en="";
        $this->_comments_fr="";
        $this->_webchances="";
        $this->_trainingnote=0;
        $this->_formnote=0;
        $this->_owners="-";
        $this->_trainingshot=0;
        $this->_selectionbox=0;
        $this->_casak="";
    }

    public function get_hWopRate() {
        return $this->_hWopRate;
    }

    public function set_hWopRate($_hWopRate) {
        $this->_hWopRate = $_hWopRate;
    }

        public function get_id_horse() {
        return $this->_id_horse;
    }

    public function set_id_horse($_id_horse) {
        $this->_id_horse = $_id_horse;
    }

    public function get_ref_race() {
        return $this->_ref_race;
    }

    public function set_ref_race($_ref_race) {
        $this->_ref_race = $_ref_race;
    }

    public function get_hnum() {
        return $this->_hnum;
    }

    public function set_hnum($_hnum) {
        $this->_hnum = $_hnum;
    }

    public function get_hname() {
        return $this->_hname;
    }

    public function set_hname($_hname) {
        $this->_hname = $_hname;
    }

    public function get_htype() {
        return $this->_htype;
    }

    public function set_htype($_htype) {
        $this->_htype = $_htype;
    }

    public function get_hodds() {
        return $this->_hodds;
    }

    public function set_hodds($_hodds) {
        $this->_hodds = $_hodds;
    }

    public function get_ref_stable() {
        return $this->_ref_stable;
    }

    public function set_ref_stable($_ref_stable) {
        $this->_ref_stable = $_ref_stable;
    }

    public function get_ref_jockey() {
        return $this->_ref_jockey;
    }

    public function set_ref_jockey($_ref_jockey) {
        $this->_ref_jockey = $_ref_jockey;
    }

    public function get_hperf() {
        return $this->_hperf;
    }

    public function set_hperf($_hperf) {
        $this->_hperf = $_hperf;
    }

    public function get_hage() {
        return $this->_hage;
    }

    public function set_hage($_hage) {
        $this->_hage = $_hage;
    }

    public function get_hrating() {
        return $this->_hrating;
    }

    public function set_hrating($_hrating) {
        $this->_hrating = $_hrating;
    }

    public function get_hequip() {
        return $this->_hequip;
    }

    public function set_hequip($_hequip) {
        $this->_hequip = $_hequip;
    }

    public function get_weight() {
        return $this->_weight;
    }

    public function set_weight($_weight) {
        $this->_weight = $_weight;
    }

    public function get_hweight() {
        return $this->_hweight;
    }

    public function set_hweight($_hweight) {
        $this->_hweight = $_hweight;
    }

    public function get_hdraw() {
        return $this->_hdraw;
    }

    public function set_hdraw($_hdraw) {
        $this->_hdraw = $_hdraw;
    }

    public function get_htfactor() {
        return $this->_htfactor;
    }

    public function set_htfactor($_htfactor) {
        $this->_htfactor = $_htfactor;
    }

    public function get_hchances() {
        return $this->_hchances;
    }

    public function set_hchances($_hchances) {
        $this->_hchances = $_hchances;
    }

    public function get_hnb() {
        return $this->_hnb;
    }

    public function set_hnb($_hnb) {
        $this->_hnb = $_hnb;
    }

    public function get_h_stjoc() {
        return $this->_h_stjoc;
    }

    public function set_h_stjoc($_h_stjoc) {
        $this->_h_stjoc = $_h_stjoc;
    }
    public function get_hrank() {
        return $this->_hrank;
    }

    public function set_hrank($_hrank) {
        $this->_hrank = $_hrank;
    }

    public function get_hplacerate() {
        return $this->_hplacerate;
    }

    public function set_hplacerate($_hplacerate) {
        $this->_hplacerate = $_hplacerate;
    }
    
    public function get_comments() {
        return $this->_comments;
    }

    public function get_comments_en() {
        return $this->_comments_en;
    }

    public function set_comments_en($_comments_en) {
        $this->_comments_en = $_comments_en;
    }

    
    public function set_comments_fr($_comments_fr) {
        $this->_comments_fr = $_comments_fr;
    }

    public function get_webchances() {
        return $this->_webchances;
    }

    public function set_webchances($_webchances) {
        $this->_webchances = $_webchances;
    }

    public function get_trainingnote() {
        return $this->_trainingnote;
    }

    public function set_trainingnote($_trainingnote) {
        $this->_trainingnote = $_trainingnote;
    }

    public function get_formnote() {
        return $this->_formnote;
    }

    public function set_formnote($_formnote) {
        $this->_formnote = $_formnote;
    }

    public function get_owners() {
        return $this->_owners;
    }

    public function set_owners($_owners) {
        $this->_owners = $_owners;
    }

    public function get_trainingshot() {
        return $this->_trainingshot;
    }

    public function set_trainingshot($_trainingshot) {
        $this->_trainingshot = $_trainingshot;
    }

    public function get_selectionbox() {
        return $this->_selectionbox;
    }

    public function set_selectionbox($_selectionbox) {
        $this->_selectionbox = $_selectionbox;
    }

    public function get_casak() {
        return $this->_casak;
    }

    public function set_casak($_casak) {
        $this->_casak = $_casak;
    }

    
    
    function createHorse(){
        try {
            $conn = new PDO('mysql:host='.DB_HOST.';dbname='.DB, DB_USN, DB_PWD);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $conn->prepare('INSERT INTO _horse_tb(_ref_race, _hnum, _hname, _htype, _hodds, _ref_stable, 
                _ref_jockey, _hperf, _hage, _hrating, _hequip, _weight, _hweight, _hdraw, _htfactor, _hchances, 
                _hnb, _h_stjoc, _hrank, _hplacerate, _hWopRate) VALUES(:refrace, :hnum, :hname, :htype, :hodds, :refstable, :refjockey, :hperf, 
                :hage, :hrating, :hequip, :weight, :hweight, :hdraw, :htfactor, :hchances, :hnb, :hstjoc,
                :hrank, :hplacerate, :hwoprate)');
            $stmt->execute(array(
              ':refrace'=>  $this->_ref_race, ':hnum'=>$this->_hnum, ':hname'=>$this->_hname, 
                ':htype'=>$this->_htype, ':hodds'=>$this->_hodds, ':refstable'=>$this->_ref_stable, 
                ':refjockey'=>$this->_ref_jockey, ':hperf'=>$this->_hperf, ':hage'=>  $this->_hage, 
                ':hrating'=>$this->_hrating, ':hequip'=>$this->_hequip, ':weight'=>$this->_weight, 
                ':hweight'=>$this->_hweight, ':hdraw'=>$this->_hdraw, ':htfactor'=>$this->_htfactor, 
                ':hchances'=>$this->_hchances, ':hnb'=>$this->_hnb, ':hstjoc'=>$this->_h_stjoc,
                ':hrank'=>$this->_hrank, ':hplacerate'=>  $this->_hplacerate, ':hwoprate'=>$this->_hWopRate
            ));
            $conn=null;
            return true;
        } catch(PDOException $e) {
          return $e->getMessage();
        }
        
    }

    public static function getRaceHorses($rId){
        try {
          $conn = new PDO('mysql:host='.DB_HOST.';dbname='.DB, DB_USN, DB_PWD);
          $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          $stmt = $conn->prepare('SELECT * FROM _horse_tb WHERE _ref_race=:rId');
          $stmt->execute(array(':rId' => $rId));
          $result = $stmt->fetchAll();
          $conn=null;
          
          return $result;
        
        } catch(PDOException $e) {
            echo 'ERROR: ' . $e->getMessage();
        }
        return false;
    }
    
    public static function getRaceRez($rId){
        try {
          $conn = new PDO('mysql:host='.DB_HOST.';dbname='.DB, DB_USN, DB_PWD);
          $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          $stmt = $conn->prepare('SELECT * FROM _horse_tb WHERE _ref_race=:rId ORDER BY _hrank ASC');
          $stmt->execute(array(':rId' => $rId));
          $result = $stmt->fetchAll();
          $conn=null;
          
          return $result;
        
        } catch(PDOException $e) {
            echo 'ERROR: ' . $e->getMessage();
        }
        return false;
    }
    
    function updateHorseBasic(){
        try {
            $conn = new PDO('mysql:host='.DB_HOST.';dbname='.DB, DB_USN, DB_PWD);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $conn->prepare('UPDATE _horse_tb SET _hnum = :hnum, _hname = :hname, _hchances = :hchances,
                _hweight = :hweight, _hperf = :hperf, _hage = :hage, _hequip = :hequip, _weight = :weight, 
                _hdraw = :hdraw, _htfactor = :htfactor, _htype=:htype, _ref_stable=:ref_stable, 
                _ref_jockey=:ref_jockey, _h_stjoc=:stjoc, _hWopRate=:wopRate, _webchances=:webChances, 
                _comments_en=:hCommentEn, _comments_fr=:hCommentFr, _trainingnote=:hTNote, _formnote=:hFormNote, 
                _owners=:hOwners, _trainingshot=:chkTrainShot, _selectionbox=:hSelBox, _casak=:casak WHERE _id_horse=:id_horse');
            $stmt->execute(array(
              ':hnum'=>  $this->_hnum, ':hname'=>$this->_hname, 
                ':hchances'=>$this->_hchances, ':hweight'=>$this->_hweight, ':hperf'=>$this->_hperf, ':hage'=>  $this->_hage,  
                ':hequip'=>$this->_hequip, ':weight'=>$this->_weight, ':hdraw'=>$this->_hdraw, ':htfactor'=>$this->_htfactor, 
                ':htype'=>$this->_htype, ':ref_stable'=>$this->_ref_stable, ':ref_jockey'=>$this->_ref_jockey, 
                ':stjoc'=>$this->_h_stjoc, ':wopRate'=>$this->_hWopRate, ':webChances'=>  $this->_webchances,
                ':hCommentEn'=>$this->_comments_en, ':hCommentFr'=>$this->_comments_fr, ':hTNote'=>$this->_trainingnote, 
                ':hFormNote'=>$this->_formnote, ':hOwners'=>$this->_owners, ':chkTrainShot'=>$this->_trainingshot, 
                ':hSelBox'=>$this->_selectionbox, ':casak'=>$this->_casak, ':id_horse'=>$this->_id_horse
            ));
            $conn=null;
            return true;
        } catch(PDOException $e) {
          return $e->getMessage();
        }
    }
    
    public static function addHorseWeight($hnum, $hWei, $rId){
        try {
            $conn = new PDO('mysql:host='.DB_HOST.';dbname='.DB, DB_USN, DB_PWD);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $conn->prepare('UPDATE _horse_tb SET _hweight = :hweight WHERE _hnum=:hnum AND _ref_race=:rId');
            $stmt->execute(array(
              ':hnum'=>  $hnum, ':hweight'=>$hWei, ':rId'=>$rId
            ));
            $conn=null;
            return true;
        } catch(PDOException $e) {
          return $e->getMessage();
        }
    }
    public static function addHorseTime($hnum, $hTime, $rId){
        try {
            $conn = new PDO('mysql:host='.DB_HOST.';dbname='.DB, DB_USN, DB_PWD);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $conn->prepare('UPDATE _horse_tb SET _htfactor = :htfactor WHERE _hnum=:hnum AND _ref_race=:rId');
            $stmt->execute(array(
              ':hnum'=>  $hnum, ':htfactor'=>$hTime, ':rId'=>$rId
            ));
            $conn=null;
            return true;
        } catch(PDOException $e) {
          return $e->getMessage();
        }
    }
    public static function addHorse_WeightTime($hnum, $hTime, $hWei, $rId){
        try {
            $conn = new PDO('mysql:host='.DB_HOST.';dbname='.DB, DB_USN, DB_PWD);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $conn->prepare('UPDATE _horse_tb SET _hweight = :hweight, _htfactor = :htfactor WHERE _hnum=:hnum AND _ref_race=:rId');
            $stmt->execute(array(
              ':hnum'=>  $hnum, ':htfactor'=>$hTime, ':hweight'=>$hWei, ':rId'=>$rId
            ));
            $conn=null;
            return true;
        } catch(PDOException $e) {
          return $e->getMessage();
        }
    }
    public static function addHorse_OwnerCasak($hnum, $hOwner, $hCasak, $rId){
        try {
            $conn = new PDO('mysql:host='.DB_HOST.';dbname='.DB, DB_USN, DB_PWD);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $conn->prepare('UPDATE _horse_tb SET _owners = :owners, _casak = :casak WHERE _hnum=:hnum AND _ref_race=:rId');
            $stmt->execute(array(
              ':hnum'=>  $hnum, ':owners'=>$hOwner, ':casak'=>$hCasak, ':rId'=>$rId
            ));
            $conn=null;
            return true;
        } catch(PDOException $e) {
          return $e->getMessage();
        }
    }
    public static function saveOdds($hnum, $refRace, $hOdds){
        try {
            $conn = new PDO('mysql:host='.DB_HOST.';dbname='.DB, DB_USN, DB_PWD);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $conn->prepare('UPDATE _horse_tb SET _hodds = :hodds WHERE _hnum=:hnum AND _ref_race=:rId');
            $stmt->execute(array(
              ':hnum'=>  $hnum, ':hodds'=>$hOdds, ':rId'=>$refRace
            ));
            $conn=null;
            return true;
        } catch(PDOException $e) {
          return $e->getMessage();
        }
    }
    public static function saveRez_Place($hnum, $refRace, $place,$rank){
        try {
            $conn = new PDO('mysql:host='.DB_HOST.';dbname='.DB, DB_USN, DB_PWD);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $conn->prepare('UPDATE _horse_tb SET _hplacerate = :hplacerate, _hrank = :hrank WHERE _hnum=:hnum AND _ref_race=:rId');
            $stmt->execute(array(
              ':hnum'=>  $hnum, ':hplacerate'=>$place, ':hrank'=>$rank, ':rId'=>$refRace
            ));
            $conn=null;
            return true;
        } catch(PDOException $e) {
          return $e->getMessage();
        }
    }
    
   public static function getWebOddsByRaceId($rId){
        try {
            $eor=0;$acc=1;
            
          $conn = new PDO('mysql:host='.DB_HOST.';dbname='.DB, DB_USN, DB_PWD);
          $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          $stmt = $conn->prepare('SELECT DISTINCT _hnum, _hodds, _htype FROM `_horse_tb`, `_race_tb` WHERE _ref_race=:rId AND _eor=:eor AND _accept=:acc AND _ref_race=_id_race');
          $stmt->execute(array(':rId' => $rId,':eor' => $eor, ':acc' => $acc));
          
          $result = $stmt->fetchAll();
          $conn=null;
          
          return $result;
        
        } catch(PDOException $e) {
            echo 'ERROR: ' . $e->getMessage();
        }
        return false;
    }
    
    
   public static function getBetOddsByRaceId($rId){
        try {
            $eor=0;$acc=1;$htype=1;
            
          $conn = new PDO('mysql:host='.DB_HOST.';dbname='.DB, DB_USN, DB_PWD);
          $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          $stmt = $conn->prepare('SELECT DISTINCT _hnum, _hodds, _htype FROM `_horse_tb`, `_race_tb` WHERE _ref_race=:rId AND _eor=:eor AND _accept=:acc AND _ref_race=_id_race');
          $stmt->execute(array(':rId' => $rId,':eor' => $eor, ':acc' => $acc));
          
          $result = $stmt->fetchAll();
          $conn=null;
          
          return $result;
        
        } catch(PDOException $e) {
            echo 'ERROR: ' . $e->getMessage();
        }
        return false;
    }
   public static function getBetOddsByRH($rId, $h){
        try {
            $htype=1;
            
          $conn = new PDO('mysql:host='.DB_HOST.';dbname='.DB, DB_USN, DB_PWD);
          $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          $stmt = $conn->prepare('SELECT _hodds FROM `_horse_tb` WHERE _ref_race=:rId AND _hnum=:hnum AND _htype=:htype');
          $stmt->execute(array(':rId' => $rId,':hnum' => $h, ':htype' => $htype));
          
          $result = $stmt->fetchAll();
          $conn=null;
          
          return $result;
        
        } catch(PDOException $e) {
            echo 'ERROR: ' . $e->getMessage();
        }
        return false;
    }
   public static function getHorseId($rId, $h){
        try {
            $htype=1;
            
          $conn = new PDO('mysql:host='.DB_HOST.';dbname='.DB, DB_USN, DB_PWD);
          $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          $stmt = $conn->prepare('SELECT _id_horse FROM `_horse_tb` WHERE _ref_race=:rId AND _hnum=:hnum AND _htype=:htype');
          $stmt->execute(array(':rId' => $rId,':hnum' => $h, ':htype' => $htype));
          
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
