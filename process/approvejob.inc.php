<?php
require_once("../common/logincheck.php");
require_once("../common/database.php");
if (!($userloggedin)) {//Prevent the user visiting this page if not logged in 
  //Redirect to user account page
  //header("Location: login.php");
  http_response_code(403);
  die();
}

//exit("Byeeeeee");
try
{	
	if(isset($_POST['jobid'])){
			$timeapproved = date("Y-m-d H:i:s");

			if($result = mysqli_query($mysqli, "UPDATE job SET 
			status = 1, 
			timeapproved='$timeapproved',
			approvedby = {$_SESSION['id']}
			WHERE id={$_POST['jobid']}")){
				echo "approved";
			}
		
	}
}
catch(Exception $ex)
{
	echo $ex->getMessage();

}
	
?>