<?php

require_once("database.php");

//to get the total bill of any single order
function getordertotal($orderid){

	global $mysqli;
	$billtotal = 0;

	// $query = "SELECT orderitems.*, product.* FROM orderitems 
	// INNER JOIN product ON orderitems.modelid = product.id 
	// WHERE orderid=$orderid";

	$query = "SELECT orderitems.*, product.*, user.pricing FROM orderitems 
	INNER JOIN product ON orderitems.modelid = product.id 
	INNER JOIN orders ON orderitems.orderid = orders.orderid 
	INNER JOIN user ON orders.dealerid = user.id 
	WHERE orderitems.orderid=$orderid";


	if ($result = $mysqli->query($query)) {
		while ($thisproduct = $result->fetch_object()) {
		     //echo $objectname->Name;
		     //echo "<br>";
		    /*
			$unitprice = "";
			if($thisproduct->pricing == "default"){
				$unitprice = $thisproduct->pricedefault;
			}
			else if($thisproduct->pricing == "silver"){
				$unitprice = $thisproduct->pricesilver;
			}
			else if($thisproduct->pricing == "gold"){
				$unitprice = $thisproduct->pricegold;
			}
			else if($thisproduct->pricing == "platinum"){
				$unitprice = $thisproduct->priceplatinum;
			}
			
			*/
			
			$unitprice = $thisproduct->unitprice;

			$totalpriceforthismodel = $unitprice*($thisproduct->amount+$thisproduct->amountissued-$thisproduct->amountfree);
			//$totalpriceforthismodel = $unitprice*($thisproduct->amountissued);
			$billtotal = $billtotal + $totalpriceforthismodel;
			$totalpriceforthismodel = number_format((float)$totalpriceforthismodel, 2, '.', ',');

			$amountforthisitem = $thisproduct->amount + $thisproduct->amountissued;

		}
	}

	return $billtotal;
}

function getcompletedordertotal($orderid){

	global $mysqli;
	$billtotal = 0;

	// $query = "SELECT orderitems.*, product.* FROM orderitems 
	// INNER JOIN product ON orderitems.modelid = product.id 
	// WHERE orderid=$orderid";

	$query = "SELECT orderitems.*, product.*, user.pricing FROM orderitems 
	INNER JOIN product ON orderitems.modelid = product.id 
	INNER JOIN orders ON orderitems.orderid = orders.orderid 
	INNER JOIN user ON orders.dealerid = user.id 
	WHERE orderitems.orderid=$orderid";


	if ($result = $mysqli->query($query)) {
		while ($thisproduct = $result->fetch_object()) {
		     //echo $objectname->Name;
		     //echo "<br>";
		    /*
			$unitprice = "";
			if($thisproduct->pricing == "default"){
				$unitprice = $thisproduct->pricedefault;
			}
			else if($thisproduct->pricing == "silver"){
				$unitprice = $thisproduct->pricesilver;
			}
			else if($thisproduct->pricing == "gold"){
				$unitprice = $thisproduct->pricegold;
			}
			else if($thisproduct->pricing == "platinum"){
				$unitprice = $thisproduct->priceplatinum;
			}
			
			*/
			
			$unitprice = $thisproduct->unitprice;

			//$totalpriceforthismodel = $unitprice*($thisproduct->amount+$thisproduct->amountissued-$thisproduct->amountfree);
			$totalpriceforthismodel = $unitprice*($thisproduct->amountissued - $thisproduct->amountfree);
			$billtotal = $billtotal + $totalpriceforthismodel;
			$totalpriceforthismodel = number_format((float)$totalpriceforthismodel, 2, '.', ',');

			$amountforthisitem = $thisproduct->amount + $thisproduct->amountissued;

		}
	}

	return $billtotal;
}

