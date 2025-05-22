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
		$query = "SELECT * FROM product";

		//UDARA
		if(isset($_POST["Name"]) && strlen($_POST["Name"]) > 0){
			$query .= "  WHERE model LIKE '%".$_POST["Name"]."%'";
			//$query .= " WHERE NAME LIKE '%".$_POST["Name"]."%'";
		}

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
		

		//UDARA
		$result = mysqli_query($mysqli, $query);
		//$recordCount = $result->num_rows;
		
		//Add all records to an array
		$rows = array();
		while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
		{
		    

		    $row['imageupload'] = "<form class='form-inline' method='post' action='uploadimage.php' enctype='multipart/form-data'>
  <div class='form-group mx-sm-3 mb-2'>
    <label class='btn btn-success'> +
    <input type='file' hidden class='form-control btn btn-primary' name='fileToUpload' id='fileToUpload'>
    </label>
  </div>
      <input type='hidden' class='form-control' name='productid' value='{$row['id']}'>
  </div>
  <button type='submit' class='btn btn-primary mb-2'>Upload</button>
</form>";

			
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

		$addquery = "INSERT IGNORE INTO product (model, timeadded, status, pricedefault, pricesilver, pricegold, priceplatinum, cmb) VALUES ('$model', '".time()."', '$status', '{$_POST['pricedefault']}', '{$_POST['pricesilver']}', '{$_POST['pricegold']}', '{$_POST['priceplatinum']}', {$_POST['cmb']})";

		//echo "<br><br>";

		$result = mysqli_query($mysqli, $addquery);

		//$lastresult = mysqli_fetch_array($result);
		$lastproductid = $mysqli->insert_id;

		$result2 = mysqli_query($mysqli, "INSERT INTO maininventory (modelid, amount) VALUES ($lastproductid, 0)");
		
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
		$id = $_POST['id'];
		$model = htmlentities($_POST['model'], ENT_QUOTES);
		$status = $_POST['status']; 

		//Update record in database
		$result = mysqli_query($mysqli, "UPDATE product SET
		model = '$model',
		status = '$status',
		pricedefault = {$_POST['pricedefault']},
		pricesilver = {$_POST['pricesilver']},
		pricegold = {$_POST['pricegold']},
		priceplatinum = {$_POST['priceplatinum']},
		cmb = {$_POST['cmb']}
		WHERE id=$id");

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