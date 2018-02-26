<?php require "include/header.php"; ?>
	
<style type="text/css">
input {
  input[type="checkbox"]:required:invalid + label { color: red; };
  input[type="checkbox"]:required:valid + label { color: green; };
  vertical-align:top;
}
p {
    text-indent: 50px;
}
h3 {
	display: block;
    text-align: center;
    color: red;
	font-family: Tahoma, Geneva, sans-serif;
    }
</style>

<?php
	$employeeid   = $_SESSION['employeeid'];
	$displayname  = $_SESSION['displayname'];
	$model        = $_SESSION['model'];
    $model_num    = $_SESSION['model_num'];
	$ipaddr       = $_SERVER['REMOTE_ADDR'];
	$cid_school   = $_SESSION['school'];
	
// Ensure user is not already signed in. 
	$username = 	$_SESSION['username'];
	
if(!isset($username)){
   error_log("User already logged in: " . $_SESSION['displayname'] . " " . $_SESSION['employeeid'] . " - " . $ipaddr, 0);
   header("location:exit.php");
   die;
   }

//
// This html form was created in this fashion because this same form must appear as both a html document and a pdf.  Keeping all the text in one place will hopefully 
//   make future changes to the Device Agreement document easier to impliment.
//

$_SESSION['line1'] = "Recipient Name: ";
$_SESSION['line2'] = "Date Issued: ";
$_SESSION['line3'] = "Manufacturer: ";
$_SESSION['line4'] = "Serial #: ";
$_SESSION['line5'] = "Employee ID#: ";
$_SESSION['line6'] = "Location: ";
$_SESSION['line7'] = "Description: ";
$_SESSION['line8'] = "Inventory #: ";

$_SESSION['line10'] = "This technology device is to be used in accordance with Howard County Public School System (HCPSS) Policy 8080 Responsible Use of Technology and Social Media and I have no expectation of personal privacy while using this device.";
$_SESSION['line11'] = "This device is issued to me (the recipient listed above) but will remain the property of the HCPSS.";
$_SESSION['line12'] = "If my employment with HCPSS ends, this device must be returned to my Supervisor or Designee.";
$_SESSION['line13'] = "If requested by my Supervisor or Designee, I will return this device.";
$_SESSION['line14'] = "I agree that this device is to be used exclusively by me, my students, and other HCPSS employees.";
$_SESSION['line15'] = "To protect this device from damage, I will store this device in a protective case when transporting.";
$_SESSION['line16'] = "I am responsible for the safe handling, storage, and security of this device.  I agree to take appropriate precautions to prevent damage, loss, or theft.";
$_SESSION['line17'] = "I will not leave this device unattended in plain view.";
$_SESSION['line18'] = "In the event that this device is damaged due to neglect and the damage is not covered under warranty, I agree to pay the cost of the repair or replacement not to exceed the equivalent replacement cost according the following depreciation schedule (e.g. for $1000 teacher laptop).";
$_SESSION['line191'] = "Year";
$_SESSION['line192'] = "% of Cost";
$_SESSION['line193'] = "Employee Pays (example)";
$_SESSION['line201'] = "1";
$_SESSION['line202'] = "75%";
$_SESSION['line203'] = "$1000  x  75%  =  $750";
$_SESSION['line211'] = "2";
$_SESSION['line212'] = "50%";
$_SESSION['line213'] = "$1000  x  50%  =  $500";
$_SESSION['line221'] = "3";
$_SESSION['line222'] = "25%";
$_SESSION['line223'] = "$1000  x  25%  =  $250";
$_SESSION['line231'] = "4 and beyond";
$_SESSION['line232'] = "5%";
$_SESSION['line233'] = "$1000  x   5%  =  $50";
$_SESSION['line24'] = "In the event that this device is lost or stolen, I agree to assign all insurance proceeds to the HCPSS.   If the insurance proceeds do not cover the cost of the device equivalent replacement cost according to the above depreciation schedule, I am responsible for paying the difference.";
$_SESSION['line25'] = "If this device is lost, stolen, or damaged, I will immediately notify my Supervisor or Designee.  The Supervisor or Designee will report the incident to the HCPSS Office of Safety, Environment, and Risk Management.";
$_SESSION['line26'] = "If this is an iOS device (e.g. iPad, iPhone) I agree to abide by the iOS Device Purchase and Use Guideline TD-ME-2012-10 which is posted on the Purchasing Office Web Site Approved Bid List for Apple Computers.";
?>

	<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" class="w3-container w3-card-4 w3-padding-large">
		  <div>		
			<a href="devicelookup.php" class="w3-btn-block w3-red w3-border w3-round-large" name="lookupanother">Not what you are looking for? Click Here to Lookup a Different Device</a><p>
		  </div>
	</form>
 
<div class="w3-container w3-padding-large">
<hr>
<h3>Please read all the Terms of this Agreement, then click "I Agree" at the bottom.</h3>

<center>
<table class="w3-table-all w3-card-4 w3-padding-large w3-bordered" style="width:80%">
<tr class="w3-hover-green">
    <td><b><?php echo $_SESSION['line1']; ?></b> <?php echo $_SESSION['displayname']; ?></td>
	<td><b><?php echo $_SESSION['line5']; ?></b> <?php echo $_SESSION['employeeid']; ?></td>
</tr>
<tr class="w3-hover-green">
	<td><b><?php echo $_SESSION['line2']; ?></b> <?php echo $_SESSION['date']; ?></td>
    <td><b><?php echo $_SESSION['line6']; ?></b> <?php if (empty($_SESSION['selectlocation'])) {echo $cid_school;}{echo $_SESSION['selectlocation'];}?></td>
