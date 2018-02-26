<?php require "include/header.php"; ?>

<?php
	
// Ensure user is not already signed in. 
	$username = 	$_SESSION['username'];
	$employeeid  = $_SESSION['employeeid'];
	$displayname = $_SESSION['displayname'];
	$ipaddr       = $_SERVER['REMOTE_ADDR'];

if(!isset($username)){
   error_log("User already logged in: " . $_SESSION['displayname'] . " " . $_SESSION['employeeid'] . " - " . $ipaddr, 0);
   header("location:exit.php");
   die;
   }
	
// Logged who looked up a device and what they looked up.
    dalog($username,'EXIT','daModule','exit.php');
	
// destroy user session
   @ldap_close($ldap);
   session_unset();
   session_destroy(); 

?>


<div class="w3-container w3-card-4 w3-padding-large">
<center><h2>Thank You</h2></center>
<center><h2>for using the</h2></center>
<center><h2>Online Device Agreement system</h2></center>
<center><h1>You are Done.</h1></center>

<hr>
<center>	
	  <div>
			<a href="index.php" class="w3-btn-block w3-blue w3-border w3-round-large" name="relogin">Return to Device Agreement Login</a><p>
	  </div>
 </center>
</div>



<?php 
    require "include/footer.php";
    exit;
?>