<?php require "include/header.php"; ?>
<?php require('include/fpdf.php'); ?>

<?php

$return = NULL;

	$employeeid  = $_SESSION['employeeid'];
	$displayname = $_SESSION['displayname'];
	$av_num      = $_SESSION['av_num'];
	$ipaddr       = $_SERVER['REMOTE_ADDR'];
	
// Ensure user is not already signed in. 
$username    = $_SESSION['username'];
	
if(!isset($username)){
   error_log("User already logged in: " . $_SESSION['displayname'] . " " . $_SESSION['employeeid'] . " - " . $ipaddr, 0);
   header("location:exit.php");
   die;
   }
 
// Call function to create PDF of device agreement.  Agreement is copied to subdirectory "pdf" and also copied to "/mnt/dpm4/cid" to archive off the CID server. 

createdeviceagreement();

// Write device agreement filename to deviceagreement table
	
$filename    = $_SESSION['filename'];
	
$sql = "update deviceagreements set filename = '$filename' where av_num = '$av_num'";

$result = mysqli_query($conn, $sql)
			or die ("Could not execute second update query. Page agreements.php. 009");
			
if (!$result) {
    echo "DB Error, could not perform second update of the Inventory database. Page agreements.php. 010";
    echo "MySQL Error: " . (mysqli_error());
	error_log("DB Error, could not perform second update of the Inventory database. Page agreements.php. 010", 0);
    exit;
}	

	// Logged who looked up a device and what they looked up.
    dalog($username,'Create','daModule',$filename);
?>

<center><h3>If you need to create an additional Device Agreement under YOUR name, click the button below.</h3></center>

	<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" class="w3-container w3-card-4 w3-padding-large">
		  <div>
			<a href="<?php echo "pdf/" . $_SESSION['filename']; ?>" class="w3-btn-block w3-purple w3-border w3-round-large" name="downloadcopy" download="<?php echo "pdf/" . $_SESSION['filename']; ?>">Download and Save a Copy of this Device Agreement</a><p>
		  </div>
		  <div>		
			<a href="devicelookup.php" class="w3-btn-block w3-blue w3-border w3-round-large" name="lookupanother">Create Another Device Agreement</a><p>
		  </div>
		  <div>
			<a href="displayuseragreements.php" class="w3-btn-block w3-blue w3-border w3-round-large" name="previousagreements">Display Previous Device Agreements</a><p>
		  </div>
		  <div>
			<a href="index.php" class="w3-btn-block w3-blue w3-border w3-round-large" name="relogin">EXIT, Login to Device Agreement application as Different User</a><p>
		  </div>
	</form>	
<br>
</div>

<?php require "include/footer.php"; ?>