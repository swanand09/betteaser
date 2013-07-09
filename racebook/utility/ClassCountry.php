<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

include '\conn\conn.php';

function getCountryList(){
    $i=0;
    $q="SELECT * from _country_tb";
    $res=mysql_query($q);
    while($row = mysql_fetch_array($res)){
        $country[$i][0]=$row['_id_country'];
        $country[$i][1]=$row['_cname'];
        $country[$i][2]=$row['_curr_code'];
        $country[$i][3]=$row['_ph_code'];
        
        $i++;
    }
    mysql_free_result($res);
    return $country;
}
function getQuestionList(){
    $i=0;
    $q="SELECT * from _questionlist_tb";
    $res=mysql_query($q);
    while($row = mysql_fetch_array($res)){
        $question[$i][0]=$row['_id_qlist'];
        $question[$i][1]=$row['_question'];
        
        $i++;
    }
    mysql_free_result($res);
    return $question;
}

function getCountryId($countryName){
    $q="SELECT * from _country_tb WHERE `_cname`='".$countryName."'";
    $res=mysql_query($q);
    
    
}
function getCountryName($countryId){
    $q="SELECT _cname from _country_tb WHERE `_id_country`='".$countryId."'";
    $res=mysql_query($q);
    $row = mysql_fetch_array($res);
    mysql_free_result($res);
    $countryName=$row[0];
    return $countryName;
}

function create_year_dropdown($start_year = FALSE, $end_year = FALSE) {
    $start_year = ($start_year) ? $start_year - 1 : date('Y') - 99;
    $end_year = ($end_year) ? $end_year : date('Y');

    // Generate the select
    $retval .= '<option value="-1">YYYY</option>';
    for ($i = $end_year; $i > $start_year; $i -= 1) {
        $retval .= '<option value="'.$i.'">'.$i.'</option>';
    }

	
    return $retval;
}
function create_date() {
    $sdate = 1;
    $edate = 31;

    // Generate the select
    $retval .= '<option value="-1">DD</option>';
    for ($i = $sdate; $i <= $edate; $i++) {
        $retval .= '<option value="'.$i.'">'.$i.'</option>';
    }

	
    return $retval;
}
?>
