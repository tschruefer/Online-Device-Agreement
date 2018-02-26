<?php require "include/header.php"; ?>

<?php

// Initialize php variables

	$id = $displayname = $av_num = $serial_num = $ipaddr = $txid = $confirmby = $comfirmdate = $refnum = $to_loc = $from_loc = $manufacturer = $model = $model_num = $description = $date = $mail = $location = $employeeid = $name = $sn = $givenname = $status  = $jobdescription = $dae_status = $dae_employeeid = $dae_mail = NULL;

// Move session variables into php variables

$username     = mysqli_real_escape_string($conn, $_SESSION['username']);
$displayname  = mysqli_real_escape_string($conn, $_SESSION['displayname']);
$av_num       = mysqli_real_escape_string($conn, $_SESSION['av_num']);
$date         = $_SESSION['date'] = $today = date("Y-m-d");
// $date         = date('Y-m-d');
$time         = date('h:i:s');
$serial_num   = mysqli_real_escape_string($conn, $_SESSION['serial_num']);
$manufacturer = mysqli_real_escape_string($conn, $_SESSION['manufacturer']);
$model        = mysqli_real_escape_string($conn, $_SESSION['model']);
$model_num    = mysqli_real_escape_string($conn, $_SESSION['model_num']);
$description  = mysqli_real_escape_string($conn, $_SESSION['description']);
$givenname    = mysqli_real_escape_string($conn, $_SESSION['givenname']);       // first name
$sn           = mysqli_real_escape_string($conn, $_SESSION['sn']);              // last name 
$name         = $givenname . " " . $sn;
$employeeid   = $_SESSION['employeeid'];
$mail         = mysqli_real_escape_string($conn, $_SESSION['mail']);
// $location     = mysqli_real_escape_string($conn, $_SESSION['selectlocation']);
$location     = $_SESSION['selectlocation'];
$ipaddr       = $_SERVER['REMOTE_ADDR'];
$jobdescription = mysqli_real_escape_string($conn, $_SESSION['jobdescription']);
// $id           = $_SESSION['id'];
$av_num_chk     = NULL; 
// $cid_id			= NULL;
$detail         = NULL; 
$comment        = NULL;
$cid_fkrecid    = $_SESSION['cid_id'];
// $from_loc       = $_SESSION['school'];
$txid           = NULL;
$confirmdate    = NULL;
$refnum         = NULL;
$confirmby      = NULL; 

// mysqli_free_result($result);

//////////////////////////////////
// Check to see if Device Agreement already exists for this equipment. If a prior Device Agreement exists, make it "Inactive".
//////////////////////////////////

$sql = "select av_num from deviceagreements where serial_num = '$serial_num' or av_num = '$av_num'";

$result = mysqli_query($conn, $sql)
			or die ("Could not execute select query. Page agreements.php. 001");
			
if (!$result) {
    echo "DB Error, could not select from the deviceagreement table. Page agreements.php. 002";
    echo "MySQL Error: " . (mysqli_error());
	error_log("DB Error, could not select from the deviceagreement table. Page agreements.php. 002", 0);
    exit;
}

while ($row = mysqli_fetch_array($result)) {
	$av_num_chk=$row['av_num'];
}

if ($av_num_chk == $av_num) {
	$sql = "update deviceagreements set status = 'Inactive' where serial_num = '$serial_num' or av_num = '$av_num'";

$result = mysqli_query($conn, $sql)
			or die ("Could not execute update of status. Page agreements.php. 003");
			
if (!$result) {
    echo "DB Error, could not perform update of the DeviceAgreements table. Page agreements.php. 004";
    echo "MySQL Error: " . (mysqli_error());
	error_log("DB Error, could not perform update of the DeviceAgreements table. Page agreements.php. 004", 0);
    exit;
    }
}

///////////////////////////
// INSERT Inventory database, deviceagreements table with user and device information, only after user agrees to terms and conditions on device agreement
///////////////////////////
				
