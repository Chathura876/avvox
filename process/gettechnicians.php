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

		$dataarray['technicians'] = "";
		$dataarray['dealers'] = "";

		$query = "SELECT * FROM user WHERE usertype='technician' AND area IN ('{$_POST['area']}', 'All') ORDER BY fullname ASC";
		if ($result = $mysqli->query($query)) {
			while ($technician = $result->fetch_object()) {
			     //echo $objectname->Name;
			     //echo "<br>";
				$dataarray['technicians'] .= "<option value='{$technician->id}'>{$technician->fullname}</option>";
			}
		}

		$query2 = "SELECT * FROM user WHERE usertype IN ('dealer', 'shop')  AND area='{$_POST['area']}' ORDER BY fullname ASC";
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