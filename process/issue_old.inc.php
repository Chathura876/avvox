<?php
require_once("../common/logincheck.php");
require_once("../common/database.php");
if (!($userloggedin)) {//Prevent the user visiting this page if not logged in 
  //Redirect to user account page
  //header("Location: login.php");
  http_response_code(403);
  die();
}

if(isset($_POST["submit"])){
 
	$dealerid = htmlentities($_POST['dealerid']); 
	$modelid = htmlentities($_POST['model']); 
	$amount = htmlentities($_POST['amount']); 
	$ordertime = time(); 
	$addedby = $_SESSION['id']; 


	$mysqli->begin_transaction();

	$firstresult = $mysqli->query("INSERT INTO `orders` ( dealerid, modelid, amount, ordertime, addedby) VALUES ( $dealerid, $modelid, $amount, $ordertime, $addedby)");

	$secondresult =  $mysqli->query("INSERT INTO `inventory` (dealerid, modelid, amount) VALUES ($dealerid, $modelid, $amount) ON DUPLICATE KEY UPDATE amount = amount + $amount");



	if($firstresult && $secondresult){
		$mysqli->commit();
		header("Location: ../success.php?action=issued");
		echo "Success";
	}else{
		$mysqli->rollback();
		echo "Fail";
	}

/*	//adding to orders table
	if(mysqli_query($mysqli, "INSERT INTO `orders` ( dealerid, modelid, amount, ordertime, addedby) VALUES ( $dealerid, $modelid, $amount, $ordertime, $addedby)")){

		$query = "SELECT * FROM inventory WHERE dealerid=$dealerid and modelid=$modelid LIMIT 1";
		if ($result = $mysqli->query($query)) {

			if($rowcount =  $result->num_rows >0){//record already exists, update
				mysqli_query($mysqli, "UPDATE inventory SET
				amount = amount + $amount 
				WHERE dealerid = '$dealerid' AND modelid = '$modelid' LIMIT 1");
			}
			else{//add new record 
				mysqli_query($mysqli, "INSERT INTO `inventory` (dealerid, modelid, amount) VALUES ($dealerid, $modelid, $amount)");
			}
		
		}

		$inventoryquery = "INSERT INTO `inventory` (dealerid, modelid, amount) VALUES ($dealerid, $modelid, $amount) ON DUPLICATE KEY UPDATE amount = amount + $amount";

		if (mysqli_query($mysqli, $inventoryquery)){//both queries are ok, redirect

		}		
	}*/

	//adding or updating inventory table


}



?>