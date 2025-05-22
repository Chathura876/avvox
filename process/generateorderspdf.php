<?php
require_once("../common/logincheck.php");
require_once("../common/database.php");
if (!($userloggedin)) {//Prevent the user visiting this page if not logged in 
  //Redirect to user account page
  //header("Location: login.php");
  http_response_code(403);
  die();
}
error_reporting(E_ALL);

require_once '../dompdf/autoload.inc.php';

	// reference the Dompdf namespace
use Dompdf\Dompdf;


if(isset($_POST['printdatastring'])){
	//echo $_POST['printdatastring'];



	// instantiate and use the dompdf class
	$dompdf = new Dompdf();


	$pdfstring = <<<'EOT'

	<style>
	#udaratable {
	  font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
	  border-collapse: collapse;
	  width: 100%;
	}

	#udaratable td, #udaratable th {
	  border: 1px solid #ddd;
	  padding: 8px;
	}

	#udaratable tr:nth-child(even){background-color: #f2f2f2;}

	#udaratable tr:hover {background-color: #ddd;}

	#udaratable th {
	  padding-top: 12px;
	  padding-bottom: 12px;
	  text-align: left;
	  background-color: #4CAF50;
	  color: white;
	}
	</style>



EOT;

	$pdfstring .= $_POST['printdatastring'];


	$docname = "orders-report-".date('Y-m-d-h-i-s-A');

	$dompdf->loadHtml($pdfstring);

	// (Optional) Setup the paper size and orientation
	$dompdf->setPaper('A4', 'landscape');

	$dompdf->add_info('Author', 'Udara Akalanka');

	// Render the HTML as PDF
	$dompdf->render();



	// Output the generated PDF to Browser
	$dompdf->stream($docname);


}
	





	
?>