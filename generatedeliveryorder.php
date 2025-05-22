<?php require_once "common/header.php" ?>
<?php
$permissions = array("admin", "dealer", "shop", "salesrep","operator");

if (!(in_array($_SESSION['usertype'], $permissions))){
    header("Location: index.php");  
}

?>
<?php require_once "common/nav.php" ?>

<script type="text/javascript">
	//var totalproducts = 0;
  function validateamount(field, rules, i, options){
    
    if(field.val() < 0){
      //alert(rules);
      return "amount should be greater than or equel to 0";
    }

  }

	function isInt(value) {
	  return !isNaN(value) && (function(x) { return (x | 0) === x; })(parseFloat(value))
	}

	var productidobject = {};//to store current main inventory amounts for each product
</script>


<style>
.udaratable, #udaratable {
  /*font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;*/
  border-collapse: collapse;
  width: 100%;
}

.udaratable td, .udaratable th, #udaratable td, #udaratable th {
  border: 1px solid #ddd;
  padding: 8px;
  font-size: 13px;
}

#udaratable tr:nth-child(even){background-color: #f2f2f2;}

#udaratable tr:hover {background-color: #ddd;}

.udaratable, #udaratable th {
  padding-top: 12px;
  padding-bottom: 12px;
  text-align: left;
  background-color: #4CAF50;
  /*background-color: #9698ed;*/
  color: white;
}

.customtext{
	font-size: 13px;
}

</style>

<?php

if(isset($_GET["orderid"])){

	$invoicestring = "";

	$productinvcountarray = array();//array to store current main inventory amounts for each product
	
	$statusquery = "SELECT issued FROM orders WHERE orderid={$_GET["orderid"]}";

	
	
	if($statusresult = $mysqli->query($statusquery)) {
		$thisorder = $statusresult->fetch_object();
		if($thisorder->issued <1){
			echo "<div class='row'>
			<div class='col-12 mb-3 alert-danger'>
			Sorry This order hasn't approved yet
			</div>
			</div>";
			require_once "common/footer.php";
			
			exit();
		}
	}	
	
	$query = "SELECT orders.*, user.shopname, user.address, user.pricing FROM orders 
	INNER JOIN user
	WHERE orderid={$_GET["orderid"]}
	AND orders.dealerid = user.id
	";

	$order = "";

	if ($result = $mysqli->query($query)) {
		$order = $result->fetch_object();
	}

	$ordertime = date("Y-m-d", $order->ordertime);


echo "<div style='width: 210mm; margin-bottom:20px'>";

// Read image path, convert to base64 encoding
$image = './images/logo.jpg'; 
$imageData = base64_encode(file_get_contents($image));

// Format the image SRC:  data:{mime};base64,{data};
$imagepath = 'data:'.mime_content_type($image).';base64,'.$imageData;

$invoicestring .= "


<table align='right' style='width:100%'>
	
<tr>
	<td align='left' style=' font-size:12px'>
	</td>

	<td style='font-size:12px; width: 25%; margin-right:0px'>
	<font color='#9698ed' size='4'>DELIVERY NOTE </font><br>
	Order Date: $ordertime<br>
	Order ID: {$order->orderid}<br>
	Invoice Date: ".date('Y-m-d')."<br>
	</td>
</tr>


</table><br><br><br><br><br><br>";

$invoicestring .= "<b>DELIVER TO:</b><br>{$order->shopname}<br>{$order->address} <br><br>";

$invoicestring .= "<table id='udaratable'>
<tr>
<th style='background-color:#6f6d6d;'>Model</th>
<th style='width:10%; text-align:right; background-color:#6f6d6d;'>Qty</th>
</tr>
";

$billtotal = 0;

$query = "SELECT orderitems.*, product.* FROM orderitems 
INNER JOIN product ON orderitems.modelid = product.id 
WHERE orderid={$_GET["orderid"]}";
if ($result = $mysqli->query($query)) {
	while ($thisproduct = $result->fetch_object()) {
	     //echo $objectname->Name;
	     //echo "<br>";
		$unitprice = "";
		if($order->pricing == "default"){
			$unitprice = $thisproduct->pricedefault;
		}
		else if($order->pricing == "silver"){
			$unitprice = $thisproduct->pricesilver;
		}
		else if($order->pricing == "gold"){
			$unitprice = $thisproduct->pricegold;
		}
		else if($order->pricing == "platinum"){
			$unitprice = $thisproduct->priceplatinum;
		}				

		$totalpriceforthismodel = $unitprice*($thisproduct->amount+$thisproduct->amountissued-$thisproduct->amountfree);
		$billtotal = $billtotal + $totalpriceforthismodel;
		$totalpriceforthismodel = number_format((float)$totalpriceforthismodel, 2, '.', ',');

		$amountforthisitem = $thisproduct->amount + $thisproduct->amountissued;

		$invoicestring .= "<tr>
		<td>{$thisproduct->model}</td>
		<td align='right'>$amountforthisitem</td>
		</tr>";
	}
}

$billtotal = number_format((float)$billtotal, 2, '.', ',');

$invoicestring .= "</table>";

$invoicestring .="

<br>

<div style='float:left; height: 90mm; width:46%; border: 0px solid red'>
<div style='height: 35mm; width:100%; margin-bottom:10px; border: 0px solid red'>


<table style='border:1px solid black; border-collapse: collapse;' class='customtext' width='100%'>
  <tr>
    <th style='background-color:#6f6d6d; border:none; color:#ffffff; padding:5px;'>Prepared by</th>
  </tr>
  <tr>
    <td style='border:0px; padding:5px;'><br>Name:<br><br>Signature:<br><br></td>
  </tr>
 
</table>



</div>
<div style='height: 50mm; width:100%; border: 0px solid red'>


<table style='border:1px solid black; border-collapse: collapse;' class='customtext'   width='100%'>
  <tr>
    <th style='background-color:#6f6d6d; color:#ffffff; padding:5px;'>Received by</th>
  </tr>
  <tr>
    <td style='border:0px; padding:5px;'>
    <p>We hereby confirm that all the above goods received with good condition</p>

   Name:<br><br>Signature:<br><br></td>
  </tr>
 
</table>



</div>
</div>
<div style='float:right; margin-left: 20px; height: 90mm; width:46%; border: 0px solid black'>


<table style='border:1px solid black;' class='customtext'  width='100%'>
  <tr>
    <th style='background-color:#6f6d6d; color:#ffffff; padding:5px;'>Remarks</th>
  </tr>
  <tr>
    <td style='border:0px; padding:5px; height:75mm'><br><br><br><br><br></td>
  </tr>
</table>


</div>






";

$invoicestring .="

<div style='font-size: 16px; width:100%; text-align: center; padding-top:15px; clear:both; margin-left:auto; margin-right:auto'><b>Thank You For Your Business!</b></div>
";

echo $invoicestring;

//correct formating difference3s with pdf

$invoicestring = str_replace(
	"<div style='height: 35mm; width:100%; margin-bottom:10px; border: 0px solid red'>", 
	"<div style='height: 30mm; width:100%; margin-bottom:10px; border: 0px solid red'>", 
	$invoicestring);

$invoicestring = str_replace(
	"<td style='border:0px; padding:5px; height:75mm'><br><br><br><br><br></td>", 
	"<td style='border:0px; padding:5px; height:63mm'><br><br><br><br><br></td>", 
	$invoicestring);

 } ?>


 <form action="process/generateinvoicepdf.php" method="POST">

