<?php require "include/header.php"; ?>
  
<style>
input[type=text] {
    padding: 12px 20px;
	background-color: lightyellow;
    margin: 8px 0;
    box-sizing: border-box;
	border-radius: 4px;
    }
select {
  font-size: 20px;
}
</style>


<?php
	$av_num = $serial_num = $manufacturer = $model = $model_num = $description = $serial_num_da = $employeeid_da = $av_num_da = $status = $cid_school = $posttext = NULL;
	$employeeid  = $_SESSION['employeeid'];
	$displayname = $_SESSION['displayname'];
	$ipaddr      = $_SERVER['REMOTE_ADDR'];
	$_SESSION['selectlocation'] = NULL;
	
// Ensure user is not already signed in. 
	$username = 	$_SESSION['username']; 

if(!isset($username)){
   error_log("User already logged in: " . $_SESSION['displayname'] . " " . $_SESSION['employeeid'] . " - " . $ipaddr, 0);
   header("location:exit.php");
   die;
   }
   
// Lookup CID Locations
	$sql = "select school_abbreviation, school_name from locations order by school_name";

	$result = mysqli_query($conn, $sql)
				or die ("Could not execute select query. Page selectlocation.php. 001");

	if (!$result) {
			 echo "DB Error, could not query the database. Page selectlocation.php. 001";
			 echo "MySQL Error: " . mysqli_error();
			 exit;
		}   
   

?>

<div class="w3-container w3-card-4 w3-padding-large">

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" class="w3-container w3-card-4 w3-padding-large">
	<fieldset>
	   <div class="container">
		<legend><h4 class="w3-text-red">To START, Please Select your assigned location... </h4></legend>
  
          <ul>
		    <li>If you know your Home School, select that school.
			<li>If you split your time between multiple locations, select one of those locations.
			<li>If you are an itinerate employee, select the location of the office you report to.
		</ul>
  
        <?php 
		if(!isset($_POST['selfselectlocation'])) {
         ?> 
            <select name="selfselectlocation" id="selectlocation" onchange="this.form.submit()">
			       <option selected disabled value="">Select Location</option>
		<?php
//		if(!isset($_POST['selfselectlocation'])) {
				// Select Dropdown
				while ($row = mysqli_fetch_array($result)) {
				       echo "<H1><option value='" .$row['school_abbreviation']. "'>" .$row['school_name']. "</option> </H1>";
				}	   
		} else{		
		?>
			</select>

		 <?php
			
			if(isset($_POST['selfselectlocation'])) {
//				    echo "selfselectlocation: " . $_POST['selfselectlocation'];
					$_SESSION['selectlocation'] = $selfselectlocation = $_POST['selfselectlocation'];
			} 
		}	
			"<br>";
			echo "<b class=\"w3-text-red\" style=\"font-size: 16pt\">    Location: " . $_SESSION['selectlocation']. "</b><p><p>";
			
			dalog($username,'Select Location','daModule','selectlocation.php',$selfselectlocation . $ipaddr);
		?>
		</div>	
		

        
		<div class="w3-container w3-card-4 w3-padding-large">		
		    <a href="exit.php" name="exit" class="w3-btn w3-blue w3-border w3-round-large" >Exit</a>
		    <a href="selectlocation.php" name="selectlocation" class="w3-btn w3-blue w3-border w3-round-large" >Select Location Again</a>
		    <a href="devicelookup.php" name="devicelookup" class="w3-btn w3-blue w3-border w3-round-large">Next Page</a>

		</div>

	</fieldset>
</form>

<?php require "include/footer.php"; ?>