$sql = "insert into deviceagreements (status, 
									  cid_fkrecid,
                                      av_num, 
									  serial_num, 
									  manufacturer, 
									  model, 
									  model_num, 
									  description, 
									  displayname, 
									  givenname, 
									  sn, 
									  employeeid, 
									  mail, 
									  location, 
									  iagree, 
									  date_issued, 
									  agreement_version,
									  ipaddr)
                             values ('Active',	
									  '$cid_fkrecid',		
						              '$av_num',
									  '$serial_num', 
									  '$manufacturer',
									  '$model', 
									  '$model_num', 
									  '$description', 
									  '$displayname', 
									  '$givenname', 
									  '$sn', 
							     	  '$employeeid', 
							 		  '$mail', 
									  '$location', 
									  'Y', 
									  '$date', 
									  '20160113 - OPS-TEC-BMGT-008',
									  '$ipaddr')";
// echo $sql;
									  
$result = mysqli_query($conn, $sql)
          or die ("Could not execute sql insert query. Page agreements.php. 005" . mysqli_error($conn));
			
if (!$result) {
    echo "DB Error, could not insert the Inventory database, DeviceAgreements table. Page agreements.php. 006-1";
    echo "MySQL Error: " . (mysqli_error($conn));
	error_log("DB Error, could not insert the Inventory database, DeviceAgreements table. Page agreements.php. 006-2", 0);
    exit;	
}
	
/////////////////////	
// Update Inventory database, deviceagreements table with asset_value and previous user assigned_to at time of agreement.
/////////////////////

// $sql = "select asset_value, assigned_to, date_acquired, school from inventory where id = '$cid_fkrec'";
$sql = "select asset_value, assigned_to, date_acquired, school from inventory where id = '$cid_fkrecid'";

$result = mysqli_query($conn, $sql)
			or die ("Could not execute select query. Page agreements.php. 007");
			
if (!$result) {
    echo "DB Error, could not update the Inventory database. Page agreements.php. 008";
    echo "MySQL Error: " . (mysqli_error());
	error_log("DB Error, could not update the Inventory database. Page agreements.php. 008", 0);
    exit;
}	
while ($row = mysqli_fetch_array($result)) {
	$asset_value=$row['asset_value'];
	$assigned_to=$row['assigned_to'];
	$cid_school=$row['school'];
	$date_acquired=$row['date_acquired'];
}	
	
//$sql = "update deviceagreements set asset_value = '$asset_value', cid_assigned_to = '$assigned_to', cid_date_acquired = '$date_acquired', cid_school = '$cid_school'
//                                   where av_num = '$av_num' or serial_num = '$serial_num'";
	
$sql = "update deviceagreements set asset_value = '$asset_value', 
                                cid_assigned_to = '$assigned_to', 
							  cid_date_acquired = '$date_acquired', 
							         cid_school = '$cid_school'
                              where cid_fkrecid = '$cid_fkrecid'";

$result = mysqli_query($conn, $sql)
			or die ("Could not execute second update query. Page agreements.php. 009");
			
if (!$result) {
    echo "DB Error, could not perform second update of the Inventory database. Page agreements.php. 010";
    echo "MySQL Error: " . (mysqli_error());
	error_log("DB Error, could not perform second update of the Inventory database. Page agreements.php. 010", 0);
    exit;
}
	
////////////////////////
// Update Inventory database, Inventory table with new users name in assign_to and acquired_date fields.
////////////////////////

$sql = "update inventory set        status = 'Active',
                              primary_user = 'Teacher',
							   assigned_to = '$name',
                                      invT = '$jobdescription',
                                employeeid = '$employeeid',
						     date_modified = '$date',
							 time_modified = '$time',
						   method_modified = 'auto',
						  last_edit_userid = 'damodule',
						     last_inv_date = '$date',
						       last_inv_by = 'damodule'
					              where id = '$cid_fkrecid'";
							 
$result = mysqli_query($conn, $sql)
		or die ("Could not execute update query.011");
			
if (!$result) {
    echo "DB Error, could not update the Inventory database. Page agreements.php. 012";
    echo "MySQL Error: " . (mysqli_error());
	error_log("DB Error, could not update the Inventory database. Page agreements.php. 012", 0);
}	

//mysqli_free_result($result);

// Get an items current status and school

//    $sql = "select status, school from inventory where av_num = '$av_num' or serial_num = '$serial_num'";
      $sql = "select status, school from inventory where id = '$cid_fkrecid'";


    $result = mysqli_query($conn, $sql)
	     	or die ("Please enter a valid Inventory Tag or Serial Number. Page devicelookup.php.013");
	
    if (!$result) {
         echo "DB Error, could not query the database. Page devicelookup.php.014";
         echo "MySQL Error: " . mysqli_error();
         exit;
    }
	
	while ($row = mysqli_fetch_array($result)) {
	      $status=$row['status'];
		  $cid_school=$row['school'];
    }	
	