function getordertotal1($orderid){

	global $mysqli;
	$billtotal = 0;

	// $query = "SELECT orderitems.*, product.* FROM orderitems 
	// INNER JOIN product ON orderitems.modelid = product.id 
	// WHERE orderid=$orderid";

	$query = "SELECT orderitems.*, product.*, user.pricing FROM orderitems 
	INNER JOIN product ON orderitems.modelid = product.id 
	INNER JOIN orders ON orderitems.orderid = orders.orderid 
	INNER JOIN user ON orders.dealerid = user.id 
	WHERE orderitems.orderid=$orderid";


	if ($result = $mysqli->query($query)) {
		while ($thisproduct = $result->fetch_object()) {
		     //echo $objectname->Name;
		     //echo "<br>";
		    /*
			$unitprice = "";
			if($thisproduct->pricing == "default"){
				$unitprice = $thisproduct->pricedefault;
			}
			else if($thisproduct->pricing == "silver"){
				$unitprice = $thisproduct->pricesilver;
			}
			else if($thisproduct->pricing == "gold"){
				$unitprice = $thisproduct->pricegold;
			}
			else if($thisproduct->pricing == "platinum"){
				$unitprice = $thisproduct->priceplatinum;
			}
			
			*/
			
			$unitprice = $thisproduct->unitprice;

            $totalcount = $thisproduct->amount+$thisproduct->amountissued-$thisproduct->amountfree;
			$totalpriceforthismodel = $unitprice*($thisproduct->amount+$thisproduct->amountissued-$thisproduct->amountfree);
			$billtotal = $billtotal + $totalpriceforthismodel;
			$totalpriceforthismodel = number_format((float)$totalpriceforthismodel, 2, '.', ',');

			$amountforthisitem = $thisproduct->amount + $thisproduct->amountissued;

		}
	}

	return $amountforthisitem;
}



function getunitprice($dealerid, $productid){

	global $mysqli;
	$unitprice = 0.00;

	$query = "SELECT * FROM user 
	INNER JOIN product 
	WHERE user.id=$dealerid AND product.id=$productid
	";

	if ($result = $mysqli->query($query)) {
		$thisproduct = $result->fetch_object();

		if($thisproduct->pricing == "default"){
			$unitprice = $thisproduct->pricedefault;
		}
		else if($thisproduct->pricing == "silver"){
			$unitprice = $thisproduct->pricesilver;
		}
		else if($thisproduct->pricing == "gold"){
			$unitprice = $thisproduct->pricegold;
		}
		else if($thisproduct->pricing == "platinum"){
			$unitprice = $thisproduct->priceplatinum;
		}
	}

	return $unitprice;
}

function getunitpriceoforder($productid, $orderid){

	global $mysqli;
	$unitprice = 0.00;

	$query = "SELECT * FROM orderitems 
	WHERE modelid=$productid AND orderid=$orderid LIMIT 1
	";

	if ($result = $mysqli->query($query)) {
		if($objectname = $result->fetch_object()){
			return $objectname->unitprice;
		}
		else{
			return false;
		}
	
	}
	else{
		
	}

}

//--------------------------------------------------------------------------------------------------------

//get the total value of all orders within given timefram and given orderstatus
//orderstatus -1 means all orders within the given period

function gettotalsales($startdate, $enddate, $orderstatus = -1){

	global $mysqli;

	$startdatetimestamp = strtotime($startdate);
	$enddatetimestamp = strtotime($enddate);

	$totalsales = 0;


	$query = "SELECT * FROM orders 
	WHERE issuedtime BETWEEN $startdatetimestamp AND $enddatetimestamp
	";

	if($orderstatus !=-1){
		$query .= " AND issued > $orderstatus";
	}


	if ($result = $mysqli->query($query)) {
		while ($order = $result->fetch_object()) {
		     //echo $objectname->Name;
		     //echo "<br>";
			$totalsales += getcompletedordertotal($order->orderid);
		}
	}

	return $totalsales;

}


function gettotalsalesbysection($startdate, $enddate, $section, $orderstatus = 3){

	global $mysqli;

	$startdatetimestamp = strtotime($startdate);
	$enddatetimestamp = strtotime($enddate);

	$totalsales = 0;


	$query = "SELECT * FROM orders 
	WHERE issuedtime BETWEEN $startdatetimestamp AND $enddatetimestamp 
	AND section=$section AND issued > 1
	";

// 	if($orderstatus !=-1){
// 		$query .= " AND issued=$orderstatus";
// 	}


	if ($result = $mysqli->query($query)) {
		while ($order = $result->fetch_object()) {
		     //echo $objectname->Name;
		     //echo "<br>";
			$totalsales += getcompletedordertotal($order->orderid);
		}
	}

	return $totalsales;

}

