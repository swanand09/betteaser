<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

include 'const.php';
include ('Mail.php');
include ('Mail/mime.php');

class Client {
    //put your code here
    private $title;
    private $_reg_date;
    private $fname;
    private $sname;
    private $gender;
    private $country;
    private $address;
    private $town;
    private $postcode;
    private $dob;
    private $email;
    private $ccode;
    private $mobile;
    private $username;
    private $password;
    private $refQuestion;
    private $answer;
    private $curr;
    private $promoCode;
    private $acceptNews;
    private $above18;
    private $opBal_date;
    private $opBal;
    private $bal;
    private $hash;
    private $status; //0 -> pending , 1 ->active, 2->inactive, 3->ban, 4->closed

    function Client(){
        $this->bal=0;
        $this->opBal=0;
        $this->opBal_date=date("Y-m-d H:i:s");
        $this->_reg_date=date("Y-m-d H:i:s");
        $this->status=0;
    }
    
    function get_title() {
        return $this->title;
    }
    function get_fname() {
        return $this->fname;
    }
    function get_sname() {
        return $this->sname;
    }
    function get_gender() {
        return $this->gender;
    }
    function get_country() {
        return $this->country;
    }
    function get_address() {
        return $this->address;
    }
    function get_town() {
        return $this->town;
    }
    function get_postcode() {
        return $this->postcode;
    }
    function get_dob() {
        return $this->dob;
    }
    function get_email() {
        return $this->email;
    }
    function get_ccode() {
        return $this->ccode;
    }
    function get_mobile() {
        return $this->mobile;
    }
    function get_username() {
        return $this->username;
    }
    function get_password() {
        return $this->password;
    }
    function get_refQuestion() {
        return $this->refQuestion;
    }
    function get_answer() {
        return $this->answer;
    }
    function get_curr() {
        return $this->curr;
    }
    function get_promoCode() {
        return $this->promoCode;
    }
    function get_acceptNews() {
        return $this->acceptNews;
    }
    function get_above18() {
        return $this->above18;
    }
    function get_bal() {
        return $this->bal;
    }
    function get_status() {
        return $this->status;
    }
    
    function get_hash() {
        return $this->hash;
    }
    
    public function get_reg_date() {
        return $this->_reg_date;
    }

    public function set_reg_date($_reg_date) {
        $this->_reg_date = $_reg_date;
    }
    
    public function getOpBal_date() {
        return $this->opBal_date;
    }

    public function setOpBal_date($opBal_date) {
        $this->opBal_date = $opBal_date;
    }

    public function getOpBal() {
        return $this->opBal;
    }

    public function setOpBal($opBal) {
        $this->opBal = $opBal;
    }
    
    public function set_title($value) {
         $this->title=$value;
    }
    public function set_fname($value) {
         $this->fname=$value;
    }
    public function set_sname($value) {
         $this->sname=$value;
    }
    public function set_gender($value) {
         $this->gender=$value;
    }
    public function set_country($value) {
         $this->country=$value;
    }
    public function set_address($value) {
         $this->address=$value;
    }
    public function set_town($value) {
         $this->town=$value;
    }
    public function set_postcode($value) {
         $this->postcode=$value;
    }
    public function set_dob($value) {
         $this->dob=$value;
    }
    public function set_email($value) {
         $this->email=$value;
    }
    public function set_ccode($value) {
         $this->ccode=$value;
    }
    public function set_mobile($value) {
         $this->mobile=$value;
    }
    public function set_username($value) {
         $this->username=$value;
    }
    public function set_password($value) {
         $this->password=$value;
    }
    public function set_refQuestion($value) {
         $this->refQuestion=$value;
    }
    public function set_answer($value) {
         $this->answer=$value;
    }
    public function set_curr($value) {
         $this->curr=$value;
    }
    public function set_promoCode($value) {
         $this->promoCode=$value;
    }
    public function set_acceptNews($value) {
         $this->acceptNews=$value;
    }
    public function set_above18($value) {
         $this->above18=$value;
    }
    public function set_bal($value) {
         $this->bal=$value;
    }
    public function set_status($value) {
         $this->status=$value;
    }
    public function set_hash($value) {
         $this->hash=$value;
    }
    
