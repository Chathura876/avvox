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
  function validateamount(field, rules, i, options){
    
    if(field.val() < 1){
      //alert(rules);
      return "amount should be greater than or equel to 1";
    }

  }

	function isInt(value) {
	  return !isNaN(value) && (function(x) { return (x | 0) === x; })(parseFloat(value))
	}
</script>

<form method="post" id= "udaraform" action="process/addinventory.inc.php">

<div class="row">
   <div class="col-12"><h5>Add Inventory for Dealer</h5></div>

<?php if(isset($_GET['action'])){ ?>

    <div class='col-12' id='successmessage' style='display:none'><div class='alert alert-success' role='alert'>
            <b>Items Successfully added into the inventory</b>
    </div></div>

    <script type="text/javascript">
    	$("#successmessage").show().delay(5000).fadeOut(2000);
    </script>

<?php }  ?>


<div class="form-group col-md-6 col-12">
	<label for="model">Model &nbsp;	&nbsp;	</label>
	    <select class="form-control" id="model" name="model">
			<?php
			$query = "SELECT * FROM product WHERE status='Active' ORDER BY model ASC";
			if ($result = $mysqli->query($query)) {
				while ($product = $result->fetch_object()) {
				     echo "<option value='$product->id'>$product->model</option>";
				}
			}
			?>

	    </select>
</div>

<div class="form-group col-md-3 col-6">
	<label for="amount">Amount  &nbsp;	&nbsp;</label>
	<input type="number" min="1" class="form-control" 
    data-validation-engine="validate[required,custom[integer], min[1], funcCall[validateamount]]"
  id="amount" name="amount">
</div>

<div  class="form-group col-md-3 col-6">
	<button class="btn btn-success" id="additembutton" onclick="addnewitem()" style="margin-top: 32px;" type="button">+</button>

</div>

	<div class="col-12 mb-3 alert-danger" id="emptyamount" style="display: none">
	Please enter a positive integer value for amount
	</div>

	<div class="col-12">
	<br><h6>Summary</h6>	
	<table class="table" style="display:none" id="itemstable" style="width:100%">
	  <tr>
	    <th>Model&nbsp;	&nbsp;</th>
	    <th align='right'>Amount</th>
	    <th>Remove</th>
	  </tr>
	</table>

	</div>

</div>


<div class="row" id="emptydiv">
	<div class="col-12 mb-3 alert-danger">
	Your list is empty
	</div>
</div>

<div class="row alert alert-danger" id="noitems" style="display: none">
	<div class="col-12 mb-3">
	Please add at least one item before ordering!!
	</div>
</div>

<div class="row">


	<div class="form-group col-md-6" id="techdistrictdiv">
	  <label for="techdistrict">District</label>
	  <select class="form-control" id="techdistrict" name="techdistrict" >
	   	 <option>Ampara</option>
		 <option>Anuradhapura</option>
		 <option>Batticaloa</option>
		 <option>Badulla</option>
		 <option>Colombo</option>
		 <option>Galle</option>
		 <option>Gampaha</option>
		 <option>Hambantota</option>
		 <option>Jaffna</option>
		 <option>Kalutara</option>
		 <option>Kandy</option>
		 <option>Kegalle</option>
		 <option>Kilinochchi</option>
		 <option>Kurunegala</option>
		 <option>Mannar</option>
		 <option>Matale</option>
		 <option>Matara</option>
		 <option>Monaragala</option>
		 <option>Mulativu</option>
		 <option>Nuwaraeliya</option>
		 <option>Polonnaruwa</option>
		 <option>Puttalam</option>
		 <option>Rathnapura</option>
		 <option>Trincomalee</option>
		 <option>Vavuniya</option>
	  </select>
	</div>

	  <div class="form-group col-md-6" id="dealerdiv">
	    <label for="dealerid">Dealer or Shop</label>
	    <select class="form-control" id="dealerid" name="dealerid">
	    </select>
	  </div>


</div>


<div class="row">	
<div class="col-6">
	
<button class="btn btn-primary" id="submit" name="submit" disabled="true" type="submit">Add to Inventory</button>
</div>


</div> <!-- end row -->

</form>	



<script type="text/javascript">
  
$(document).ready(function () {


  $("#amount").on('input blur paste', function(){
  	    if (evt.which < 48 || evt.which > 57){
        evt.preventDefault();
    	}
  });	

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

function addnewitem(value){

	var amountvalue = document.getElementById("amount").value;
	//alert(amountvalue);
	//if (!(Number.isInteger(amountvalue))) {
	//if(!(amountvalue === parseInt(amountvalue, 10))){
	if(!(isInt(amountvalue) && amountvalue >= 1)){
		$("amount").addClass("has-error");
		$("#amount").focus();
		$("#emptyamount").show("fast");
	
    	return false;
  	}

  	$("#emptyamount").hide();
   // if($('#amount').val() == ''){
   //    alert('Input can not be left blank');
   //    return false;
   // }
	var thisrecord = "<tr id='record"+itemcount+"'><td>"+$("#model").find('option:selected').text()+"</td><td align='right'>"+Math.trunc($("#amount").val())+"</td><td>&nbsp;	&nbsp;<button class='btn btn-danger' id='removeitembutton"+itemcount+"' onclick='deleteitem(this.id)' type='button'>&#10005;</button></td></tr>";

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