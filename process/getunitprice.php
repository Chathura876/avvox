<?php
require_once("../common/logincheck.php");
require_once("../common/database.php");
require_once("../common/common_functions.php");
if (!($userloggedin)) {//Prevent the user visiting this page if not logged in 
  //Redirect to user account page
  //header("Location: login.php");
  http_response_code(403);
  die();
}
try
{	
	if(isset($_POST['dealerid'])){

		$dataarray = array();

		$dataarray['unitprice'] = "";

		$unitprice = 0;
		
		if($unitprice = getunitpriceoforder($_POST['productid'], $_POST['orderid'])){

		}
		else{

		$query = "SELECT * FROM product WHERE id={$_POST['productid']}";
		if ($result = $mysqli->query($query)) {
			$thisproduct = $result->fetch_object();
			//$id = $objectname->id;
			//$name = $objectname->name;
			//$address = $objectname->address;
			//$rowcount =  $result->num_rows;


			$query2 = "SELECT * FROM user WHERE id={$_POST['dealerid']}";
			if ($result2 = $mysqli->query($query2)) {
				$dealer = $result2->fetch_object();
				$pricing = $dealer->pricing;

				if($pricing == "default"){
					$unitprice = $thisproduct->pricedefault;
				}
				else if($pricing == "silver"){
					$unitprice = $thisproduct->pricesilver;
				}
				else if($pricing == "gold"){
					$unitprice = $thisproduct->pricegold;
				}
				else if($pricing == "platinum"){
					$unitprice = $thisproduct->priceplatinum;
				}				

			
			}
		}

			

		
		}
        $dataarray['unitprice'] = $unitprice;
		echo json_encode($dataarray);		

	}		
}
catch(Exception $ex)
{
	echo $ex->getMessage();

}
	
?>