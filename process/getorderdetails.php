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
	if(isset($_POST['orderid'])){

		$query = "SELECT orderitems.*, product.* FROM orderitems
		INNER JOIN product
		WHERE orderitems.orderid={$_POST['orderid']}
		AND orderitems.modelid = product.id 
		AND orderitems.amount + orderitems.amountissued > 0
		";

		$issued = 0;
		$pricing = "default";
		$billtotal = 0;
		$colspan = 0;
		//echo $query;
		$query2 = "SELECT orders.*, user.* FROM orders 
		INNER JOIN user ON orders.dealerid = user.id 
		WHERE orderid={$_POST['orderid']}";
		if ($result2 = $mysqli->query($query2)) {
			$objectname = $result2->fetch_object();
			$issued = $objectname->issued;
			$pricing = $objectname->pricing;
			$section = $objectname->section;
		
		}
		    if($section == 1){
		        $sectionname = 'DR';
		    } else if($section == 2){
		        $sectionname = 'SK';
		    }
		     else if($section == 3){
		        $sectionname = 'COP';
		    } else if($section == 4){
		        $sectionname = 'DZ';
		    }

		//echo $query;

		$issuetable = "";
		$ordertable = "";


		if ($result = $mysqli->query($query)) {

			//if($issued>0){
			if(false){
				$colspan = 4;
				$issuetable .= "
				<table class='table table-responsive' id='issuetable' style='width:100%'>
				  <tr>
				    <th>Model&nbsp;	&nbsp;</th>
				    <th>Section</th>
				    <th align='right'>Requested</th>
				    <th align='right'>Free</th>
				    <th align='right'>Unit Price</th>
				    <th align='right'>Price (Rs)</th>    
				  </tr>";
			}
			else{
				$colspan = 6;
				$issuetable .= "
				<table class='table table-responsive' id='issuetable' style='width:100%'>
				  <tr>
				    <th>Model&nbsp;	&nbsp;</th>
				    <th>Section</th>
				    <th align='right'>Requested</th>
				    <th align='right'>Issued</th>
				    <th align='right'>Pending</th>
				    <th align='right'>Free</th>
				    <th align='right'>Unit Price</th>
				    <th align='right'>Price (Rs)</th>
				  </tr>";

			}


			while ($item = $result->fetch_object()) {

				$totalnoofitems = $item->amount + $item->amountissued;
				
                /*
				$unitprice = "";
				if($pricing == "default"){
					$unitprice = $item->pricedefault;
				}
				else if($pricing == "silver"){
					$unitprice = $item->pricesilver;
				}
				else if($pricing == "gold"){
					$unitprice = $item->pricegold;
				}
				else if($pricing == "platinum"){
					$unitprice = $item->priceplatinum;
				}
                */
                $unitprice = $item->unitprice;
                
				$price = $unitprice*($totalnoofitems - $item->amountfree);
				$billtotal += $price;
				$price = number_format((float)$price, 2, '.', ',');

				//if($issued){
				if(false){
					$issuetable .= "<tr>
					<td>{$item->model}</td>
					<td>{$sectionname}</td>
					<td>$totalnoofitems</td>
					<td>{$item->amountfree}</td>
					<td>$unitprice</td>
					<td align='right>Rs. $price</td>
					
					</tr>";
				}
				else{
					$remainingamount = $totalnoofitems - $item->amountissued;
					$issuetable .= "<tr>
					<td>{$item->model}</td>
					<td>{$sectionname}</td>
					<td>$totalnoofitems</td>
					<td>{$item->amountissued}</td>
					<td>$remainingamount</td>
					<td>{$item->amountfree}</td>
					<td>$unitprice</td>
					<td align='right'>Rs. $price</td>
					</tr>";					
				}

			}

			$billtotal = number_format((float)$billtotal, 2, '.', ',');
			$issuetable .= "<tr><td></td><td colspan='$colspan' align='right'><b>Total:</b></td><td align='right'><b>Rs. $billtotal</b></td></tr>";

			$issuetable .= "</table>";
		
		}


		echo $issuetable;


		
	}
}
catch(Exception $ex)
{
	echo $ex->getMessage();

}
