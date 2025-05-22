<?php
require_once("../common/logincheck.php");
require_once("../common/database.php");
if (!($userloggedin)) {//Prevent the user visiting this page if not logged in 
  //Redirect to user account page
  //header("Location: login.php");
  http_response_code(403);
  die();
}


//exit();

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

/*	$query1 = "INSERT INTO `orders` (dealerid, ordertime, addedby, lastupdate) VALUES ($dealerid, $ordertime, $addedby, $ordertime)";

	$firstresult = $mysqli->query($query1);*/

	$query1 = "";	
	$query2 = "";
	$noerror = true;

	$addedtime = date("Y-m-d H:i:s");

	foreach ($_POST['products'] as $product) {
		//$totalamountforthisitem = $product[1] + $product[2]; 

		if($product[1] == "add"){//user is trying to add to inventory

			$query1 = "INSERT INTO maininventory (modelid, amount) VALUES ({$product[2]}, {$product[3]}) 
				ON DUPLICATE KEY UPDATE    
				modelid={$product[2]}, 
				amount= amount + {$product[3]}
				";
		}
		else{//user is trying to remove from inventory

			$query1 = "INSERT INTO maininventory (modelid, amount) VALUES ({$product[2]}, {$product[3]}) 
				ON DUPLICATE KEY UPDATE    
				modelid={$product[2]}, 
				amount= amount - {$product[3]}
				";
				$product[3] = $product[3] *-1;
		}		
		//print_r($product);
		//echo "{$product[0]}-{$product[1]}<br>";
		$query2 ="INSERT INTO topup (topupid, productid, quantity, topupdate, addedtime, note, addedby) VALUES (NULL, {$product[2]}, {$product[3]}, '{$_POST['from']}', '$addedtime', '{$product[0]}', {$_SESSION['id']})";


		//echo "$query1<br>$query2<br><br>";

		if(!($mysqli->query($query1))){
			$noerror = false;
		}
		if(!($mysqli->query($query2))){
			$noerror = false;
		}		
	}





	if($noerror){
		$mysqli->commit();
		header("Location: ../managemaininventory.php?action=inventoryadded");
		//echo "Success";
	}else{
		$mysqli->rollback();
		echo "Fail";
	}




}



?>