// ///////////////////////////////////////////////////////////////////////////////////////////////////
// Routine inserts "Pending" record into transfer table
// Translate locations from standard hcpss location abbreviations to long form.
// ///////////////////////////////////////////////////////////////////////////////////////////////////

	switch ($location) {
		case "Ascend One Center":
		 $to_loc = "AOC";
		 break;
		case "Atholton Elementary School":
		 $to_loc = "AES";
		 break;
		case "Atholton High School":
		 $to_loc = "AHS";
		 break;		 
		case "Applications and Research Lab":
		 $to_loc = "ARL";
		 break;
		case "Bellows Spring Elementary School":
		 $to_loc = "BSES";
		 break;
		case "Bollman Bridge Elementary School":
		 $to_loc = "BBES";
		 break;		 
		case "Bonnie Branch Middle School":
		 $to_loc = "BBMS";
		 break;
		case "Bryant Woods Elementary School":
		 $to_loc = "BWES";
		 break;
		case "Burleigh Manor Middle School":
		 $to_loc = "BMMS";
		 break;
		case "Bushy Park Elementary School":
		 $to_loc = "BPES";
		 break;
		case "Cedar Lane School":
		 $to_loc = "CLS";
		 break;
		case "Clarksville Elementary School":
		 $to_loc = "CES";
		 break;
		case "Clarksville Middle School":
		 $to_loc = "CMS";
		 break;
		case "Clemens Crossing Elementary School":
		 $to_loc = "CCES";
		 break;
		case "Cradlerock Elementary School":
		 $to_loc = "CRES";
		 break;		 
        case "Centennial High School":
		 $to_loc = "CHS";
         break;
        case "Centennial Lane Elementary School":
		 $to_loc = "CLES";
         break;		 
		case "Central Office":
		case "CENTRAL OFFICE":
		 $to_loc = "CO";
		 break;		 
		case "CUSTODIAL//MAINTENANCE//GROUNDS":
		 $to_loc = "RRGNDS";
		 break;
		case "Dayton Oaks Elementary School":
		 $to_loc = "DOES";
		 break;
		case "Deep Run Elementary School":
		 $to_loc = "DRES";
		 break;
		case "Ducketts Lane Elementary School":
		 $to_loc = "DLES";
		 break;
		case "Dunloggin Middle School":
		 $to_loc = "DMS";
		 break;
		case "Dorsey Building":
		 $to_loc = "DB";
		 break;		 
		case "Elkridge Landing Middle School":
		 $to_loc = "ELMS";
		 break;
		case "Ellicott Mills Middle School":
		 $to_loc = "EMMS";
		 break;
		case "Elkridge Elementary School":
		 $to_loc = "EES";
		 break;	
		case "Folly Quarter Middle School":
		 $to_loc = "FQMS";
		 break;		 
		case "Forest Ridge Elementary School":
		 $to_loc = "FRES";
		 break;
		case "Fulton Elementary School":
		 $to_loc = "FES";
		 break;
		case "Glenelg High School":
		 $to_loc = "GHS";
		 break;
		case "Glenwood Middle School":
		 $to_loc = "GMS";
		 break;		 
		case "Gorman Crossing Elementary School":
		 $to_loc = "GCES";
		 break;
		case "Guilford Elementary School":
		 $to_loc = "GES";
		 break;		 
		case "Hammond Elementary School":
		 $to_loc = "HES";
		 break;		 
		case "Hammond High School":
		 $to_loc = "HAHS";
		 break;		 
		case "Hammond Middle School":
		 $to_loc = "HMS";
		 break;		 
		case "Harper's Choice Middle School":
		 $to_loc = "HCMS";
		 break;		 
		case "Hollifield Station Elementary School":
		 $to_loc = "HSES";
		 break;		 
		case "Homewood School":
		 $to_loc = "HS";
		 break;		 
		case "Howard High School":
		 $to_loc = "HOHS";
		 break;		 
		case "Ilchester Elementary School":
		 $to_loc = "IES";
		 break;	
		case "Jeffers Hill Elementary School":
		 $to_loc = "JHES";
		 break;		 
		case "Lake Elkhorn Middle School":
		 $to_loc = "LEMS";
		 break;		 
		case "Laurel Woods Elementary School":
		 $to_loc = "LWES";
		 break;		 
		case "Lime Kiln Middle School":
		 $to_loc = "LKMS";
		 break;		 
		case "Lisbon Elementary School":
		 $to_loc = "LES";
		 break;	
		case "Logistics Center":
		 $to_loc = "LC";
		 break; 
		case "Long Reach High School":
		 $to_loc = "LRHS";
		 break;		 
		case "Longfellow Elementary School":
		 $to_loc = "LFES";
		 break;
		case "Manor Woods Elementary School":
		 $to_loc = "MWES";
		 break;		 
		case "Marriotts Ridge High School":
		 $to_loc = "MRHS";
		 break;
		case "Mayfield Woods Middle School":
		 $to_loc = "MWMS";
		 break;
		case "Mount View Middle School":
		 $to_loc = "MVMS";
		 break;
		case "Mt. Hebron High School":
		 $to_loc = "MHHS";		 
		 break;
		case "Murray Hill Middle School":
		 $to_loc = "MHMS";		 
		 break;		 
		case "Northfield Elementary School":
		 $to_loc = "NES";		 
		 break;		 
		case "Oakland Mills High School":
		 $to_loc = "OMHS";		 
		 break;		 
        case "Oakland Mills Middle School":
		 $to_loc = "OMMS";		 
		 break;		 
		case "Old Cedar Lane":
		 $to_loc = "OCL";		 
		 break;		 
		case "Patapsco Middle School":
		 $to_loc = "PMS";		 
		 break;		 
		case "Patuxent Valley Middle School":
		 $to_loc = "PVMS";		 
		 break;		 
		case "Phelps Luck Elementary School":
		 $to_loc = "PLES";		 
		 break;		 
		case "Pointers Run Elementary School":
		 $to_loc = "PRES";		 
		 break;		 
		case "Reservoir High School":
		 $to_loc = "REHS";		 
		 break;		 
		case "River Hill High School":
		 $to_loc = "RHHS";		 
		 break;		 
		case "Rockburn Elementary School":
		 $to_loc = "RES";		 
		 break;	
		case "Running Brook Elementary School":
		 $to_loc = "RBES";		 
		 break;		 
		case "St. John's Lane Elementary School":
		 $to_loc = "SJLES";		 
		 break;		
		case "Stevens Forest Elementary School":
		 $to_loc = "SFES";		 
		 break;
		case "Swansfield Elementary School":
		 $to_loc = "SES";		 
		 break;		 
		case "Talbott Springs Elementary School":
		 $to_loc = "TSES";		 
		 break;
		case "Thomas Viaduct Middle School":
		 $to_loc = "TVMS";		 
		 break;		 
		case "Thunder Hill Elementary School":
		 $to_loc = "THES";		 
		 break;		 
		case "Tridelphia Ridge Elementary School":
		 $to_loc = "TRES";		 
		 break;		 
	    case "Veterans Elementary School":
		 $to_loc = "VES";		 
		 break;		 
		case "Waterloo Elementary School":
		 $to_loc = "WATES";		 
		 break;		 
		case "Waverly Elementary School":
		 $to_loc = "WAVES";		 
		 break;		 
	    case "West Friendship Elementary School":
		 $to_loc = "WFES";		 
		 break; 
		case "Wilde Lake High School":
		 $to_loc = "WLHS";		 
		 break;		 
		case "Wilde Lake Middle School":
		 $to_loc = "WLMS";		 
		 break;		 
	    case "Worthington Elementary School":
		 $to_loc = "WOES";		 
		 break;
	    case "SUB*":
		 $to_loc = "Sub Central";		 
		 break;
		case " ":
		 $to_loc = "CO";		 
		 break;
		default: 
		 $to_loc = "CO";
		 break;
	}

	$to_loc = $location;
	
