<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

include("./utility/ClassManager.php");
include("./utility/ClassMeeting.php");
include("./utility/ClassCover.php");
include("./include/leftlink.php");

    $manager = New Manager();
    $manager->confirm_Manager();
    
    
?>
<html>
    <head>
        <title>Welcome Admin</title>
        <link rel="stylesheet" href="../css/reset.css" />
        <link rel="stylesheet" href="css/style.css" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
        <script src="js/cover.js" ></script>
    </head>
    <body>
       <?php include 'include\header.php'; ?>
        <div id="content">
            <div id="leftmenu">
                <?php echo $leftlink; ?>
            </div>
            <div id="rightcontent">
                <div id="meetingList">
                    <h3>Covered Bets Management</h3><br/>
                    <table cellspacing="0" cellpadding="1" border="1" width="600px" class="display"  id="example" >
                        <thead>
                        <tr class="header">
                            <td>&nbsp;</td>
                            <td>Race</td>
                            <td>Horse</td>
                            <td>Amount</td>
                            <td>Odds</td>
                            <td>Payout</td>
                            <td>Date</td>
                            <td>Display</td>
                        </tr></thead>
                        <?php
                        $i = 0;
                        $cover = Cover::getAllCovers();
                        foreach ($cover as $cv) {
                            $dat = str_replace('/', '-', $cv[_date]);
                            if ($i % 2 == 0) {
                                echo "<tr id='" . $cv[_id_cover] . "'>";
                            } else {
                                echo "<tr class='hlight' id='" . $cv[_id_cover] . "'>";
                            }

                            echo '<td>' . $cv[_id_cover] . '</td>';
                            echo '<td>' . $cv[_rnum] . '</td>';
                            echo '<td>' . $cv[_hname] . '</td>';
                            echo '<td>' . $cv[_amount] . '</td>';
                            echo '<td>' . $cv[_odds] . '</td>';
                            echo '<td>' . $cv[_po] . '</td>';
                            echo "<td style='display: none;'>" . $cv[_date] . "</td>";
                            echo '<td>' . date("D - d M Y", strtotime($dat)) . '</td>';
                            echo '<td>' . $cv[_show] . '</td>';
                            echo '<tr/>';
                            $i++;
                        }
                        ?>
                    </table><br/>
                    
                </div>
                <div id="editMeeting">
                    <h3>Edit Bets</h3>
                    <form id="frmEditMeeting">
                        <legend id="cHname">xx</legend>
                        <fieldset>
                            <ol>
                                <li>
                                    <input type="hidden" id="covId" name="covId" />
                                    <input type="checkbox" style="margin-left: -40px;" id="eShow" name="eShow" />
                                    <label for=eShow>Show Bet</label>
                                </li>
                                <li>
                                    <label>&nbsp;</label>
                                    <button type=submit name="savCovBets" style="margin-left: -40px;"  value="Save" id="savCovBets">Save</button>
                                </li>
                            </ol>
                        </fieldset>
                        
                    </form>
                    <div class="msgStatus"></div>
                    <a href="#" id="closeEdit">Close Window</a>
                    </form>
                </div>
                
            </div>
        </div>
    </body>
</html>