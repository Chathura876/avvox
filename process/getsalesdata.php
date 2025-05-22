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
	if(isset($_POST['id'])){

		$query = "SELECT modelid, count(modelid) AS amount, model FROM `customer` 
INNER JOIN product
WHERE dealerid={$_POST['id']} 
AND customer.modelid = product.id 
GROUP by modelid
		";


		if ($result = $mysqli->query($query)) {


			if($result->num_rows<1){
				 exit("<font color='red'><b>Sales data of this dealer/shop is empty!!</b></font>");
			}

			echo "	<table class='table table-responsive' id='itemstable' style='width:100%'>
	  <tr>
	    <th>Model&nbsp;	&nbsp;</th>
	    <th align='right'>Amount Sold</th>
	  </tr>";

			while ($product = $result->fetch_object()) {
			     //echo $item->model."=".$item->amount;
			     //echo "<br>";
				echo "<tr>
				<td>{$product->model}</td>
				<td>{$product->amount}</td>
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