//  Build field for insert command
 $txid = $to_loc . "_" . $av_num . "_" . $serial_num;	
 

/////////////////////////////////////////
//  Check Transfer table to ensure device is not already in Transfer status.
/////////////////////////////////////////

$sql = "select avnum from transfers where avnum = '$av_num'";

	$result = mysqli_query($conn, $sql)
				or die ("Could not execute select query. Page agreements.php. 024");
				
	if (!$result) {
		echo "DB Error, could not query Transfers table. Page agreements.php. 024";
		echo "MySQL Error: " . (mysqli_error());
		error_log("DB Error, could not update the deviceagreement_emails database. Page agreements.php. 024", 0);
		exit;
	}	
	
	$rowsreturned = mysql_num_rows($result);


// Insert record into Transfer table

if ($cid_school != $to_loc) {
		$comment = 'Transfer initiated by user, ' . $displayname . ' upon completion of an Online Device Agreement.';

		$sql = "insert into transfers (avnum,
										from_loc,
										to_loc,
										submitter,
										status,
										comment,
										confirmby,
										confirmdate,
										reason,
										datein,
										rowid,
										manufacturer,
										model,
										model_num,
										`desc`,
										txid,
										refnum)
								values ('$av_num',
										'$cid_school',
										'$to_loc',
										'damodule',
										'pending',
										'$comment',
										' ',
										 NULL,
										'transfer',
										'$date',
										'$cid_fkrecid',
										'$manufacturer',
										'$model',
										'$model_num',
										'$description',
										'$txid',
										 NULL)";

		// echo $sql;
											  
		$result = mysqli_query($conn, $sql)
					or die ("Could not execute insert query. Inventory database, Transfers table. Page agreements.php. 015");
					
		if (!$result) {
			echo "DB Error, could not insert the Inventory database, Transfers table. Page agreements.php. 016";
			echo "MySQL Error: " . (mysqli_error());
			error_log("DB Error, could not insert the Inventory database, Transfers table. Page agreements.php. 017", 0);
			exit;	
		}	
}

