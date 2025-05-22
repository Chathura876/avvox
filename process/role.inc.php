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

		//$query = "SELECT role_id, role_name FROM `roles`";
		// $query = "SELECT *
        // from roles_permissions rp
        //     inner join roles r on rp.role_id = r.role_id
        //     inner join permissions p on rp.perm_id = p.perm_id group by rp.role_id";
            $query = "SELECT * FROM roles";

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
			$sorthingmethod = "role_id ASC";
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
            
            
            $row['actions'] = "

            <a class='btn btn-success btn-sm my-1' style='color:white' href='addrole.php?role_id={$row['role_id']}' role='button'>Edit Permission</a>

            ";

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
		$description = htmlentities($_POST['role_name']);


		//Insert record into database

		$result = mysqli_query($mysqli, "INSERT INTO `roles` (role_name) VALUES ('$description')");
		
		//Get last inserted record to return to jTable so the new record will be displayed in the table
		$result = mysqli_query($mysqli, "SELECT * FROM `roles` WHERE role_id = LAST_INSERT_ID();");
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
		$description = htmlentities($_POST['perm_desc']);

		//Update record in database
		$result = mysqli_query($mysqli, "UPDATE `permissions` SET
		perm_desc = '$description'
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
		$result = mysqli_query($mysqli, "DELETE FROM `roles` WHERE role_id = " . $_POST["role_id"] . ";");

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
