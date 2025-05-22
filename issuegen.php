<?php
function microtime_float()
{
        list($usec, $sec) = explode(" ", microtime());
        return ((float)$usec + (float)$sec);
}

$time_start = microtime_float();

require_once "common/database.php";


$query = "SELECT id FROM user WHERE usertype='dealer' OR usertype='shop'";
if ($result = $mysqli->query($query)) {
	while ($user = $result->fetch_object()) {
	     //echo $user->id;
	     for ($i = 1; $i <17 ; $i++) {

	     	$amount = mt_rand(10, 50);
	     	$orderquery = "INSERT INTO orders VALUES (NULL, {$user->id}, $i, $amount, ".time().", 1)";
	     	//echo "<br>";
	     	$inventoryquery = "INSERT INTO inventory VALUES ({$user->id}, $i, $amount)";
	     	$mysqli->query($orderquery);
	     	$mysqli->query($inventoryquery);
	     	//echo "<br>";
	     	// if ($result = $mysqli->query($query)) {
	     	// 	$objectname = $result->fetch_object();
	     	// 	$id = $objectname->id;
	     	// 	$name = $objectname->name;
	     	// 	$address = $objectname->address;
	     	// 	$rowcount =  $result->num_rows;
	     	
	     	// }
	     }
	}
}


$time_end = microtime_float();
$time = $time_end - $time_start;

echo "Completed in in $time seconds\n";

?>