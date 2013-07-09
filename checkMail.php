<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
include '\utility\ClassClient.php';

$email = trim(strtolower($_POST['email']));
$email = mysql_escape_string($email);

if(Client::checkClientEmail($email)){
    echo '1';
}else{
    echo '0';
}
?>
