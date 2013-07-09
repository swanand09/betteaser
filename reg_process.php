<?php

    include 'ClassClient.php';
    include 'include/conn.php';

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
    
    
    $newClient=new Client();
    
    if(($_POST['fname']!='')&&($_POST['sname']!='')&&($_POST['address1']!='')
            &&($_POST['town']!='')&&($_POST['email']!='')&&($_POST['username']!='')&&($_POST['pass']!='')
            &&($_POST['cpass']!='')&&($_POST['answer']!='')&&($_POST['betCurr']!='')&&($_POST['promocode']!='')){
        
        
    }else{
        
    }
    

?>
