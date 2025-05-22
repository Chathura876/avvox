<?php
require_once("../common/logincheck.php");
require_once("../common/database.php");
if (!($userloggedin)) {//Prevent the user visiting this page if not logged in 
  //Redirect to user account page
  //header("Location: login.php");
  http_response_code(403);
  die();
}

require_once '../dompdf/autoload.inc.php';

// reference the Dompdf namespace
use Dompdf\Dompdf;

// instantiate and use the dompdf class
$dompdf = new Dompdf();


//exit();

//exit("Byeeeeee");

//$pdfstring = '<link href="/crm/css/bootstrap.min.css" rel="stylesheet" /> ';
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

	if(isset($_GET['dealerid']) && isset($_GET['techid']) && isset($_GET['status'])){

		//echo $_GET['dealerid']."-".$_GET['techid'];
		//exit();
		//filer on techid
		if($_GET['dealerid'] == 0 && $_GET['techid'] == 0){//both fields are any
			$query = "SELECT job.id, job.contactname, user.fullname, job.timeadded FROM job
			INNER JOIN user
			WHERE job.techid = user.id 
			AND job.status = {$_GET['status']}
			";
		}
		else if($_GET['dealerid'] == 0){//only dealer is any

			$query = "SELECT job.id, job.contactname, user.fullname, job.timeadded FROM job
			INNER JOIN user
			WHERE job.techid={$_GET['techid']}
			AND job.techid = user.id 
			AND job.status = {$_GET['status']}
			";
			
		}
		else if($_GET['techid'] == 0){//only techid is any
			$query = "SELECT job.id, job.contactname,  job.timeadded, user.fullname FROM customer
			INNER JOIN job
			INNER JOIN user
			WHERE customer.dealerid={$_GET['dealerid']}
			AND customer.warrantyid = job.warrantyid
			AND job.techid = user.id
			AND job.status={$_GET['status']}
			";			
		}
		else{// both values has specified
			$query = "SELECT job.id, job.contactname, user.fullname, job.timeadded FROM job
			INNER JOIN user
			INNER JOIN customer
			WHERE job.techid={$_GET['techid']}
			AND customer.dealerid={$_GET['dealerid']}
			AND job.techid = user.id
			AND job.warrantyid = customer.warrantyid 
			AND job.status = {$_GET['status']}
			";				

		}

		//echo $query;

		//filter on dealer id
	

		//filter on both
	


		if ($result = $mysqli->query($query)) {

			if($result->num_rows>0){
			$pdfstring .= "	<table class='table table-responsive' id='udaratable' style='width:100%'>
	  <tr>
	    <th></th>
	    <th>Customer Name&nbsp;	&nbsp;</th>
	    <th align='right'>Technician Name</th>
	    <th align='right'>Time Added</th>
	    <th align='right'>Description</th>
	  </tr>";

	  		$i = 1;

			while ($item = $result->fetch_object()) {
			     //echo $item->model."=".$item->amount;
			     //echo "<br>";
				$descstring = "";
				$query2 = "SELECT * FROM joblog WHERE jobid='{$item->id}'";
				if ($result2 = $mysqli->query($query2)) {
					while ($log = $result2->fetch_object()) {
					     //echo $objectname->Name;
					     //echo "<br>";
						$descstring .= "{$log->description}<br>";
					}
				}


				$pdfstring .= "<tr>
				<td>$i</td>
				<td>{$item->contactname}</td>
				<td>{$item->fullname}</td>
				<td>{$item->timeadded}</td>
				<td>$descstring</td>				
				</tr>";

				$i++;
			}

			$pdfstring .= "</table>";
			}
			else{
				$pdfstring .= "<div class='alert alert-info col-md-6'>There aren't any results for your selectoin criteria.<div>";
			}
		}
		
	}


//echo $pdfstring;

//exit();

$dompdf->loadHtml($pdfstring);

// (Optional) Setup the paper size and orientation
$dompdf->setPaper('A4', 'landscape');

// Render the HTML as PDF
$dompdf->render();

// Output the generated PDF to Browser
$dompdf->stream();	

?>