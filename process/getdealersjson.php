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
	if(isset($_GET['area'])){

		$dataarray = array();

		$dataarray['dealers'] = "";


		$query2 = "SELECT * FROM user WHERE usertype IN ('dealer', 'shop') AND area='{$_GET['area']}' ORDER BY fullname ASC";
		if ($result2 = $mysqli->query($query2)) {


/*{
   "Result":"OK",
   "Options":[
      {
         "DisplayText":"Home phone",
         "Value":"1"
      },
      {
         "DisplayText":"Office phone",
         "Value":"2"
      },
      {
         "DisplayText":"Cell phone",
         "Value":"3"
      }
   ]
}*/

			$resultstring = '{
			   "Result":"OK",
			   "Options":[';

			while ($dealer = $result2->fetch_object()) {
			     //echo $objectname->Name;
			     //echo "<br>";
				//$dataarray['dealers'] .= "<option value='{$dealer->id}'>{$dealer->shopname}</option>";

				$resultstring .= '
			      {
			         "DisplayText":"'.$dealer->shopname.'",
			         "Value":"'.$dealer->id.'"
			      },

				';

			}

			$resultstring = rtrim(trim($resultstring), ',');
			//echo $resultstring;

			$resultstring .= ']
			}';

		}

		echo $resultstring;		

	}		
}
catch(Exception $ex)
{
	echo $ex->getMessage();

}
	
?>