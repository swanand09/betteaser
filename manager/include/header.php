<?php session_start(); ?>
<span class="header1" style="float:left; padding: 5px; font-weight: bold; font-size: 14px;">BetTeaser Ltd</span>
<div style="float:right;width:200px; text-align:right; padding: 5px;" >
<?php echo 'Welcome '.$_SESSION['adminUsn'];?>&nbsp;&nbsp;|&nbsp;&nbsp;
<a href="login.php?action=loggedout">Logout</a></div>
<div style="clear:both"></div>
<hr />