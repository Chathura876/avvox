<?php require_once "common/header.php" ?>
<?php
$permissions = array("admin", "technician");

if (!(in_array($_SESSION['usertype'], $permissions))){
    header("Location: index.php");  
}

?>
<?php require_once "common/nav.php" ?>

<?php if(isset($_GET['jobid'])){ ?>

<div class="row">
	<div class="col-12">
	  <h5>Job Update</h5>
	</div>
</div>

<form method="post" autocomplete="off" id= "udaraform" action="process/jobupdate.inc.php">

<div class="row">
	<div class="form-group col-md-6">
	  <label for="log">Select one of the options below or add description</label>
	  <select class="form-control" id="log" name="log" >
		 <option>Customer Was not at home</option>
		 <option>Customer Didn't Answer the Call</option>
		 <option>Warranty Card missing</option>
		 <option>Warranty Expired</option>
		 <option>Brought item home for repair</option>
		 <option>Can't Repair. Item returned to office</option>
		 <option>Item Repaired successfully</option>
		 <option>Item Replaced with a new Item</option>
		<option>Other</option>
	  </select>
	</div>
</div>

<div class="row" id="descdiv" style="display:none">
	<div class="form-group col-md-6">
	  <label for="description">Description</label>
	    <textarea class="form-control" id="description" name="description" data-validation-engine="validate[required]" rows="4"></textarea>
	</div>
</div>



<input type="hidden" id="jobid" name="jobid" value="<?php echo $_GET['jobid'] ?>">

<button type="submit" class="btn btn-primary">Update</button>
</form>

<script type="text/javascript">
  
$(document).ready(function () {
  //alert("HI");
  $("#udaraform").validationEngine('attach', {promptPosition : "inline", validationEventTrigger: "keyup"});
  $("#description").prop('disabled', true);

});

$('#log').on('change', function (e) {
    var optionSelected = $("option:selected", this);
    var selectedarea = this.value;
    if(selectedarea != "Other"){
		$("#descdiv").hide();
	    $("#description").prop('disabled', true);
    }
    else{
		$("#descdiv").show();
	    $("#description").prop('disabled', false);    	
    }

});

</script>

<?php } ?>

<?php require_once "common/footer.php" ?>