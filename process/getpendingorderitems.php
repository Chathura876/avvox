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


	$query = "
	SELECT modelid, product.*, sum(amount) AS amount FROM `orderitems` 
	inner join product
	inner join orders 
	where orderitems.modelid=product.id
	AND orderitems.orderid = orders.orderid
	AND orders.issued < 2  
	group by modelid
";


	if ($result = $mysqli->query($query)) {


		if($result->num_rows<1){
			 exit("<font color='green'><b>No Pending Order Items!!</b></font>");
		}

		$totalCMBforallitems = 0;

		echo "	<table class='table table-responsive' id='itemstable' style='width:100%'>
  <tr>
    <th>Model&nbsp;	&nbsp;</th>
    <th align='right'>Amount</th>
    <th align='right'>total CMB</th>
  </tr>";

		while ($product = $result->fetch_object()) {
		     //echo $item->model."=".$item->amount;
		     //echo "<br>";
			$totalCMBforthisitem = $product->amount*$product->cmb;

			$totalCMBforallitems += $totalCMBforthisitem;
			echo "<tr>
			<td>{$product->model}</td>
			<td>{$product->amount}</td>
			<td align='right'>". number_format((float)$totalCMBforthisitem, 2, '.', ',')."</td>
			</tr>";
		}

		echo "<tr><td colspan='2' align='right'>Total CMB</td><td>$totalCMBforallitems</td></tr>";
		echo "</table>";
	}
		
}
catch(Exception $ex)
{
	echo $ex->getMessage();

}
	
?>