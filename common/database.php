<?php

$db_host = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "ac";

$mysqli = new mysqli($db_host, $db_user, $db_pass, $db_name);

/* check connection */
if (mysqli_connect_errno()) {
	printf("Connect failed: %s\n", mysqli_connect_error());
	exit();
}


function pmsdb($query){//used for get records
	global $db_host, $db_user, $db_pass, $db_name;
	$mysqli = new mysqli($db_host, $db_user, $db_pass, $db_name);
	//echo $query;
	/* check connection */
	if (mysqli_connect_errno()) {
		printf("Connect failed: %s\n", mysqli_connect_error());
		exit();
	}
	 
		$result_array = array();
		
	if ($result = $mysqli->query($query)) {
		if(is_object($result)){

			if($result->num_rows > 0){
				while ($obj = $result->fetch_object()) {
					$result_array[] = $obj;
					
					
				}
			}
		}
		


	}
	else{
		echo "ERROR ".$mysqli->error;
		$result_array=  false;
	}

	return $result_array;// return result set as an array of objects
}


function pmsdb2($query){//used for get records
	global $mysqli;


	 
		$result_array = array();
		
	if ($result = $mysqli->query($query)) {
		if(is_object($result)){

			if($result->num_rows > 0){
				while ($obj = $result->fetch_object()) {
					$result_array[] = $obj;
					
					
				}
			}
		}
		


	}
	else{
		echo "ERROR ".$mysqli->error;
		$result_array=  false;
	}

	return $result_array;// return result set as an array of objects
}







function pmsinsert($query){//used for update records
	global $db_host, $db_user, $db_pass, $db_name;
	$mysqli = new mysqli($db_host, $db_user, $db_pass, $db_name);
	//echo $query;
	/* check connection */
	if (mysqli_connect_errno()) {
		printf("Connect failed: %s\n", mysqli_connect_error());
		exit();
	}
	 

		
	if ($result = $mysqli->query($query)) {
		return true;
	}
	else{

		echo "ERROR ".$mysqli->error;

	}
	return false;
}



?>