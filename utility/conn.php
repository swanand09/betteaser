<?

include 'const.php';

$dbhost=DB_HOST;
$dbusername=DB_USN;
$dbpassword=DB_PWD;
$db=DB;
$con = mysql_connect($dbhost,$dbusername,$dbpassword);
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }
mysql_select_db($db);
?>
