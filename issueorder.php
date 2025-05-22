<?php require_once "common/header.php" ?>
<?php
$permissions = array("admin", "dealer", "shop", "salesrep", "operator", "storeskeeper", "operator");

if (!(in_array($_SESSION['usertype'], $permissions))) {
	header("Location: index.php");
}

?>
<?php require_once "common/nav.php" ?>

<script type="text/javascript">
	//var totalproducts = 0;
	function validateamount(field, rules, i, options) {

		if (field.val() < 0) {
			//alert(rules);
			return "amount should be greater than or equel to 0";
		}

	}

	function isInt(value) {
		return !isNaN(value) && (function(x) {
			return (x | 0) === x;
		})(parseFloat(value))
	}

	var productidobject = {}; //to store current main inventory amounts for each product
</script>


<style>
	#udaratable {
		/*font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;*/
		border-collapse: collapse;
		width: 100%;
	}

	#udaratable td,
	#udaratable th {
		border: 1px solid #ddd;
		padding: 8px;
		font-size: 13px;
	}

	#udaratable tr:nth-child(even) {
		background-color: #f2f2f2;
	}

	#udaratable tr:hover {
		background-color: #ddd;
	}

	#udaratable th {
		padding-top: 12px;
		padding-bottom: 12px;
		text-align: left;
		background-color: #4CAF50;
		color: white;
	}
</style>

<?php