<input type="hidden" id="printdatastring" name="printdatastring" value="<?php echo $invoicestring ?>"> &nbsp; &nbsp;
<button type="button" class="btn btn-primary ml-3 float-right" onclick='window.print()'>Print</button>
  <button type="submit" class="btn btn-primary float-right">PDF</button>
</form>



</div> <!-- end main div -->

<script type="text/javascript">
  
$(document).ready(function () {

  $("#amount").on('input blur paste', function(){
  	    if (evt.which < 48 || evt.which > 57){
        evt.preventDefault();
    	}
  })

  //alert("HI");

  $("#udaraform").validationEngine('attach', {promptPosition : "bottomLeft", validationEventTrigger
: "keyup", onValidationComplete: function(form, status){
	if(totalproducts< 1){
		$("#itemstable").hide( "slow" );
		$("#emptydiv").show("slow");
		$("#noitems").show("slow");

	}
	else{
		//$("#noitems").hide("slow");	
		return true;	
	}
  } });


  $('#techdistrict').on('change', function (e) {
    var optionSelected = $("option:selected", this);
    var selectedarea = this.value;
    //alert(valueSelected);
        $.ajax({
          type: 'POST',
          async: false,
          url: 'process/getdealers.php',
          data: {"area": selectedarea },
          dataType: 'html',
          success: function (data) {
			var peopledata = JSON.parse(data);
            $("#dealerid").html(peopledata.dealers);
          },
          error: function () {
              alert('An unknown error occoured, Please try again Later...!');
              
          }
        });
});

$("#techdistrict").trigger("change");

});

var totalproducts = 0;

var itemcount = 1;

var productarray = [];//this array is used to prevent duplicate values


<?php 

//$udara = $productinvcountarray[0];
//$udara = "HIHIHIHIHH";

