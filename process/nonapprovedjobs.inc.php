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
		$query = "SELECT job.id AS id, contactname, contactno, timeadded, status, jobtype, fullname FROM job 
		INNER JOIN user
		WHERE job.techid = user.id
		AND status=0";

		//UDARA
		if(isset($_POST["Name"]) && strlen($_POST["Name"]) > 0){
			$query .= "  AND CONCAT_WS(job.id, contactname, contactno, timeadded, fullname) LIKE '%".$_POST["Name"]."%'";
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
			$sorthingmethod = "id DESC";
		}
		//if($recordCount > $_GET["jtPageSize"]){
			$query .= " ORDER BY $sorthingmethod LIMIT " . $_GET["jtStartIndex"] . "," . $_GET["jtPageSize"] ;
		//}
		

		//UDARA
		$result = mysqli_query($mysqli, $query);
		//$recordCount = $result->num_rows;
		
		//Add all records to an array
		$rows = array();
		while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
		{
		    
			// if($row['issued']== 0){
			//     $row['actions'] = "<a class='btn btn-success btn-sm' style='color:white' href='issueorder.php?orderid={$row['orderid']}' role='button'>Issue</a>
			//     ";
			// }
			// else{
			//     $row['actions'] = "Issued";				
			// }

			// $row['ordertime'] = date("Y-m-d", $row['ordertime']);

		 //    $row['summary'] ="<button type='button' value='{$row['orderid']}' class='btn btn-primary btn-sm' data-toggle='modal' data-target='#exampleModal'>Details</button>";
			$row['actions'] = "
			<button type='button' id='udara' onclick='approvejob(this)' value='{$row['id']}' class='btn btn-primary btn-sm my-1 mx-auto jobapprove'>Approve</button>
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