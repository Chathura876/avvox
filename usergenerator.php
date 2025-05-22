<?php

$mysqli = new mysqli("localhost", "root", "root", "mybroker");

$query = "select district from district";
if ($result = $mysqli->query($query)) {
	while ($objectname = $result->fetch_object()) {
	     echo "\"".$objectname->district."\",";
	     //echo "<br>";
	}
}

?>