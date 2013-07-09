<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

include '\utility\ClassClient.php';

$username = trim(strtolower($_POST['username']));
$username = mysql_escape_string($username);

if(Client::checkClientUsn($username)){
    echo '1';
}else{
    echo '0';
}

?>