if (isset($_GET["orderid"])) {




	$invoicestring = "";
	$alertstring = ""; //to show error messages
	$errors = false;
	$dealerid = "";




	$productinvcountarray = array(); //array to store current main inventory amounts for each product

	$statusquery = "SELECT issued, dealerid FROM orders WHERE orderid={$_GET["orderid"]}";



	if ($statusresult = $mysqli->query($statusquery)) {
		$thisorder = $statusresult->fetch_object();
		$dealerid = $thisorder->dealerid;
		if ($thisorder->issued > 1) {
			echo "<div class='row'>
			<div class='col-12 mb-3 alert-danger'>
			Sorry This order has been issued already
			</div>
			</div>";
			require_once "common/footer.php";

			exit();
		}
		if ($thisorder->issued < 1) { //not approved yet
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

	$invoicestring .= "

<div align='center'>INVOICE</div>
<hr>
<table align='right' style='width:100%'>
	
	<tr>
	<td align='left' rowspan='3' style='width:60%; font-size:12px'>Avvox Lanka Pvt. Ltd<br>
No20, Guildford,Crescent,<br> 
Colombo 07.<br>
Phone: +94 11 26 62 525<br>
Email: avvoxdz@gmail.com</td>
<th>Order Date</th>
<th>: </th>
<td>$ordertime</td>
</tr>
	<tr><th>Order ID</th><th>: </th><td>{$order->orderid}</td></tr>
	<tr><th>Invoice Date</th><th>: </th><td>" . date('Y-m-d') . "</td></tr>
	<tr><td></td></tr>
	<tr></tr>

</table><br><br><br><br><br><br>";



	$invoicestring .= "<b>Bill To:</b><br>{$order->shopname}<br>{$order->address} <br><br>";

	$invoicestring .= "<table id='udaratable'>
<tr><th>Model</th><th>Purchase</th><th>Free</th><th>Stock</th><th>Unit Price</th><th>Amount</th></tr>
";

	$billtotal = 0;

	$query = "SELECT orderitems.*, product.*, maininventory.amount AS stock FROM orderitems 
INNER JOIN product ON orderitems.modelid = product.id 
LEFT JOIN maininventory ON orderitems.modelid = maininventory.modelid
WHERE orderid={$_GET["orderid"]}";
	if ($result = $mysqli->query($query)) {
		while ($thisproduct = $result->fetch_object()) {
			//echo $objectname->Name;
			//echo "<br>";

			// 		$unitprice = "";
			// 		if($order->pricing == "default"){
			// 			$unitprice = $thisproduct->pricedefault;
			// 		}
			// 		else if($order->pricing == "silver"){
			// 			$unitprice = $thisproduct->pricesilver;
			// 		}
			// 		else if($order->pricing == "gold"){
			// 			$unitprice = $thisproduct->pricegold;
			// 		}
			// 		else if($order->pricing == "platinum"){
			// 			$unitprice = $thisproduct->priceplatinum;
			// 		}

			$unitprice = $thisproduct->unitprice;

			$purchaseitemcount = $thisproduct->amount - $thisproduct->amountfree;
			$totalpriceforthismodel = $unitprice * ($thisproduct->amount - $thisproduct->amountfree);
			$billtotal = $billtotal + $totalpriceforthismodel;
			$totalpriceforthismodel = number_format((float)$totalpriceforthismodel, 2, '.', ',');

			$invoicestring .= "<tr>
		<td>{$thisproduct->model}</td>
		<td align='right'>$purchaseitemcount</td>
		<td align='right'>{$thisproduct->amountfree}</td>";

			if ($thisproduct->amount > $thisproduct->stock) {
				$invoicestring .= "<td align='right' class='bg-danger text-light'>{$thisproduct->stock}</td>";
				// 			if($thisproduct->stock <= 0){
				// 			    $alertstring = "<div class='alert alert-danger'>Can't proceed with 0 amount in stock.</div>";
				// 			}else{
				// 			    $alertstring = "<div class='alert alert-danger'>One or more items (marked in red cells) in this order don't have enough stocks to issue this order. Please Re-Approve this order or top-up inventory or move
				// 			    remaining items for a new order and issue available items.<br>
				// 			    *select \"Move to New Order\" to proceed with available items </div>";
				// 			}

				$alertstring = "<div class='alert alert-danger'>One or more items (marked in red cells) in this order don't have enough stocks to issue this order. Please Re-Approve this order or top-up inventory or move
			    remaining items for a new order and issue available items.<br>
			    *select \"Move to New Order\" to proceed with available items </div>";

				$errors = true;
				$availableamount = $thisproduct->stock;
				$reqamount = $thisproduct->amount;
				$remainingamount = $thisproduct->amount - $thisproduct->stock;
				$product = $thisproduct->modelid;
?>
				<script type="text/javascript">
					$('#issue_button').prop('disabled', true);
				</script>

<?php

			} else {
				$invoicestring .= "<td align='right'>{$thisproduct->stock}</td>";
			}


			$invoicestring .= "<td align='right'>Rs. $unitprice</td>
		<td align='right'>Rs. $totalpriceforthismodel</td>
		</tr>";
		}
	}

	$billtotal = number_format((float)$billtotal, 2, '.', ',');

	$invoicestring .= "

<tr><td colspan='5' align='right'><b>Total:</b></td><td align='right'><b>Rs. $billtotal</b></td></tr>";

	$invoicestring .= "</table>";

	echo $invoicestring;


	echo $alertstring;
} ?>


<br>
<form action="process/issue.inc.php" method="POST">

	<input type="hidden" id="orderid" name="orderid" value="<?php echo $_GET["orderid"] ?>">
	<input type="hidden" id="dealerid" name="dealerid" value="<?php echo $dealerid ?>">
	<input type="hidden" id="availableamount" name="availableamount" value="<?php echo $availableamount ?>">
	<input type="hidden" id="remainingamount" name="remainingamount" value="<?php echo $remainingamount ?>">
	<input type="hidden" id="reqamount" name="reqamount" value="<?php echo $reqamount ?>">
	<input type="hidden" id="product" name="product" value="<?php echo $product ?>">
	<input type="hidden" id="errors" name="errors" value="<?php echo $errors ?>">

	<a class='btn btn-success' style='color:white' href='approveorder.php?orderid=<?php echo $_GET["orderid"] ?>' role='button'>Re-Approve</a>

	<?php

	if ($errors) {
	?>

		<input type="checkbox" id="moveCheck" name="move" value="" onclick="myFunction()">
		<label for="move"> Move to New Order</label><br>

		<button type="submit" id='issue_button1' name='issue_button1' class="btn btn-warning mt-2" style="display:none">Issue</button>


	<?php } else { ?>
		<button type="submit" id='issue_button' name='issue_button' class="btn btn-primary">Issue</button>

	<?php } ?>


</form>



</div> <!-- end main div -->

<script type="text/javascript">
	function myFunction() {
		// Get the checkbox
		var checkBox = document.getElementById("moveCheck");
		// Get the output text
		var text = document.getElementById("issue_button1");

		// If the checkbox is checked, display the output text
		if (checkBox.checked == true) {
			console.log('clicked');
			text.style.display = "block";
		} else {
			text.style.display = "none";
		}
	}

	$(document).ready(function() {

		$("#amount").on('input blur paste', function() {
			if (evt.which < 48 || evt.which > 57) {
				evt.preventDefault();
			}
		})

		//alert("HI");

		$("#udaraform").validationEngine('attach', {
			promptPosition: "bottomLeft",
			validationEventTrigger: "keyup",
			onValidationComplete: function(form, status) {
				if (totalproducts < 1) {
					$("#itemstable").hide("slow");
					$("#emptydiv").show("slow");
					$("#noitems").show("slow");

				} else {
					//$("#noitems").hide("slow");	
					return true;
				}
			}
		});


		$('#techdistrict').on('change', function(e) {
			var optionSelected = $("option:selected", this);
			var selectedarea = this.value;
			//alert(valueSelected);
			$.ajax({
				type: 'POST',
				async: false,
				url: 'process/getdealers.php',
				data: {
					"area": selectedarea
				},
				dataType: 'html',
				success: function(data) {
					var peopledata = JSON.parse(data);
					$("#dealerid").html(peopledata.dealers);
				},
				error: function() {
					alert('An unknown error occoured, Please try again Later...!');

				}
			});
		});

		$("#techdistrict").trigger("change");

	});

	var totalproducts = 0;

	var itemcount = 1;

	var productarray = []; //this array is used to prevent duplicate values


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


			var thisitem = "item" + itemcount;


			//product id is passed to the form as a hidden input in the first td
			var thisrecord = "<tr id='record" + itemcount + "'><td><?php echo $orderitem->model ?><input type='hidden' id='model" + itemcount + "' name='products[" + thisitem + "][]' value='<?php echo $orderitem->modelid ?>' /></td><td align='right'><input type='number' min='0' value='<?php echo $thisitemamount ?>' class='form-control col-md-4' data-validation-engine='validate[required,custom[integer], min[0], funcCall[validateamount]]' id='amount" + itemcount + "' name='products[" + thisitem + "][]'></td><td align='right'><input type='number' min='0' value='<?php echo $orderitem->amountfree ?>' class='form-control col-md-4' data-validation-engine='validate[required,custom[integer], min[0], funcCall[validateamount]]' id='amountfree" + itemcount + "' name='products[" + thisitem + "][]'></td><td class='text-right'><?php echo $productinvcountarray[$orderitem->modelid] ?></td><td>&nbsp;	&nbsp;<button class='btn btn-danger' id='removeitembutton" + itemcount + "' onclick='deleteitem(this.id)' type='button'>&#10005;</button></td></tr>";

			$("#itemstable").append(thisrecord);

			itemcount++;
			totalproducts++;



	<?php
		}
	}



	?>

	function addnewitem(value) {

		var amountvalue = document.getElementById("amount").value;
		var amountfreevalue = document.getElementById("amountfree").value;
		//alert(amountvalue);
		//if (!(Number.isInteger(amountvalue))) {
		//if(!(amountvalue === parseInt(amountvalue, 10))){

		// if(productarray.includes($("#model").val())){
		// 	return false;
		// }

		for (i = 0; i < itemcount; i++) { // prevent adding same product twice
			if ($("#model" + i).val() == $("#model").val()) {
				//console.log("HI");
				//alert("HI");
				return false;
			}
		}

		if (!(isInt(amountvalue) && isInt(amountfreevalue) && (amountvalue > 0 || amountfreevalue > 0))) {
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

		var thisitem = "item" + itemcount;

		//	$("#udaraform").append("<input type='hidden' id='model"+itemcount+"' name='products["+thisitem+"][]' value='"+ $("#model").val()+"' />");  

		//product id is passed to the form as a hidden input in the first td
		var thisrecord = "<tr id='record" + itemcount + "'><td>" + $("#model").find('option:selected').text() + "<input type='hidden' id='model" + itemcount + "' name='products[" + thisitem + "][]' value='" + $("#model").val() + "' /></td><td align='right'><input type='number' min='0' value='" + Math.trunc($("#amount").val()) + "' class='form-control col-md-4' data-validation-engine='validate[required,custom[integer], min[0], funcCall[validateamount]]' id='amount" + itemcount + "' name='products[" + thisitem + "][]'></td><td align='right'><input type='number' min='0' value='" + Math.trunc($("#amountfree").val()) + "' class='form-control col-md-4' data-validation-engine='validate[required,custom[integer], min[0], funcCall[validateamount]]' id='amountfree" + itemcount + "' name='products[" + thisitem + "][]'></td><td class='text-right'>" + productidobject[$('#model').val()] + "</td><td>&nbsp;	&nbsp;<button class='btn btn-danger' id='removeitembutton" + itemcount + "' onclick='deleteitem(this.id)' type='button'>&#10005;</button></td></tr>";

		$("#itemstable").append(thisrecord);




		/*	$("#udaraform").append("<input type='hidden' id='amount"+itemcount+"' name='products["+thisitem+"][]' value='"+ $("#amount").val()+"' />");
			$("#udaraform").append("<input type='hidden' id='amountfree"+itemcount+"' name='products["+thisitem+"][]' value='"+ $("#amountfree").val()+"' />");*/

		$("#itemstable").show("slow");
		$("#emptydiv").hide("slow");

		itemcount++;
		totalproducts++;

		if (totalproducts < 1) {
			$("#itemstable").hide("slow");
			$("#emptydiv").show("slow");
			//$("#noitems").show("slow");

		} else {
			//$("#noitems").hide("slow");		
		}
		$("#submit").attr("disabled", false); //re-enable the submit button everytime user adds an item
	}

	function deleteitem(id) {
		//var parentrecord = id.replace("removeitembutton", "record");
		$("#" + id.replace("removeitembutton", "record") + "").remove();
		$("#" + id.replace("removeitembutton", "model") + "").remove();
		$("#" + id.replace("removeitembutton", "amount") + "").remove();
		$("#" + id.replace("removeitembutton", "amountfree") + "").remove();

		totalproducts--;





		if (totalproducts < 1) {
			$("#itemstable").hide("slow");
			$("#emptydiv").show("slow");
			//$("#noitems").show("slow");
			$("#submit").attr("disabled", true);

		} else {
			//$("#noitems").hide("slow");		
		}
	}
</script>

<?php require_once "common/footer.php" ?>