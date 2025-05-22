<?php
require_once("../common/logincheck.php");
require_once("../common/database.php");
if (!($userloggedin)) { //Prevent the user visiting this page if not logged in 
	//Redirect to user account page
	//header("Location: login.php");
	http_response_code(403);
	die();
}
try {

	//Getting records (listAction)
	if ($_GET["action"] == "list") {

		//Get record count
		//$resulttotal = mysqli_query($mysqli, "SELECT COUNT(*) AS RecordCount FROM user");
		//$row = mysqli_fetch_array($resulttotal, MYSQLI_ASSOC);
		//$recordCount = $row['RecordCount'];

		//Get records from database
		//$result = mysql_query("SELECT * FROM people;");
		//$countquery = "SELECT COUNT(*) AS RecordCount FROM people";
		$query = "SELECT orderid, fullname, shopname, ordertime, issued, lastupdate, area, section  FROM orders 
		INNER JOIN user
		WHERE orders.dealerid = user.id";

		if ($_SESSION['usertype'] == 'salesrep') { //special view for salesrep
			$query .= " AND user.repid={$_SESSION['id']}";
		}

		if ($_POST["orderstatus"] != 4) { //4 means all
			$query .= " AND orders.issued={$_POST["orderstatus"]}";
		}


		//UDARA
		if (isset($_POST["Name"]) && strlen($_POST["Name"]) > 0) {
			$query .= "  AND CONCAT_WS(orders.orderid, user.fullname, user.shopname, user.area) LIKE '%" . $_POST["Name"] . "%'";
			//$query .= " WHERE NAME LIKE '%".$_POST["Name"]."%'";
		}

		if ($_SESSION['usertype'] == 'dealer' || $_SESSION['usertype'] == 'shop') {
			$query .= " AND orders.dealerid={$_SESSION['id']}";
		}


		//echo $query;		

		//calculate total number of results before limiting results
		$resulttotal = mysqli_query($mysqli, $query);
		$recordCount = $resulttotal->num_rows;

		//add limits to query
		if (isset($_GET["jtSorting"])) {
			$sorthingmethod = $_GET["jtSorting"];
		} else {
			$sorthingmethod = "lastupdate DESC";
		}
		//if($recordCount > $_GET["jtPageSize"]){
		$query .= " ORDER BY $sorthingmethod LIMIT " . $_GET["jtStartIndex"] . "," . $_GET["jtPageSize"];
		//}


		//UDARA
		$result = mysqli_query($mysqli, $query);
		//$recordCount = $result->num_rows;

		//Add all records to an array
		$rows = array();
		while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {

			if ($row['issued'] == 0) { //pending approval
				if ($_SESSION['usertype'] == 'admin' || $_SESSION['usertype'] == 'operator') {
					$row['actions'] = "


				    <a class='btn btn-success btn-sm my-1' style='color:white' href='approveorder.php?updatetype=edit&orderid={$row['orderid']}' role='button'>Edit</a>

				    <a class='btn btn-success btn-sm my-1' style='color:white' href='approveorder.php?orderid={$row['orderid']}' role='button'>Approve</a>
				    <a class='btn btn-success btn-sm my-1' style='color:white' onclick='cancelconfirm({$row['orderid']})'>Cancel</a>

				    ";
				}else if($_SESSION['usertype'] == 'accountant'){
					$row['actions'] = "Pending";
				} else {
					$row['actions'] = "

                    <a class='btn btn-success btn-sm my-1' style='color:white' href='approveorder.php?updatetype=edit&orderid={$row['orderid']}' role='button'>Edit</a>

				    ";
				}
			} else if ($row['issued'] == 1) { //Approved
				if ($_SESSION['usertype'] == 'accountant' || $_SESSION['usertype'] == 'technician' || $_SESSION['usertype'] == 'director') {
					$row['actions'] = "Approved";
				} else if ($_SESSION['usertype'] == 'storeskeeper' || $_SESSION['usertype'] == 'operator') {
					$row['actions'] = "




				    <a class='btn btn-success btn-sm my-1' style='color:white' href='issueorder.php?orderid={$row['orderid']}' role='button'>Issue</a>
				    <a class='btn btn-success btn-sm my-1' style='color:white' onclick='cancelconfirm({$row['orderid']})'>Cancel</a>
				    ";
				} else {
					$row['actions'] = "




				    <a class='btn btn-success btn-sm my-1' style='color:white' href='issueorder.php?orderid={$row['orderid']}' role='button'>Issue</a>
				    <a class='btn btn-success btn-sm my-1' style='color:white' onclick='cancelconfirm({$row['orderid']})'>Cancel</a>
				    ";
				}
			} else if ($row['issued'] == 2) { //Issued
				if ($_SESSION['usertype'] == 'admin' || $_SESSION['usertype'] == 'operator') {
					$row['actions'] = "
				    <a class='btn btn-success btn-sm my-1' style='color:white' href='completeorder.php?orderid={$row['orderid']}' role='button'>Complete</a>
				    <a class='btn btn-success btn-sm my-1' style='color:white' href='generateinvoice.php?orderid={$row['orderid']}' role='button'>Invoice</a>
				    <a class='btn btn-success btn-sm my-1' style='color:white' href='generatedeliveryorder.php?orderid={$row['orderid']}' role='button'>Delivery Order</a>				    
				    ";
				} else {
					$row['actions'] = "Issued";
				}
			} else { //Completed
				if ($_SESSION['usertype'] != 'admin') {
					$row['actions'] = "Completed";
				} else {
					$row['actions'] = "
				    <a class='btn btn-success btn-sm my-1' style='color:white' href='generateinvoice.php?orderid={$row['orderid']}' role='button'>Invoice</a>
				    <a class='btn btn-success btn-sm my-1' style='color:white' href='generatedeliveryorder.php?orderid={$row['orderid']}' role='button'>Delivery Order</a>				    
				    ";
				}
			}

			$row['ordertime'] = date("Y-m-d h:i:s A", $row['ordertime']);

			$row['summary'] = "<button type='button' value='{$row['orderid']}' class='btn btn-primary btn-sm' data-toggle='modal' data-target='#exampleModal'>Details</button>";

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
	else if ($_GET["action"] == "create") {
		$username = htmlentities($_POST['username']);
		$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
		$fullname = htmlentities($_POST['fullname']);
		$shopname = htmlentities($_POST['shopname']);
		$nic = htmlentities($_POST['nic']);
		$address = htmlentities($_POST['address']);
		$phone1 = htmlentities($_POST['phone1']);
		$phone2 = htmlentities($_POST['phone2']);

		//Insert record into database

		$result = mysqli_query($mysqli, "INSERT INTO `user` (username, password, fullname, shopname, nic, address, phone1, phone2,  usertype) VALUES ('$username', '$password', '$fullname', '$shopname', '$nic', '$address', '$phone1', '$phone2', 'dealer')");

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
	else if ($_GET["action"] == "update") {
		$id = $_POST['id'];
		$fullname = htmlentities($_POST['fullname']);
		$shopname = htmlentities($_POST['shopname']);
		$nic = htmlentities($_POST['nic']);
		$address = htmlentities($_POST['address']);
		$phone1 = htmlentities($_POST['phone1']);
		$phone2 = htmlentities($_POST['phone2']);

		//Update record in database
		$result = mysqli_query($mysqli, "UPDATE user SET
		fullname = '$fullname',
		shopname = '$shopname',
		nic = '$nic',
		address = '$address',
		phone1 = '$phone1',
		phone2 = '$phone2'
		WHERE id=$id");

		//Return result to jTable
		$jTableResult = array();
		$jTableResult['Result'] = "OK";
		print json_encode($jTableResult);
	}
	//Deleting a record (deleteAction)
	else if ($_GET["action"] == "delete") {
		//Delete from database
		$result = mysqli_query($mysqli, "DELETE FROM user WHERE id = " . $_POST["id"] . ";");

		//Return result to jTable
		$jTableResult = array();
		$jTableResult['Result'] = "OK";
		print json_encode($jTableResult);
	}
} catch (Exception $ex) {
	//Return error message
	$jTableResult = array();
	$jTableResult['Result'] = "ERROR";
	$jTableResult['Message'] = $ex->getMessage();
	print json_encode($jTableResult);
}
