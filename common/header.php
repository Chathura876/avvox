<?php
require_once("common/logincheck.php");
require_once("common/database.php");
require_once("common/common_functions.php");
if (!($userloggedin)) {//Prevent the user visiting this page if not logged in 
  //Redirect to user account page
  header("Location: login.php");
  die();
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Welcome to CRM">
    <meta name="author" content="Udara Akalanka">

    <title>Avvox CRM</title>

<!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous"> -->

<link rel="stylesheet" href="css/bootstrap.min.css">


<!--     <link href="themes/redmond/jquery-ui-1.8.16.custom.css" rel="stylesheet" type="text/css" /> -->
  <!-- <link href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css" rel="stylesheet" type="text/css" /> -->
  <link href="css/jquery-ui.css" rel="stylesheet" type="text/css" />
<!--  <link href="Scripts/jtable/themes/metro/purple/jtable.css" rel="stylesheet" type="text/css" /> -->
     <!--<link href="scripts/jtable/themes/flick/jquery-ui-1.10.1.custom.min.css" rel="stylesheet" type="text/css" /> -->
    <link href="scripts/jtable/themes/flick/jtable_jqueryui.css" rel="stylesheet" type="text/css" />
    <!--<link href="scripts/jtable/themes/lightcolor/gray/jtable.min.css" rel="stylesheet" type="text/css" />-->


     <!--  <script src="https://code.jquery.com/jquery-3.4.1.min.js" type="text/javascript"></script> -->
     <script src="js/jquery-3.4.1.min.js" type="text/javascript"></script>
    <!-- <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js" type="text/javascript"></script> -->
    <script src="js/jquery-ui.min.js" type="text/javascript"></script>
  
<!--  <script src="scripts/jquery-1.6.4.min.js" type="text/javascript"></script>
    <script src="scripts/jquery-ui-1.8.16.custom.min.js" type="text/javascript"></script> -->
<!--     <script src="Scripts/jtable/jquery.jtable.min.js" type="text/javascript"></script> -->
    <script src="scripts/jtable/jquery.jtable.new.js" type="text/javascript"></script>

<!--    validation css -->
    <link href="scripts/validationengine/validationEngine.jquery.css" rel="stylesheet" type="text/css" />
    <!--    validation js -->
      <script src="scripts/validationengine/jquery.validationEngine.min.js" type="text/javascript"></script>
      <script src="scripts/validationengine/jquery.validationEngine-en.js" type="text/javascript"></script>

      <script src="js/bootstrap.bundle.min.js" type="text/javascript"></script>
      <script src="js/bootbox.all.min.js" type="text/javascript"></script>

        <script type="text/javascript">
            $.extend(true, $.hik.jtable.prototype.options, {
                jqueryuiTheme: true
            });
        </script>



  </head>
<body>
