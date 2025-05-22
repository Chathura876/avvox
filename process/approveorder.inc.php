<?php
require_once("../common/logincheck.php");
require_once("../common/database.php");
require_once("../common/common_functions.php");
if (!($userloggedin)) {//Prevent the user visiting this page if not logged in 
  //Redirect to user account page
  //header("Location: login.php");
  http_response_code(403);
  die();
}

if(isset($_POST["submit"])){
 
	if(isset($_POST["dealerid"])){
		$dealerid = $_POST["dealerid"];
	}
	else{
		$dealerid = $_SESSION["id"];
	}

	  
	$ordertime = time(); 
	$addedby = $_SESSION['id']; 

    //taking existing unitprices into an array
	$productidarray = array();
	$query = "SELECT * FROM orderitems WHERE orderid={$_POST["orderid"]}";
	if ($result = $mysqli->query($query)) {
		while ($objectname = $result->fetch_object()) {
		     //echo $objectname->Name;
		     //echo "<br>";
			$arraykey = $objectname->modelid;
			$productidarray[$arraykey] = $objectname->unitprice;
		}
	}

	$mysqli->begin_transaction();

	$query1 = "DELETE FROM orderitems WHERE orderid={$_POST["orderid"]}";

	$firstresult = $mysqli->query($query1);

	$query2 = "INSERT INTO orderitems (orderid, modelid, amount, amountfree, unitprice) VALUES ";

	foreach ($_POST['products'] as $product) {
		$totalamountforthisitem = $product[1] + $product[2];
		$unitprice = $product[3];
		//print_r($product);
		//echo "{$product[0]}-{$product[1]}<br>";
		if(array_key_exists($product[0], $productidarray)){
			//$unitprice = $productidarray[$product[0]];
			//echo "{$product[0]} Exits <br>";
		}
		else{
			$dealerquery = "SELECT dealerid FROM orders WHERE orderid={$_POST["orderid"]} LIMIT 1";
			$thisdealer = 0;
			if ($dealerresult = $mysqli->query($dealerquery)) {
				$objectname = $dealerresult->fetch_object();
				$thisdealer = $objectname->dealerid;
			
			}
			$unitprice = getunitprice($thisdealer, $product[0]);
		}
		
		$query2 .= "({$_POST["orderid"]}, {$product[0]}, $totalamountforthisitem, {$product[2]}, $unitprice), ";
	}

	$query2 = rtrim($query2, ", ");

	//exit();

	$secondresult =  $mysqli->query($query2);

	//update status only if this is not an edit, if this is an edit, only update lastupdate time
	$lastupdate = time();
	if($_POST["updatetype"] =='approve'){
		$query3 = "UPDATE orders SET issued=1, lastupdate=$lastupdate, section={$_POST["section"]} WHERE orderid={$_POST["orderid"]}";
		$thirdresult =  $mysqli->query($query3);
		$updateaction = "orderapproved";		
	}
	else{
		$query3 = "UPDATE orders SET lastupdate=$lastupdate WHERE orderid={$_POST["orderid"]}";
		$thirdresult =  $mysqli->query($query3);
		$updateaction = "editcomplete";
	}



	if($firstresult && $secondresult && $thirdresult){
		$mysqli->commit();
		header("Location: ../manageorders.php?action=$updateaction");
		//echo "Success";
	}else{
		$mysqli->rollback();
		echo "Fail";
	}




}
