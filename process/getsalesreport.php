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

		$datastring = "<h2>Sales Report - Avvox CRM</h2>";

		$fromtimestamp = strtotime($_POST['from']) - 1;
		$totimestamp = strtotime($_POST['to']) + 86400;
		
		$query = "SELECT * FROM orders 
		INNER JOIN user 
		WHERE orders.dealerid = user.id 
		AND issuedtime BETWEEN $fromtimestamp AND $totimestamp
		";

		if($_GET['status'] != 4){//not all orders
			$query .= " AND issued > {$_GET['status']}";
		
		}
		
		if($_POST['dealerid'] != 0){//not all
			$query .= " AND dealerid={$_POST['dealerid']}";
		
		}
		
		if($_POST['repid'] != 0){//not all
			$query .= " AND dealerid={$_POST['repid']}";
		
		}
		
// 		if($_POST['section'] != 0){//not all
// 			$query .= " AND section={$_POST['section']}";
		
// 		}


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
							<b>Order Status: </b>Completed
						</td>
					</tr>
				</table><br>

				";

		// 		$datastring2 = "
		// 		 <a class='d-print-none float-right btn-lg btn px-3 btn-light' href='#' onclick='window.print()' role='button'>Print <img src='images/print-icon.png' height='31' alt='Print'></a>
  // <a class='d-print-none float-right btn-lg btn px-3 btn-light' href='process/generatepdf.php?dealerid={$_POST['dealerid']}&status={$_GET['status']}&dealername={$_POST['dealername']}&from={$_POST['from']}&to={$_POST['to']}' role='button'>PDF <img src='images/pdf-icon.png' height='31' alt='Download as PDF'></a>

		// 		";


				$datastring .= "	<table class='' id='udaratable' style='width:100%'>
				  <tr>
				    <th>Order ID</th>
				    <th>Invoice ID</th>
				    <th align='right'>Invoice Date</th>
				    <th align='right'>Dealer</th>
				    <th align='right'>Amount</th>
				  </tr>";
		



	  		$i = 1;
            $sum = 0;
			while ($item = $result->fetch_object()) {
			     //echo $item->model."=".$item->amount;
			     //echo "<br>";
				$descstring = "";
				$query2 = "SELECT * FROM orderitems 
				INNER JOIN product 
				WHERE orderid='{$item->orderid}'
				AND orderitems.modelid = product.id";
				$result2 = $mysqli->query($query2);
				//$log1 = $result2->fetch_object();
										

                $total = 0;
					while ($log1 = $result2->fetch_object()) {
					   $value = ($log1->amountissued - $log1->amountfree) * $log1->unitprice;
					   $total = $total + $value;
	

					}
					$query3 = "SELECT * FROM issue WHERE orderId='{$item->orderid}'";
					$result3 = $mysqli->query($query3);
					$issued = $result3->fetch_object();

               // $value = $log1->amountissued * $log1->unitprice;
                $tol = number_format($total,2);
                $sum = $sum + $total;
                $totalsum = number_format($sum,2);
                
				$thisorderdate = date("Y-m-d g:i a", $item->ordertime);
				$datastring .= "<tr>
				<td>{$item->orderid}</td>
				<td>{$issued->invoiceId}</td>
				<td>{$issued->issueTime}</td>
				<td>{$item->shopname}</td>					
				<td>{$tol}</td>				
				</tr>";

				$i++;
			}

			$datastring .= "<tr><th>Total</th><td></td><td></td><td></td><td><b>{$totalsum}</b></td></tr></table>";

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
	
?>