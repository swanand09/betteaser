<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 * 
 * 
 * _id_sel1 
_ref_bet 
_r1 //race num
_h1 //horse num
_rst1 
_rh1 //ref_horse
_rtxtst1 //race confirmation status
_odds1  //received odd
_payout //potential po
_windate //updated on payout
_winamount //effective payout
_date //date played
_amount //bet amount
_status //bet status: 2-lose, -2: wop, 1: win
_rfdate //refund date
_wdstatus //withdrawn status
_confirm //acepted 
_winstatus //winning status
_rwd //race //withdrawn status
_rf_client 
_place //pacebet
 * 
 */
// include 'include\header.php';
include 'include\leftlink.php';
include 'utility\ClassRace.php';
include 'utility\ClassHorse.php';

$raceId=$_GET['id'];
$raceDetails=Race::getRaceDetailById($raceId);
$raceHorse=Horse::getRaceHorses($raceId);

?>

<html>
    <head>
        <title>Welcome Admin</title>
        <link rel="stylesheet" href="../css/reset.css"/>
        <link rel="stylesheet" href="css/style.css"/>
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
        <script src="js/wpmonitor.js" ></script>
    </head>
    <body>
        <?php include 'include\header.php'; ?>
        <div id="content">
            <div id="leftmenu">
                <?php echo $leftlink; ?>
            </div><!-- End Left Menu -->
            <div id="rightcontent">
                <a href=<?php echo $_SERVER['HTTP_REFERER']; ?>>Manage Race Meeting</a><br/><br/>
                <table class="raceTable"><thead><tr class="header">
                                <td>&nbsp;</td>
                                <td>Race 
                                    <?php 
                                        echo $raceDetails[0]['_rnum']." [".$raceDetails[0]['_rdist']."] - ".$raceDetails[0]['_rtime']
                                    ?>
                                </td>
                                <td class=rezRank>TB</td>
                                <td>APB</td>
                                <td>Odds</td>
                                <td>NB</td>
                                <td>P/L</td>
                        </tr></thead>
                        <?php
                            foreach($raceHorse as $rH){
                                    if($rH['_htype']==1){
                                        
                                        $hnameSplit= explode(' ', $rH[_hname]);
                                        if(sizeof($hnameSplit)>1){
                                            $hnam=$hnameSplit[0][0].'. '.$hnameSplit[sizeof($hnameSplit)-1];
                                        }else{
                                            $hnam=$rH[_hname];
                                        }
                                        
                                        echo "<tr>";
                                        echo "<td>".$rH[_hnum]."</td>";
                                        echo "<td class='hidden'>".$rH[_hname]."</td>";
                                        echo "<td>".$hnam.' - '.$rH[_h_stjoc]."</td>";
                                        echo "<td>TB</td>";
                                        echo "<td>APB<br/>x</td>";
                                        echo "<td>".$rH[_hodds]."</td>";
                                        echo "<td>0</td>";
                                        echo "<td>0</td>";
                                        echo "</tr>";
                                    }
                            }
                        ?>
                </table>
               
  
            </div><!-- End Right Content -->
        </div><!-- End Div Content -->
    </body>
</html>