$query = "SELECT orderitems.*, product.model FROM orderitems 
INNER JOIN product ON product.id = orderitems.modelid 
WHERE orderid={$_GET["orderid"]}";
if ($result = $mysqli->query($query)) {


	while ($orderitem = $result->fetch_object()) {
		$thisitemamount = $orderitem->amount - $orderitem->amountfree;
		?>

		$("#itemstable").show("slow");

	     //echo $orderitem->Name;
	     //echo "<br>";


   var thisitem = "item"+itemcount;

 	
   //product id is passed to the form as a hidden input in the first td
	var thisrecord = "<tr id='record"+itemcount+"'><td><?php echo $orderitem->model ?><input type='hidden' id='model"+itemcount+"' name='products["+thisitem+"][]' value='<?php echo $orderitem->modelid ?>' /></td><td align='right'><input type='number' min='0' value='<?php echo $thisitemamount ?>' class='form-control col-md-4' data-validation-engine='validate[required,custom[integer], min[0], funcCall[validateamount]]' id='amount"+itemcount+"' name='products["+thisitem+"][]'></td><td align='right'><input type='number' min='0' value='<?php echo $orderitem->amountfree ?>' class='form-control col-md-4' data-validation-engine='validate[required,custom[integer], min[0], funcCall[validateamount]]' id='amountfree"+itemcount+"' name='products["+thisitem+"][]'></td><td class='text-right'><?php echo $productinvcountarray[$orderitem->modelid] ?></td><td>&nbsp;	&nbsp;<button class='btn btn-danger' id='removeitembutton"+itemcount+"' onclick='deleteitem(this.id)' type='button'>&#10005;</button></td></tr>";

	$("#itemstable").append(thisrecord);

	     itemcount++;
	     totalproducts++;



	     <?php
	}
}



?>

function addnewitem(value){

	var amountvalue = document.getElementById("amount").value;
	var amountfreevalue = document.getElementById("amountfree").value;
	//alert(amountvalue);
	//if (!(Number.isInteger(amountvalue))) {
	//if(!(amountvalue === parseInt(amountvalue, 10))){

	// if(productarray.includes($("#model").val())){
	// 	return false;
	// }

	for (i = 0; i < itemcount; i++) {// prevent adding same product twice
	  if($("#model"+i).val() == $("#model").val()){
	  	//console.log("HI");
	  	//alert("HI");
	  	return false;
	  }
	}

	if(!(isInt(amountvalue) && isInt(amountfreevalue) && (amountvalue > 0 || amountfreevalue > 0))){
		$("amount").addClass("has-error");
		$("#amount").focus();
		$("#emptyamount").show("fast");
	
    	return false;
  	}


  	productarray.push($("#model").val());

  	//alert(productarray.toString());

  	//var selectedoptionval = document.getElementById("model");
	//selectedoptionval.remove(selectedoptionval.selectedIndex);



  	$("#emptyamount").hide();
   // if($('#amount').val() == ''){
   //    alert('Input can not be left blank');
   //    return false;
   // }

   var thisitem = "item"+itemcount;

 //	$("#udaraform").append("<input type='hidden' id='model"+itemcount+"' name='products["+thisitem+"][]' value='"+ $("#model").val()+"' />");  

 	//product id is passed to the form as a hidden input in the first td
	var thisrecord = "<tr id='record"+itemcount+"'><td>"+$("#model").find('option:selected').text()+"<input type='hidden' id='model"+itemcount+"' name='products["+thisitem+"][]' value='"+ $("#model").val()+"' /></td><td align='right'><input type='number' min='0' value='"+Math.trunc($("#amount").val())+"' class='form-control col-md-4' data-validation-engine='validate[required,custom[integer], min[0], funcCall[validateamount]]' id='amount"+itemcount+"' name='products["+thisitem+"][]'></td><td align='right'><input type='number' min='0' value='"+Math.trunc($("#amountfree").val())+"' class='form-control col-md-4' data-validation-engine='validate[required,custom[integer], min[0], funcCall[validateamount]]' id='amountfree"+itemcount+"' name='products["+thisitem+"][]'></td><td class='text-right'>"+productidobject[$('#model').val()]+"</td><td>&nbsp;	&nbsp;<button class='btn btn-danger' id='removeitembutton"+itemcount+"' onclick='deleteitem(this.id)' type='button'>&#10005;</button></td></tr>";

	$("#itemstable").append(thisrecord);

	


/*	$("#udaraform").append("<input type='hidden' id='amount"+itemcount+"' name='products["+thisitem+"][]' value='"+ $("#amount").val()+"' />");
	$("#udaraform").append("<input type='hidden' id='amountfree"+itemcount+"' name='products["+thisitem+"][]' value='"+ $("#amountfree").val()+"' />");*/

	$("#itemstable").show("slow");
	$("#emptydiv").hide("slow");

itemcount++;
totalproducts++;

	if(totalproducts< 1){
		$("#itemstable").hide( "slow" );
		$("#emptydiv").show("slow");
		//$("#noitems").show("slow");

	}
	else{
		//$("#noitems").hide("slow");		
	}	
	$("#submit").attr("disabled", false);//re-enable the submit button everytime user adds an item
}

function deleteitem(id){
	//var parentrecord = id.replace("removeitembutton", "record");
	$("#"+id.replace("removeitembutton", "record")+"").remove();
	$("#"+id.replace("removeitembutton", "model")+"").remove();
	$("#"+id.replace("removeitembutton", "amount")+"").remove();
	$("#"+id.replace("removeitembutton", "amountfree")+"").remove();

	totalproducts--;





	if(totalproducts< 1){
		$("#itemstable").hide( "slow" );
		$("#emptydiv").show("slow");
		//$("#noitems").show("slow");
		$("#submit").attr("disabled", true);

	}
	else{
		//$("#noitems").hide("slow");		
	}
}
</script>

<?php require_once "common/footer.php" ?>