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
	if(isset($_POST['dealerid']) && isset($_GET['status'])){

		$datastring = "<h2>Pending Orders Report - Avvox CRM</h2>";

		$fromtimestamp = strtotime($_POST['from']) - 1;
		$totimestamp = strtotime($_POST['to']) + 86400;
		
		$query = "SELECT * FROM orders 
		INNER JOIN user 
		WHERE orders.dealerid = user.id 
		AND ordertime BETWEEN $fromtimestamp AND $totimestamp
		";

		if($_GET['status'] != 4){//not all orders
			$query .= " AND issued={$_GET['status']}";
		
		}
		
		if($_POST['dealerid'] != 0){//not all
			$query .= " AND dealerid={$_POST['dealerid']}";
		
		}		


		//echo $query;

	
	

		

		if ($result = $mysqli->query($query)) {

			if($result->num_rows>0){

				$datastring .= "
				<table style='width:100%'>
					<tr>
						<td>
							<b>Dealer:</b> {$_POST['dealername']}
						</td>
						<td>
							<b>Time Period:</b> {$_POST['from']} - {$_POST['to']}
						</td>

						<td>
							<b>Report Date:</b> ".date('Y-m-d h:i:s A')."
						</td>
						<td>
							<b>Order Status: </b>Pending
						</td>
					</tr>
				</table><br>

				";

		// 		$datastring2 = "
		// 		 <a class='d-print-none float-right btn-lg btn px-3 btn-light' href='#' onclick='window.print()' role='button'>Print <img src='images/print-icon.png' height='31' alt='Print'></a>
  // <a class='d-print-none float-right btn-lg btn px-3 btn-light' href='process/generatepdf.php?dealerid={$_POST['dealerid']}&status={$_GET['status']}&dealername={$_POST['dealername']}&from={$_POST['from']}&to={$_POST['to']}' role='button'>PDF <img src='images/pdf-icon.png' height='31' alt='Download as PDF'></a>

		// 		";


				$datastring .= "	<table class='table table-responsive' id='udaratable' style='width:100%'>
				  <tr>
				    <th>ID</th>
				    <th align='right'>Dealer</th>
				    <th align='right'>Shop</th>
				    <th align='right'>Area</th>
				    <th align='right'>Order Date</th>
				    <th align='right'>Summary</th>
				  </tr>";
		



	  		$i = 1;

			while ($item = $result->fetch_object()) {
			     //echo $item->model."=".$item->amount;
			     //echo "<br>";
				$descstring = "";
				$query2 = "SELECT * FROM orderitems 
				INNER JOIN product 
				WHERE orderid='{$item->orderid}'
				AND orderitems.modelid = product.id";
				if ($result2 = $mysqli->query($query2)) {
					$descstring .= "<table style='width:100%'>
				  <tr>
				    <th align='right'>Model</th>
				    <th align='right'>Requested</th>
				    <th align='right'>issued</th>
				    <th align='right'>Pending</th>
				  </tr>";					


					while ($log = $result2->fetch_object()) {
					     //echo $objectname->Name;
					     //echo "<br>";
						$reqamount = $log->amount + $log->amountissued;
						$descstring .= "
						  <tr>
						    <td align='right'>{$log->model}</td>
						    <td align='right'>$reqamount</td>
						    <td align='right'>{$log->amountissued}</td>
						    <td align='right'>{$log->amount}</td>

						  </tr>

						";
					}
					$descstring .= "</table>";
				}


				$thisorderdate = date("Y-m-d g:i a", $item->ordertime);
				$datastring .= "<tr>
				<td>{$item->orderid}</td>
				<td>{$item->fullname}</td>
				<td>{$item->shopname}</td>
				<td>{$item->area}</td>
				<td>$thisorderdate</td>
				<td>$descstring</td>				
				</tr>";

				$i++;
			}

			$datastring .= "</table>";

			echo $datastring;

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
