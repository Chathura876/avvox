<?php
require_once("../common/logincheck.php");
require_once("../common/database.php");
if (!($userloggedin)) {//Prevent the user visiting this page if not logged in 
  //Redirect to user account page
  //header("Location: login.php");
  http_response_code(403);
  die();
}

if(isset($_GET["orderid"])){
 



	$mysqli->begin_transaction();

	$query1 = "DELETE FROM orderitems WHERE orderid={$_GET["orderid"]}";

	$firstresult = $mysqli->query($query1);

	$query2 = "DELETE FROM orders WHERE orderid={$_GET["orderid"]}";

	$secondresult =  $mysqli->query($query2);



	if($firstresult && $secondresult){
		$mysqli->commit();
		header("Location: ../manageorders.php?action=ordercanceled");
		//echo "Success";
	}else{
		$mysqli->rollback();
		echo "Fail";
	}




}



?>