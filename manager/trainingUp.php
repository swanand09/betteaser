<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

require_once '\utility\ClassManager.php';
include 'utility\ClassMeeting.php';
//include 'include\header.php';
include 'include\leftlink.php';

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
                <div id="training" style="display:block;">
                    <h3>Upload Training</h3>
                    <form id="frmNewMeeting">
                        <fieldset>
                            <ol>
                                <li>
                                    <label for=mdate>Training Date<span id="ddformat">[DD/MM/YYYY]</span></label>
                                    <input id=mdate name=mdate type=text placeholder="" required autocomplete="off"/>
                                </li>
                                <li>
                                    <label for=trainingData>Comment</label>
                                    <textarea name="trainingData" id="trainingData" rows="4" cols="50"></textarea> 
                                </li>
                                <li>
                                    <label>&nbsp;</label>
                                    <button type=submit name="saveTraining" id="saveTraining" value="uploadTraining">Save</button>
                                </li>
                            </ol>
                        </fieldset>
                     </form>
                    <div class="msgStatus"></div>
                    
                </div>
                
            </div>
        </div>
    </body>
</html>
