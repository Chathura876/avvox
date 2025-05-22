<?php require_once "common/header.php" ?>
<?php
$permissions = array("admin","operator");
if (!(in_array($_SESSION['usertype'], $permissions))){
    header("Location: index.php");  
}
?>
<?php require_once "common/nav.php" ?>

<div class="row">
	<div class="form-group col-md-6">
	  <h5>Add New Job</h5>
	</div>
</div>



<form method="post" autocomplete="off" id= "udaraform" action="process/addjob.inc.php">

<div class="row">
<?php if(isset($_GET['action'])){ ?>

    <div class='col-12' id='successmessage' style='display:none'><div class='alert alert-success' role='alert'>
            <b>Job Added Successfully. Job ID is <?php echo $_GET['jobid'] ?>.</b>
    </div></div>

    <script type="text/javascript">
    	$("#successmessage").show().delay(60000).fadeOut(2000);
    </script>

<?php }  ?>

<?php
$query = "SHOW TABLE STATUS LIKE 'job'";
if ($result = $mysqli->query($query)) {
	$objectname = $result->fetch_object();
	$nextid = $objectname->Auto_increment;
}

?>

<div class='col-12'>
	<div class='alert alert-warning' role='alert'>
	Next Available Job id is: <b><?php echo $nextid ?></b>
	</div>

</div>

	<div class="form-group col-md-6">
	  <label for="warrantyid">Warranty Card Number</label>
	  <div class="input-group">
	  	<input type="text" class="form-control form-control-lg" id="warrantyid" name="warrantyid" data-validation-engine="validate[required]" data-prompt-position="topRight">
	  	<div class="input-group-append">
    		<button class="btn btn-primary" id="warrantyidbutton" type="button">Search</button>
  		</div>
	  </div>
	  	<span class="form-group help-block" id="infodiv"></span>
	</div>
<!-- </div>

<div class="row" id="nicdiv"> -->
	<div class="form-group col-md-6">
	  <label for="nic">NIC Number</label>
	  <div class="input-group">
	  <input type="text" class="form-control form-control-lg" id="nic" name="nic" data-prompt-position="topRight">
	  	<div class="input-group-append">
    		<button class="btn btn-primary" id="nicbutton" type="button">Search</button>
  		</div>	  
	  </div>
	  <span class="form-group help-block" id="infodiv2"></span>
	</div>

</div>


<div class="row" id="selectwarrantyiddiv" style="display:none">
  <div class="form-group col-md-6">
    <label for="selectwarrantyid">Select the Item</label>
    <select class="form-control" id="selectwarrantyid" name="selectwarrantyid">
    </select>
  </div>
</div>  

<!-- <div class="row">
	<div class="form-group col-md-6">
		<button id="proceedbutton" type="button" class="btn btn-primary">Proceed</button>
	</div>
</div>
 -->



<div class="row" >
	<div class="form-group col-md-6 validate[required]" id="contactnamediv" style="display:none">
	  <label for="contactname">Contact Person Name</label>
	  <input type="text" class="form-control" id="contactname" name="contactname" data-validation-engine="validate[required, custom[onlyLetterSp]]">
	</div>

	<div class="form-group col-md-6" id="contactnodiv" style="display:none">
	  <label for="contactno">Contact Number</label>
	  <input type="text" class="form-control" id="contactno" name="contactno" data-validation-engine="validate[required, minSize[10], maxSize[10], custom[integer], min[1]]">
	</div>

	<div class="form-group col-md-6" id="addressdiv" style="display:none">
	  <label for="address">Adderss</label>
	    <textarea class="form-control" id="address" name="address" rows="4"></textarea>
	</div>

	<div class="form-group col-md-6" id="descriptiondiv" style="display:none">
	  <label for="description">Job Description</label>
	    <textarea class="form-control" id="description" name="description" rows="4" data-validation-engine="validate[required]"></textarea>
	</div>

	<div class="form-group col-md-6"  id="purchasediv" style="display:none">
	  <label for="address">Date of Purchase</label>
	    <input type="text" class="form-control" id="purchaseddate" name="purchaseddate" data-validation-engine="validate[required]">
	</div>

  <div class="form-group col-md-6" id="modeldiv" style="display:none">
    <label for="modelid">Model</label>
    <select class="form-control" id="modelid" name="modelid">
		<?php
		$query = "SELECT * FROM product ORDER BY model ASC";
		if ($result = $mysqli->query($query)) {
			while ($model = $result->fetch_object()) {
			     echo "<option value='$model->id'>$model->model</option>";
			}
		}
		?>

    </select>
  </div>

	<div class="form-group col-md-6" id="techdistrictdiv" style="display:none">
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

	  <div class="form-group col-md-6" id="dealerdiv" style="display:none">
	    <label for="dealerid">Dealer or Shop</label>
	    <select class="form-control" id="dealerid" name="dealerid">
	    </select>
	  </div>
 
	<div class="form-group col-md-6" id="techiddiv" style="display:none">
	  <label for="techid">Technician</label>
	  <select class="form-control" id="techid" name="techid" >
	  </select>
	</div>

	<div class="form-group col-md-6" id="jobtypediv" style="display:none">
	  <label for="techid">Job Type</label>
	  <select class="form-control" id="jobtype" name="jobtype" >
	  <option>Free</option>
	  <option>Paid</option>
	  </select>
	</div>
