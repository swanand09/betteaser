<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

include 'const.php';

class PPayout {
    //put your code here
    private $_id_payout;
    private $_ref_horse;
    private $_amount;
    private $_payout;
    
    public function get_id_payout() {
        return $this->_id_payout;
    }

    public function set_id_payout($_id_payout) {
        $this->_id_payout = $_id_payout;
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

    public function get_payout() {
        return $this->_payout;
    }

    public function set_payout($_payout) {
        $this->_payout = $_payout;
    }
    
    public static function insertPayout($hid,$bAmt,$ppo){
        try {
            $conn = new PDO('mysql:host='.DB_HOST.';dbname='.DB, DB_USN, DB_PWD);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            //$stmt = $conn->prepare('UPDATE _payout_tb SET _amount=:amt, _payout=:payout WHERE _ref_horse=:refHorse');
            //$stmt->execute(array(':amt'=>$bAmt, ':payout'=>$ppo, ':refHorse'=>$hid));
            //if(!$stmt){
                $stmt = $conn->prepare('INSERT INTO _payout_tb (_ref_horse, _amount, _payout) VALUES (:refHorse, :amt, :payout)');
                $stmt->execute(array(':amt'=>$bAmt, ':payout'=>$ppo, ':refHorse'=>$hid));
            //}
            
            $conn=null;
        } catch(PDOException $e) {
          echo $e->getMessage();
        }
        //return $last_insert_id;
        
    }
    public static function updatePayout($hid,$bAmt,$ppo){
        try {
            $conn = new PDO('mysql:host='.DB_HOST.';dbname='.DB, DB_USN, DB_PWD);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $conn->prepare('UPDATE _payout_tb SET _amount=:amt, _payout=:payout WHERE _ref_horse=:refHorse');
            $stmt->execute(array(':amt'=>$bAmt, ':payout'=>$ppo, ':refHorse'=>$hid));
            
            $conn=null;
        } catch(PDOException $e) {
          echo $e->getMessage();
        }
        //return $last_insert_id;
        
    }



}

?>
