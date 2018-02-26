<?
// connect to the CID Database
$id="LMS_agent";
// $db="LMSInventory";
$pw='Te55a.13317';
$db="LMS2Inventory";
$db="LMSTest";
$dbname=$db;

/**************
// connect to the Media CID Database
$id="root";
$pw="Halo.8466";
$db="inventory";
$dbname=$db;
**************/

$conn = mysql_connect('localhost', $id, $pw);
if (!$conn) 
{
	die('Could not connect: ' . mysql_error());
}
$tf= mysql_select_db($db, $conn);
if (!$tf) 
{
	die('Could not select DB: '.$db."<br>". mysql_error());
}

?>