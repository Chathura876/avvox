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
 
	$noerror = true;
	$dealerid = $_POST["dealerid"];

	$mysqli->begin_transaction();



	foreach ($_POST['products'] as $product) {
	
		$query3 = "INSERT INTO `inventory` (dealerid, modelid, amount) VALUES ($dealerid, {$product[0]}, {$product[1]}) ON DUPLICATE KEY UPDATE amount = amount + {$product[1]}";
		if(!($mysqli->query($query3))){
			$noerror = false;
		}
		//echo "<br>";		
	
	}

	  //exit();


	if($noerror){
		$mysqli->commit();
		header("Location: ../addinventory.php?action=orderadded");
		echo "Success";
	}else{
		$mysqli->rollback();
		echo "Fail";
	}




}



?>