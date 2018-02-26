<?php require "include/header.php"; ?>
  
<style>
input[type=text] {
    padding: 12px 20px;
	background-color: lightyellow;
    margin: 8px 0;
    box-sizing: border-box;
	border-radius: 4px;
    }
</style>


<?php
	$av_num = $serial_num = $manufacturer = $model = $model_num = $description = $serial_num_da = $employeeid_da = $av_num_da = $status = $cid_school = $posttext = NULL;
	$employeeid = $_SESSION['employeeid'];
	$displayname = $_SESSION['displayname'];
	$ipaddr       = $_SERVER['REMOTE_ADDR'];
	
// Ensure user is not already signed in. 
	$username = 	$_SESSION['username']; 

if(!isset($username)){
   error_log("User already logged in: " . $_SESSION['displayname'] . " " . $_SESSION['employeeid'] . " - " . $ipaddr, 0);
   header("location:exit.php");
   die;
   }
?>

<div class="w3-container w3-card-4 w3-padding-large">

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" class="w3-container w3-card-4 w3-padding-large">
    <fieldset>
		<legend>Enter Inventory Tag or Serial Number, usually found on the back or bottom of the device. To lookup a cell phone enter the phones number in e.g. 443.864.0000:</legend>
		<div style="float:left">
		<table>
		<tr>
		<td>
            <input type="text" class="w3-input w3-border w3-round-large w3-light-yellow"  required pattern="\.[A-Za-z0-9]+{5,12}" style="font-size: 18pt" name="text" name="avserialnumber" rows="1" cols="12" autofocus title="Inventory Tag is the silver label on a device, the Serial Number is usually found on the bottom or back of a device."/>
		</td>
		<td>
			<input type ="submit" value ="Lookup Device"  class="w3-btn-block w3-boarder w3-blue w3-round-large w3-xlarge w3-margin-left <?php if (!isset($employeeid) && !isset($displayname)){ ?> w3-disabled" <?php } ?> value ="Lookup Device">   <!-- w3-ripple w3-border -->
		</td>
		</tr>	
		</table>	
		</div>
    </fieldset>
</form>

<p>

<?php

// Lookup device in CID Inventory table

if (isset($_POST['text'])) {
	$posttext = trim($_POST['text']);
//	if (empty($_POST['text'])) {
    if (empty($posttext)) { 
	    echo "<h4>This Device is not Active in our Inventory, please select another Device or contact your Media Specialist.</h4>";
		dalog($username,'Lookup','daModule','devicelookup.php',$serial_num . '--' . $av_num . '--' . $ipaddr . 'Lookup valus is empty.');
	    header("location:devicelookup.php");		
	}
		
    $sql = "select id, status, av_num, serial_num, manufacturer, model, model_num, description, date_acquired, school from inventory 
	               where (status = 'Active' or status = 'In Stock' or status = 'Stock') and (av_num = '$_POST[text]' or serial_num = '$_POST[text]') and (description = 'Laptop' or description = 'Tablet' or description = 'Phone')";
//	echo $sql;
    $result = mysqli_query($conn, $sql)
	     	or die ("Please enter a valid Inventory Tag or Serial Number. Page devicelookup.php.013");
	
    if (!$result) {
         echo "DB Error, could not query the database. Page devicelookup.php.014";
         echo "MySQL Error: " . mysqli_error();
         exit;
    }
    
	if (mysqli_affected_rows($conn)==0) {
	    echo "<h4 class=\"w3-red\">Item must be an <b>Active</b> Laptop, Tablet or Smart Phone in our inventory.  Please contact your Media Specialist or Help Desk at x7004 if you are having a problem.</h4>";
	    dalog($username,'Lookup','daModule','devicelookup.php',$serial_num . '--' . $av_num . '--' . $ipaddr . 'Active, item not found.');
		error_log("Failed device lookup = " . $displayname . " " . $serial_num . " " . $av_num, 0);
	    "<p>";
    }
	
// Load session variables with data from inventory table	
	
	while ($row = mysqli_fetch_array($result)) {
	$_SESSION['cid_id']        = $cid_fkrecid=$row{'id'};
	$_SESSION['av_num']        = $av_num=$row['av_num'];
	$_SESSION['serial_num']    = $serial_num=$row['serial_num'];
	$_SESSION['status']        = $status=$row['status'];
	$_SESSION['manufacturer']  = $manufacturer=$row['manufacturer'];
    $_SESSION['model']         = $model=$row['model'];
    $_SESSION['model_num']     = $model_num=$row['model_num'];
	$_SESSION['description']   = $description=$row['description'];
	$_SESSION['date_acquired'] = $date_acquired=$row['date_acquired'];
	$_SESSION['school']        = $cid_school=$row['school'];
    }	
	
	// Logged who looked up a device and what they looked up.
    dalog($username,'Lookup','daModule',$_POST['text']);

	// echo $fk_cidrecid;
//   if ($av_num == NULL) {
//	    echo "<h4 class=\"w3-red\">This Device is not Active in our Inventory, please select another Device or contact your Media Specialist.</h4>";
//		dalog($username,'Lookup','daModule','devicelookup.php',$serial_num . '--' . $av_num . '--' . $ipaddr . 'This is not active in our inventory.');
//	    header("location:devicelookup.php");
//    }
}

