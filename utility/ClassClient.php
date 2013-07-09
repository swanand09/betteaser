<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */



include 'const.php';
include 'Mail.php';
include 'Mail/mime.php';

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
          $stmt->execute(array('id' => $tmpId));
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
    
    public static function checkClientUsn($tmpUsn){
        try {
          $conn = new PDO('mysql:host='.DB_HOST.';dbname='.DB, DB_USN, DB_PWD);
          $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          $stmt = $conn->prepare('SELECT _username FROM _client_tb WHERE _username = :usn');
          $stmt->execute(array('usn' => $tmpUsn));
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
    public static function validate_activation($hash, $id){
        try {
          $conn = new PDO('mysql:host='.DB_HOST.';dbname='.DB, DB_USN, DB_PWD);
          $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          $stmt = $conn->prepare('SELECT _id_client, _username FROM _client_tb WHERE _id_client = :id AND _hash=:hash AND _status=0');
          $stmt->execute(array(':id' => $id, ':hash'=> $hash));
          $result = $stmt->fetchAll();
          $conn=null;
          return $result;
        
        } catch(PDOException $e) {
            echo 'ERROR: ' . $e->getMessage();
        }
    }
    
    public static function clientActivation($id){
        try {
            $conn = new PDO('mysql:host='.DB_HOST.';dbname='.DB, DB_USN, DB_PWD);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $conn->prepare('UPDATE _client_tb SET _status = 1 WHERE _id_client=:id');
            $stmt->execute(array(
              ':id'=>$id
            ));
            $conn=null;
            return true;
        } catch(PDOException $e) {
          return $e->getMessage();
        }
    
    }
    
    function sendActivationMail($cId) {
        $to = $this->email; // Send email to our user  
        $usn = $this->username;
        $hash=$this->hash;
        $key=$cId+20101;
        $link=$key.'-'.$hash;

        $text = <<<TXT
Welcome $usn,\n\r

You've made a wise choice! Thank you for taking the time to register.The fun is about to begin and we're sure you'll want to start playing.\n\r

Before that we need to confirm your account by going to the link below!\n\r

http://www.betteaser.com/activation.php?auth=$link
\n\r
So your next step is to make a deposit in your account. That's simple, too.\n\r

    1. Create a free netteller account.
    2. Log in to your BetTeaser account.
    3. Go to Deposit.
    4. Make your payment.
    5. Enjoy yourself!
    
\n\r\n\r
You received this e-mail because your email has been used to register on BetTeaser. If you think you should not have received this e-mail, please email us at support@betteaser.com

TXT;

        $html = <<<EOT

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Welcome to BetTeaser</title>
</head>

<body bgcolor="#C8DAC2">
<center>
<table width="605px" cellpadding="0" cellspacing="0" style="border: 1px silver solid;">

	<tr>
    	<td width="550px" height="155px" valign="bottom" background="http://www.betteaser.com/ads/welcome.gif"></td>
	</tr>
    <tr>
        <td width="605px" height="245px" valign="top">
        	<center>
   	  		<table width="560px" align="center">
            	<tr>
                	<td>
                    	<p><font face="Verdana, Geneva, sans-serif" size="-1" color="#1F1F1F">Welcome $usn,</font></p>
                        <p><font face="Verdana, Geneva, sans-serif" size="-1" color="#1F1F1F">You've made a wise choice! Thank you for taking the time to register.The fun is about to begin and we're sure you'll want to start playing. </font></p>
                        <p><font face="Verdana, Geneva, sans-serif" size="-1" color="#1F1F1F">Before that we need to confirm your account by click the link below!</font></p>
                        <center><p><a target="_blank" href="http://www.betteaser.com/activation.php?auth=$link" style="color: #03110A;"><font size="5" face="Verdana, Geneva, sans-serif" color="#03110A">Activate Account</font></a></p></center>
                        <p><font face="Verdana, Geneva, sans-serif" size="-1" color="#1F1F1F">If the above link is not working, please copy and paste this address (http://www.betteaser.com/activation.php?auth=$link) into your browsers address bar.</font></p>
                    <p><font face="Verdana, Geneva, sans-serif" size="-1" color="#1F1F1F">So your next step is to make a deposit in your account. That's simple, too.
					<ol>
						<li>Create a free <a href="http://www.neteller.com" target="_blank">netteller account.</a></li>
						<li>Log in to your BetTeaser account.</li>
						<li>Go to Deposit.</li>
						<li>Make your payment.</li>
						<li>Enjoy yourself!</li>
					</ol>
					</p>
					</td>
                </tr>
            </table>
			
            </center>
        </td>
  </tr>
    <tr>
        <td width="605px" height="119px" valign="top" background="img/footer.gif" style="padding: 0; margin: 0;">
        
        	<center>
        	<table width="553px" align="center" cellpadding="0" cellspacing="0" style="vertical-align: top;">
            	<tr><td height="15px"></td></tr>
            	<tr>
                    <td>
                    
                    	<p><font face="Verdana, Geneva, sans-serif" color="#85948F" size="-2">You received this e-mail because your email has been used to register on BetTeaser. If you think you should not have received this e-mail, please email us at <a href="" style="color: #03110A;"><font color="#03110A">support@betteaser.com</font></a></font></p>
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
            'Subject' => 'Welcome to BetTeaser');
        $mime = new Mail_mime($crlf);
        $mime->setTXTBody($text);

        $mime->setHTMLBody($html);
        $body = $mime->get();
        $hdrs = $mime->headers($hdrs);
        $mail = Mail::factory('mail');
        $succ = $mail->send($to, $hdrs, $body);
        if (PEAR::isError($succ)) {
            echo 'There was a problem while sending you the registration confirmation.';
        } else {
            echo 'Email sent succesfully';
        }
    }
    
    
    
    public static function contactus_copy($name, $to, $subject, $msg){
        
        

        $text = <<<TXT
Dear $name,\n\r

This is an auto-generated copy of your contact request at BetTeaser.
Please allow a minimum of 24 hours for a reply. \n\r

        $msg

TXT;

        $html = <<<EOT

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Welcome to BetTeaser</title>
</head>

<body bgcolor="#C8DAC2">
<center>
<table width="605px" cellpadding="0" cellspacing="0" style="border: 1px silver solid;">

    <tr>
        <td width="605px" height="245px" valign="top">
        	<center>
   	  		<table width="560px" align="center">
            	<tr>
                	<td>
                    	<p><font face="Verdana, Geneva, sans-serif" size="-1" color="#1F1F1F">Dear $name,</font></p>
                        <p><font face="Verdana, Geneva, sans-serif" size="-1" color="#1F1F1F">This is an auto-generated copy of your contact request at BetTeaser.
Please allow a minimum of 24 hours for a reply. </font></p>
                        <p><font face="Verdana, Geneva, sans-serif" size="-1" color="#1F1F1F">$msg</font></p>
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
            'Subject' => 'Betteaser.com - '.$subject);
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
            return 1;
            //echo 'Email sent succesfully';
        }
    }
    
    public static function contactus($name, $to, $subject, $msg){
        
        

        $text = <<<TXT
        This is a message from: $name - $to\n\r
        Subject: $subject\n\r
        $msg
TXT;

        $html = <<<EOT

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Contact Us</title>
</head>

<body bgcolor="#C8DAC2">
<center>
<table width="605px" cellpadding="0" cellspacing="0" style="border: 1px silver solid;">

    <tr>
        <td width="605px" height="245px" valign="top">
        	<center>
   	  		<table width="560px" align="center">
            	<tr>
                	<td>
                    	<p><font face="Verdana, Geneva, sans-serif" size="-1" color="#1F1F1F">This is a message from: $name - $to</font></p>
                    	<p><font face="Verdana, Geneva, sans-serif" size="-1" color="#1F1F1F">Subject: $subject</font></p>
                        <p><font face="Verdana, Geneva, sans-serif" size="-1" color="#1F1F1F">$msg</font></p>
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
        $hdrs = array('From' => 'Customer Contact <care@betteaser.com>',
            'Subject' => $subject);
        $mime = new Mail_mime($crlf);
        $mime->setTXTBody($text);

        $mime->setHTMLBody($html);
        $body = $mime->get();
        $hdrs = $mime->headers($hdrs);
        $mail = Mail::factory('mail');
        $succ = $mail->send('support@betteaser.com', $hdrs, $body);
        if (PEAR::isError($succ)) {
            //echo 'There was a problem while sending you the registration confirmation.';
            return 0;
        } else {
            return 1;
            //echo 'Email sent succesfully';
        }
    }

}

?>
