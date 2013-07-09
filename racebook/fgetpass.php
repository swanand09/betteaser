<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

include 'utility\ClassClient.php';
include 'utility\ClassRecoverMail.php';

$action=mysql_real_escape_string(trim($_POST['action']));

if($action=='getSeqQuestion'){
    $field=mysql_real_escape_string(trim($_POST['field']));
    $valu=mysql_real_escape_string(trim($_POST['val']));
    
    $seqQ = Client::getSeqQuestion($field, $valu);
    $seqQ=$seqQ[0]['_question'];
    echo $seqQ;
}
if($action=='getAnswer'){
    $ans=strtolower(mysql_real_escape_string(trim($_POST['ans'])));
    $field=strtolower(mysql_real_escape_string(trim($_POST['field'])));
    $valu=strtolower(mysql_real_escape_string(trim($_POST['valu'])));
    
    $rCl=Client::getAnswer($ans,$field,$valu);
    $refCl=$rCl[0]['_id_client'];
    $clEmail=$rCl[0]['_email'];
    $clUsn=$rCl[0]['_username'];
    
    if($refCl!=''){
        //save req in table recover email
        define(PW_SALT,'(*96-');
        $expFormat = mktime(date("H"), date("i"), date("s"), date("m")  , date("d")+3, date("Y"));
	$expDate = date("Y-m-d H:i:s",$expFormat);
        $hash=md5($refCl . '_' . rand(0,10000) .$expDate . PW_SALT);
        if(!RecoverMail::checkPendingRecovery($refCl)){
            $recoverId=Client::saveRecoverMailRec($refCl,$hash,$expDate);
            if($recoverId!=''){
                $sendMail=Client::sendForgotPass($clEmail, $clUsn, $hash, $refCl);
                if($sendMail==1){
                    echo 'An email has been sent to you with instructions on how to reset your password.';
                }else{
                    echo 'There was an error while sending you the recover password email. Please contact us at care@betteaser.com for assistance.';
                }
            }
        }else{
            echo 'An email with further instructions to reset your password has already been sent. Please check in your inbox or in your junk folder. Having difficulty resetting your password? Please email us at care@betteaser.com, an agent will help you find your way.';
        }
        
    }
    
}
?>
