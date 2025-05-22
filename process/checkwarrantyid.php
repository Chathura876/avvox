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
	if(isset($_POST['warrantyid'])){

		//Get record count
		$resulttotal = mysqli_query($mysqli, "SELECT COUNT(*) AS RecordCount FROM customer WHERE warrantyid='{$_POST['warrantyid']}' LIMIT 1");
		$row = mysqli_fetch_array($resulttotal, MYSQLI_ASSOC);
		$recordCount = $row['RecordCount'];
		if($recordCount>0){
			//echo "exists";
			$query = "SELECT customer.*, product.* FROM customer 
			INNER JOIN product
			WHERE warrantyid='{$_POST['warrantyid']}'
			AND customer.modelid = product.id
			";
			if ($result = $mysqli->query($query)) {
				$customer = $result->fetch_object();
				$expiredate = date('Y-m-d', strtotime('+1 year', strtotime($customer->purdate)));// adding warranty expire date to the existing object

				$status = "";
				if($expiredate < date("Y-m-d")){
					//$customer->warrantyinfo = "This item was purchased on {$customer->purdate}. This item's <b><font color='red'>warranty has expired on $expiredate</font></b>";
					$status = "<b><font color='red'>Warranty Expired on $expiredate</font></b>";
				}else{
					//$customer->warrantyinfo = "This item was purchased on {$customer->purdate}. This item's <b><font color='green'>warranty expires on $expiredate</font></b>";
					$status = "<b><font color='green'>Under Warranty. Expires on $expiredate</font></b>";
				}				

				$customer->warrantyinfo = "
				<br><table>
				<tr><th>Product</th><td>:</td><td>{$customer->model}</td></tr>
				<tr><th>Purchesed</th><td>:</td><td>{$customer->purdate}</td></tr>
				<tr><th>Warranty</th><td>:</td><td>$status</td></tr>				
				</table>

				";



				$customer->result = "exists";// adding new value to the existing object

				echo json_encode($customer);
			
			}
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