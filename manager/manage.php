<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

//require_once '\utility\ClassManager.php';
include("./utility/ClassManager.php");
include("./utility/ClassMeeting.php");
include("./utility/ClassRace.php");
include("./include/leftlink.php");


    $manager = New Manager();
    $manager->confirm_Manager();
    
    $mId=$_GET['id'];
    
    $meetingName=Meeting::getMeetingName($mId);
    
    $race=Race::getRaceMeeting($mId);
    
    //print_r($race);

    
?>
<html>
    <head>
        <title>Welcome Admin</title>
        <link rel="stylesheet" href="../css/reset.css"/>
        <link rel="stylesheet" href="css/style.css"/>
        <link rel="stylesheet" href="css/jquery-ui.css" />
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
        <script src="js/jquery-ui.js"></script>
        <script src="js/race.js" ></script>
    </head>
    <body>
        <?php include 'include\header.php'; ?>
        <div id="content">
            <div id="leftmenu">
                <?php echo $leftlink; ?>
            </div>
            <div id="rightcontent">
                <div id="meetingList">
                    <h3>Race Management For <?php echo $meetingName[0][_mname]; ?></h3>&nbsp;<a href="#createRace" id="btnCreateRace">Create Race</a><br/>
                    <table cellspacing="0" cellpadding="1" border="1" width="500px" style="font-size: 11px;" >
                        <thead>
                            <tr class="header">
                                <td>#</td>
                                <td>Time</td>
                                <td>Race Name</td>
                                <td>Dist</td>
                                <td>Rating</td>
                                <td>Web Status</td>
                                <td>Race Status</td>
                                <td>Accept</td>
                                <td>Ended</td>
                                <td>Horses</td>
                                <td>Edit</td>
                                <td>Web Info</td>
                                <td>Manage</td>
                            </tr></thead>
                        <?php
                            $i=0;$winMonitor='';$placeMonitor='';
                            foreach ($race as $r){
                                if ($i % 2 == 0) {
                                    echo "<tr id='" . $r[_id_race] . "'>";
                                } else {
                                    echo "<tr class='hlight' id='" . $r[_id_race] . "'>";
                                }
                                
                                if($r[_eor]==1){
                                    $ended='Yes';
                                }else{
                                    $ended='No';
                                }
                                
                                if($r[_accept]==1){
                                    $accept='Yes';
                                }else{
                                    $accept='No';
                                }
                                if($r[_rstatus]==0){
                                    $rstatus='NO';
                                }else{
                                    $rstatus='S'.$r[_rstatus];
                                }
                                
                                echo "<td>".$r[_rnum]."</td>";
                                echo "<td>".$r[_rtime]."</td>";
                                echo "<td id='rname'>".$r[_rname]."</td>";
                                echo "<td>".$r[_rdist]."</td>";
                                echo "<td>".$r[_rating]."</td>";
                                echo "<td>".$r[_webstatus]."</td>";
                                echo "<td>".$rstatus."</td>";
                                echo "<td>".$accept."</td>";
                                echo "<td>".$ended."</td>";
                                echo "<td><a class='rHorse' href=listhorse.php?id=" . $r[_id_race] . ">Horses</a></td>";
                                echo "<td><a class='editRace' href=edit.php?id=" . $r[_id_race] . ">Edit</a></td>";
                                echo "<td><a class='editWebInfo' href=webinfo.php?id=" . $r[_id_race] . ">Web Info</a></td>";
                                echo "<td><a class='mRace' href=managerace.php?id=" . $r[_id_race] . ">Manage</a></td>";
                                echo "</tr>";
                                
                                $winMonitor.="<li><a href=winmonitor.php?id=".$r[_id_race]."&m=".$mId." >R".$r[_rnum]."</a></li>";
                                $placeMonitor.="<li><a href=placemonitor.php?id=".$r[_id_race]."&m=".$mId." >R".$r[_rnum]."</a></li>";
                                
                                $i++;
                            }
                            //$winMonitor.="<li><a target='_blank' href=allmonitor.php?id=all&m=".$mId." >ALL</a></li>";
                            $winMonitor.="<li><a target='_blank' href=riskmonitor.php?id=all&m=".$mId." >ALL</a></li>";
                            $placeMonitor.="<li><a target='_blank' href=placemonitor.php?id=all&m=".$mId." >ALL</a></li>";
                        ?>
                    </table><br/>
                    
                </div>
                <div id="createRace">
                    <h3>Create Race</h3>
                    <form id="frmNewRace">
                        <fieldset>
                            <ol>
                                <li>
                                    <input id=mId name=mId type=hidden placeholder="" value="<?php echo $mId; ?>"  />
                                </li>
                                <li>
                                    <label for=rnum>Race Num</label>
                                    <input id=rnum name=rnum type=text placeholder="" required autofocus autocomplete="off" />
                                </li>
                                <li>
                                    <label for=rtime>Time<span id="ddformat">[HH:MM]</span></label>
                                    <input id=rtime name=rtime type=text placeholder="" required autofocus autocomplete="off"/>
                                </li>
                                <li>
                                    <label for=c_rname>Race Name</label>
                                    <input id=c_rname name=c_rname type=text placeholder="" required autofocus autocomplete="off"/>
                                </li>
                                <li>
                                    <label for=rdist>Dist</label>
                                    <input id=rdist name=rdist type=text placeholder="" required autofocus autocomplete="off"/>
                                </li>
                                <li>
                                    <label for=rating>Rating</label>
                                    <input id=rating name=rating type=text placeholder="" required autofocus autocomplete="off"/>
                                </li>
                                <li>
                                    <label>&nbsp;</label>
                                    <button type=submit name="saveRaces" id="saveRaces" value="create">Save</button>
                                </li>
                            </ol>
                        </fieldset>
                     </form>
                    <div class="msgStatus"></div>
                    <a href="#" id="closeCreate">Close Window</a>
                </div>
                <div id="editRace">
                    <h3>Edit Race</h3>
                    <form id="frmEditRace">
                        <fieldset>
                            <ol>
                                <li>
                                    <label for=rId>Race Id</label>
                                    <input id=rId name=rId type=text placeholder="" readonly="readonly" />
                                </li>
                                <li>
                                    <label for=ernum>Race Num</label>
                                    <input id=ernum name=ernum type=text placeholder="" required autofocus autocomplete="off" />
                                </li>
                                <li>
                                    <label for=ertime>Time<span id="ddformat">[HH:MM]</span></label>
                                    <input id=ertime name=ertime type=text placeholder="" required autofocus autocomplete="off"/>
                                </li>
                                <li>
                                    <label for=ername>Name</label>
                                    <input id=ername name=ername type=text placeholder="" required autofocus autocomplete="off"/>
                                </li>
                                <li>
                                    <label for=erdist>Dist</label>
                                    <input id=erdist name=erdist type=text placeholder="" required autofocus autocomplete="off"/>
                                </li>
                                <li>
                                    <label for=erating>Rating</label>
                                    <input id=erating name=erating type=text placeholder="" required autofocus autocomplete="off"/>
                                </li>
                                <li>
                                    <label for=wstatus>Web Status</label>
                                    <select name="wstatus"  id="wstatus">
                                        <option value = "racecard">racecard</option>
                                        <option value = "result">result</option>
                                    </select>
                                </li>
                                <li>
                                    <label for=rstatus>Race Status</label>
                                    <input id=rstatus name=rstatus type=text placeholder="" required autofocus autocomplete="off"/>
                                    
                                </li>
                                <li>
                                    <label>&nbsp;</label>
                                    <button type=submit name="eRace" id="eRace" value="edit">Save</button>
                                </li>
                            </ol>
                        </fieldset>
                    </form>
                    <div class="msgStatus"></div>
                    <a href="#" id="closeEdit">Close Window</a>
                    </form>
                </div>
                <div class="clearFloat"></div>
                <div id="oddsFunctions">
                    <div id="winMonitor">
                        <h3>Win Monitor</h3>
                        <ul>
                            <?php echo $winMonitor; ?>
                        </ul><br/>
                        <a href="bpoWin.php">BIG PAYOUT</a>
                    </div>
                    <div id="placeMonitor">
                        <h3>Place Monitor</h3>
                        <ul>
                            <?php echo $placeMonitor; ?>
                        </ul><br/>
                        <a href="bpoPlace.php">BIG PAYOUT</a>
                        
                    </div>
                </div>
                <div class="clearFloat"></div><br/><br/>
                <div id="listhorse">
                    <h3 class="divTitle"></h3>
                    <div id="horseList">
                        
                    </div>
                    
                    <br/><a id="addHorses" href='#addHorses'>Import Horses</a>&nbsp;|&nbsp;<a id="addHWeight" href='#addHorses'>Import Horse Weight, Time factor & Owner and Casak</a>&nbsp;|&nbsp;<a id="addNomination" href='#addHorses'>Import Nomination</a>&nbsp;|&nbsp;<a href="#" id="closeHorse">Close Window</a>
                </div><!-- End List Horse -->
                <div id="importHorse">
                    <h3>Import Horses</h3>
                    <form id="frmImportHorse">
                        
                        <textarea id="horseData" name="horseData" row="50" cols="40" required></textarea><br/>
                        <button type="submit" name="sIHorse" id="sIHorse" value="saveHorse">Save</button>
                    </form><br/>
                    <a href="#" id="closeImportHorse">Close Window</a>
                </div><!-- END Import Horse -->
                
                <div id="importNomi">
                    <h3>Import Nomination</h3>
                    <form id="frmImportNomi">
                        
                        <textarea id="horseNomi" name="horseNomi" row="50" cols="40" required></textarea><br/>
                        <button type="submit" name="sINomi" id="sINomi" value="saveNomi">Save</button>
                    </form><br/>
                    <a href="#" id="closeImportNomi">Close Window</a>
                </div><!-- END Import Nomination -->
                
                
                <div id="importHorseWeight">
                    <h3>Import Horse Weight, Time factor & Owner and Casak</h3>
                    <form id="frmImportHorseWeight">
                        Weight Only<input type="radio" name="hWnT" id="hWeight" checked="checked" value="hWeight" />&nbsp;|&nbsp;
                        Time Only<input type="radio" name="hWnT" id="hTFactor" value="hTFactor" />&nbsp;|&nbsp;
                        Weight & Time<input type="radio" name="hWnT" id="hWeiTime" value="hWeiTime" />&nbsp;|&nbsp;
                        Owners & Casak<input type="radio" name="hWnT" id="hOwnerNCasak" value="hOwnerNCasak" /><br/>
                        <br/><textarea id="weightData" name="weightData" row="60" cols="50" required></textarea><br/>
                        <button type="submit" name="sIHorseWeight" id="sIHorseWeight" value="saveHorseWeight">Save</button>
                    </form><br/>
                    <a href="#" id="closeImportHorseWeight">Close Window</a>
                </div><!-- END Import Horse Weight -->
                
                <div id="editHorse">
                    <h3>Edit Horse</h3>
                    <form id="frmEditHorse">
                        <fieldset>
                            <ol>
                                <li class="hiddenTd">
                                    <label for=editHorse_rId>Race Id</label>
                                    <input id=editHorse_rId name=editHorse_rId type=text placeholder="" readonly="readonly" />
                                </li>
                                <li>
                                    <label for=hId>Horse Id</label>
                                    <input id=hId name=hId type=text placeholder="" readonly="readonly" />
                                </li>
                                <li>
                                    <label for=hNum>Horse Num</label>
                                    <input id=hNum name=hNum type=text placeholder="" autocomplete="off" />
                                </li>
                                <li>
                                    <label for=hNum>Horse Name</label>
                                    <input id=hNam name=hNam type=text placeholder="" autocomplete="off" />
                                </li>
                                <li>
                                    <label>Press Chances</label>
                                    <input class="pChance" id=chanceN name=chanceN type=text placeholder="nn" pattern="[n]+"  autocomplete="off"  />
                                    <input class="pChance" id=chanceX name=chanceX type=text placeholder="xx" pattern="[x]+" autocomplete="off" />
                                    <input class="pChance" id=chanceE name=chanceE type=text placeholder="ee" pattern="[e]+"  autocomplete="off" />
                                    <input class="pChance" id=chanceD name=chanceD type=text placeholder="dd" pattern="[d]+" autocomplete="off" />
                                </li>
                                <li>
                                    <label>Press Chances</label>
                                    <input class="pChance" id=chanceS name=chanceS type=text placeholder="ss" pattern="[s]+" autocomplete="off" />
                                    <input class="pChance" id=chanceM name=chanceM type=text placeholder="mm" pattern="[m]+" autocomplete="off" />
                                    <input class="pChance" id=chanceC name=chanceC type=text placeholder="cc" pattern="[c]+"  autocomplete="off" />
                                    <input class="pChance" id=chanceL name=chanceL type=text placeholder="ll" pattern="[l]+" autocomplete="off" />
                                </li>
                                <li>
                                    <label>Press Chances</label>
                                    <input class="pChance" id=chanceY name=chanceY type=text placeholder="YY" pattern="[Y]+" autocomplete="off" />
                                    <input class="pChance" id=chanceP name=chanceP type=text placeholder="PP" pattern="[P]+"  autocomplete="off" />

                                </li>
                                <li>
                                    <label for=hMgWeight>Horse Weight</label>
                                    <input id=hMgWeight name=hMgWeight type=text placeholder="" autocomplete="off" />
                                </li>
                                <li>
                                    <label for=hStable>Stable</label>
                                    <select id="hStable" name="hStable">
                                    </select>
                                </li>
                                <li>
                                    <label for=hJockey>Jockey</label>
                                    <select id="hJockey" name="hJockey">
                                    </select>
                                </li>
                                <li>
                                    <label for=hPerf>Horse Perf</label>
                                    <input id=hPerf name=hPerf type=text placeholder="" autocomplete="off" />
                                </li>
                                <li>
                                    <label for=hAge>Horse Age</label>
                                    <input id=hAge name=hAge type=text placeholder="" autocomplete="off"/>
                                </li>
                                <li>
                                    <label for=hEquip>Horse Equip</label>
                                    <input id=hEquip name=hEquip type=text placeholder="" autocomplete="off" />
                                </li>
                                <li>
                                    <label for=hWei>Weight</label>
                                    <input id=hWei name=hWei type=text placeholder="" autocomplete="off" />
                                </li>
                                <li>
                                    <label for=hDraw>Draw</label>
                                    <input id=hDraw name=hDraw type=text placeholder="" autocomplete="off" />
                                </li>
                                <li>
                                    <label for=hTfactor>Time Factor</label>
                                    <input id=hTfactor name=hTfactor type=text placeholder="" autocomplete="off" />
                                </li>
                                <li>
                                    <label for=hType>Type</label>
                                    <select id="hType" name="hType">
                                        <option value = "1">NO</option>
                                        <option value = "2">EA</option>
                                        <option value = "11">NR</option>
                                        <option value = "12">WoP</option>
                                    </select>
                                    <input class="hidden" style="width: 30px;" type="text" name="wopRate" id="wopRate" autocomplete="off" />
                                </li>
                                <li>
                                    <label for=hCommentEn>Comment Eng</label>
                                    <textarea id="hCommentEn" name="hCommentEn" placeholder="Horse Comment Eng" cols="30" rows="3"></textarea>
                                </li>
                                <li>
                                    <label for=hCommentFr>Comment Fr</label>
                                    <textarea id="hCommentFr" name="hCommentFr" placeholder="Horse Comment Fr" cols="30" rows="3"></textarea>
                                </li>
                                <li>
                                    <label for=hTNote>Train Note</label>
                                    <input id=hTNote name=hTNote type=text placeholder="x/10" autocomplete="off" />
                                </li>
                                <li>
                                    <label for=hFormNote>Form Note</label>
                                    <input id=hFormNote name=hFormNote type=text placeholder="x/10" autocomplete="off" />
                                </li>
                                <li>
                                    <label for=hOwners>Owners</label>
                                    <textarea id="hOwners" name="hOwners" placeholder="Horse Owners" cols="30" rows="3"></textarea>
                                </li>
                                <li>
                                    <input type="checkbox" id="hTrainShot" name="hTrainShot" />
                                    <label for=hTrainShot>Train Shot</label>
                                </li>
                                <li>
                                    <input type="checkbox" id="hSelBox" name="hSelBox" />
                                    <label for=hSelBox>Selection Box</label>
                                </li>
                                <li>
                                    <label for=hCasak>Casak</label>
                                    <input id=hCasak name=hCasak type=text placeholder="" autocomplete="off" />
                                </li>
                                <li>
                                    <label>&nbsp;</label>
                                    <button type=submit name="saveHorseRec" id="saveHorseRec" value="saveHorseRec">Save</button>
                                </li>
                            </ol>
                        </fieldset>
                    </form>
                    <a href="#" id="closeEditHorse">Close Window</a>
                </div><!-- End edit Horse -->
                <div id="webInfo">
                    <h3>Add / Edit - Race Info</h3>
                    <form id="frmWebInfo">
                        <fieldset>
                            <ol>
                                <li class="hiddenTd">
                                    <label for=webInfo_rId>Race Id</label>
                                    <input id=webInfo_rId name=webInfo_rId type=text placeholder="" readonly="readonly" />
                                </li>
                                <li>
                                    <label for=prize>Prize</label>
                                    <input id="prize" name="prize" type=text placeholder="" autocomplete="off" />
                                </li>
                                <li>
                                    <label for=aTitle_en>Analysis Title</label>
                                    <input id="aTitle_en" name="aTitle_en" type=text placeholder="Analysis Title - En" width="500" autocomplete="off" />
                                </li>
                                <li>
                                    <label for=aText_en>Analysis Text</label>
                                    <textarea id="aText_en" name="aText_en" placeholder="Race preview english" cols="35" rows="10"></textarea>
                                </li><br/>
                                <hr/><br/>
                                <li>
                                    <label for=aTitle_fr>Titre D'analyse</label>
                                    <input id="aTitle_fr" name="aTitle_fr" type=text placeholder="Titre D'analyse - Fr" width="500" autocomplete="off" />
                                </li>
                                <li>
                                    <label for=aText_fr>Texte D'analyse</label>
                                    <textarea id="aText_fr" name="aText_fr" placeholder="Race preview french" cols="35" rows="10"></textarea>
                                </li><br/>
                                <hr/><br/>
                                <li>
                                    <label for=cGears>Changed Gears</label>
                                    <textarea id="cGears" name="cGears" placeholder="Changed Gears Horses" cols="35" rows="5"></textarea>
                                </li><br/>
                                <hr/><br/>
                                <li>
                                    <label for=sRep>Steward Report</label>
                                    <textarea id="sRep" name="sRep" placeholder="Steward Report" cols="35" rows="10"></textarea>
                                </li>
                                <li>
                                    <label>&nbsp;</label>
                                    <button type=submit name="saveWebInfo" id="saveWebInfo" value="saveWebInfo">Save</button>
                                </li>
                            </ol>
                        </fieldset>
                    </form>
                    <br/><a href="#" id="closeWebInfo">Close Window</a>
                </div><!-- End Web Info -->
            </div>
        </div>
    </body>
</html>
