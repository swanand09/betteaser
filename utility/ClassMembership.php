<?php

require 'ClassClient.php';

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Membership {

    function validate_user($usn, $pwd) {
        $ensure_credentials = Client::validate_user($usn, sha1($pwd));

        //echo 'Username: '.$ensure_credentials[0]['_username'].'<br/>Status: '.$ensure_credentials[0]['_status'];

        if ($ensure_credentials[0]['_username'] != '') {
            if ($ensure_credentials[0]['_status'] == 1) {
                $_SESSION['status'] = 'authorized';
                $_SESSION['clientUsn'] = $ensure_credentials[0]['_username'];
                if($_SESSION['url']!=''){
                    header("location: ".$_SESSION['url']);
                }else{
                    header("location: index.php");
                }
            }
            if ($ensure_credentials[0]['_status'] == 0) {
                $msg = "<fieldset id='error'><p class='loginErr'>";
                $msg.="Dear " . $ensure_credentials[0]['_username'] . ", your account needs to be activated before you can use it. Please follow the instructions sent by mail.";
                $msg.="</p></fieldset>";
                return $msg;
            }
        } else {
            $msg = "<fieldset id='error'><p class='loginErr'>";
            $msg.="You have entered an invalid login credential. Please check the details above and try again.";
            $msg.="</p></fieldset>";
            return $msg;
        }
    }

    function log_User_Out() {
        if (isset($_SESSION['status'])) {
            unset($_SESSION['status']);
            unset($_SESSION['clientUsn']);
            if (isset($_COOKIE[session_name()]))
                setcookie(session_name(), '', time() - 1000);
            session_destroy();
            header("location: index.php");
        }
    }

    function confirm_Member() {
        session_start();
        if ($_SESSION['status'] == 'authorized')
            header("location: /racebook/index.php");
    }

}

?>
