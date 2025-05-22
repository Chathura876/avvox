<?php
// Database Connection
require_once("../common/logincheck.php");
require_once("../common/database.php");
if (!($userloggedin)) {//Prevent the user visiting this page if not logged in 
  //Redirect to user account page
  //header("Location: login.php");
  http_response_code(403);
  die();
}
 
if(isset($_POST['export_excel'])){
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
		
		if($_POST['repid'] != 0){//not all
			$query .= " AND dealerid={$_POST['repid']}";
		
		}

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

				$datastring .= "	<table class='' id='udaratable' style='width:100%'>
				  <tr>
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
				INNER JOIN orders 
				WHERE orderitems.orderid ='{$item->orderid}'";
				$result2 = $mysqli->query($query2);
				$log1 = $result2->fetch_object();

                $sum = $sum + $log1->amountissued;
                
				$thisorderdate = date("Y-m-d g:i a", $item->ordertime);
				$datastring .= "<tr>
				<td>{$item->orderid}</td>
				<td>$thisorderdate</td>
				<td>{$item->fullname}</td>				
				<td>{$log1->amountissued}</td>				
				</tr>";

				$i++;
			}

			$datastring .= "<tr><th>Total</th><td></td><td></td><td><b>{$sum}</b></td></tr></table>";
			
		}
			header('Content-Type:application/xls');
			header('Content-Disposition:attachment; filename=download.xls');

			echo $datastring;
			
			exit;
 }
}
?>