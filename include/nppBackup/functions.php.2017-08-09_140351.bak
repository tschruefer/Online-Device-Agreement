<!-- USER FUNCTIONS -->

<?php
function sec_session_start() {
session_start();
ini_set( 'session.use_only_cookies', TRUE );				
ini_set( 'session.cookie_lifetime', 1000 );   // Session expires in 10 minutes. 
session_regenerate_id(true);     // Change the session ID on every request
}

function sessiondata() {
			$displayname = $_SESSION['displayname'];
			$givenname   = $_SESSION['givenname'];
			$sn          = $_SESSION['sn'];
			$employeeid  = $_SESSION['employeeid'];
			$mail        = $_SESSION['mail'];
			$description = $_SESSION['jobdescription'];
			$location    = $_SESSION['selectlocation'];
			$username    = $_SESSION['username'];
            $date        = date('Y-m-d');
			$time        = date('h:i:s');
			$ipaddr      = $_SERVER['REMOTE_ADDR'];
}		
		
function mymail() {
// the message
    $msg = "You recently completed a Howard County School System Device agreement.\n If you did not use our Online Device Agreement system recently, please let us know immediately.\n Otherwise please find a copy of your new Device Agreement in this emails enclosure.";

// use wordwrap() if lines are longer than 70 characters
    $msg = wordwrap($msg,70);
    $subject = "HCPSS Device Agreement Confirmation";
	$headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
	$headers .= "From: jbageant@hcpss.org" . "\r\n";
	$headers .= "CC: tschruefer@hcpss.org" . "\r\n";
	
// send email
mail($_SESSION['mail'],$subject,$msg,$headers);
	
}

function dalog($username,$action,$app,$search) {

    	date_default_timezone_set("America/New_York");
        require "include/conn.php";
		$ipaddr = $_SERVER['REMOTE_ADDR'];
		
	//  Who just logged in?						
	
	$sql = "insert into dalog (username,
							   ipaddr,
							   action,
							   app,
							   search)	
   					values  ('$username', 
							 '$ipaddr', 
							 '$action', 
							 '$app',
							 '$search')";
							 
	$result = mysqli_query($conn, $sql)
			or die ("Could not execute insert query. Page functions.php. 001");

	if (!$result) {
		echo "DB Error, could not update the Inventory database, daLog table. Page functions.php. 002";
		echo "MySQL Error: " . (mysqli_error());
		error_log("DB Error, could not update the Inventory database, daLog table. Page functions.php. 003", 0);
		exit;	
	}						 
}

