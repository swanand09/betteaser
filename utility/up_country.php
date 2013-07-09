<?php
    include 'include/conn.php';

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
    $info=$_REQUEST['info'];
    if ($info !=''){
        $ia=explode("\n", $info);
        for($i=0;$i<sizeof($ia);$i++){
            $row=$ia[$i];
            $field=explode(";", $row);
            
            $country=mysql_real_escape_string(trim($field[1]));
            $capital=mysql_real_escape_string(trim($field[2]));
            $currCode=mysql_real_escape_string(trim($field[3]));
            $phCode=mysql_real_escape_string(trim($field[4]));
            
            $qry="INSERT INTO `_country_tb` (`_cname`,`_capital`,`_curr_code`,`_ph_code`) VALUES ('".$country."','".$capital."','".$currCode."','".$phCode."')";
            //echo '<br/>'.$qry;
            
            if (mysql_query($qry)){
                //echo '*** Saved<br/>';
            }else{
                echo '*** Failed<br/>';
            }
        }
    }
    
?>
<html>
    <head>
        <title>Import Country CSV</title>
    </head>
    <body>
        <form action="<? echo $_SERVER['PHP_SELF']?>" method="POST">
            <textarea cols="150" rows="15" name="info"><? echo urldecode($_REQUEST['info']);?></textarea>
            <input type="submit" name="Save"></input>
        </form>
    </body>
</html>
