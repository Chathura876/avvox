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

		$query = "SELECT joblog.*, fullname FROM joblog
		INNER JOIN user
		WHERE jobid={$_POST['jobid']}
		AND joblog.addedby = user.id
		";


		if ($result = $mysqli->query($query)) {

			echo "	<table class='table table-responsive' id='itemstable' style='width:100%'>
	  <tr>
	    <th>Time&nbsp;	&nbsp;</th>
	    <th align='right'>Description</th>
		<th align='right'>Added By</th>
	  </tr>";

			while ($job = $result->fetch_object()) {
			     //echo $item->model."=".$item->amount;
			     //echo "<br>";
				echo "<tr>
				<td>{$job->timeadded}</td>
				<td>".nl2br($job->description)."</td>
				<td>{$job->fullname}</td>
				</tr>";
			}

			echo "</table>";
		}
		
	}
}
catch(Exception $ex)
{
	echo $ex->getMessage();

}
	
?>