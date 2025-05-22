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
		$query = "SELECT id, fullname, nic, address, phone1, phone2, email FROM user WHERE usertype='operator'";

		//UDARA
		if(isset($_POST["Name"]) && strlen($_POST["Name"]) > 0){
			$query .= "  AND CONCAT_WS(fullname, nic, address, phone1, phone2, email) LIKE '%".$_POST["Name"]."%'";
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
			$sorthingmethod = "fullname ASC";
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
		$username = htmlentities($_POST['username']); 
		$password = password_hash($_POST['password'], PASSWORD_DEFAULT); 
		$fullname = htmlentities($_POST['fullname']);  
		$nic = htmlentities($_POST['nic']); 
		$address = htmlentities($_POST['address']); 
		$phone1 = htmlentities($_POST['phone1']); 
		$phone2 = htmlentities($_POST['phone2']);
		$email = htmlentities($_POST['email']); 

		//Insert record into database

		$result = mysqli_query($mysqli, "INSERT INTO `user` (username, password, fullname, nic, address, phone1, phone2, email, usertype, role_id) VALUES ('$username', '$password', '$fullname', '$nic', '$address', '$phone1', '$phone2', '$email', 'operator',11)");
		
		//Get last inserted record to return to jTable so the new record will be displayed in the table
		$result = mysqli_query($mysqli, "SELECT * FROM user WHERE id = LAST_INSERT_ID();");
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
		$fullname = htmlentities($_POST['fullname']);  
		$nic = htmlentities($_POST['nic']); 
		$address = htmlentities($_POST['address']); 
		$phone1 = htmlentities($_POST['phone1']); 
		$phone2 = htmlentities($_POST['phone2']);
		$email = htmlentities($_POST['email']); 

		//Update record in database
		$result = mysqli_query($mysqli, "UPDATE user SET
		fullname = '$fullname',
		nic = '$nic',
		address = '$address',
		phone1 = '$phone1',
		phone2 = '$phone2',
		email = '$email'
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
		$result = mysqli_query($mysqli, "DELETE FROM user WHERE id = " . $_POST["id"] . ";");

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
