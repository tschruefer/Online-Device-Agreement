<?php require "include/header.php";

// Ensure user is not already signed in. 
	$av_num = $serial_num = $manufacturer = $model = $model_num = $description = $serial_num_da = $employeeid_da = $av_num_da = $status = NULL;
	
// Ensure user is not already signed in. 
	$ipaddr       = $_SERVER['REMOTE_ADDR'];
	$username = 	$_SESSION['username']; 
	$employeeid = $_SESSION['employeeid'];
	$displayname = $_SESSION['displayname'];
if(!isset($username)){
   error_log("User already logged in: " . $_SESSION['displayname'] . " " . $_SESSION['employeeid'] . " - " . $ipaddr, 0);
   header("location:exit.php");
   die;
   }
?>

<style>
div.scroll {
<!--		width: 1500px;  --> 
	height: 400px; 
	overflow: scroll;
}
</style>

<?php

	$check = $displayname = $av_num = $serial_num = $manufacturer = $model = $model_num = $description = $serial_num_da = $employeeid_da = $av_num_da = $status = $timestamp = $filename = NULL;
		
	$displayname =  $_SESSION['displayname'];
	$givenname =    $_SESSION['givenname'];
	$sn =           $_SESSION['sn'];
	$employeeid =   $_SESSION['employeeid'];
	$displayname =  $_SESSION['displayname'];
	$username = 	$_SESSION['username'];
//	$filename = 	$_SESSION['filename'];
	$pdf         = "pdf/";
		
$sql = "select status, av_num, serial_num, model, model_num, manufacturer, description, agreement_version, timestamp, filename from deviceagreements where status = 'Active' and employeeid = '$employeeid' order by status, timestamp desc, description asc";

$result = mysqli_query($conn, $sql)
			or die ("Could not execute select query. Page displayuseragreements.php. 001");

if (!$result) {
         echo "DB Error, could not query the database. Page displayuseragreements.php. 001";
         echo "MySQL Error: " . mysqli_error();
         exit;
    }
	
while ($row = mysqli_fetch_array($result)) {
	$av_num[]=$row['av_num'];
	$status[]=$row['status'];
	$serial_num[]=$row['serial_num'];
	$manufacturer[]=$row['manufacturer'];
	$model[]=$row['model'];
	$model_num[]=$row['model_num'];
	$description[]=$row['description'];
	$agreement_version[]=$row['agreement_version'];
	$timestamp[]=$row['timestamp'];
	$filename[]=$row['filename'];
	}
	
// If the user does not already have any device agreement records skip to the selectlocation.php page.
//if ($row == " ") {
//$check = array_filter($result);	
if (empty($status)) {
    header('Location:selectlocation.php');
    exit;
}	
?>
	
<div class="w3-container w3-card-4 w3-padding-large">

<h4>Hello, <u><b><?php echo " " . $_SESSION['givenname'] . ""?></b></u>, we currently have the following Device Agreements on file under your Employee Number <b><?php echo " " . $_SESSION['employeeid'] . "." ?></b></h4>
<ul>
<li>This system is intended for staff who have portable technology assigned to them to perform their job duties.
<li>You will need to complete a separate Device Agreement for each item assigned to you.
<li>You only need to complete this online form if you have one of the below types of devices assigned.
  <ul>
	<li>Laptop
	<li>Tablet
	<li>Smart Phone
  </ul>
</ul> 

<?php
  $rowcount=mysqli_num_rows($result);
  printf("You currently have %d Active Device Agreements on file.\n",$rowcount);	
  printf(" \n");
?>

<div>


<table class="w3-table-all w3-striped">
<tr class="w3-blue w3-small">
  <th>Download</th>
  <th>Date</th>
  <th>Inventory Number</th>
  <th>Serial Number</th>
  <th>Manufacturer</th>
  <th>Model</th>
  <th>Model Number</th>
  <th>Description</th>
  <th>Device Agreement Version</th>
</tr>

<?php
for ($x = 0; $x < $rowcount; $x++) { 
	echo "<tr class=\"w3-hover-green w3-tiny\" >";
	echo '<td> <a href="' . "pdf/" . $filename[$x] . '" class="w3-btn w3-blue w3-border w3-round-large" download=' . "pdf/" .  $filename[$x] . '>Download</a></td>';
	echo "<td>" .date('Y-m-d', strtotime($timestamp[$x])). "</td>";
//	echo "<td>" .$status[$x]. "</td>";  
	echo "<td>" .$av_num[$x]. "</td>";
	echo "<td>" .$serial_num[$x]. "</td>";
	echo "<td>" .$manufacturer[$x]. "</td>";
	echo "<td>" .$model[$x]. "</td>";
	echo "<td>" .$model_num[$x]. "</td>";
	echo "<td>" .$description[$x]. "</td>";
	echo "<td>" .$agreement_version[$x]. "</td>";
	echo "</tr>";
	}
?>

</table>

</div>

		<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" class="w3-container w3-card-4 w3-padding-large">
		    <fieldset>
			<legend><h5 class="w3-text-red">If you have questions or see an error, contact your Media Specialist or CID designee.</h5></legend>
		    <div class="container">
				<a href="exit.php" class="w3-btn w3-blue w3-border w3-round-large">Exit</a>
	            <a href="selectlocation.php" class="w3-btn w3-blue w3-border w3-round-large" name="relogin">Next Page - Create New Device Agreement</a>
            </div>
	    	</fieldset>
		</form>		

</div>
<?php require "include/footer.php"; ?>