</div>

<input type="hidden" id="warrantyidval" name="warrantyidval">

<input type="hidden" id="addtype" name="addtype">

<input type="hidden" id="olddealerid" name="olddealerid">

<button type="submit" class="btn btn-primary" id="addbutton" disabled="disabled">Add Job</button>
</form>

<script type="text/javascript">
  
$(document).ready(function () {
  //alert("HI");
  $("#udaraform").validationEngine('attach', {promptPosition : "inline", validationEventTrigger: "keyup"});

  $("#purchaseddate").datepicker({
  	dateFormat: 'yy-mm-dd', 
  	maxDate: 0,
	changeMonth: true,
    changeYear: true
  });//0 is for today

  //initializing technician and dealer data for the first time
  $("#techdistrict").trigger("change");
        //   $.ajax({
        //   type: 'POST',
        //   async: false,
        //   url: 'process/gettechnicians.php',
        //   data: {"area": "Ampara" },
        //   dataType: 'html',
        //   success: function (data) {
        //     //alert(data);
        //     $("#techid").empty();
        //     $("#techid").append(data);
        //   },
        //   error: function () {
        //       alert('An unknown error occoured, Please try again Later...!');
              
        //   }
        // });

});

//$( "#warrantyid" ).blur(function() {
$( "#warrantyidbutton" ).click( function() {
		$("#warrantyidval").val($("#warrantyid").val()); //assign value to hidden input 

      $.ajax({
        type: 'POST',
        async: false,
        url: 'process/checkwarrantyid.php',
        data: {warrantyid: $("#warrantyid").val()},
        dataType: 'html',
        success: function (data) {
          var customerdata = JSON.parse(data);// parse and get string data to javascript object
          //alert (customerdata.result);

        	$("#infodiv").html(customerdata.warrantyinfo);

         	if(customerdata.result == 'exists'){
	            $("#contactname").val(customerdata.fullname);
	            $("#contactno").val(customerdata.phone);
	            $("#nic").val(customerdata.nic);
	            //$("#nicdiv").hide();
	            $("#addressdiv").hide();
	            $("#purchasediv").hide();
	            $("#modeldiv").hide();
				$("#dealerdiv").hide();

			    $("#contactnamediv").show();
			    $("#contactnodiv").show();
			    $("#descriptiondiv").show();
			    $("#techdistrictdiv").show();
			    $("#techiddiv").show();
			    $("#addbutton").show();
			    $("#jobtypediv").show();

			    $("#addbutton").prop('disabled', false);

	            //$("#nic").prop('disabled', true);//disable thi inputs because they arent needed for existing customer
	            $("#address").prop('disabled', true);
	            $("#purchaseddate").prop('disabled', true);
	            $("#modelid").prop('disabled', true);
				$("#dealerid").prop('disabled', true);


	            $("#infodiv").html(customerdata.warrantyinfo);
	            $("#addtype").val("existing");
	            $("#olddealerid").val(customerdata.dealerid); 
          	}
	        else{
	            //alert("Not Exists");

	            $("#addbutton").prop('disabled', false);
	            $("#nic").val("");//empty the nic field


	            $("#contactname").val("");
	            $("#contactno").val("");            

	            $("#address").prop('disabled', false);
	            $("#purchaseddate").prop('disabled', false);
	            $("#modelid").prop('disabled', false);
				$("#dealerid").prop('disabled', false);

	            $("#addressdiv").show();
	            $("#purchasediv").show();
	            $("#modeldiv").show();
				$("#dealerdiv").show();

			    $("#contactnamediv").show();
			    $("#contactnodiv").show();
			    $("#descriptiondiv").show();
			    $("#techdistrictdiv").show();
			    $("#techiddiv").show();
			    $("#addbutton").show();
			    $("#jobtypediv").show();




	            $("#infodiv").html('<div class="alert alert-warning" role="alert">This item doesn\'t exists in the System. Please fill the information below to add this item into the system and create a new job</div>');
	            $("#addtype").val("new"); 

	            $("#infodiv2").empty();
	            $("#selectwarrantyiddiv").hide();           
	        }
        },
        error: function () {
            alert('An unknown error occoured, Please try again Later...!');
            
        }
      });
});


