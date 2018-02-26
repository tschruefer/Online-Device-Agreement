<?php require "include/header.php"; ?>
<div id="wrapper" class="w3-container">


<?php

	$username = $displayname = $av_num = $serial_num = $manufacturer = $model = $model_num = $description = $serial_num_da = $employeeid_da = $av_num_da = $status = $action = $app = NULL;
	
//	$employeeid = $_SESSION['employeeid'];
//	$displayname = $_SESSION['displayname'];
//	$_SESSION['username'] = $username;

//if(!isset($username)) {
//    error_log("User already logged in: " . $displayname . " " . $employeeid, 0);
//    header("location:exit.php");
//}

if(isset($_POST['username']) && isset($_POST['password'])){
	
// Ensure user is not already signed in. 
//$_SESSION['login'] = true;

// Setup AD login.
 		
    $adServer = "ldap://coadc01svde003.hcpss.org";
	
    $ldap = ldap_connect($adServer);
    $username = $_POST['username'];
    $password = $_POST['password'];

    $ldaprdn = 'hcpss' . "\\" . $username;

    ldap_set_option($ldap, LDAP_OPT_PROTOCOL_VERSION, 3);
    ldap_set_option($ldap, LDAP_OPT_REFERRALS, 0);

    $bind = @ldap_bind($ldap, $ldaprdn, $password);
	$_SESSION['user_agent'] = $_SERVER['HTTP_USER_AGENT'];


    if ($bind) {
			if ($_SESSION['user_agent'] != $_SERVER['HTTP_USER_AGENT'])
			{
			// Force user to log in again
			echo "<p><h4>Login failed, your web browser is not supported.</h4>";
			error_log("Login failed - " . $username, 0);
			exit;
			}
        $filter = "(sAMAccountName=$username)";
        $result = ldap_search($ldap,"dc=hcpss,dc=org",$filter);
        $info = ldap_get_entries($ldap, $result);
		
		for ($i=0; $i<$info["count"]; $i++)
        {
            if($info['count'] > 1)          // Limit program to only grab the first occurance
                break;

			$displayname = $_SESSION['displayname'] = $info[$i]["displayname"][0];
			$givenname   = $_SESSION['givenname'] = $info[$i]["givenname"][0];
			$sn          = $_SESSION['sn'] = $info[$i]["sn"][0];
			$employeeid  = $_SESSION['employeeid'] = $info[$i]["employeeid"][0];
			$mail        = $_SESSION['mail'] = $info[$i]["mail"][0];
			$description = $_SESSION['jobdescription'] = $info[$i]["description"][0];
//			$location    = $_SESSION['physicaldeliveryofficename'] = $info[$i]["physicaldeliveryofficename"][0];
			               $_SESSION['username'] = $username;
			               $_SESSION['date'] = $today = date("Y-m-d");
			$ipaddr      = $_SERVER['REMOTE_ADDR'];
            			
			//  Who just logged in?			
			//$app = 'daModule';
			//$action = 'Login';
	        dalog($username,'Login','daModule','index.php');
			
 		header('Location:displayuseragreements.php');
        }
        @ldap_close($ldap);
    } else {
		header('Location:index.php');
		echo "<h4 class=\"w3-red\">Invalid Password for Username: <b>" . $username . "</b></h4>";
		error_log("Invalid password for Username: " . $username, 0);
		exit;
    }

}else{
?>

    <div class="w3-container">

    <form class="w3-container w3-card-4 w3-padding-large" id="login" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
	  <fieldset>
	    <legend><h1>Device Agreement Login</h1></legend>
		<div>
        <label class="w3-label w3-text-blue" for="username" required>Username: </label>
		<input class="w3-input w3-border w3-round-large w3-light-grey" style="width:50%" id="username" type="text" name="username" placeholder="username" pattern="\_\.[A-Za-z0-9]+{5,25}" autofocus required maxlength="25" title="Same as your computer login"/>
        </div>
		<div>
		<p><label class="w3-label w3-text-blue" for="password" required>Password:  </label>
		<input class="w3-input w3-border w3-round-large w3-light-grey" style="width:50%" id="password" type="password" name="password" placeholder="password" pattern="\-\_\.\!\@\#\$\%\^\&\*\+\=[A-Za-z0-9]+{8,25}" required maxlength="20" title="Same as your computer or email password"/>
		</div>
		<div>
		<p><input class="w3-btn w3-blue w3-border w3-round-large"  style="width:30%" type="submit" name="submit" value="Login" /><br>
		</div>
		<p><p><p><p>
	  </fieldset>	
    </form>

	</div>
	
<br><br>
<h3>Use your Active Directory Username and Password to login to this system. You cannot create a Device Agreement for another staff member; each staff member must login separately.</h3>
<br>
<h3 class="w3-text-red">Difficulty using this application?  <a href="mailto:itam@hcpss.org?Subject=Device%20Agreement%20Trouble" target="_top">Send eMail to: itam@hcpss.org</a> or call the Technology Help Desk at x7004.</h3>
<br>
<h3>This system was developed in accordance with HCPSS Policy  <a href="http://www.hcpss.org/f/board/policies/3040.pdf" target="_blank">3040</a> and  <a href="http://www.hcpss.org/f/board/policies/8080.pdf" target="_blank">8080</a>.</h3>
<h3>Also see HCPSS <a href="http://www.hcpss.org/f/aboutus/purchasing/bids/approved/apple-contracts/ios-purchase-guidelines.pdf" target="_blank">iOS Device Purchase & User Guidlines</a>.</h3>

<?php

} 

?> 

</div>
<?php require 'include/index_footer.php'; ?>