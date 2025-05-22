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
	if(isset($_POST['jobid3'])){


			$timecompleted = date("Y-m-d H:i:s");

			$mysqli->begin_transaction();


			$query1 = "UPDATE job SET 
			status = 3, 
			timecompleted ='$timecompleted',
			completedby = {$_SESSION['id']}
			WHERE id={$_POST['jobid3']}";


			$firstresult = $mysqli->query($query1);

			$finallog = "Job Was Marked as verified. ".PHP_EOL.$_POST['description3'];

			$query2 = "INSERT INTO joblog (jobid, description, timeadded, addedby) VALUES ( {$_POST['jobid3']}, '$finallog', '$timecompleted', {$_SESSION['id']})";

			$secondresult =  $mysqli->query($query2);



			if($firstresult && $secondresult){
				$mysqli->commit();
				//header("Location: ../success.php?action=jobcompleted");
				echo "verified";
			}else{
				$mysqli->rollback();
				echo "Fail";
			}			
		
	}
}
catch(Exception $ex)
{
	echo $ex->getMessage();

}
	
?>