    function createClient(){
        try {
            $conn = new PDO('mysql:host='.DB_HOST.';dbname='.DB, DB_USN, DB_PWD);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $conn->prepare('INSERT INTO _client_tb(_title, _reg_date, _firstname, _lastname, _gender, _country,
              _address, _town, _postcode, _dob, _email, _ccode, _mphone, _username, _pass, _seqQ, _seqA, _currency,
              _promocode, _above18, _acceptnews, _opBal_date, _opBal, _bal, _status, _hash) VALUES(:title, :regDate, :fname, :lname, :gender, :country,
              :address, :town, :postcode, :dob, :email, :ccode, :mphone, :usn, :pwd, :seqQ, :seqA, :curr, :promocode,
              :above18, :accNews, :opBalDt, :opBal, :bal, :status, :hash)');
            $stmt->execute(array(
              ':title'=>$this->title, ':regDate'=>$this->_reg_date, ':fname'=>$this->fname, ':lname'=>$this->sname, ':gender'=>$this->gender,
              ':country'=>$this->country, ':address'=>$this->address, ':town'=>$this->town, ':postcode'=>$this->postcode,
              ':dob'=>  $this->dob, ':email'=>  $this->email, ':ccode'=>  $this->ccode, ':mphone'=>  $this->mobile,
              ':usn'=>  $this->username, ':pwd'=>  $this->password, ':seqQ'=>  $this->refQuestion, ':seqA'=>  $this->answer,
              ':curr'=>  $this->curr, ':promocode'=>  $this->promoCode, ':above18'=>$this->above18, ':accNews'=>$this->acceptNews,
              ':opBalDt'=>$this->opBal_date, ':opBal'=>$this->opBal, ':bal'=>$this->bal, ':status'=>$this->status, ':hash'=>$this->hash
          ));
            $last_insert_id = $conn->lastInsertId();
            
            $conn=null;
        } catch(PDOException $e) {
          echo $e->getMessage();
        }
        return $last_insert_id;
    }
    
    function printClient(){
        echo 'title: '.$this->title.' fname: '.$this->fname.' lname: '.$this->sname.' gender: '.$this->gender.
              ' country: '.$this->country.' address: '.$this->address.' town: '.$this->town.' postcode: '.$this->postcode.
              ' dob: '.$this->dob.' email: '.$this->email.' ccode: '.$this->ccode.' mphone: '.$this->mobile.
              ' usn: '.$this->username.' pwd: '.$this->password.' seqQ: '.$this->refQuestion.' seqA: '.$this->answer.
              ' curr: '.$this->curr.' promocode: '.$this->promoCode.' above18: '.$this->above18.' accNews: '.$this->acceptNews.
              ' hash: '.$this->hash.' bal: '.$this->bal.' status: '.$this->status;
    }
    
    function checkClientId($tmpId){
        try {
          $conn = new PDO('mysql:host='.DB_HOST.';dbname='.DB, DB_USN, DB_PWD);
          $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          $stmt = $conn->prepare('SELECT * FROM _client_tb WHERE _id_client = :id');
          $stmt->execute(array(':id' => $tmpId));
          $result = $stmt->fetchAll();
          $conn=null;
          if ( count($result) ) {
              //echo 'True';
              return true;
            
          } else {
              //echo 'False';
            return false;
          }
        
          
        } catch(PDOException $e) {
            echo 'ERROR: ' . $e->getMessage();
        }
    }
    
    public static function getClUsnById($id){
        try {
          $conn = new PDO('mysql:host='.DB_HOST.';dbname='.DB, DB_USN, DB_PWD);
          $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          $stmt = $conn->prepare('SELECT _username FROM _client_tb WHERE _id_client = :id');
          $stmt->execute(array(':id' => $id));
          $result = $stmt->fetchAll();
          $conn=null;
          return $result;
        
        } catch(PDOException $e) {
            echo 'ERROR: ' . $e->getMessage();
        }
    }
    
    public static function checkClientUsn($tmpUsn){
        try {
          $conn = new PDO('mysql:host='.DB_HOST.';dbname='.DB, DB_USN, DB_PWD);
          $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          $stmt = $conn->prepare('SELECT _username FROM _client_tb WHERE _username = :usn');
          $stmt->execute(array(':usn' => $tmpUsn));
          $result = $stmt->fetchAll();
          $conn=null;
          if ( count($result) ) {
              return true;
          } else {
            return false;
          }
        
        } catch(PDOException $e) {
            echo 'ERROR: ' . $e->getMessage();
        }
    }
    
    public static function getClientBalByUsn($Usn){
        try {
          $conn = new PDO('mysql:host='.DB_HOST.';dbname='.DB, DB_USN, DB_PWD);
          $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          $stmt = $conn->prepare('SELECT * FROM _client_tb WHERE _username = :usn');
          $stmt->execute(array('usn' => $Usn));
          $result = $stmt->fetchAll();
          $conn=null;
          return $result;
        
        } catch(PDOException $e) {
            echo 'ERROR: ' . $e->getMessage();
        }
    }
    