$( "#nicbutton" ).click(function() {
      $.ajax({
        type: 'POST',
        async: false,
        url: 'process/checknic.php',
        data: {nic: $("#nic").val()},
        dataType: 'html',
        success: function (data) {
          var customerdata = JSON.parse(data);// parse and get string data to javascript object
          //alert (customerdata.result);

        	

         	if(customerdata.result == 'morethanone'){
         		$("#infodiv2").html(customerdata.description);
         		$("#selectwarrantyid").html(customerdata.content);
         		$("#selectwarrantyiddiv").show();
         		$('#warrantyid').val($("#selectwarrantyid").val());
    			$("#warrantyidbutton").trigger("click");
    			$("#selectwarrantyiddiv").show();

    			//$("#warrantyid").prop('disabled', true);

	   //          $("#contactname").val(customerdata.fullname);
	   //          $("#contactno").val(customerdata.phone);
	   //          $("#nicdiv").hide();
	   //          $("#addressdiv").hide();
	   //          $("#purchasediv").hide();
	   //          $("#modeldiv").hide();
				// $("#dealerdiv").hide();
	   //          $("#nic").prop('disabled', true);//disable thi inputs because they arent needed for existing customer
	   //          $("#address").prop('disabled', true);
	   //          $("#purchaseddate").prop('disabled', true);
	   //          $("#modelid").prop('disabled', true);
				// $("#dealerid").prop('disabled', true);
	   //          $("#infodiv").html(customerdata.warrantyinfo);
	   //          $("#addtype").val("existing");
	   //          $("#olddealerid").val(customerdata.dealerid); 
          	}
          	else if(customerdata.result == 'one'){
          		$("#infodiv2").empty();

			    $('#warrantyid').val(customerdata.content);
			    $("#warrantyidbutton").trigger("click");
			    $("#selectwarrantyiddiv").hide();

			    //$("#warrantyid").prop('disabled', true);

          	}
	        else{
	            $("#infodiv").empty();
	            $("#selectwarrantyiddiv").hide();

	            $("#contactname").val("");
	            $("#contactno").val(""); 
	            $("#warrantyid").val("");

	            $("#warrantyid").prop('disabled', false);           
	            //$("#nicdiv").show();
	   //          $("#addressdiv").show();
	   //          $("#purchasediv").show();
	   //          $("#modeldiv").show();
				// $("#dealerdiv").show();
	   //          $("#nic").prop('disabled', false);//disable thi inputs because they arent needed for existing customer
	   //          $("#address").prop('disabled', false);
	   //          $("#purchaseddate").prop('disabled', false);
	   //          $("#modelid").prop('disabled', false);
				// $("#dealerid").prop('disabled', false);
	            $("#infodiv2").html('<div class="alert alert-warning" role="alert">No records found for this NIC. Please Search using Warranty Card Number</div>');
	            $("#addtype").val("new");
	            $('#warrantyid').removeAttr('value');//make the warranty id field empty            
	        }
        },
        error: function () {
            alert('An unknown error occoured, Please try again Later...!');
            
        }
      });
});



$('#techdistrict').on('change', function (e) {
    var optionSelected = $("option:selected", this);
    var selectedarea = this.value;
    //alert(valueSelected);
        $.ajax({
          type: 'POST',
          async: false,
          url: 'process/gettechnicians.php',
          data: {"area": selectedarea },
          dataType: 'html',
          success: function (data) {
			var peopledata = JSON.parse(data);
            $("#techid").html(peopledata.technicians);
            $("#dealerid").html(peopledata.dealers);
          },
          error: function () {
              alert('An unknown error occoured, Please try again Later...!');
              
          }
        });
});


$('#selectwarrantyid').on('change', function (e) {
    //var optionSelected = $("option:selected", this);
    //var selectedarea = this.value;
    $('#warrantyid').val(this.value);
    $("#warrantyidbutton").trigger("click");

    //alert(valueSelected);

});

$('#proceedbutton').click(function (e) {
    $("#udaraform").show();
    if($("#addtype").val() == 'new'){
        $("#addressdiv").show();
        $("#purchasediv").show();
        $("#modeldiv").show();
		$("#dealerdiv").show();    	
    }
    else{
        $("#addressdiv").hide();
        $("#purchasediv").hide();
        $("#modeldiv").hide();
		$("#dealerdiv").hide();    	
    }

    $("#contactnamediv").show();
    $("#contactnodiv").show();
    $("#descriptiondiv").show();
    $("#techdistrictdiv").show();
    $("#techiddiv").show();
    $("#addbutton").show();
    $("#jobtypediv").show();
    //$("#contactnodiv").show();

});

</script>


<?php require_once "common/footer.php" ?>