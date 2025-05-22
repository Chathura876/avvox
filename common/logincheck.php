<?php
session_start();
date_default_timezone_set('Asia/Colombo');
$userloggedin = false;
if (isset($_SESSION['loggedin'])) {//keep users loggedin/out status
  $userloggedin = true;
}
?>