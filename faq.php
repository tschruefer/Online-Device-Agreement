<?php require "include/header.php";

$username    =	$_SESSION['username'];
if(!isset($username)){
   error_log("User already logged in: " . $_SESSION['displayname'] . " " . $_SESSION['employeeid'], 0);
   header("location:index.php");
   die;
   }
?>


<table class="w3-table-all w3-striped">
<tr>
<h2 class="w3-container w3-card-4 w3-padding-large">Frequently Asked Questions</h2>
</tr>
<tr>
<td>
Q: What do I do if this system does not work for me?
<br>
A: Contact the Help Desk at x7004 and put in a Trouble Ticket. Or, <a href="mailto:itam@hcpss.org?Subject=Device%20Agreement%20Trouble" target="_top">Send eMail to: itam@hcpss.org</a>.
</td>
</tr>
<tr>
<td>
Q: HCPSS Policy What?
<br>
A: For guidance see HCPSS Policy  <a href="http://www.hcpss.org/f/board/policies/3040.pdf" target="_blank">3040</a> and  <a href="http://www.hcpss.org/f/board/policies/8080.pdf" target="_blank">8080</a>.
</td>
</tr>
<tr>
<td>
Q: What about iOS Devices?
<br>
A: See HCPSS <a href="http://www.hcpss.org/f/aboutus/purchasing/bids/approved/apple-contracts/ios-purchase-guidelines.pdf" target="_blank">iOS Device Purchase & User Guidlines</a>.</h3>
</td>
</tr>
<tr>
<td>
Q: Can I retrieve previous Device Agreements?
<br>
A: Yes. You will see any active Device Agreements, that have previously been entered through this portal.
</td>
</tr>
<tr>
<td>
Q: Can I create more than one Device Agreement, if i have other devices that are not listed?
<br>
A: Yes.
</td>
</tr>
<tr>
<td>
Q: Can another staff member create a Device Agreement with this same session?
<br>
A: No, other staff members will have to login under their own username to create their own Device Agreement.
</td>
</tr>
<tr>
<td>
Q: Can I get a copy of this Device Agreement?
<br>
A: Yes, you will be given an opportunity to download a copy of your just completed agreement at the end of this session.
</td>
</tr>
<tr>
<td>
Q: What happens to my current Device Agreement when I get a new piece of equipment?
<br>
A: This is a new feature in the next version.  Your Device Agreement will be made inactive when the device is transferred to the Warehouse or Dorsey Repair shop.
</td>
</tr>
<tr>
<td>
Q: How will we know who has or has not signed the form?
<br>
A: You will see the Device come up on the CID Transfer page, with a note indicating a Device Agreement has been completed and the device is in Transfer "pending" status waiting for Media Special to "Confirm" the transfer.
</td>
</tr>
<td>
Q: When a staff member signs for a device, will the media specialist or CID designee be notified in some way?  
<br>
A: You will see the Device come up on the CID Transfer page.
</td>
</tr>
<td>
Q: How does an assigned technology device agreement form become deleted or archived for a device?   
<br>
A: First, when another staff member completes a new Device Agreement for your device, your Device Agreement will become "Inactive". Second, this is a coming feature, when a device is transferred to Warehouse or Dorsey Repair, any Device Agreements associated with that item will becoming "Inactive".
</td>
</tr>
<td>
Q: For instance, what would be the procedure if a staff member retired or left HCPSS?  
<br>
A: That item should be transferred to the Warehouse to be reissued or retired and disposed of in accordance with HCPSS policy.
</td>
</tr>
<td>
Q: What would happen if two people attempted to sign for the same device?  This could happen if one person did not release their digital signature from the device and a second person attempts to sign for it.
<br>
A: The last person to complete a Device Agreement would then have an active agreement associated with them.  If this was done in error, the correct staff member would need to create a Device Agreement for that item.
</td>
</tr>
<td>
Q: When a staff member changes school, will the location field for the form automatically update? 
<br>
A: No.  In a future version we will allow Media Specialists to see users Device Agreements, as long as the item has been transferred into their school.
</td>
</tr>
<td>
Q: How should we handle devices that are assigned to students?
<br>
A: Currently Device Agreements are not required for students, only staff.
</td>
</tr>
<td>
Q: Are device agreements restricted to laptops, tablets and phones or allow someone to enter a device agreement for anything they may want to checkout?
<br>
A: Currently the only restriction is that an item must be in the CID, this could be used to sign-out any technology item.  However, we only require Device Agreements for Laptops, Tablets and Phones.
</td>
</tr>
</table>

<?php require "include/footer.php"; ?>