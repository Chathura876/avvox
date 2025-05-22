<?php require_once "common/header.php" ?>
<?php
$permissions = array("admin");

if (!(in_array($_SESSION['usertype'], $permissions))){
    header("Location: index.php");  
}

?>
<?php require_once "common/nav.php" ?>

<script type="text/javascript">
	var totalproducts = 0;
	<?php $totalproducts = 0; ?>
  function validateamount(field, rules, i, options){
    
    if(field.val() < 0){
      //alert(rules);
      return "amount should be greater than or equal to 0";
    }

  }

	function isInt(value) {
	  return !isNaN(value) && (function(x) { return (x | 0) === x; })(parseFloat(value))
	}
</script>

<?php

if(isset($_GET["orderid"])){
	
	$statusquery = "SELECT issued FROM orders WHERE orderid={$_GET["orderid"]}";

	
	
	if($statusresult = $mysqli->query($statusquery)) {
		$thisorder = $statusresult->fetch_object();
		if($thisorder->issued >0){
			echo "<div class='row'>
			<div class='col-12 mb-3 alert-danger'>
			Sorry This order has been issued already
			</div>
			</div>";
			require_once "common/footer.php";
			
			exit();
		}
	}	
	
	$query = "SELECT orders.*, user.shopname FROM orders 
	INNER JOIN user
	WHERE orderid={$_GET["orderid"]}
	AND orders.dealerid = user.id
	";

	if ($result = $mysqli->query($query)) {
		$order = $result->fetch_object();
	}


?>

<form method="post" id= "udaraform" autocomplete="off" action="process/issue.inc.php">

<div class="row">
   <div class="col-12"><h5>Issue Orders</h5></div>
   <div class="col-12"><h5><?php echo $order->shopname ?></h5></div>


	<div class="col-12 mb-3 alert-danger" id="emptyamount" style="display: none">
	Please enter a numerical value for amount
	</div>

	<div class="col-12">
	<br><h6>Order summary</h6>


	<table class="table table-responsive" id="itemstable" style="width:100%">
	  <tr>
	    <th>Model&nbsp;	&nbsp;</th>
	    <th align='right'>Amount</th>
	    <th align='right'> Mark Complete</th>
	  </tr>

	<?php $query = "SELECT orderitems.*, product.model FROM orderitems 
	INNER JOIN product
	WHERE orderid={$_GET["orderid"]}
	AND orderitems.modelid=product.id";
	if ($result = $mysqli->query($query)) {
		while ($orderitem = $result->fetch_object()) {

			if($orderitem->amount > 0){
				$totalamountforthisproduct = $orderitem->amount + $orderitem->amountissued ;
				echo "<tr id='record{$orderitem->id}'><td>{$orderitem->model}</td>
				<td>
				<input type='number' min='0' max='{$orderitem->amount}' id='' name='products[{$orderitem->id}][]' value='{$orderitem->amount}' data-validation-engine='validate[required,custom[integer], max[{$orderitem->amount}],  funcCall[validateamount]]' />
				</td>

				<input type='hidden' id='model{$orderitem->id}' name='products[{$orderitem->id}][]' value='{$orderitem->modelid}'>

				<td>
				<input type='checkbox' id='' name='products[{$orderitem->id}][]' value='$totalamountforthisproduct' />
				</td>

				</tr>";
				$totalproducts++;
				//echo "<input type='hidden' id='model{$orderitem->id}' name='products[{$orderitem->id}][]' value='{$orderitem->modelid}'>";
			}
		}
	}	
	?>	  
	</table>

	</div>

</div>

<div class="row" id="emptydiv" style="display:none" >
	<div class="col-12 mb-3 alert-danger">
	Sorry, You have deleted all the items. So you can't proceed!!! 
	
	Please <button class="btn btn-primary btn-sm"  type="button" onClick="window.location.reload()">Refresh</button> this page and try again.
	</div>
</div>

<input type="hidden" id="orderid" name="orderid" value="<?php echo $_GET["orderid"] ?>">
<input type="hidden" id="dealerid" name="dealerid" value="<?php echo $order->dealerid ?>">


<div class="row">	
<div class="col-6">
	
<button class="btn btn-primary" id="submit" name="submit" type="submit">Issue</button>
</div>


</div> <!-- end row -->

</form>	

<?php } ?>

<script type="text/javascript">

var totalproducts = <?php echo $totalproducts ?>;
  
$(document).ready(function () {
  //alert("HI");
  $("#udaraform").validationEngine('attach', {promptPosition : "inline", validationEventTrigger: "keyup"});

});

//var totalproducts = 0;

var itemcount = 1;

function addnewitem(value){

	var amountvalue = document.getElementById("amount").value;
	//alert(amountvalue);
	//if (!(Number.isInteger(amountvalue))) {
	//if(!(amountvalue === parseInt(amountvalue, 10))){
	if(!(isInt(amountvalue))){
		$("amount").addClass("has-error");
		$("#amount").focus();
		$("#emptyamount").show("slow");
	
    	return false;
  	}

  	$("#emptyamount").hide();
   // if($('#amount').val() == ''){
   //    alert('Input can not be left blank');
   //    return false;
   // }
	var thisrecord = "<tr id='record"+itemcount+"'><td>"+$("#model").find('option:selected').text()+"</td><td align='right'>"+$("#amount").val()+"</td><td>&nbsp;	&nbsp;<button class='btn btn-danger' id='removeitembutton"+itemcount+"' onclick='deleteitem(this.id)' type='button'>&#10005;</button></td></tr>";

	$("#itemstable").append(thisrecord);

	var thisitem = "item"+itemcount;

	$("#udaraform").append("<input type='hidden' id='model"+itemcount+"' name='products["+thisitem+"][]' value='"+ $("#model").val()+"' />");
	$("#udaraform").append("<input type='hidden' id='amount"+itemcount+"' name='products["+thisitem+"][]' value='"+ $("#amount").val()+"' />");

	$("#itemstable").show("slow");
	$("#emptydiv").hide("slow");

itemcount++;
totalproducts++;

	if(totalproducts< 1){
		$("#itemstable").hide( "slow" );
		$("#emptydiv").show("slow");
		//$("#noitems").show("slow");

	}	

}

function deleteitem(id){
	//var parentrecord = id.replace("removeitembutton", "record");
	$("#"+id.replace("removeitembutton", "record")+"").remove();
	$("#"+id.replace("removeitembutton", "model")+"").remove();
	//$("#"+id.replace("removeitembutton", "amount")+"").remove();

	totalproducts--;

 	if(totalproducts< 1){
		$("#itemstable").hide( "slow" );
		$("#emptydiv").show("slow");
		$("#submit").attr("disabled", true);

	}

}
</script>

<?php require_once "common/footer.php" ?>