    public static function checkClientEmail($tmpEmail){
        try {
          $conn = new PDO('mysql:host='.DB_HOST.';dbname='.DB, DB_USN, DB_PWD);
          $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          $stmt = $conn->prepare('SELECT _email FROM _client_tb WHERE _email = :email');
          $stmt->execute(array('email' => $tmpEmail));
          $result = $stmt->fetchAll();
          $conn=null;
          if ( count($result) ) {
              return true;
          } else {
            return false;
          }
        
        } catch(PDOException $e) {
            echo 'ERROR: ' . $e->getMessage();
        }
    }
    
    public static function validate_user($usn, $pwd){
        try {
          $conn = new PDO('mysql:host='.DB_HOST.';dbname='.DB, DB_USN, DB_PWD);
          $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          $stmt = $conn->prepare('SELECT _username, _status FROM _client_tb WHERE _username = :usn AND _pass=:pwd');
          $stmt->execute(array('usn' => $usn, 'pwd'=> $pwd));
          $result = $stmt->fetchAll();
          $conn=null;
          return $result;
        
        } catch(PDOException $e) {
            echo 'ERROR: ' . $e->getMessage();
        }
    }
    
    public static function checkClientBal($usn){
        try {
          $conn = new PDO('mysql:host='.DB_HOST.';dbname='.DB, DB_USN, DB_PWD);
          $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          $stmt = $conn->prepare('SELECT _bal FROM _client_tb WHERE _username = :usn');
          $stmt->execute(array(':usn' => $usn));
          $result = $stmt->fetchAll();
          $conn=null;
          return $result;
        
        } catch(PDOException $e) {
            echo 'ERROR: ' . $e->getMessage();
        }
    }
    
    public static function updateBal($newBal, $cl){
        try {
            $conn = new PDO('mysql:host='.DB_HOST.';dbname='.DB, DB_USN, DB_PWD);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $conn->prepare('UPDATE _client_tb SET _bal = :bal WHERE _username= :cl');
            $stmt->execute(array(
              ':bal'=>  $newBal, ':cl'=>$cl
            ));
            $conn=null;
            return true;
        } catch(PDOException $e) {
          return $e->getMessage();
        }
    }
    
