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
		$query = "SELECT warrantyid, fullname, nic, phone, address, purdate, modelid, product.model as modelname FROM customer
		    INNER JOIN product
		    WHERE customer.modelid = product.id
		";

		//UDARA
		if(isset($_POST["Name"]) && strlen($_POST["Name"]) > 0){
			$query .= "  AND CONCAT_WS(warrantyid, fullname, nic, phone, address, purdate, product.model) LIKE '%".$_POST["Name"]."%'";
			//$query .= " WHERE NAME LIKE '%".$_POST["Name"]."%'";
			if(!($_SESSION['usertype'] =='admin' || $_SESSION['usertype'] =='salesrep')){
				$query .= " AND dealerid={$_SESSION['id']}";
			}			
		}
		else{
			if(!($_SESSION['usertype'] =='admin' || $_SESSION['usertype'] =='salesrep')){
				$query .= " AND dealerid={$_SESSION['id']}";
			}
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
		    //$row['modelname'] = date("Y-m-d", $row['purdate']);
		    	
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
		$warrantyid = htmlentities($_POST['warrantyid']); 
		$fullname = htmlentities($_POST['fullname']); 
		$nic = htmlentities($_POST['nic']); 
		$phone = htmlentities($_POST['phone']); 
		$address = addslashes(htmlentities($_POST['address'])); 
		$purdate = htmlentities($_POST['purdate']); 
		$modelid = htmlentities($_POST['modelid']);
		if(isset($_POST["dealerid"])){
			$dealerid =  $_POST["dealerid"];
		}else{
			$dealerid =  $_SESSION['id'];
		}
		

		//echo "INSERT INTO customer (warrantyid, fullname, nic, phone, address, purdate, modelid) VALUES ('$warrantyid', '$fullname', '$nic', '$phone', '$address', $purdate, $modelid)";

		//exit();


		//Insert record into database

		$mysqli->begin_transaction();


		$firstresult = mysqli_query($mysqli, "INSERT INTO customer (warrantyid, fullname, nic, phone, address, purdate, modelid, dealerid) VALUES ('$warrantyid', '$fullname', '$nic', '$phone', '$address', '$purdate', $modelid, $dealerid)");
		

		$secondresult = mysqli_query($mysqli, "UPDATE inventory
			SET amount=amount-1
			WHERE dealerid=$dealerid AND modelid=$modelid");


		

		if($firstresult && $secondresult){
			$mysqli->commit();

			//Get last inserted record to return to jTable so the new record will be displayed in the table
			$result = mysqli_query($mysqli, "SELECT warrantyid, fullname, nic, phone, address, purdate, modelid FROM customer WHERE warrantyid = '$warrantyid'");
			$row = mysqli_fetch_array($result);

			//Return result to jTable
			$jTableResult = array();
			$jTableResult['Result'] = "OK";
			$jTableResult['Record'] = $row;
			print json_encode($jTableResult);
		}else{
			$mysqli->rollback();
			//echo "Fail";
		}



	}
	//Updating a record (updateAction)
	else if($_GET["action"] == "update")
	{
		$warrantyid = htmlentities($_POST['warrantyid']); 
		$fullname = htmlentities($_POST['fullname']); 
		$nic = htmlentities($_POST['nic']); 
		$phone = htmlentities($_POST['phone']); 
		$address = addslashes((htmlentities($_POST['address']))); 



		//Update record in database
		if($result = mysqli_query($mysqli, "UPDATE customer SET
		fullname = '$fullname',
		nic = '$nic',
		phone = '$phone',
		address = '$address'
		WHERE warrantyid='$warrantyid'")){
					//Return result to jTable
			$jTableResult = array();
			$jTableResult['Result'] = "OK";
			print json_encode($jTableResult);
		}


	}
	//Deleting a record (deleteAction)
	else if($_GET["action"] == "delete")
	{
		//Delete from database
		if($result = mysqli_query($mysqli, "DELETE FROM customer WHERE warrantyid = '". $_POST["warrantyid"] ."'")){
		//Return result to jTable
			$jTableResult = array();
			$jTableResult['Result'] = "OK";
			print json_encode($jTableResult);			

		}


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