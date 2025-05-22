<?php



   /**
 * Simple function to replicate PHP 5 behaviour
 */
function microtime_float()
{
    list($usec, $sec) = explode(" ", microtime());
    return ((float)$usec + (float)$sec);
}

$time_start = microtime_float();

$x = 0;
while ($x<100000000) {
      $y =  34234/342/567*435*23456/4567*456;
      $x++;
}

$time_end = microtime_float();
$time = $time_end - $time_start;

echo "Did nothing in $time seconds\n";


?>

