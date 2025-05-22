<?php
require_once("../common/logincheck.php");
require_once("../common/database.php");
if (!($userloggedin)) {//Prevent the user visiting this page if not logged in 
  //Redirect to user account page
  //header("Location: login.php");
  http_response_code(403);
  die();
}
try
{
	
	//Getting records (listAction)
	if($_GET["action"] == "list")
	{
		
		//Get record count
		//$resulttotal = mysqli_query($mysqli, "SELECT COUNT(*) AS RecordCount FROM user");
		//$row = mysqli_fetch_array($resulttotal, MYSQLI_ASSOC);
		//$recordCount = $row['RecordCount'];

		//Get records from database
		//$result = mysql_query("SELECT * FROM people;");
		//$countquery = "SELECT COUNT(*) AS RecordCount FROM people";
		// $query = "SELECT product.*, maininventory.amount AS quantity, SUM(orderitems.amount) AS pending FROM product
		// INNER JOIN maininventory ON product.id = maininventory.modelid 
		// INNER JOIN orderitems ON product.id = orderitems.modelid 
		// GROUP BY orderitems.modelid
		// ";

	// 	$query = "
	// 	SELECT product.*, maininventory.amount AS quantity, sum(orderitems.amount) AS pending FROM `orderitems` 
	// 	inner join product
	// 	inner join orders 
	// 	inner join maininventory
	// 	where orderitems.modelid=product.id
	// 	AND orderitems.orderid = orders.orderid 
	// 	AND maininventory.modelid = product.id
	// 	AND orders.issued = 0  
	// 	group by orderitems.modelid
	// ";		

	// 	$query = "
	// 	SELECT product.*, maininventory.amount AS quantity, sum(orderitems.amount) AS pending FROM product 
	// 	inner join maininventory ON maininventory.modelid = product.id
 //        INNER JOIN orderitems  ON orderitems.modelid = product.id 
	// 	group by orderitems.modelid
	// ";	

/*		$query = "
		SELECT product.*, maininventory.amount AS quantity, sum(orderitems.amount) AS pending FROM product 
		LEFT join maininventory ON maininventory.modelid = product.id
        LEFT JOIN orderitems  ON orderitems.modelid = product.id 
        LEFT JOIN orders ON orderitems.orderid = orders.orderid AND orders.issued = 0 		
		";*/

		$query = "
		SELECT product.* , maininventory.amount AS quantity, 
		(SELECT SUM(amount) FROM orderitems INNER join orders on orderitems.orderid= orders.orderid and orders.issued<2 WHERE orderitems.modelid = product.id) AS pending 
		FROM product 
		INNER JOIN maininventory ON maininventory.modelid = product.id 
		";


/*SELECT product.* , (SELECT SUM(amount) FROM orderitems WHERE orderitems.modelid = product.id) AS pending FROM product
LEFT JOIN orderitems ON product.id = orderitems.modelid



SELECT product.* , (SELECT SUM(amount) FROM orderitems INNER join orders on orderitems.orderid= orders.orderid and orders.issued=0 WHERE orderitems.modelid = product.id) AS pending FROM product 
INNER JOIN maininventory ON maininventory.productid = product.id

*/
		//UDARA
		if(isset($_POST["Name"]) && strlen($_POST["Name"]) > 0){
			$query .= " WHERE CONCAT_WS(product.id, product.model)  LIKE '%".$_POST["Name"]."%'";
			//$query .= "  AND product.model  LIKE '%".$_POST["Name"]."%'";
			//$query .= " WHERE NAME LIKE '%".$_POST["Name"]."%'";
		}

		//$query .= " group by orderitems.modelid";
		//echo $query;

		//calculate total number of results before limiting results
		$resulttotal = mysqli_query($mysqli, $query);
		$recordCount = $resulttotal->num_rows;

		//add limits to query
		if(isset($_GET["jtSorting"])){
			$sorthingmethod = $_GET["jtSorting"];
		}
		else{
			$sorthingmethod = "model ASC";
		}
		if($recordCount > $_GET["jtPageSize"]){
			$query .= " ORDER BY $sorthingmethod LIMIT " . $_GET["jtStartIndex"] . "," . $_GET["jtPageSize"] ;
		}
		
		//echo $query;
		//UDARA
		$result = mysqli_query($mysqli, $query);
		//$recordCount = $result->num_rows;
		
		//Add all records to an array
		$rows = array();
		while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
		{
		    
			
			if(file_exists("../uploads/productimages/thumbs/{$row['id']}.jpg")){
				//$row['productimage'] = "<img src='uploads/productimages/thumbs/{$row['id']}.jpg' >";
				$row['productimage'] = "<a href='uploads/productimages/{$row['id']}.jpg' data-toggle='lightbox' data-title='Product: {$row['model']}'>
    				<img src='uploads/productimages/thumbs/{$row['id']}.jpg' class='img-fluid'>";
			}
			else if(file_exists("../uploads/productimages/{$row['id']}.jpeg")){
				$row['productimage'] = "<img src='uploads/productimages/{$row['id']}.jpeg' >";
			}			
			else if(file_exists("../uploads/productimages/{$row['id']}.png")){
				$row['productimage'] = "<img src='uploads/productimages/{$row['id']}.png' >";
			}
			else if(file_exists("../uploads/productimages/{$row['id']}.bmp")){
				$row['productimage'] = "<img src='uploads/productimages/{$row['id']}.bmp' >";
			}
			else if(file_exists("../uploads/productimages/{$row['id']}.gif")){
				$row['productimage'] = "<img src='uploads/productimages/{$row['id']}.gif' >";
			}									
			else{
				$row['productimage'] = "No Image";
			}

			$row['quantitysellable'] = $row['quantity'] - $row['pending'];

			if(is_null($row['pending'])){
				$row['pending'] = 0;
			}

			$rows[] = $row;
		}		


		//Return result to jTable
		$jTableResult = array();
		$jTableResult['Result'] = "OK";
		$jTableResult['TotalRecordCount'] = $recordCount;
		$jTableResult['Records'] = $rows;
		print json_encode($jTableResult);
	}
	//Creating a new record (createAction)
	else if($_GET["action"] == "create")
	{ 
		$model = htmlentities($_POST['model'], ENT_QUOTES); 
		$status = $_POST['status'];

		//Insert record into database

		$result = mysqli_query($mysqli, "INSERT IGNORE INTO product (model, timeadded, status) VALUES ('$model', '".time()."', '$status', '{$_POST['pricedefault']}', '{$_POST['pricesilver']}', '{$_POST['pricegold']}', '{$_POST['priceplatinum']}, {$_POST['cmb']})");
		
		//Get last inserted record to return to jTable so the new record will be displayed in the table
		$result = mysqli_query($mysqli, "SELECT * FROM product WHERE id = LAST_INSERT_ID();");
		$row = mysqli_fetch_array($result);

		//Return result to jTable
		$jTableResult = array();
		$jTableResult['Result'] = "OK";
		$jTableResult['Record'] = $row;
		print json_encode($jTableResult);
	}
	//Updating a record (updateAction)
	else if($_GET["action"] == "update")
	{
		$modelid = $_POST['id'];
		//$model = htmlentities($_POST['model'], ENT_QUOTES);
		$amount = $_POST['addamount']; 
		$addedtime = date("Y-m-d H:i:s");
		$note = addslashes(htmlentities($_POST['note']));


		//Update record in database
		if($_POST["action"] == "add"){//user is trying to add to inventory
			$result = mysqli_query($mysqli, "
			INSERT INTO maininventory (modelid, amount) VALUES ($modelid, $amount) 
			ON DUPLICATE KEY UPDATE    
			modelid=$modelid, 
			amount= amount + $amount
			");
		}
		else{//user is trying to remove from inventory
			$result = mysqli_query($mysqli, "
			INSERT INTO maininventory (modelid, amount) VALUES ($modelid, $amount) 
			ON DUPLICATE KEY UPDATE    
			modelid=$modelid, 
			amount= amount - $amount
			");
			$amount = $amount*-1;//after updating the inventory topup table amount should be minus
		}

		$result2 = mysqli_query($mysqli, "INSERT INTO topup (topupid, productid, quantity, topupdate, addedtime, note, addedby) VALUES (NULL, $modelid, {$_POST['addamount']}, '{$_POST['date']}', '$addedtime', '$note', {$_SESSION['id']})");


		//Return result to jTable
		$jTableResult = array();
		$jTableResult['Result'] = "OK";
		print json_encode($jTableResult);
	}
	//Deleting a record (deleteAction)
	else if($_GET["action"] == "delete")
	{
		//Delete from database
		$result = mysqli_query($mysqli, "DELETE FROM product WHERE id = " . $_POST["id"] . ";");

		//Return result to jTable
		$jTableResult = array();
		$jTableResult['Result'] = "OK";
		print json_encode($jTableResult);
	}



}
catch(Exception $ex)
{
    //Return error message
	$jTableResult = array();
	$jTableResult['Result'] = "ERROR";
	$jTableResult['Message'] = $ex->getMessage();
	print json_encode($jTableResult);
}
	
?>