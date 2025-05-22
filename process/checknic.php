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
	if(isset($_POST['nic'])){

		//Get record count
		$resulttotal = mysqli_query($mysqli, "SELECT COUNT(*) AS RecordCount FROM customer WHERE nic='{$_POST['nic']}'");
		$row = mysqli_fetch_array($resulttotal, MYSQLI_ASSOC);
		$recordCount = $row['RecordCount'];

		$resultarray = array();
		if($recordCount>1){//this means there are more than 1 items for this customer, so we allow user to select the exact item
			//echo "exists";

			$resultarray['result'] = "morethanone";
			$query = "SELECT customer.*, product.* FROM customer
			 INNER JOIN product
			 WHERE customer.nic='{$_POST['nic']}'
			 AND customer.modelid = product.id;

			";

			$optionsstring = "";
			if ($result = $mysqli->query($query)) {
				while ($customer = $result->fetch_object()) {
				     //echo $customer->Name;
				     //echo "<br>";
					$optionsstring .= "<option value='{$customer->warrantyid}'>{$customer->warrantyid} - {$customer->model}</option>";
				}
			}

			$resultarray['content'] = $optionsstring;

			$resultarray['description'] = "<div class='alert alert-info'>This customer has purchased more than one item. Please select the correct item from the list</div>";


			echo json_encode($resultarray);
			

		}
		else if($recordCount ==1){//this means there are only 1 item for this customer
			//echo "exists";

			$resultarray['result'] = "one";
			$query = "SELECT customer.*, product.* FROM customer
			 INNER JOIN product
			 WHERE customer.nic='{$_POST['nic']}'
			 AND customer.modelid = product.id;

			";

			if ($result = $mysqli->query($query)) {
				$customer = $result->fetch_object();// no need loop because only one record
				$resultarray['content'] = $customer->warrantyid;
	
			}

			

			$resultarray['description'] = "This customer has purchased exactly one item";


			echo json_encode($resultarray);
			

		}		
		else{
			echo '{"result": "notexists"}';
		}		
	}
}
catch(Exception $ex)
{
	echo $ex->getMessage();

}
	
?>