function filterpagelog($username,$displayname,$employeeid,$location) {
	    date_default_timezone_set("America/New_York");
        require "include/conn.php";
		$ipaddr = $_SERVER['REMOTE_ADDR'];
	
	$sql = "insert into dafilterpagelog (username,
										 ipaddr,
									     displayname,
							         	 employeeid,
										 location)	
								values  ('$username',
										 '$ipaddr', 
										 '$displayname',
										 '$employeeid',
										 '$location')";
							 
	$result = mysqli_query($conn, $sql)
			or die ("Could not execute insert query. Page filerpage.php, functions.php. 001");

	if (!$result) {
		echo "DB Error, could not update the Inventory database, da_filterpage. Page filerpage.php, functions.php. 002";
		echo "MySQL Error: " . (mysqli_error());
		error_log("DB Error, could not update the Inventory database, da_filterpage table. Page filerpage.php, functions.php. 003", 0);
		exit;	
	}
}
   
   
function createdeviceagreement() {

date_default_timezone_set("America/New_York");

//require('include/fpdf.php');

define('BULLET',chr(186));    // Create a php constant to encode an ascii character, in this case creating a bullet in the pdf output.

$title = "Howard County Public School System";
$subtitle = "Assigned Technology Device Agreement";

$line1 = $_SESSION['line1'];     // Recipient Name
$line2 = $_SESSION['line2'];     // Date Issued
$line3 = $_SESSION['line3'];     // Manufacturer
$line4 = $_SESSION['line4'];     // Serial #
$line5 = $_SESSION['line5'];     // Employee ID
$line6 = $_SESSION['line6'];     // Location
$line7 = $_SESSION['line7'];     // Description
$line8 = $_SESSION['line8'];     // Inventory #
$line10 = $_SESSION['line10'];    // Condition Line 
$line11 = $_SESSION['line11'];    // Condition Line 
$line12 = $_SESSION['line12'];    // Condition Line
$line13 = $_SESSION['line13'];    // Condition Line 
$line14 = $_SESSION['line14'];    // Condition Line 
$line15 = $_SESSION['line15'];    // Condition Line 
$line16 = $_SESSION['line16'];    // Condition Line 
$line17 = $_SESSION['line17'];    // Condition Line 
$line18 = $_SESSION['line18'];    // Condition Line 
$line191 = $_SESSION['line191'];    // Condition Line 
$line192 = $_SESSION['line192'];    // Condition Line 
$line193 = $_SESSION['line193'];    // Condition Line 
$line201 = $_SESSION['line201'];    // Condition Line 
$line202 = $_SESSION['line202'];    // Condition Line 
$line203 = $_SESSION['line203'];    // Condition Line 
$line211 = $_SESSION['line211'];    // Condition Line 
$line212 = $_SESSION['line212'];    // Condition Line 
$line213 = $_SESSION['line213'];    // Condition Line 
$line221 = $_SESSION['line221'];    // Condition Line 
$line222 = $_SESSION['line222'];    // Condition Line 
$line223 = $_SESSION['line223'];    // Condition Line 
$line231 = $_SESSION['line231'];    // Condition Line 
$line232 = $_SESSION['line232'];    // Condition Line
$line233 = $_SESSION['line233'];    // Condition Line
$line24 = $_SESSION['line24'];    // Condition Line 
$line25 = $_SESSION['line25'];    // Condition Line 
$line26 = $_SESSION['line26'];    // Condition Line 

$displayname  = $_SESSION['displayname'];
$av_num       = $_SESSION['av_num'];
$serial_num   = $_SESSION['serial_num'];
$manufacturer = $_SESSION['manufacturer'];
$model        = $_SESSION['model'];
$model_num    = $_SESSION['model_num'];
$description  = $_SESSION['description'];
$employeeid   = $_SESSION['employeeid'];
$location     = $_SESSION['selectlocation'];
$cid_school   = $_SESSION['school'];
$date         = $_SESSION['date'];
$sn           = $_SESSION['sn'];
$givenname    = $_SESSION['givenname'];
$filename     = "";
$da_location  = NULL;

if (empty($_SESSION['selectlocation'])) {
	$da_location = $cid_school;
	}{
	$da_location = $location;
	}


$pdf = new FPDF('P','pt','Letter');

// Set PDF document properties

$pdf->SetTitle('Assigned Technology Device Agreement');
$pdf->SetAuthor('OPS-TEC-BMGT-008 approved at Superintendents Cabinet meeting 13Jan2016');
$pdf->SetSubject('Device Agreement');
$pdf->SetKeyWords('Device Agreement OPS-TEC-BMGT-008 HCPSS Howard Technology Inventory CID OPS TEC BMGT');
$pdf->SetCreator('Howard County Public School System');

// Create page heading

$pdf->AddPage();
$pdf->SetFont('Times','',20);
$pdf->SetFillColor(0,0,0);
$pdf->SetTextColor(255,255,255);
$pdf->Cell(0,35,$title,0,1,'C',true);

// Create page contents

$pdf->ln(14);
//$pdf->Line(30, 70, 550, 70);
$pdf->SetFillColor(0,0,0);
$pdf->SetTextColor(0,0,0);

// Line 1

$pdf->SetFont('Times','',10);
$pdf->SetX(60);
$pdf->Cell(80,15,$line1,0,0,'L');              // Recipient Name
$pdf->Cell(200,15,$displayname,0,0,'L');
$pdf->Cell(80,15,$line5,0,0,'L');             // Employee ID
$pdf->Cell(75,15,$employeeid,0,1,'L');

//Line 2

$pdf->SetX(60);
$pdf->Cell(80,15,$line2,0,0,'L');             // Date Issued
$pdf->Cell(200,15,$date,0,0,'L');
$pdf->Cell(80,15,$line6,0,0,'L');            // Location
// $pdf->Cell(75,15,$location,0,1,'L');
$pdf->Cell(75,15,$da_location,0,1,'L');

// Line 3

$pdf->SetX(60);
$pdf->Cell(80,15,$line3,0,0,'L');             // Manufacturer
$pdf->Cell(200,15,$manufacturer,0,0,'L');
$pdf->Cell(80,15,$line7,0,0,'L');            // Description
$pdf->Cell(75,15,$description . ", " . $model . ", " . $model_num,0,1,'L');

// Line 4

$pdf->SetX(60);
$pdf->Cell(80,15,$line4,0,0,'L');            // Serial #
$pdf->Cell(200,15,$serial_num,0,0,'L');
$pdf->Cell(80,15,$line8,0,0,'L');           // Inventory 
$pdf->Cell(75,15,$av_num,0,1,'L');

$pdf->ln(14);

// sub-section title

$pdf->SetFont('Times','',20);
$pdf->SetFillColor(0,0,0);
$pdf->SetTextColor(255,255,255);
$pdf->Cell(0,35,$subtitle,1,1,'C',true);

// Terms and Conditions section.

$pdf->SetFont('Times','',10);
$pdf->SetFillColor(255,255,255);
$pdf->SetTextColor(0,0,0);

$pdf->ln(14);

//$pdf->SetX(60);
$pdf->Cell(20,15,BULLET,0,0,'R');
$pdf->MultiCell(500,15,$line10,0,1,'J');
$pdf->ln(6);
$pdf->Cell(20,15,BULLET,0,0,'R');
$pdf->MultiCell(500,15,$line11,0,1,'J');
$pdf->ln(6);
$pdf->Cell(20,15,BULLET,0,0,'R');
$pdf->MultiCell(500,15,$line12,0,1,'J');
$pdf->ln(6);
$pdf->Cell(20,15,BULLET,0,0,'R');
$pdf->MultiCell(500,15,$line13,0,1,'J');
$pdf->ln(6);
$pdf->Cell(20,15,BULLET,0,0,'R');
$pdf->MultiCell(500,15,$line14,0,1,'J');
$pdf->ln(6);
$pdf->Cell(20,15,BULLET,0,0,'R');
$pdf->MultiCell(500,15,$line15,0,1,'J');
$pdf->ln(6);
$pdf->Cell(20,15,BULLET,0,0,'R');
$pdf->MultiCell(500,15,$line16,0,1,'J');
$pdf->ln(6);
$pdf->Cell(20,15,BULLET,0,0,'R');
$pdf->MultiCell(500,15,$line17,0,1,'J');
$pdf->ln(6);
$pdf->Cell(20,15,BULLET,0,0,'R');
$pdf->MultiCell(500,15,$line18,0,1,'J');
$pdf->ln(14);

$pdf->Cell(50,15,"",0,0,'R');
$pdf->Cell(125,15,$line191,1,0,'C');
$pdf->Cell(125,15,$line192,1,0,'C');
$pdf->Cell(125,15,$line193,1,1,'C');

$pdf->Cell(50,15,"",0,0,'R');
$pdf->Cell(125,15,$line201,1,0,'C');
$pdf->Cell(125,15,$line202,1,0,'C');
$pdf->Cell(125,15,$line203,1,1,'C');

$pdf->Cell(50,15,"",0,0,'R');
$pdf->Cell(125,15,$line211,1,0,'C');
$pdf->Cell(125,15,$line212,1,0,'C');
$pdf->Cell(125,15,$line213,1,1,'C');

$pdf->Cell(50,15,"",0,0,'R');
$pdf->Cell(125,15,$line221,1,0,'C');
$pdf->Cell(125,15,$line222,1,0,'C');
$pdf->Cell(125,15,$line223,1,1,'C');

$pdf->Cell(50,15,"",0,0,'R');
$pdf->Cell(125,15,$line231,1,0,'C');
$pdf->Cell(125,15,$line232,1,0,'C');
$pdf->Cell(125,15,$line233,1,1,'C');

$pdf->ln(14);

$pdf->Cell(20,15,BULLET,0,0,'R');
$pdf->MultiCell(500,15,$line24,0,1,'J');
$pdf->ln(6);
$pdf->Cell(20,15,BULLET,0,0,'R');
$pdf->MultiCell(500,15,$line25,0,1,'J');
$pdf->ln(6);
$pdf->Cell(20,15,BULLET,0,0,'R');
$pdf->MultiCell(500,15,$line26,0,1,'J');
$pdf->ln(6);

//Signature block

$pdf->ln(10);
$pdf->SetFont('Times','UI',10);
$pdf->Cell(50,15,"",0,0,'R');
$pdf->Cell(110,15,$_SESSION['displayname'],0,0,'L');
$pdf->SetFont('Times','',10);
$pdf->Cell(90,15," -- Signed by Active Directory Authentication.",0,1,'L');
$pdf->ln(6);
$pdf->Cell(50,15,"",0,0,'R');
$pdf->SetFont('Times','I',8);
$pdf->Cell(60,15,"Creation Date: ",0,0,'L');
$pdf->Cell(80,15,date("l jS \of F Y H:i:s A"),0,1,'L');


$pdf->ln(9);
$pdf->SetFont('Times','',6);
$pdf->Cell(500,10,"Associcated with document OPS-TEC-BMGT-008 approved at Superintendent's Cabinet meeting Jan13, 2016",0,1,'C');

// Output document to file system, ensure that old files are not overwritten.
// First time file creation
$counter = 0;
 $filename = $_SESSION['sn'] . "_" . $_SESSION['givenname'] . "_" . $_SESSION['employeeid'] . "(" . $counter . ")" . ".pdf";    // Build pdf filename
// $filename = $_SESSION['sn'] . "_" . $_SESSION['givenname'] . "_" . $_SESSION['employeeid'] . "(" . $counter . ")" . ".pdf";    // Build pdf filename

// Load 
$_SESSION['filename'] = $filename;

while (file_exists('pdf/' . $filename)) {
	$_SESSION['filename'] = $filename     = $_SESSION['sn'] . "_" . $_SESSION['givenname'] . "_" . $_SESSION['employeeid'] . "(" . $counter . ")" . ".pdf";
	$counter++;
}

$pdf->Output('F','pdf/' . $filename);                                         // Output for testing.       
//$pdf->Output('F',$_SERVER['DOCUMENT_ROOT'] . $filename);           // Output document to file system
//$pdf->Output('D',$filename);                                       // Output document for user download
}
?>	