</tr>
<tr class="w3-hover-green">
    <td><b><?php echo $_SESSION['line3']; ?></b> <?php echo $_SESSION['manufacturer']; ?></td> 
	<td><b><?php echo $_SESSION['line7']; ?></b> <?php echo $_SESSION['description'] . ", " . $model . ", " . $model_num; ?></td>
</tr>
<tr class="w3-hover-green">
    <td><b><?php echo $_SESSION['line4']; ?></b> <?php echo $_SESSION['serial_num']; ?></td> 
	<td><b><?php echo $_SESSION['line8']; ?></b> <?php echo $_SESSION['av_num']; ?></td>
</tr>
</table>
</center>
<p>
<form action="agreements.php" method="post" id="agreementID" class="w3-container w3-card-4">
<br><p>
<table class="w3-table-all w3-striped w3-bordered" style="width:100%">
<ul class="w3-ul w3-center" style="width:100%">
<p><tr class="w3-hover-green"><td><li></td><td>  <label class="w3-validate"><?php echo $_SESSION['line10'] ?></label></li></td></tr>
<p><tr class="w3-hover-green"><td><li></td> <td> <label class="w3-validate"><?php echo $_SESSION['line11'] ?></label><p></td></tr>
<p><tr class="w3-hover-green"><td><li></td> <td> <label class="w3-validate"><?php echo $_SESSION['line12'] ?></label><p></td></tr>
<p><tr class="w3-hover-green"><td><li></td> <td> <label class="w3-validate"><?php echo $_SESSION['line13'] ?></label><p></td></tr>
<p><tr class="w3-hover-green"><td><li></td> <td> <label class="w3-validate"><?php echo $_SESSION['line14'] ?></label><p></td></tr>
<p><tr class="w3-hover-green"><td><li></td> <td> <label class="w3-validate"><?php echo $_SESSION['line15'] ?></label><p></td></tr>
<p><tr class="w3-hover-green"><td><li></td> <td> <label class="w3-validate"><?php echo $_SESSION['line16'] ?></label><p></td></tr>
<p><tr class="w3-hover-green"><td><li></td> <td> <label class="w3-validate"><?php echo $_SESSION['line17'] ?></label><p></td></tr>
<p><tr class="w3-hover-green"><td><p><li></td> <td> <label class="w3-validate"><?php echo $_SESSION['line18'] ?></label><p></td></tr>
</table>
<p>
<table class="w3-table-all w3-centered" style="width:100%">
<tr>
   <th><?php echo $_SESSION['line191'] ?></th>	
   <th><?php echo $_SESSION['line192'] ?></th>	
   <th><?php echo $_SESSION['line193'] ?></th>
</tr>
<tr class="w3-hover-green">
   <td align="center"><?php echo $_SESSION['line201'] ?></td>	
   <td align="center"><?php echo $_SESSION['line202'] ?></td>	
   <td align="center"><?php echo $_SESSION['line203'] ?></td>
</tr>
<tr class="w3-hover-green">
   <td align="center"><?php echo $_SESSION['line211'] ?></td>	
   <td align="center"><?php echo $_SESSION['line212'] ?></td>	
   <td align="center"><?php echo $_SESSION['line213'] ?></td>
</tr>
<tr  class="w3-hover-green">
   <td align="center"><?php echo $_SESSION['line221'] ?></td>	
   <td align="center"><?php echo $_SESSION['line222'] ?></td>	
   <td align="center"><?php echo $_SESSION['line223'] ?></td>
</tr>
<tr class="w3-hover-green">
   <td align="center"><?php echo $_SESSION['line231'] ?></td>
   <td align="center"><?php echo $_SESSION['line232'] ?></td>	
   <td align="center"><?php echo $_SESSION['line233'] ?></td>
</tr>
</table>
<table class="w3-table-all w3-striped w3-bordered" style="width:100%">
<p><tr class="w3-hover-green"><td><li></td> <td><label class="w3-validate"><?php echo $_SESSION['line24'] ?></label><p></td></tr>
<p><tr class="w3-hover-green"><td><li></td> <td><label class="w3-validate"><?php echo $_SESSION['line25'] ?></label><p></td></tr>
<p><tr class="w3-hover-green"><td><li></td> <td><label class="w3-validate"><?php echo $_SESSION['line26'] ?></label><p></td></tr>
</table>

<!-- <p><p><br><input id="field_terms" class="w3-check w3-padding-large w3-bordered" type="checkbox" required name="termsandconditions">  -->
<br>
	<label for="field_terms" class="w3-validate"><h3 class="w3-text-red">By Clicking "I Agree", you are indicating your agreement to all the above <u>Terms and Conditions.</u></h3></label><br>
    <div class="w3-container w3-padding-large w3-bordered">
	<label for="field_terms"><?php echo " <u>" . $_SESSION['displayname'] . "</u> - "; ?>Signed by Active Directory Authentication.</u></label>
	<h6><label for="field_terms">Creation Date: <i><?php date_default_timezone_set("America/New_York"); echo date("l jS \of F Y H:i:s A"); ?><i></label><br><p></h6>
	    <div class="container">
			<a href="exit.php" class="w3-btn w3-blue w3-border w3-round-large w3-section w3-ripple">Exit</a>
			<input type="submit" class="w3-btn w3-blue w3-border w3-round-large w3-section w3-ripple" name="submit" value="I Agree to all Terms and Conditions"><p>
        </div>
   	</div>
</form>				
		
</div>		

<?php require "include/footer.php"; ?>