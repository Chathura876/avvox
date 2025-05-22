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

		$query = "SELECT perm_id,perm_type, perm_desc FROM `permissions`";

		//UDARA
		if(isset($_POST["Name"]) && strlen($_POST["Name"]) > 0){
			//$query .= "  AND CONCAT_WS(fullname, nic, address, phone1, phone2, email) LIKE '%".$_POST["Name"]."%'";
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
			$sorthingmethod = "perm_id ASC";
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
		    $rows[] = $row;
		    //print_r($row);
		    //echo "<br><br><br>";
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
		$type = htmlentities($_POST['perm_type']);
		$description = htmlentities($_POST['perm_desc']);


		//Insert record into database

		$result = mysqli_query($mysqli, "INSERT INTO `permissions` (perm_type,perm_desc) VALUES ('$type','$description')");
		
		//Get last inserted record to return to jTable so the new record will be displayed in the table
		$result = mysqli_query($mysqli, "SELECT * FROM `permissions` WHERE perm_id = LAST_INSERT_ID();");
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
		$id = $_POST['perm_id'];
		$type = htmlentities($_POST['perm_type']);
		$description = htmlentities($_POST['perm_desc']);

		//Update record in database
		$result = mysqli_query($mysqli, "UPDATE `permissions` SET
		perm_type = '$type',
		perm_desc = '$description'
		WHERE perm_id=$id");

		//Return result to jTable
		$jTableResult = array();
		$jTableResult['Result'] = "OK";
		print json_encode($jTableResult);
	}
	//Deleting a record (deleteAction)
	else if($_GET["action"] == "delete")
	{
		//Delete from database
		$result = mysqli_query($mysqli, "DELETE FROM `permissions` WHERE perm_id = " . $_POST["id"] . ";");

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
