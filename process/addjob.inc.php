<?php
require_once("../common/logincheck.php");
require_once("../common/database.php");
if (!($userloggedin)) {//Prevent the user visiting this page if not logged in 
  //Redirect to user account page
  //header("Location: login.php");
  http_response_code(403);
  die();
}

if(isset($_POST['addtype'])){
	if($_POST['addtype']=="new"){//not existing item in the system. have to add the information to customer table too
		//here we have to add it for  customer, job, joblog tables
		$warrantyid = htmlentities($_POST['warrantyid']); 
		$fullname = htmlentities($_POST['contactname']); 
		$nic = htmlentities($_POST['nic']); 
		$phone = htmlentities($_POST['contactno']); 
		$address = addslashes(htmlentities($_POST['address'])); 
		$purdate = htmlentities($_POST['purchaseddate']); 
		$modelid = htmlentities($_POST['modelid']);
		$dealerid =  htmlentities($_POST['dealerid']);
		$timeadded = date("Y-m-d H:i:s");
		$techid = htmlentities($_POST['techid']);
		$jobtype = htmlentities($_POST['jobtype']);
		$addedby = $_SESSION['id'];
		$description = addslashes(htmlentities($_POST['description']));

		if($jobtype=="Free"){
			$jobstatus = 1;//0 paid not approved, 1 free or paid approved, 2 completed
		}
		else{
			$jobstatus = 0;
		}


		$mysqli->begin_transaction();
		
/* 		echo "INSERT INTO customer (warrantyid, fullname, nic, phone, address, purdate, modelid, dealerid) VALUES ('$warrantyid', '$fullname', '$nic', '$phone', '$address', '$purdate', $modelid, $dealerid)";
		
		echo "<br>";
		
		echo "INSERT INTO job ( warrantyid, contactname, contactno, techid, timeadded, status, jobtype, addedby) VALUES ('$warrantyid', '$fullname', '$phone', $techid, '$timeadded', $jobstatus, '$jobtype', $addedby)";
		
		echo "<br>";
		
		echo "INSERT INTO joblog (jobid, description, timeadded, addedby) VALUES (LAST_INSERT_ID(), '$description', '$timeadded', $addedby)";
		
		exit(); */

		$firstresult = mysqli_query($mysqli, "INSERT INTO customer (warrantyid, fullname, nic, phone, address, purdate, modelid, dealerid) VALUES ('$warrantyid', '$fullname', '$nic', '$phone', '$address', '$purdate', $modelid, $dealerid)");

		$secondresult = mysqli_query($mysqli, "INSERT INTO job ( warrantyid, contactname, contactno, techid, dealerid, timeadded, status, jobtype, addedby, lastupdate) VALUES ('$warrantyid', '$fullname', '$phone', $techid, $dealerid, '$timeadded', $jobstatus, '$jobtype', $addedby, ".time().")");

		$last_id = mysqli_insert_id($mysqli);		

		$thirdresult = mysqli_query($mysqli, "INSERT INTO joblog (jobid, description, timeadded, addedby) VALUES (LAST_INSERT_ID(), '$description', '$timeadded', $addedby)");

		if($firstresult && $secondresult && $thirdresult){
			$mysqli->commit();
			//echo "Success";
			header("Location: ../addjob.php?action=added&jobid=$last_id");
			
		}else{
			$mysqli->rollback();
			echo "Fail";
		}				

	}
	else{//job for a existing item in the system
		$warrantyid = htmlentities($_POST['warrantyid']);
		$fullname = htmlentities($_POST['contactname']); 
		$phone = htmlentities($_POST['contactno']); 
		$timeadded = date("Y-m-d H:i:s");
		$techid = htmlentities($_POST['techid']);
		$jobtype = htmlentities($_POST['jobtype']);
		$addedby = $_SESSION['id'];
		$description = addslashes(htmlentities($_POST['description']));
		$olddealerid = htmlentities($_POST['olddealerid']);

		if($jobtype=="Free"){
			$jobstatus = 1;//0 paid not approved, 1 free or paid approved, 2 completed
		}
		else{
			$jobstatus = 0;
		}


		$mysqli->begin_transaction();
		
/* 		echo "INSERT INTO job ( warrantyid, contactname, contactno, techid, timeadded, status, jobtype, addedby) VALUES ('$warrantyid', '$fullname', '$phone', $techid, $timeadded, 0, '$jobtype', $addedby)";
		
		echo "<br>";
		
		echo "INSERT INTO joblog (jobid, description, timeadded, addedby) VALUES (LAST_INSERT_ID(), '$description', $timeadded, $addedby)";
		
		exit(); */
		

		$firstresult = mysqli_query($mysqli, "INSERT INTO job ( warrantyid, contactname, contactno, techid, dealerid, timeadded, status, jobtype, addedby, lastupdate) VALUES ('$warrantyid', '$fullname', '$phone', $techid, $olddealerid, '$timeadded', $jobstatus, '$jobtype', $addedby, ".time().")");

		$last_id = mysqli_insert_id($mysqli);

		$secondresult = mysqli_query($mysqli, "INSERT INTO joblog (jobid, description, timeadded, addedby) VALUES (LAST_INSERT_ID(), '$description', '$timeadded', $addedby)");



		if($firstresult && $secondresult){
			$mysqli->commit();
			//echo "Success";
			header("Location: ../addjob.php?action=added&jobid=$last_id");
			
		}else{
			$mysqli->rollback();
			echo "Fail";
		}	

	}
}

	
?>