    public static function updatePwd($pwd, $clId){
        try {
            $conn = new PDO('mysql:host='.DB_HOST.';dbname='.DB, DB_USN, DB_PWD);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $conn->prepare('UPDATE _client_tb SET _pass = :pwd WHERE _id_client= :clId');
            $stmt->execute(array(':pwd'=>  $pwd, ':clId'=>$clId));
            $conn=null;
            return true;
        } catch(PDOException $e) {
          return $e->getMessage();
        }
    }
    public static function updatePromocode($clId){
        $pCode=' ';
        try {
            $conn = new PDO('mysql:host='.DB_HOST.';dbname='.DB, DB_USN, DB_PWD);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $conn->prepare('UPDATE _client_tb SET _promocode =:pCode  WHERE _id_client= :clId');
            $stmt->execute(array(':pCode'=>$pCode,':clId'=>$clId));
            $conn=null;
            return true;
        } catch(PDOException $e) {
          return $e->getMessage();
        }
    }
    
    
    public static function getSeqQuestion($field, $valu){
        try {
          $conn = new PDO('mysql:host='.DB_HOST.';dbname='.DB, DB_USN, DB_PWD);
          $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          if ($field == 'email') {
                $stmt = $conn->prepare('SELECT _question, _id_client FROM `_questionlist_tb`,  _client_tb WHERE _id_qlist=_seqQ AND _email=:email');
                $stmt->execute(array(':email' => $valu));
            }
            if ($field == 'uname') {
                $stmt = $conn->prepare('SELECT _question, _id_client FROM `_questionlist_tb`,  _client_tb WHERE _id_qlist=_seqQ AND _username=:usn');
                $stmt->execute(array(':usn' => $valu));
            }
          
          $result = $stmt->fetchAll();
          $conn=null;
          return $result;
        
        } catch(PDOException $e) {
            echo 'ERROR: ' . $e->getMessage();
        }
    }
    public static function getAnswer($ans,$field,$valu){
        try {
            $conn = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB, DB_USN, DB_PWD);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            if ($field == 'mail') {
                $stmt = $conn->prepare('SELECT _id_client, _email, _username FROM `_client_tb` WHERE LCASE(_seqA)=:ans AND _email=:mail');
                $stmt->execute(array(':ans' => $ans,':mail'=>$valu));
            }
            if ($field == 'uname') {
                $stmt = $conn->prepare('SELECT _id_client, _email, _username FROM `_client_tb` WHERE LCASE(_seqA)=:ans AND _username=:uname');
                $stmt->execute(array(':ans' => $ans,':uname'=>$valu));
            }
            
            $result = $stmt->fetchAll();
            $conn = null;
            return $result;
        } catch (PDOException $e) {
            echo 'ERROR: ' . $e->getMessage();
        }
    }
    
    public static function saveRecoverMailRec($clId,$hash,$expDate){
        try {
            $conn = new PDO('mysql:host='.DB_HOST.';dbname='.DB, DB_USN, DB_PWD);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $conn->prepare('INSERT INTO _recoveryemail(_ref_client, _key, _datetime) VALUES(:refClient, :key, :dat)');
            $stmt->execute(array(
              ':refClient'=>$clId, ':key'=>$hash, ':dat'=>$expDate
          ));
            $last_insert_id = $conn->lastInsertId();
            
            $conn=null;
        } catch(PDOException $e) {
          echo $e->getMessage();
        }
        return $last_insert_id;
    }
    
    public static function sendForgotPass($clEmail, $clUsn, $hash, $refCl){
        $link=$hash.'-'.urlencode(base64_encode($refCl));
        $to=$clEmail;
        $text = <<<TXT
Dear $clUsn,\n\r

We have received your request for a new password. Please visit the following link to reset your password:\n\r

http://www.betteaser.com/recover.php?r=$link
\n\r
The link will expire in 3 days for security reasons.\n\r

    
\n\r\n\r
You received this e-mail because there was a request to reset your password. If you did not initiate it, no action is needed.
Your password will not be reset unless you visit the above link. However you may want to log into your account and change your password and/or your security answer
as someone may have guessed it. For more info email us at support@betteaser.com

TXT;

        $html = <<<EOT

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>BetTeaser - Password Requested</title>
</head>

<body bgcolor="#C8DAC2">
<center>
<table width="605px" cellpadding="0" cellspacing="0" style="border: 1px silver solid;">

	<tr>
    	<td width="550px" height="155px" valign="bottom" background="http://www.betteaser.com/ads/forgotpass.gif;"></td>
	</tr>
    <tr>
        <td width="605px" height="245px" valign="top">
        	<center>
   	  		<table width="560px" align="center">
            	<tr>
                	<td>
                    	<p><font face="Verdana, Geneva, sans-serif" size="-1" color="#1F1F1F">Dear $clUsn,</font></p>
                        <p><font face="Verdana, Geneva, sans-serif" size="-1" color="#1F1F1F">We have received your request for a new password. Please visit the following link to reset your password:</font></p>
                        <center><p><a target="_blank" href="http://www.betteaser.com/recover.php?r=$link" style="color: #03110A;"><font size="5" face="Verdana, Geneva, sans-serif" color="#03110A">Reset Password</font></a></p></center>
                        <p><font face="Verdana, Geneva, sans-serif" size="-1" color="#1F1F1F">If the above link is not working, please copy and paste this address (http://www.betteaser.com/recover.php?r=$link) into your browsers address bar.</font></p>
                        <p><font face="Verdana, Geneva, sans-serif" size="-1" color="#1F1F1F">The link will expire in 3 days for security reasons.</p>
			</td>
                </tr>
            </table>
			
            </center>
        </td>
  </tr>
    <tr>
        <td width="605px" height="119px" valign="top" style="padding: 0; margin: 0;">
        
        	<center>
        	<table width="553px" align="center" cellpadding="0" cellspacing="0" style="vertical-align: top;">
            	<tr><td height="15px"></td></tr>
            	<tr>
                    <td>
                    
                    	<p><font face="Verdana, Geneva, sans-serif" color="#85948F" size="-2">You received this e-mail because there was a request to reset your password. If you did not initiate it, no action is needed.
Your password will not be reset unless you visit the above link. However you may want to log into your account and change your password and/or your security answer
as someone may have guessed it. For more info email us at <a href="" style="color: #03110A;"><font color="#03110A">support@betteaser.com</font></a></font></p>
                    </td>
                </tr>
           </table>
        	</center>
            
        
      </td>
  </tr>

</table>
</center>
</body>
</html>
EOT;


        $crlf = "\n";
        $hdrs = array('From' => 'BetTeaser <support@betteaser.com>',
            'Subject' => 'New password requested');
        $mime = new Mail_mime($crlf);
        $mime->setTXTBody($text);

        $mime->setHTMLBody($html);
        $body = $mime->get();
        $hdrs = $mime->headers($hdrs);
        $mail = Mail::factory('mail');
        $succ = $mail->send($to, $hdrs, $body);
        if (PEAR::isError($succ)) {
            //echo 'There was a problem while sending you the registration confirmation.';
            return 0;
        } else {
            //echo 'Email sent succesfully';
            return 1;
        }
    
    }
}

?>
