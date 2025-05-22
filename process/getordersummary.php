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

		$datastring = "<h2>Orders Summary - Avvox CRM</h2>";

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
							<b>Order Status: </b>{$_POST['orderstatus']}
						</td>
					</tr>
				</table><br>

				";

				$datastring2 = "
				 <a class='d-print-none float-right btn-lg btn px-3 btn-light' href='#' onclick='window.print()' role='button'>Print <img src='images/print-icon.png' height='31' alt='Print'></a>
                <a class='d-print-none float-right btn-lg btn px-3 btn-light' href='process/generatepdf.php?dealerid={$_POST['dealerid']}&status={$_GET['status']}&dealername={$_POST['dealername']}&from={$_POST['from']}&to={$_POST['to']}' role='button'>PDF <img src='images/pdf-icon.png' height='31' alt='Download as PDF'></a>

				";

                $query1 = "SELECT * FROM product";
				
				$result1 = $mysqli->query($query1);
                
				$datastring .= "	<table style='width=100%;' class='table table-responsive' id='udaratable' >
				
				  <tr>
				    <th align='right'>Order ID</th>
				    <th align='right'>Order Date</th>
				    <th align='right'>Dealer</th>";
				    
				    while($lg = $result1->fetch_object()){
				        $datastring .= "<th align='right'>{$lg->model}</th>";
				    }
				$datastring .= "
				    <th style='max-width:100px; !important'>Total</th>
				  </tr>";
		



	  		$i = 1;
            $sum1 = 0;
			while ($item = $result->fetch_object()) {
			     //echo $item->model."=".$item->amount;
			     //echo "<br>";
				$descstring = "";
				
				$query2 = "SELECT * FROM orderitems 
				INNER JOIN product 
				WHERE orderid='{$item->orderid}'
				AND orderitems.modelid = '{$lg->id}'";
				
				if ($result2 = $mysqli->query($query2)) {
					$descstring .= "<table style='width:100%'>
				
						  <tr>
				  ";					
                    
				
                    $j=0;
                    
					while ($log = $result2->fetch_object()) {
					     //echo $objectname->Name;
					     //echo "<br>";
					    
						$reqamount = $log->amount + $log->amountissued;
						$descstring .= "";
						
						$j++;
					}
						$descstring .= "</tr><tr>";
					
					$query0 = "SELECT amountissued FROM orderitems 
        				INNER JOIN product 
        				WHERE orderid='{$item->orderid}'
        				AND orderitems.modelid = product.id";
				    
				    
				    $result0 = $mysqli->query($query0);
				    
				     $query11 = "SELECT * FROM product";
				
				    $result11 = $mysqli->query($query11);
				
				    while($lg1 = $result11->fetch_object()){
				        while($log1 = $result0->fetch_object()){
    					    if($log1->model == $lg1->model){
    					        $descstring .= "<td align='right'>{$log1->amountissued}</td>";
    					        
    					    }else{
    					        $descstring .= "<td align='right'>0</td>";
    					    }
					    
					    }
				    }
					
					
					$descstring .= "</tr></table>";
				}
                
				$thisorderdate = date("Y-m-d", $item->ordertime);
				$datastring .= "<tr>
				<td>{$item->orderid}</td>
				<td>{$thisorderdate}</td>
				<td>{$item->fullname}</td>";
				
				$query0 = "SELECT * FROM orderitems 
        				INNER JOIN product 
        				WHERE orderid='{$item->orderid}'
        				AND orderitems.modelid = product.id";
				    
				    
				    $result0 = $mysqli->query($query0);
				    
				     $query11 = "SELECT * FROM product";
				
				    $result11 = $mysqli->query($query11);
				    
				    // $lg1 = $result11->fetch_object();
				    
				    // $log1 = $result0->fetch_object();
				    $sum = 0;
				    while($lg1 = $result11->fetch_object()){
				        $query10 = "SELECT * FROM orderitems 
        				INNER JOIN product 
        				WHERE orderid='{$item->orderid}'
        				AND orderitems.modelid = '{$lg1->id}'";
        				
        				$result10 = $mysqli->query($query10);
        				
        				$log10 = $result10->fetch_object();
        				$total[] = array(
        				    "id" => $log10->modelid,
        				    "count" => $log10->amountissued
        				    );
        				
        				if($log10->amountissued){
				         $datastring .= "<td>{$log10->amountissued}</td>";   
        				 $sum = $sum + $log10->amountissued;  
        				}else{
        				    $datastring .= "<td>-</td>"; 
        				}
				    }
				    $sum1 = $sum+$lg1->amountissued;
				    
				
				
				$datastring .= "<td><b>{$sum}</b></td></tr>";

				$i++;
			}

			$datastring .= "<tr><th></th><th>Total</th><th></th>";
			$query12 = "SELECT * FROM product";
				
			$result12 = $mysqli->query($query12);
			
			$sum2 = 0;
			while($item1 = $result12->fetch_object()){
			    $sum1 = 0;
			    
			    $result14 = $mysqli->query($query);
			    while($item14 = $result14->fetch_object()){
			        $query13 = "SELECT * FROM orderitems 
        				INNER JOIN product 
        				WHERE orderid='{$item14->orderid}'
        				AND orderitems.modelid = '{$item1->id}'";
        				
        				$result13 = $mysqli->query($query13);
        				
        				$log13 = $result13->fetch_object();
        				
                        $sum1 = $sum1 + $log13->amountissued;
			    }
			        $datastring .= "<td><b>{$sum1}</b></td>";
			        $sum2 += $sum1;
			    
			}
            $datastring .= "<th>{$sum2}</th><tr></table>";
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