// Display device information
    
//	echo "<br>";
	echo "<p><b>Date Issued:      </b> <span class=\"w3-text-red\">".$_SESSION['date']."</span>";
	echo "<p><b>Inventory #:      </b> <span class=\"w3-text-red\">".$av_num."</span>";
    echo "<p><b>Serial #:         </b> <span class=\"w3-text-red\">".$serial_num."</span>";
    echo "<p><b>Manufacturer:     </b> <span class=\"w3-text-red\">".$manufacturer."</span>";
	echo "<p><b>Model:            </b> <span class=\"w3-text-red\">".$model."</span>";
    echo "<p><b>Model Number:     </b> <span class=\"w3-text-red\">".$model_num."</span>";
	echo "<p><b>Description:      </b> <span class=\"w3-text-red\">".$description."</span>";
	echo "<p><b>Location:         </b> <span class=\"w3-text-red\">".$cid_school."</span>";
	
// Check deviceagreement table for prior agreements for this device and user.

	if (isset($_POST['text'])) {
       $sql = "select av_num, serial_num, employeeid from deviceagreements 
												  where (av_num = '$_POST[text]' or serial_num = '$_POST[text]') and employeeid = '$employeeid'";

		$result = mysqli_query($conn, $sql)
	     	or die ("Please enter a valid Inventory Tag or Serial Number. Page devicelookup.php.016");

		if (!$result) {
			error_log("Invalid query - " . $displayname, 0);
			echo "DB Error, could not query the DeviceAgreement table. Page devicelookup.php.017";
			echo "MySQL Error: " . mysqli_error();
			exit;
		}

		while ($row = mysqli_fetch_array($result)) {
			$av_num_da=$row['av_num'];
			$serial_num_da=$row['serial_num'];
			$employeeid_da=$row['employeeid']; 
		}

//    		echo "serial_num_da = " . $serial_num_da;
//			echo "av_num_da = " . $av_num_da;
        
		if (!is_null($av_num_da)){
			if ($serial_num_da == $serial_num || $av_num_da == $av_num || $employeeid_da == $employeeid) {
			echo "<h4 class=\"w3-red\">A Device Agreement already exists for this Device under your Employee ID.</h4>";
			}
	    }
	}
?>

		<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" class="w3-container w3-card-4 w3-padding-large">
		    <fieldset>
			<legend><h5 class="w3-text-red">Ensure this is the equipment you want to create a Device Agreement for, then click Next Page to continue.</h5></legend>
		    <div class="container" style="width:30%" >
				<a href="exit.php" class="w3-btn w3-blue w3-border w3-round-large">Exit</a>
				<input type="submit" value="Next Page" name="correctdevice" class="w3-btn w3-blue w3-border w3-round-large <?php if (!isset($av_num) || !isset($serial_num) && $status = "Active"){ ?> w3-disabled" <?php } ?> value="Next Page">
            </div>
	    	</fieldset>
		</form>				
</div>

<!-- style="width:30%" -->

<?php
	if (isset($_POST['correctdevice'])) {
		header('Location:displayagreement.php');
	}{
        dalog($username,'Lookup','daModule','devicelookup.php',$serial_num . '--' . $av_num . '--' . $ipaddr);
    }
?>
		
<?php require "include/footer.php"; ?>