function gettotalsalesbysection1($startdate, $enddate, $section, $orderstatus = 0){

	global $mysqli;

	$totalsales = 0;


	$query = "SELECT * FROM orders 
	WHERE  ordertime BETWEEN $startdatetimestamp AND $enddatetimestamp 
	AND section=$section AND issued=$orderstatus
	";

// 	if($orderstatus !=-1){
// 		$query .= " AND issued>=$orderstatus";
// 	}


	if ($result = $mysqli->query($query)) {
		while ($order = $result->fetch_object()) {
		     //echo $objectname->Name;
		     //echo "<br>";
			$totalsales += getordertotal1($order->orderid);
		}
	}

	return $totalsales;

}

	$startdatetimestamp = strtotime($startdate);
	$enddatetimestamp = strtotime($enddate);

function getpendingordersales($orderstatus = 1){
    global $mysqli;

	$totalsales = 0;


	$query = "SELECT * FROM orders 
	WHERE issued=1
	";

// 	if($orderstatus !=-1){
// 		$query .= "";
// 	}


	if ($result = $mysqli->query($query)) {
		while ($order = $result->fetch_object()) {
		     //echo $objectname->Name;
		     //echo "<br>";
			$totalsales += getordertotal($order->orderid);
		}
	}

	return $totalsales;
}

function getpendingjobss(){
    $query30 = "SELECT COUNT(id) AS jobcount FROM job WHERE status=2";
    
    if($result = $mysqli->query($query30)){
        if($job = $result->fetch_object()){
            return $job->jobcount;
        }else{
            return false;
        }
    }
}

function getpendingjobs(){
    
}


function getpendingsalesbysection($section, $orderstatus = 1){

	global $mysqli;

	$totalsales = 0;


	$query = "SELECT * FROM orders 
	WHERE section=$section AND issued=1
	";

// 	if($orderstatus !=-1){
// 		$query .= " AND issued>=$orderstatus";
// 	}


	if ($result = $mysqli->query($query)) {
		while ($order = $result->fetch_object()) {
		     //echo $objectname->Name;
		     //echo "<br>";
			$totalsales += getpendingordertotal($order->orderid);
		}
	}

	return $totalsales;

}

function getpendingordertotal($orderid){

	global $mysqli;
	$billtotal = 0;

	// $query = "SELECT orderitems.*, product.* FROM orderitems 
	// INNER JOIN product ON orderitems.modelid = product.id 
	// WHERE orderid=$orderid";

	$query = "SELECT orderitems.*, product.*, user.pricing FROM orderitems 
	INNER JOIN product ON orderitems.modelid = product.id 
	INNER JOIN orders ON orderitems.orderid = orders.orderid 
	INNER JOIN user ON orders.dealerid = user.id 
	WHERE orderitems.orderid=$orderid";


	if ($result = $mysqli->query($query)) {
		while ($thisproduct = $result->fetch_object()) {
		     //echo $objectname->Name;
		     //echo "<br>";
		    /*
			$unitprice = "";
			if($thisproduct->pricing == "default"){
				$unitprice = $thisproduct->pricedefault;
			}
			else if($thisproduct->pricing == "silver"){
				$unitprice = $thisproduct->pricesilver;
			}
			else if($thisproduct->pricing == "gold"){
				$unitprice = $thisproduct->pricegold;
			}
			else if($thisproduct->pricing == "platinum"){
				$unitprice = $thisproduct->priceplatinum;
			}
			
			*/
			
			$unitprice = $thisproduct->unitprice;

			$totalpriceforthismodel = $unitprice*($thisproduct->amount-$thisproduct->amountfree);
			$billtotal = $billtotal + $totalpriceforthismodel;
			$totalpriceforthismodel = number_format((float)$totalpriceforthismodel, 2, '.', ',');

			$amountforthisitem = $thisproduct->amount + $thisproduct->amountissued;

		}
	}

	return $billtotal;
}

function check($id)
{
	return in_array($id, $_SESSION['permissions']);
}
?>