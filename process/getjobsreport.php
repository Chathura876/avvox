<?php
require_once("../common/logincheck.php");
require_once("../common/database.php");
if (!($userloggedin)) {//Prevent the user visiting this page if not logged in 
  //Redirect to user account page
  //header("Location: login.php");
  http_response_code(403);
  die();
}

//exit("Byeeeeee");
try
{	
	if(isset($_POST['dealerid']) && isset($_POST['techid']) && isset($_GET['status'])){

		//$query = "";

		$query = "
		SELECT job.id, job.contactname, job.warrantyid, user.fullname, job.timeadded, customer.address , job.contactno, product.model, user2.shopname FROM job 
		INNER JOIN user ON job.techid = user.id 
		INNER JOIN user AS user2 ON job.dealerid = user2.id 
		INNER JOIN customer ON job.warrantyid=customer.warrantyid 
		INNER JOIN product ON customer.modelid = product.id 
		WHERE job.status = {$_GET['status']} 
		";

		if($_POST['dealerid'] != 0){
			$query .= " AND job.dealerid={$_POST['dealerid']}";
		}

		if($_POST['techid'] != 0){
			$query .= " AND job.techid={$_POST['techid']}";
		}

		if($_POST['from'] == $_POST['to']){
			$query .= " AND DATE(job.timeadded) = '{$_POST['from']}'";
		}else{
			$query .= " AND job.timeadded BETWEEN '{$_POST['from']}' AND '{$_POST['to']}'";
		}							

		if($_POST['modelid'] != "All"){
			$query .= " AND customer.modelid = {$_POST['modelid']}";
		}

/*		if($_POST['dealerid'] == 0 && $_POST['techid'] == 0){//both fields are any
			$query = "SELECT job.id, job.contactname, job.warrantyid, user.fullname, job.timeadded, customer.address , job.contactno, product.model, user2.shopname   
			FROM job
			INNER JOIN user 
			INNER JOIN user as user2 ON job.dealerid = user2.id
			INNER JOIN product
			INNER JOIN customer
			WHERE job.techid = user.id
			AND job.warrantyid=customer.warrantyid 
			AND customer.modelid = product.id 
			AND job.status = {$_GET['status']}
			";
		}
		else if($_POST['dealerid'] == 0){//only dealer is any

			$query = "SELECT job.id, job.contactname, job.warrantyid, user.fullname, job.timeadded, customer.address, job.contactno, product.model  FROM job
			INNER JOIN user
			INNER JOIN product
			INNER JOIN customer				
			WHERE job.techid={$_POST['techid']}
			AND job.techid = user.id 
			AND job.warrantyid=customer.warrantyid 
			AND customer.modelid = product.id 				
			AND job.status = {$_GET['status']}
			";
			
		}
		else if($_POST['techid'] == 0){//only techid is any
			$query = "SELECT job.id, job.contactname, job.warrantyid,  job.timeadded, user.fullname, customer.address, job.contactno, product.model  FROM customer
			INNER JOIN job
			INNER JOIN user
			INNER JOIN product				
			WHERE customer.dealerid={$_POST['dealerid']}
			AND customer.warrantyid = job.warrantyid
			AND job.techid = user.id
			AND customer.modelid = product.id 					
			AND job.status={$_GET['status']}
			";			
		}
		else{// both values has specified
			$query = "SELECT job.id, job.contactname, job.warrantyid, user.fullname, job.timeadded, customer.address, job.contactno, product.model  FROM job
			INNER JOIN user 
			INNER JOIN product
			INNER JOIN customer
			WHERE job.techid={$_POST['techid']}
			AND customer.dealerid={$_POST['dealerid']}
			AND job.techid = user.id 
			AND customer.modelid = product.id 
			AND job.warrantyid = customer.warrantyid 
			AND job.status = {$_GET['status']}
			";				

		}	*/	




		//echo $query;










		//
		//$query .= " AND job.timeadded >= '{$_POST['from']}' AND job.timeadded <= '{$_POST['to']}'";

		//echo $query;

		//filter on dealer id
	

		//filter on both

		if($_GET['status'] ==0){
			echo "<h5>NonApproved Jobs Report</h5>";
		}
		else if($_GET['status'] ==1){
			echo "<h5>Pending Jobs Report</h5>";
			//echo $_POST['from'];
			//echo $_POST['to'];
		}
		else{
			echo "<h5>Completed Jobs Report</h5>";
		}		
	

		

		if ($result = $mysqli->query($query)) {

			if($result->num_rows>0){

				echo "
				<div class='row'>
					<div class='col-md-6'>
						<b>Dealer:</b> {$_POST['dealername']}
					</div>
					<div class='col-md-6'>
						<b>Technician:</b> {$_POST['techname']}
					</div>
				</div>

				<div class='row'>
					<div class='col-md-6'>
						<b>Report Date:</b> ".date('Y-m-d')."
					</div>
					<div class='col-md-6'>
						<b>Report Time:</b> ".date('h:i:s A')."
					</div>
				</div>
				<br>
				";

				echo "
				 <a class='d-print-none float-right btn-lg btn px-3 btn-light' href='#' onclick='window.print()' role='button'>Print <img src='images/print-icon.png' height='31' alt='Print'></a>
  <a class='d-print-none float-right btn-lg btn px-3 btn-light' href='process/generatepdf.php?dealerid={$_POST['dealerid']}&techid={$_POST['techid']}&status={$_GET['status']}&dealername={$_POST['dealername']}&techname={$_POST['techname']}&from={$_POST['from']}&to={$_POST['to']}&modelid={$_POST['modelid']}' role='button'>PDF <img src='images/pdf-icon.png' height='31' alt='Download as PDF'></a>

				";

			if($_GET['status'] ==1){
				echo "	<table class='table table-responsive' id='udaratable' style='width:100%'>
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
				echo "	<table class='table table-responsive' id='udaratable' style='width:100%'>
				  <tr>
				    <th>Job ID</th>
				    <th>Date</th>
				    <th style='width:25%'>Customer Name&nbsp;	&nbsp;</th>
				    <th style='width:25%'>Customer Adderss&nbsp;	&nbsp;</th>
				    <th>Customer Mobile&nbsp;	&nbsp;</th>
				    <th>Warranty ID&nbsp;	&nbsp;</th>
				    <th>Model&nbsp;	&nbsp;</th>
				    <th style='width:25%' align='right'>Technician</th>
				    <th align='right'>Shop</th>
				    <th style='width:25%' align='right'>Time Added</th>
				    <th style='width:25%' align='right'>Job Log</th>
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
				echo "<tr>
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
				echo "<tr>
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

			echo "</table>";

			}
			else{
				echo "<div class='alert alert-info col-md-6'>There aren't any results for your selection criteria.<div>";
			}
		}
		
	}
}
catch(Exception $ex)
{
	echo $ex->getMessage();

}
	
?>