/////////////////////////////////////////
//  Update deviceagreement_emails table to stop the system from nagging users to complete their device agreements.
/////////////////////////////////////////

$sql = "select status, employeeid from deviceagreement_emails where employeeid = '$employeeid' or mail = '$mail'";

$result = mysqli_query($conn, $sql)
			or die ("Could not execute select query. Page agreements.php. 018");
			
if (!$result) {
    echo "DB Error, could not update the deviceagreement_emails database. Page agreements.php. 019";
    echo "MySQL Error: " . (mysqli_error());
	error_log("DB Error, could not update the deviceagreement_emails database. Page agreements.php. 019", 0);
    exit;
}	
while ($row = mysqli_fetch_array($result)) {
	$dae_status=$row['status'];
	$dae_employeeid=$row['employeeid'];
	$dae_mail=$row['mail'];
}	

// Turn off nagging emails
if (!empty($dae_status)) {
	$sql = "update deviceagreement_emails set status = 'Completed' where (employeeid = '$dae_employeeid' or mail = '$dae_mail') and status = 'Pending'";

	$result = mysqli_query($conn, $sql)
				or die ("Could not execute update query. Inventory database, deviceagreement_emails table. Page agreements.php. 020");

	if (!$result) {
	   echo "DB Error, could not update the Inventory database, deviceagreement_emails table. Page agreements.php. 021";
	    echo "MySQL Error: " . (mysqli_error());
		error_log("DB Error, could not update the Inventory database, deviceagreement_emails table. Page agreements.php. 021", 0);
	    exit;	
	}	
}	
	
// //////////////////////////////////////  
// Insert record into Auditlog table  //
// //////////////////////////////////////
	
$detail = 	'User ' .$username. ' inserted item: ' . $av_num . ' into device agreement table';
	
	$sql = "insert into auditlog (date,
								time,
								userid,
								ipaddr,
								action,
								detail,
								app,
								cidrec,
								school,
								av_num,
								serial_num,
								status)
						values ('$date',
								'$time',
								'damodule',
								'$ipaddr',
								'insert',
								'$detail',
								'daModule',
								'$cid_fkrecid',
								'$to_loc',
								'$av_num',
								'$serial_num',
								'$status')";
// echo $sql;
						  
$result = mysqli_query($conn, $sql)
			or die ("Could not execute insert query. Page agreements.php. 022");
			
if (!$result) {
    echo "DB Error, could not update the Inventory database, Auditlog table. Page agreements.php. 023";
    echo "MySQL Error: " . (mysqli_error());
	error_log("DB Error, could not update the Inventory database, Auditlog table. Page agreements.php. 023", 0);
    exit;	
}
	
// Next page to generate a PDF of the Device Agreement

header('Location:goodbyeandthanksforallthefish.php');
?>