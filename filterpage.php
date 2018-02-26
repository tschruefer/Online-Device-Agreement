<?php require "include/header.php"; ?>
<div id="wrapper" class="w3-container">

<?php
	$av_num = $serial_num = $manufacturer = $model = $model_num = $description = $serial_num_da = $employeeid_da = $av_num_da = $status = NULL;

	$ipaddr       = $_SERVER['REMOTE_ADDR'];
	$location     = $_SESSION['physicaldeliveryofficename'];
	
// Ensure user is not already signed in. 
	$username = 	$_SESSION['username']; 
	$employeeid = $_SESSION['employeeid'];
	$displayname = $_SESSION['displayname'];
	
if(!isset($username)){
   error_log("User already logged in: " . $_SESSION['displayname'] . " " . $_SESSION['employeeid'] . " - " . $ipaddr, 0);
   header("location:exit.php");
   die;
   }

// Log who got to this page.
    dalog($username,'FilterPage','daModule','filterpage.php');
?>

<div class="w3-container w3-card-4 w3-padding-large">

<h4>This system is intended for staff who have portable technology assigned to them to perform their job duties.  </h4>
<h5>You only need to complete this online form if you have one of the below types of devices assigned to you.</h5>

<ul>
	<li>Laptop
	<li>Tablet
	<li>Smart Phone
</ul> 

</div>
		<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" class="w3-container w3-card-4 w3-padding-large">
		    <fieldset>
			<legend><h5 class="w3-text-red">Click <b>EXIT</b> to logoff, otherwise Click <b>Next Page</b> to continue.</h5></legend>
		    <div class="container">
				<input type="submit" value="Exit" name="exitfilter" class="w3-btn w3-blue w3-border w3-round-large value="Exit">
	            <a href="displayuseragreements.php" class="w3-btn w3-blue w3-border w3-round-large" name="displayexisting">Next Page - View Existing Device Agreement</a>
            </div>
	    	</fieldset>
		</form>		
	
<?php	
// Did user press EXIT?
if (isset($_POST['exitfilter'])){
   filterpagelog($username,$displayname,$employeeid,$location);   // User ended session
   header("location:exit.php");
   die;
   }
?>
</div>
<?php require "include/footer.php"; ?>