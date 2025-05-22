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
		//print_r($product);
		//echo "{$product[0]}-{$product[1]}<br>";
		//$query2 .= "(LAST_INSERT_ID(), {$product[0]}, {$product[1]}), ";

		$issuedamount = 0;

		$query = "SELECT * FROM orderitems WHERE orderid=$orderid AND modelid={$product[1]} LIMIT 1";
		if ($result = $mysqli->query($query)) {
			$objectname = $result->fetch_object();

			$currenttotalamount = $objectname->amount + $objectname->amountissued;

			$issuedamount = $objectname->amountissued;

			if($currenttotalamount == $product[2]){//User hasn't changed Original amount
				if($objectname->amount > $product[0]){
					$isincompleteditems = true;
				}
			}
			else{//user has changed the original amount
				if($product[2] > $product[0] + $objectname->amountissued){
					$isincompleteditems = true;
				}
			}


		
		}




			$newamount = $product[2] - ($product[0] + $issuedamount);
			$query2 = "UPDATE orderitems 
			SET amountissued= amountissued + {$product[0]},
			    amount = $newamount
			WHERE orderid=$orderid AND modelid={$product[1]};";
			if(!($mysqli->query($query2))){
				$noerror = false;
			}

			//echo "$query2<br>";
			
			$query3 = "INSERT INTO `inventory` (dealerid, modelid, amount) VALUES ($dealerid, {$product[1]}, {$product[0]}) ON DUPLICATE KEY UPDATE amount = amount + {$product[0]}";
			if(!($mysqli->query($query3))){
				$noerror = false;
			}

			//echo "$query3<br>";			
		
	}

	if($isincompleteditems == false){
		$query1 = "UPDATE orders SET
		issued = 1,
		issuedtime = $issuedtime,
		issuedby = $issuedby WHERE orderid=$orderid";
		
		//echo "<br>";

		//$firstresult = $mysqli->query($query1);
		if(!($mysqli->query($query1))){
			$noerror = false;
		}
	}

	//echo $query2;
	//exit();

	//echo $query2 = rtrim($query2, ", ");

	//exit();

	//$secondresult =  $mysqli->multi_query($query2);//here multi_query is needed because there are several statements seperated by semicolons

	//echo $noerror;

	//exit();

	if($noerror){
		$mysqli->commit();
		header("Location: ../manageorders.php?action=issuecomplete");
		echo "Success";
	}else{
		$mysqli->rollback();
		echo "Fail";
	}




}



?>