<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

include("./utility/ClassManager.php");
include("./utility/ClassMeeting.php");
include("./include/leftlink.php");

//include 'include\leftlink.php';

    $manager = New Manager();
    $manager->confirm_Manager();
    
    
?>
<html>
    <head>
        <title>Welcome Admin</title>
        <link rel="stylesheet" href="../css/reset.css" />
        <link rel="stylesheet" href="css/style.css" />
        <link rel="stylesheet" href="css/jquery-ui.css" />
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
        <script src="js/jquery-ui.js" ></script>
        <script src="js/meeting.js" ></script>
    </head>
    <body>
       <?php include 'include\header.php'; ?>
        <div id="content">
            <div id="leftmenu">
                <?php echo $leftlink; ?>
            </div>
            <div id="rightcontent">
                <div id="meetingList">
                    <h3>Meeting Management</h3>&nbsp;<a href="#createMeeting" id="btnCreateMeeting">Create Meeting</a><br/>
                    <table cellspacing="0" cellpadding="1" border="1" width="600px" class="display"  id="example" >
                        <thead>
                        <tr class="header">
                            <td>&nbsp;</td>
                            <td>Name</td>
                            <td>Date</td>
                            <td>Status</td>
                            <td>Comments</td>
                            <td>Pitch</td>
                            <td>F-Rail</td>
                            <td>Display</td>
                            <td>Current</td>
                            <td>Edit</td>
                            <td>Manage</td>
                        </tr></thead>
                        <?php
                        $i = 0;
                        $mting = Meeting::getMeeting();
                        foreach ($mting as $meeting) {
                            $dat = str_replace('/', '-', $meeting[_mdate]);
                            if ($i % 2 == 0) {
                                echo "<tr id='" . $meeting[_id_meeting] . "'>";
                            } else {
                                echo "<tr class='hlight' id='" . $meeting[_id_meeting] . "'>";
                            }

                            echo '<td>' . $meeting[_id_meeting] . '</td>';
                            echo '<td>' . $meeting[_mname] . '</td>';
                            echo "<td class='hiddenTd'>" . $meeting[_mdate] . "</td>";
                            echo '<td>' . date("D - d M Y", strtotime($dat)) . '</td>';
                            echo '<td>' . $meeting[_mstatus] . '</td>';
                            echo '<td>' . $meeting[_comment] . '</td>';
                            echo '<td>' . $meeting[_pitch] . '</td>';
                            echo '<td>' . $meeting[_falserail] . '</td>';
                            echo '<td>' . $meeting[_display] . '</td>';
                            echo '<td>' . $meeting[_current] . '</td>';
                            echo "<td><a class='editMeeting' href=edit.php?id=" . $meeting[_id_meeting] . ">Edit</a></td>";
                            echo '<td><a href=manage.php?id=' . $meeting[_id_meeting] . '>Manage</a></td>';
                            echo '<tr/>';
                            $i++;
                        }
                        ?>
                    </table><br/>
                    
                </div>
                <div id="createMeeting">
                    <h3>Create Meeting</h3>
                    <form id="frmNewMeeting">
                        <fieldset>
                            <ol>
                                <li>
                                    <label for=mname>Meeting Name</label>
                                    <input id=mname name=mname type=text placeholder="" required autofocus autocomplete="off" />
                                </li>
                                <li>
                                    <label for=mdate>Date<span id="ddformat">[DD/MM/YYYY]</span></label>
                                    <input id=mdate name=mdate type=text placeholder="" required autofocus autocomplete="off"/>
                                </li>
                                <li>
                                    <label for=mstatus>Status</label>
                                    <select name="mstatus"  id="mstatus">
                                        <option value = "upcoming">upcoming</option>
                                        <option value = "nomination">nomination</option>
                                        <option value = "racecard">racecard</option>
                                        <option value = "result">result</option>
                                        <option value = "cancelled">canceled</option>
                                    </select>
                                </li>
                                <li>
                                    <label for=mcomment>Comment</label>
                                    <input id=mcomment name=mcomment type=text placeholder="" autocomplete="off"/>
                                </li>
                                <li>
                                    <label>&nbsp;</label>
                                    <button type=submit name="saveMeeting" id="saveMeeting" value="create">Save</button>
                                </li>
                            </ol>
                        </fieldset>
                     </form>
                    <div class="msgStatus"></div>
                    <a href="#" id="closeCreate">Close Window</a>
                </div>
                <div id="editMeeting">
                    <h3>Edit Meeting</h3>
                    <form id="frmEditMeeting">
                        <fieldset>
                            <ol>
                                <li>
                                    <label for=eId>Id</label>
                                    <input id=eId name=eId type=text placeholder="" readonly="readonly"/>
                                </li>
                                <li>
                                    <label for=ename>Meeting Name</label>
                                    <input id=ename name=ename type=text placeholder="" required autofocus autocomplete="off" />
                                </li>
                                <li>
                                    <label for=edate>Date<span id="ddformat">[DD/MM/YYYY]</span></label>
                                    <input id=edate name=edate type=text placeholder="" required autofocus autocomplete="off"/>
                                </li>
                                <li>
                                    <label for=estatus>Status</label>
                                    <select name="estatus"  id="estatus">
                                        <option value = "upcoming">upcoming</option>
                                        <option value = "nomination">nomination</option>
                                        <option value = "racecard">racecard</option>
                                        <option value = "result">result</option>
                                        <option value = "cancelled">canceled</option>
                                    </select>
                                </li>
                                <li>
                                    <label for=ecomment>Comment</label>
                                    <input id=ecomment name=ecomment type=text placeholder="" autocomplete="off"/>
                                </li>
                                <li>
                                    <label for=epitch>Pitch</label>
                                    <input id=epitch name=epitch type=text placeholder="" autocomplete="off"/>
                                </li>
                                <li>
                                    <label for=efalserail>False Rail</label>
                                    <input id=efalserail name=efalserail type=text placeholder="" autocomplete="off"/>
                                </li>
                                <li>
                                    <input type="checkbox" id="eDisplay" name="eDisplay" />
                                    <label for=eDisplay>Display Meeting</label>
                                </li>
                                <li>
                                    <input type="checkbox" id="eCurrent" name="eCurrent" />
                                    <label for=eCurrent>Current Meeting</label>
                                </li>
                                <li>
                                    <label>&nbsp;</label>
                                    <button type=submit name="saveEditMeeting" value="edit" id="saveEditMeeting">Save</button>
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
