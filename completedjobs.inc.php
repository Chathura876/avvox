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
		$query = "SELECT job.id AS id, contactname, contactno, timeadded, status, jobtype, timecompleted, user.fullname, user2.shopname FROM job 
		INNER JOIN user ON job.techid = user.id 
		INNER JOIN user AS user2 ON job.dealerid = user2.id 
		WHERE status=2";

		//UDARA
		if(isset($_POST["Name"])){
			$query .= "  AND CONCAT(job.id, contactname, contactno, timeadded, fullname) LIKE '%".$_POST["Name"]."%'";
			//$query .= " WHERE NAME LIKE '%".$_POST["Name"]."%'";
		}

		if($_SESSION['usertype'] =='dealer' || $_SESSION['usertype'] =='shop'){
			$query .= " AND dealerid={$_SESSION['id']}";
		}
		else if($_SESSION['usertype'] =='technician'){
			$query .= " AND techid={$_SESSION['id']}";
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
			<button type='button' value='{$row['id']}' class='btn btn-primary btn-sm my-1 mx-auto' data-toggle='modal' data-target='#exampleModal'>&nbsp;&nbsp;View Log&nbsp;&nbsp;</button>
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