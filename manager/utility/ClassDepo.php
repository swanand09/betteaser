<?php
include 'const.php';

class Depo {
    //put your code here
    private $_id_depo;
    private $_ref_client;
    private $_amount;
    private $_depodat;

    public function get_id_depo() {
        return $this->_id_depo;
    }

    public function set_id_depo($_id_depo) {
        $this->_id_depo = $_id_depo;
    }

    public function get_ref_client() {
        return $this->_ref_client;
    }

    public function set_ref_client($_ref_client) {
        $this->_ref_client = $_ref_client;
    }

    public function get_amount() {
        return $this->_amount;
    }

    public function set_amount($_amount) {
        $this->_amount = $_amount;
    }

    public function get_depodat() {
        return $this->_depodat;
    }

    public function set_depodat($_depodat) {
        $this->_depodat = $_depodat;
    }

    function deposit(){
        try {
            $conn = new PDO('mysql:host='.DB_HOST.';dbname='.DB, DB_USN, DB_PWD);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $conn->prepare('INSERT INTO _depo_tb(_ref_client, _amount, _depodat) VALUES(:refC, :amt, :dat)');
            $stmt->execute(array(
              ':refC'=>$this->_ref_client, ':amt'=>$this->_amount, ':dat'=>$this->_depodat
          ));
            $last_insert_id = $conn->lastInsertId();
            
            $conn=null;
        } catch(PDOException $e) {
          echo $e->getMessage();
        }
        return $last_insert_id;
    
    }
}

?>
