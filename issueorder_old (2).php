<?php require_once "common/header.php" ?>
<?php
$permissions = array("admin", "dealer", "shop", "salesrep");

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

<?php

if(isset($_GET["orderid"])){

	$productinvcountarray = array();//array to store current main inventory amounts for each product
	
	$statusquery = "SELECT issued FROM orders WHERE orderid={$_GET["orderid"]}";

	
	
	if($statusresult = $mysqli->query($statusquery)) {
		$thisorder = $statusresult->fetch_object();
		if($thisorder->issued >1){
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

<form method="post" id= "udaraform" action="process/approveorder.inc.php">

<input type='hidden' id='orderid' name='orderid' value='<?php echo $_GET["orderid"] ?>' />	

<div class="row">
   <div class="col-12"><h5>Approve Order</h5></div>


<div class="form-group col-md-6 col-12">
	<label for="model">Model &nbsp;	&nbsp;	</label>
	    <select class="form-control" id="model" name="model">
			<?php

			

			$query = "SELECT product.*, maininventory.amount FROM product 
			INNER JOIN maininventory ON product.id = maininventory.modelid  
			WHERE status='Active' ORDER BY model ASC";
			if ($result = $mysqli->query($query)) {

				while ($product = $result->fetch_object()) {
				     echo "<option value='$product->id'>$product->model</option>";
				     $productinvcountarray[$product->id] = $product->amount;

				     ?> 
				     <script type="text/javascript">
				     	productidobject["<?php echo $product->id ?>"] = <?php echo $product->amount ?>
				     </script>


				     <?php
				}
			}
			?>

	    </select>
</div>

<div class="form-group col-md-2 col-6">
	<label for="amount">Quantity  &nbsp;	&nbsp;</label>
	<input type="number" min="0" value="0" class="form-control" 
    data-validation-engine="validate[required,custom[integer], min[0], funcCall[validateamount]]"
  id="amount" name="amount">
</div>

<div class="form-group col-md-2 col-6">
	<label for="amountfree">Free &nbsp;	&nbsp;</label>
	<input type="number" min="0" value="0" class="form-control" 
    data-validation-engine="validate[required,custom[integer], min[0], funcCall[validateamount]]"
  id="amountfree" name="amountfree">
</div>

<div  class="form-group col-md-2 col-6">
	<button class="btn btn-success" id="additembutton" onclick="addnewitem()" style="margin-top: 32px;" type="button">+</button>

</div>

	<div class="col-12 mb-3 alert-danger" id="emptyamount" style="display: none">
	Please enter valid values for amount and free amount
	</div>

	<div class="col-12">
	<br><h6>Order summary</h6>	
	<table class="table" style="display:none" id="itemstable" style="width:100%">
	  <tr>
	    <th>Model&nbsp;	&nbsp;</th>
	    <th class="text-right">Quantity</th>
	    <th class="text-right">Free</th>
	    <th class="text-right">Inventory</th>
	    <th>Remove</th>
	  </tr>
	</table>

	</div>

</div>


<div class="row" id="emptydiv" style="display:none">
	<div class="col-12 mb-3 alert-danger">
	Your order list is empty
	</div>
</div>

<div class="row alert alert-danger" id="noitems" style="display: none">
	<div class="col-12 mb-3">
	Please add at least one item before ordering!!
	</div>
</div>


<div class="row">	
<div class="col-6">
	
<button class="btn btn-primary" id="submit" name="submit" type="submit">Approve</button>
</div>


</div> <!-- end row -->

</form>	

<?php } ?>

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