<?php
require_once("../common/logincheck.php");
require_once("../common/database.php");
if (!($userloggedin)) {//Prevent the user visiting this page if not logged in 
  //Redirect to user account page
  //header("Location: login.php");
  http_response_code(403);
  die();
}

if(isset($_POST['jobid'])){


		if(isset($_POST['description'])){
			$description = htmlentities($_POST['description'], ENT_QUOTES);
		}else{
			$description = htmlentities($_POST['log'], ENT_QUOTES);
		}

		$timeadded = date("Y-m-d H:i:s");

		$addedby = $_SESSION['id'];

		$query = "INSERT INTO joblog (jobid, description, timeadded, addedby) VALUES ( {$_POST['jobid']}, '$description', '$timeadded', $addedby)";

		$query2 = "UPDATE job SET lastupdate=".time()." WHERE id={$_POST['jobid']}";


		if(mysqli_query($mysqli, $query) && mysqli_query($mysqli, $query2)){
			echo "updated";
			//header("Location: ../success.php?action=jobupdatecomplete");
		}

		exit();

	
}

	
?>