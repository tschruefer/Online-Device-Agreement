<?php
// connect to the DeviceAgreement Database
//=============
$user="LMS_USER";
$pw='Sept@1911';
$db="CID_INVENTORY";

$dbname=$db;
$conn = mysqli_connect('localhost', $user, $pw, $db);
if (!$conn) 
{
	die('Could not connect: ' . mysqli_error($conn));
}
$tf= mysqli_select_db($conn, $db);
if (!$tf) 
{
	die('Could not select DB: '.$db."<br>". mysqli_error($conn));
}
$_SESSION['dbx_name'] =$dbname;

?>
