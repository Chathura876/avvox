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
	if(isset($_POST['username'])){

		//Get record count
		$resulttotal = mysqli_query($mysqli, "SELECT COUNT(*) AS RecordCount FROM user WHERE username='{$_POST['username']}' LIMIT 1");
		$row = mysqli_fetch_array($resulttotal, MYSQLI_ASSOC);
		$recordCount = $row['RecordCount'];
		if($recordCount>0){
			echo "taken";
		}
		else{
			echo "available";
		}		
	}
}
catch(Exception $ex)
{
	echo $ex->getMessage();

}
