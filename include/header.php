<!DOCTYPE html>
<html lang="en-US">
<head>
<link rel="stylesheet" href="css/w3.css">
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- 21feb18 - tcs - ref favicon.ico error in error_log -->
<link rel="shortcut icon" href="data:image/x-icon;," type="image/x-icon">
<!-- *** -->
<title>HCPSS Online Device Agreement</title>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<meta http-equiv="Pragma" content="no-cache" />
<meta http-equiv="Expires" content="-1" />
<meta http-equiv="Cache-Control" content="no-cache" />
</head>
<body>
<div id="header" class="w3-container">
<table class="w3-table w3-left-align" style="width:80%">
<tr>
<td>
<img border="0" src="images\HCPSSLogoWhite.png" alt="HCPSS Logo" >
</td>
<td class="w3-table w3-center">
<h1>Howard County Public Schools</h1>
<h2>Assigned Technology Device Agreement</h2>
</td>
</tr>
</table>
</div>
<?php
date_default_timezone_set("America/New_York");
require "include/conn.php";
require "include/functions.php";
sec_session_start();
// header("Expires: Fri, 1 Jan 2016 06:00:00 GMT");

?>

