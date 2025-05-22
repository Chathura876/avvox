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
	if(isset($_POST['area'])){

		$dataarray = array();

		$dataarray['dealers'] = "";


		$query2 = "SELECT * FROM user WHERE usertype IN ('dealer', 'shop')";

		if($_POST['area'] != "All"){
			$query2 .= " AND area='{$_POST['area']}'";
		}


		if(isset($_POST['repid'])){//reps can only see relevent dealers
			$query2 .= " AND repid ={$_POST['repid']}";

		}


		$query2 .= " ORDER BY fullname ASC";
		if ($result2 = $mysqli->query($query2)) {
			while ($dealer = $result2->fetch_object()) {
			     //echo $objectname->Name;
			     //echo "<br>";
				$dataarray['dealers'] .= "<option value='{$dealer->id}'>{$dealer->shopname}</option>";
			}
		}

		echo json_encode($dataarray);		

	}		
}
catch(Exception $ex)
{
	echo $ex->getMessage();

}
	
?>