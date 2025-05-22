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

		$datastring = "<h2>Inventory Report - Avvox CRM</h2>";
        
        // $query = "SELECT * FROM product WHERE status='Active'";
        $query = "
		SELECT product.* , maininventory.amount AS quantity, 
		(SELECT SUM(amount) FROM orderitems INNER join orders on orderitems.orderid= orders.orderid and orders.issued<2 WHERE orderitems.modelid = product.id) AS pending 
		FROM product 
		INNER JOIN maininventory ON maininventory.modelid = product.id 
		";
        
        if ($result = $mysqli->query($query)) {
            
            $datastring .= "	<table style='width=100%;' class='table' id='udaratable' >
				
				  <tr>
				    <th align='right'>Model</th>
				    <th align='right'>Default Price</th>
				    <th align='right'>Quantity</th>
				    <th align='right'>Pending</th>
				    <th align='right'>Sellable</th>";
				    
				$datastring .= "
				    
				  </tr>";
			
			while ($item = $result->fetch_object()) {
			 //   $query2 = "SELECT * FROM maininventory INNER JOIN product WHERE maininventory.modelid = {$item->id}";
			 //   $result2 = $mysqli->query($query2);
			 //   $item2 = $result2->fetch_object();
			    $thisaddeddate = date("Y-m-d", $item->timeadded);
			    $defaultprice = number_format($item->pricedefault,2);
			    $datastring .= "<tr>
			        <td>{$item->model}</td>
			        <td align='right'>{$defaultprice}</td>
			        <td align='right'>{$item->quantity}</td>";
			        if($item->pending){
			            $datastring .= "<td align='right'>{$item->pending}</td>";
			        }else{
			            $datastring .= "<td align='right'>0</td>";
			        }
			        $sellable = $item->quantity - $item->pending;
			        if($sellable>0){
			            $datastring .= "<td align='right'>{$sellable}</td>";
			        }else{
			            
			            $datastring .= "<td align='right'>0</td>";
			        }
			    $datastring .= "</tr>";
			}
        }
		echo $datastring;
		

		
}
catch(Exception $ex)
{
	echo $ex->getMessage();

}
	
?>