<?php

require 'ClassAdmin.php';

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Manager {

    function validate_manager($usn, $pwd) {
        $ensure_credentials = Admin::validate_admin($usn, sha1($pwd));

        if ($ensure_credentials[0]['_usn'] != '') {
            if ($ensure_credentials[0]['_ustatus'] == 1) {
                $_SESSION['adminstatus'] = 'authorized';
                $_SESSION['adminUsn'] = $ensure_credentials[0]['_usn'];
                header("location: index.php");
            }
        } else {
            $msg = "<fieldset id='error'><p class='loginErr'>";
            $msg.="You have entered an invalid login credential. Please check the details above and try again.";
            $msg.="</p></fieldset>";
            return $msg;
        }
    }

    function log_Admin_Out() {
        if (isset($_SESSION['adminstatus'])) {
            unset($_SESSION['adminstatus']);
            unset($_SESSION['admintUsn']);
            if (isset($_COOKIE[session_name()]))
                setcookie(session_name(), '', time() - 1000);
            session_destroy();
            header("location: index.php");
        }
    }

    function confirm_Manager() {
        session_start();
        if ($_SESSION['adminstatus'] != 'authorized')
            header("location: login.php");
    }

}

?>
