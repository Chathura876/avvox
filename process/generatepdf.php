<?php
require_once("../common/logincheck.php");
require_once("../common/database.php");
if (!($userloggedin)) {//Prevent the user visiting this page if not logged in 
  //Redirect to user account page
  //header("Location: login.php");
  http_response_code(403);
  die();
}
error_reporting(E_ALL);
require_once '../dompdf/autoload.inc.php';

// reference the Dompdf namespace
use Dompdf\Dompdf;

// instantiate and use the dompdf class
$dompdf = new Dompdf();


$pdfstring = <<<'EOT'

<style>
#udaratable {
  font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

#udaratable td, #udaratable th {
  border: 1px solid #ddd;
  padding: 8px;
  font-size: 10px;
}

#udaratable tr:nth-child(even){background-color: #f2f2f2;}

#udaratable tr:hover {background-color: #ddd;}

#udaratable th {
  padding-top: 12px;
  padding-bottom: 12px;
  text-align: left;
  background-color: #4CAF50;
  color: white;
}
</style>



EOT;
	
	if(isset($_GET['dealerid']) && isset($_GET['techid']) && isset($_GET['status'])){


		$query = "
		SELECT job.id, job.contactname, job.warrantyid, user.fullname, job.timeadded, customer.address , job.contactno, product.model, user2.shopname FROM job 
		INNER JOIN user ON job.techid = user.id 
		INNER JOIN user AS user2 ON job.dealerid = user2.id 
		INNER JOIN customer ON job.warrantyid=customer.warrantyid 
		INNER JOIN product ON customer.modelid = product.id 
		WHERE job.status = {$_GET['status']} 
		";

		if($_GET['dealerid'] != 0){
			$query .= " AND job.dealerid={$_GET['dealerid']}";
		}

		if($_GET['techid'] != 0){
			$query .= " AND job.techid={$_GET['techid']}";
		}

		if($_GET['from'] == $_GET['to']){
			$query .= " AND DATE(job.timeadded) = '{$_GET['from']}'";
		}else{
			$query .= " AND job.timeadded BETWEEN '{$_GET['from']}' AND '{$_GET['to']}'";
		}							

		if($_GET['modelid'] != "All"){
			$query .= " AND customer.modelid = {$_GET['modelid']}";
		}
	


/*			if($_GET['dealerid'] == 0 && $_GET['techid'] == 0){//both fields are any
				$query = "SELECT job.id, job.contactname, job.warrantyid, user.fullname, job.timeadded, customer.address , job.contactno, product.model FROM job
			INNER JOIN user
			INNER JOIN product
			INNER JOIN customer
			WHERE job.techid = user.id
			AND job.warrantyid=customer.warrantyid 
			AND customer.modelid = product.id 
				AND job.status = {$_GET['status']}
				";
			}
			else if($_GET['dealerid'] == 0){//only dealer is any

				$query = "SELECT job.id, job.contactname, job.warrantyid, user.fullname, job.timeadded, customer.address , job.contactno, product.model FROM job
			INNER JOIN user
			INNER JOIN product
			INNER JOIN customer				
			WHERE job.techid={$_GET['techid']}
			AND job.techid = user.id 
			AND job.warrantyid=customer.warrantyid 
			AND customer.modelid = product.id 
				AND job.status = {$_GET['status']}
				";
				
			}
			else if($_GET['techid'] == 0){//only techid is any
				$query = "SELECT job.id, job.contactname, job.warrantyid,  job.timeadded, user.fullname, customer.address , job.contactno, product.model FROM customer
			INNER JOIN job
			INNER JOIN user
			INNER JOIN product				
			WHERE customer.dealerid={$_GET['dealerid']}
			AND customer.warrantyid = job.warrantyid
			AND job.techid = user.id
			AND customer.modelid = product.id 
				AND job.status={$_GET['status']}
				";			
			}
			else{// both values has specified
				$query = "SELECT job.id, job.contactname, job.warrantyid, user.fullname, job.timeadded, customer.address , job.contactno, product.model FROM job
			INNER JOIN user 
			INNER JOIN product
			INNER JOIN customer
			WHERE job.techid={$_GET['techid']}
			AND customer.dealerid={$_GET['dealerid']}
			AND job.techid = user.id 
			AND customer.modelid = product.id 
			AND job.warrantyid = customer.warrantyid 
				AND job.status = {$_GET['status']}
				";				

			}*/


		// if($_GET['modelid'] != "All"){
		// 	$query .= " AND customer.modelid = {$_GET['modelid']}";
		// }





		// if($_GET['from'] == $_GET['to']){
		// 	$query .= " AND DATE(job.timeadded) = '{$_GET['from']}'";
		// }else{
		// 	$query .= " AND job.timeadded BETWEEN '{$_GET['from']}' AND '{$_GET['to']}'";
		// }


		if($_GET['status'] ==0){
			$pdfstring .= "<h2>NonApproved Jobs Report - Avvox CRM</h2>";
		}
		else if($_GET['status'] ==1){
			$pdfstring .= "<h2>Pending Jobs Report - Avvox CRM</h2>";
		}
		else{
			$pdfstring .= "<h2>Completed Jobs Report - Avvox CRM</h2>";
		}		
	

		

		if ($result = $mysqli->query($query)) {

			if($result->num_rows>0){

				// $pdfstring .= "
				// <div class='row'>
				// 	<div class='col-md-6'>
				// 		<b>Dealer:</b> {$_GET['dealername']}
				// 	</div>
				// 	<div class='col-md-6'>
				// 		<b>Technician:</b> {$_GET['techname']}
				// 	</div>
				// </div>

				// <div class='row'>
				// 	<div class='col-md-6'>
				// 		<b>Report Date:</b> ".date('Y-m-d')."
				// 	</div>
				// 	<div class='col-md-6'>
				// 		<b>Report Time:</b> ".date('h:i:s A')."
				// 	</div>
				// </div>
				// <br>
				// ";

				$pdfstring .= "
				<table style='width:100%'>
				<tr><td><b>Dealer:</b> {$_GET['dealername']}&nbsp;&nbsp;&nbsp;</td><td><b>Technician:</b> {$_GET['techname']}&nbsp;&nbsp;&nbsp;</td>
				<td><b>Report Date:</b> ".date('Y-m-d')."&nbsp;&nbsp;&nbsp;</td><td><b>Report Time:</b> ".date('h:i:s A')."</td></tr>
				</table><br>

				";

			if($_GET['status'] ==1){
				$pdfstring .= "	<table class='table table-responsive' id='udaratable' style='width:100%'>
				  <tr>
				    <th>Job ID</th>
				    <th>Date</th>
				    <th>Customer Name&nbsp;	&nbsp;</th>
				    <th>Customer Address&nbsp;	&nbsp;</th>
				    <th>Customer Mobile&nbsp;	&nbsp;</th>
				    <th>Warranty ID&nbsp;	&nbsp;</th>
				    <th>ModelD&nbsp;	&nbsp;</th>
				    <th align='right'>Technician</th>
				    <th align='right'>Shop</th>
				    <th align='right'>Time Added</th>
				    <th align='right'>Days Passed</th>
				    <th align='right'>Job Log</th>
				  </tr>";
			}else{
				$pdfstring .= "	<table class='table table-responsive' id='udaratable' style='width:100%'>
				  <tr>
				    <th>Job ID</th>
				    <th>Date</th>
				    <th>Customer Name&nbsp;	&nbsp;</th>
				    <th>Customer Adderss&nbsp;	&nbsp;</th>
				    <th>Customer Mobile&nbsp;	&nbsp;</th>
				    <th>Warranty ID&nbsp;	&nbsp;</th>
				    <th>Model&nbsp;	&nbsp;</th>
				    <th align='right'>Technician</th>
				    <th align='right'>Shop</th>
				    <th align='right'>Time Added</th>
				    <th align='right'>Job Log</th>
				  </tr>";				
			}



	  		$i = 1;

			while ($item = $result->fetch_object()) {
			     //echo $item->model."=".$item->amount;
			     //echo "<br>";
				$descstring = "";
				$query2 = "SELECT * FROM joblog WHERE jobid='{$item->id}'";
				if ($result2 = $mysqli->query($query2)) {
					$descstring .= "<ul>";
					while ($log = $result2->fetch_object()) {
					     //echo $objectname->Name;
					     //echo "<br>";
						$descstring .= "<li>{$log->description}</li>";
					}
					$descstring .= "</ul>";
				}

				if($_GET['status'] ==1){
					$dayspassed = floor((time() -strtotime($item->timeadded))/(60*60*24));
					$pdfstring .= "<tr>
				<td>{$item->id}</td>
				<td>{$item->timeadded}</td>
				<td>{$item->contactname}</td>
				<td>{$item->address}</td>
				<td>{$item->contactno}</td>
				<td>{$item->warrantyid}</td>
				<td>{$item->model}</td>
				<td>{$item->fullname}</td>
				<td>{$item->shopname}</td>
				<td>{$item->timeadded}</td>
				<td>$dayspassed</td>
				<td>$descstring</td>				
					</tr>";			
				}else{
					$pdfstring .= "<tr>
				<td>{$item->id}</td>
				<td>{$item->timeadded}</td>
				<td>{$item->contactname}</td>
				<td>{$item->address}</td>
				<td>{$item->contactno}</td>
				<td>{$item->warrantyid}</td>
				<td>{$item->model}</td>
				<td>{$item->fullname}</td>
				<td>{$item->shopname}</td>
				<td>{$item->timeadded}</td>
				<td>$descstring</td>				
					</tr>";				
				}

				$i++;

			}

			$pdfstring .= "</table>";


			}
			else{
				$pdfstring .= "<div class='alert alert-info col-md-6'>There aren't any results for your selection criteria.<div>";
			}
		}
		
	}


//echo $pdfstring;
//exit();

$docname = "";
//generating good name for the output file
if($_GET['status'] ==0){
	$docname = "nonpproved-Jobs-Report-".date('Y-m-d-h-i-s-A');
}
else if($_GET['status'] ==1){
	$docname = "Pending-Jobs-Report-".date('Y-m-d-h-i-s-A');
}
else{
	$docname .= "Completed-Jobs-Report-".date('Y-m-d-h-i-s-A');
}


$dompdf->loadHtml($pdfstring);

// (Optional) Setup the paper size and orientation
$dompdf->setPaper('A4', 'landscape');

$dompdf->add_info('Author', 'Udara Akalanka');

// Render the HTML as PDF
$dompdf->render();



// Output the generated PDF to Browser
$dompdf->stream($docname);	
?>