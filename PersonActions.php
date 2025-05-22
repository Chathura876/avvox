<?php
require_once "common/functions.php";
try
{
	
	//Getting records (listAction)
	if($_GET["action"] == "list")
	{
		
		//Get record count
		$resulttotal = mysqli_query($mysqli, "SELECT COUNT(*) AS RecordCount FROM people");
		$row = mysqli_fetch_array($resulttotal, MYSQLI_ASSOC);
		$recordCount = $row['RecordCount'];

		//Get records from database
		//$result = mysql_query("SELECT * FROM people;");
		$countquery = "SELECT COUNT(*) AS RecordCount FROM people";
		$query = "SELECT * FROM people";

		//UDARA
		if(isset($_POST["Name"])){
			$query .= " WHERE NAME LIKE '%".$_POST["Name"]."%'";
			//$query .= " WHERE NAME LIKE '%".$_POST["Name"]."%'";
		}

		//calculate total number of results before limiting results
		$resulttotal = mysqli_query($mysqli, $query);
		$recordCount = $resulttotal->num_rows;

		//add limits to query
		$query .= " ORDER BY " . $_GET["jtSorting"] . " LIMIT " . $_GET["jtStartIndex"] . "," . $_GET["jtPageSize"] ;

		//UDARA
		$result = mysqli_query($mysqli, $query);
		//$recordCount = $result->num_rows;
		
		//Add all records to an array
		$rows = array();
		while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
		{
		    $row['profilelink'] = "<a href='profile.php?id={$row['PersonId']}'> View Profile</a>";//adding custom element to array (profilelink)
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
		//Insert record into database
		$result = mysqli_query($mysqli, "INSERT INTO people(Name, Age, RecordDate) VALUES('" . $_POST["Name"] . "', " . $_POST["Age"] . ",now());");
		
		//Get last inserted record (to return to jTable)
		$result = mysqli_query($mysqli, "SELECT * FROM people WHERE PersonId = LAST_INSERT_ID();");
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
		//Update record in database
		$result = mysqli_query($mysqli, "UPDATE people SET Name = '" . $_POST["Name"] . "', Age = " . $_POST["Age"] . ", RecordDate = '" . $_POST["RecordDate"] . "', sex = '" . $_POST["sex"] . "', about = '" . $_POST["about"] . "' WHERE PersonId = " . $_POST["PersonId"] . ";");

		//Return result to jTable
		$jTableResult = array();
		$jTableResult['Result'] = "OK";
		print json_encode($jTableResult);
	}
	//Deleting a record (deleteAction)
	else if($_GET["action"] == "delete")
	{
		//Delete from database
		$result = mysqli_query($mysqli, "DELETE FROM people WHERE PersonId = " . $_POST["PersonId"] . ";");

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