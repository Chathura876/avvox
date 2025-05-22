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


	$mysqli->begin_transaction();

	$query1 = "INSERT INTO `orders` (dealerid, ordertime, addedby, lastupdate) VALUES ($dealerid, $ordertime, $addedby, $ordertime)";

	$firstresult = $mysqli->query($query1);

	$query2 = "INSERT INTO orderitems (orderid, modelid, amount, amountfree, unitprice) VALUES ";

	foreach ($_POST['products'] as $product) {
		$totalamountforthisitem = $product[1] + $product[2]; 
		//print_r($product);
		//echo "{$product[0]}-{$product[1]}<br>";
		$unitprice = getunitprice($dealerid, $product[0]);
		$query2 .= "(LAST_INSERT_ID(), {$product[0]}, $totalamountforthisitem, {$product[2]}, $unitprice), ";
	}

	$query2 = rtrim($query2, ", ");

	//exit();

	$secondresult =  $mysqli->query($query2);



	if($firstresult && $secondresult){
		$mysqli->commit();
		header("Location: ../manageorders.php?action=orderadded");
		//echo "Success";
	}else{
		$mysqli->rollback();
		echo "Fail";
	}




}



?>