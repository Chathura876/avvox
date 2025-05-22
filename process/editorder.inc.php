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
 
	$orderid = $_POST["orderid"];
	$issuedby = $_SESSION["id"];  
	$issuedtime = time(); 
	$addedby = $_SESSION['id'];
	$dealerid = $_POST["dealerid"];

	$noerror = true;

	

	$mysqli->begin_transaction();
	


	//$query2 = "";

	$isincompleteditems = false;

	foreach ($_POST['products'] as $product) {


		$query = "SELECT * FROM orderitems WHERE orderid=$orderid AND modelid={$product[1]} LIMIT 1";
		if ($result = $mysqli->query($query)) {
			$objectname = $result->fetch_object();

			$newamount =  $product[0] - $objectname->amountissued;

			$query2 = "UPDATE orderitems 
			SET amount = $newamount
			WHERE orderid=$orderid AND modelid={$product[1]};";

			if(!($mysqli->query($query2))){
				$noerror = false;
			}

			//echo "<br>";
		
		}


	}

	//exit("HI");

	if($noerror){
		$mysqli->commit();
		header("Location: ../manageorders.php?action=editcomplete");
		echo "Success";
	}else{
		$mysqli->rollback();
		echo "Fail";
	}




}



?>