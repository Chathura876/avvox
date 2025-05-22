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

/*if(isset($_POST["notdelivered"])){
	echo "HI";
}

exit();
*/
if((isset($_POST["complete"]) || isset($_POST["notdelivered"])) && isset($_POST["dealerid"])){//user maya have clicked either Complete or not delivered button
 
	if(isset($_POST["dealerid"])){
		$dealerid = $_POST["dealerid"];
	}
	else{
		$dealerid = $_SESSION["id"];
	}

	  
	$ordertime = time(); 
	$addedby = $_SESSION['id'];
	$noerror = true; 

	$allquerystring = "";

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

	//first restore all the  items to the main inventory

	$queryrestore = "SELECT * FROM orderitems WHERE orderid={$_POST["orderid"]}";
	$allquerystring .= $queryrestore."<br>";
	if ($result = $mysqli->query($queryrestore)) {
		while ($restoreitem = $result->fetch_object()) {
		     //echo $objectname->Name;
		     //echo "<br>";

			$previouslyissued = $restoreitem->amount + $restoreitem->amountissued;
			$restorequery = "
				INSERT INTO maininventory (modelid, amount) VALUES ({$restoreitem->modelid}, $previouslyissued) 
				ON DUPLICATE KEY UPDATE    
				modelid={$restoreitem->modelid}, 
				amount= amount + $previouslyissued


				";

			$allquerystring .= $restorequery."<br>";


			if(!($mysqli->query($restorequery))){
				$noerror = false;
			}
		}
	}

	//now we can safely remove the original items from order

	$query1 = "DELETE FROM orderitems WHERE orderid={$_POST["orderid"]}";

	$allquerystring .= $query1."<br>";

	$firstresult = $mysqli->query($query1);


	//adding new items to order
	//query for orderitems table insert
	$query2 = "INSERT INTO orderitems (orderid, modelid, amount, amountissued, amountfree, unitprice) VALUES ";

	foreach ($_POST['products'] as $product) {
		$totalamountforthisitem = $product[1] + $product[2]; 
		//print_r($product);
		//echo "{$product[0]}-{$product[1]}<br>";
		//$query2 .= "({$_POST["orderid"]}, {$product[0]}, 0,  $totalamountforthisitem, {$product[2]}), ";


		if(isset($_POST["complete"])){//only update main inventory and shop inventory if the user has pressed complete button
		
		if(array_key_exists($product[0], $productidarray)){//existing price
				$unitprice = $productidarray[$product[0]];
				//echo "{$product[0]} Exits <br>";
			}
			else{//new item 
				$dealerquery = "SELECT dealerid FROM orders WHERE orderid={$_POST["orderid"]} LIMIT 1";
				$thisdealer = 0;
				if ($dealerresult = $mysqli->query($dealerquery)) {
					$objectname = $dealerresult->fetch_object();
					$thisdealer = $objectname->dealerid;
				
				}
				$unitprice = getunitprice($thisdealer, $product[0]);
			}
			//query part to insert to ordersitms table
			$query2 .= "({$_POST["orderid"]}, {$product[0]}, 0,  $totalamountforthisitem, {$product[2]}, $unitprice), ";

		//remove issued items from main inventory
			$querymain = "UPDATE maininventory SET amount = amount-$totalamountforthisitem WHERE  modelid={$product[0]}";
			$allquerystring .= $querymain."<br>";
			if(!($mysqli->query($querymain))){
				$noerror = false;
			}

			//add issued items to the relevent dealer/shop
			$queryshop = "INSERT INTO `inventory` (dealerid, modelid, amount) VALUES ($dealerid, {$product[0]}, $totalamountforthisitem) ON DUPLICATE KEY UPDATE amount = amount + $totalamountforthisitem";
			$allquerystring .= $queryshop."<br>";
			if(!($mysqli->query($queryshop))){
				$noerror = false;
			}


		}
		else{//this means the user has pressed not deliverd button, so in orderistmes table amountissued=0;
			$query2 .= "({$_POST["orderid"]}, {$product[0]}, $totalamountforthisitem,  0, {$product[2]}), ";
		}				
	}

	$query2 = rtrim($query2, ", ");

	//exit();

	$allquerystring .= $query2."<br>";
	$secondresult =  $mysqli->query($query2);

	//update ordrestatus as completed
	if(isset($_POST["complete"])){
		$query3 = "UPDATE orders SET issued=3, lastupdate=".time()." WHERE orderid={$_POST["orderid"]}";
	}
	else{
		$query3 = "UPDATE orders SET issued=1, lastupdate=".time()." WHERE orderid={$_POST["orderid"]}";	
	}
	
	$allquerystring .= $query3."<br>";

	$thirdresult =  $mysqli->query($query3);

	//echo $allquerystring;


	if($noerror && $firstresult && $secondresult && $thirdresult){
		$mysqli->commit();
		if(isset($_POST["complete"])){
			header("Location: ../manageorders.php?action=ordercompleted");
		}
		else{
			header("Location: ../manageorders.php?action=notdelivered");
		}
		//echo "Success";
	}else{
		$mysqli->rollback();
		echo "Fail";
	}




}



?>