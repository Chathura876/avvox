<?php require_once "common/header.php" ?>
<?php require_once "common/nav.php" ?>

<style>
.dash-button{
    color: #fff;
    background-color: #49274A;
    border: 0px solid #fff;
	font-size: 20px; 
	width: 100%
}
</style>

<?php
//START LINKS FOR ADMIN
if($_SESSION['usertype'] == 'admin'){
?>
<h5 class="text-center">Welcome to Avvox CRM. Please select an action</h5>


<div class="row">
	<div class="col-12 col-md-6 mb-3 mx-auto">
	<a class="btn btn-primary bg-gradient-primary shadow-lg rounded p-2 dash-button" href="manageproducts.php" role="button">Manage Products</a>
	</div>
</div>	


<div class="row">
	<div class="col-12 col-md-6 mb-3 mx-auto">
	<a class="btn btn-primary bg-gradient-primary shadow-lg rounded p-2 dash-button" href="addorder.php" role="button">Order Products</a>
	</div>
</div>	


<div class="row">
	<div class="col-12 col-md-6 mb-3 mx-auto">
	<a class="btn btn-primary bg-gradient-primary shadow-lg rounded p-2 dash-button" href="manageorders.php" role="button">Manage Orders</a>
	</div>
</div>	


<div class="row">
	<div class="col-12 col-md-6 mb-3 mx-auto">
	<a class="btn btn-primary bg-gradient-primary shadow-lg rounded p-2 dash-button" href="managedealers.php" role="button">Manage Dealers</a>
	</div>
</div>	


<div class="row">
	<div class="col-12 col-md-6 mb-3 mx-auto">
	<a class="btn btn-primary bg-gradient-primary shadow-lg rounded p-2 dash-button" href="manageshops.php" role="button">Manage Shops</a>
	</div>
</div>	


<div class="row">
	<div class="col-12 col-md-6 mb-3 mx-auto">
	<a class="btn btn-primary bg-gradient-primary shadow-lg rounded p-2 dash-button" href="managetechnicians.php" role="button">Manage Technicians</a>
	</div>
</div>	


<div class="row">
	<div class="col-12 col-md-6 mb-3 mx-auto">
	<a class="btn btn-primary bg-gradient-primary shadow-lg rounded p-2 dash-button" href="managesalesreps.php" role="button">Manage Sales Reps</a>
	</div>
</div>	


<div class="row">
	<div class="col-12 col-md-6 mb-3 mx-auto">
	<a class="btn btn-primary bg-gradient-primary shadow-lg rounded p-2 dash-button" href="managecustomers.php" role="button">Manage Customers</a>
	</div>
</div>	


<div class="row">
	<div class="col-12 col-md-6 mb-3 mx-auto">
	<a class="btn btn-primary bg-gradient-primary shadow-lg rounded p-2 dash-button" href="addjob.php" role="button">Add New Job</a>
	</div>
</div>	


<div class="row">
	<div class="col-12 col-md-6 mb-3 mx-auto">
	<a class="btn btn-primary bg-gradient-primary shadow-lg rounded p-2 dash-button" href="nonapprovedjobs.php" role="button">Non-Approved Jobs</a>
	</div>
</div>	


<div class="row">
	<div class="col-12 col-md-6 mb-3 mx-auto">
	<a class="btn btn-primary bg-gradient-primary shadow-lg rounded p-2 dash-button" href="pendingjobs.php" role="button">Pending Jobs</a>
	</div>
</div>

<div class="row">
	<div class="col-12 col-md-6 mb-3 mx-auto">
	<a class="btn btn-primary bg-gradient-primary shadow-lg rounded p-2 dash-button" href="completedjobs.php" role="button">Completed Jobs</a>
	</div>
</div>

<div class="row">
	<div class="col-12 col-md-6 mb-3 mx-auto">
	<a class="btn btn-primary bg-gradient-primary shadow-lg rounded p-2 dash-button" href="nonapprovedjobsreport.php" role="button">Non-Approved Jobs Report</a>
	</div>
</div>

<div class="row">
	<div class="col-12 col-md-6 mb-3 mx-auto">
	<a class="btn btn-primary bg-gradient-primary shadow-lg rounded p-2 dash-button" href="pendingjobsreport.php" role="button">Pending Jobs Report</a>
	</div>
</div>

<div class="row">
	<div class="col-12 col-md-6 mb-3 mx-auto">
	<a class="btn btn-primary bg-gradient-primary shadow-lg rounded p-2 dash-button" href="completedjobsreport.php" role="button">Completed Jobs Report</a>
	</div>
</div>	
<?php }
else if($_SESSION['usertype'] == 'dealer'){ ?>

<div class="row">
	<div class="col-12 col-md-6 mb-3 mx-auto">
	<a class="btn btn-primary bg-gradient-primary shadow-lg rounded p-2 dash-button" href="addorder.php" role="button">Order Products</a>
	</div>
</div>	


<div class="row">
	<div class="col-12 col-md-6 mb-3 mx-auto">
	<a class="btn btn-primary bg-gradient-primary shadow-lg rounded p-2 dash-button" href="manageorders.php" role="button">Manage Orders</a>
	</div>
</div>

<div class="row">
	<div class="col-12 col-md-6 mb-3 mx-auto">
	<a class="btn btn-primary bg-gradient-primary shadow-lg rounded p-2 dash-button" href="manageshops.php" role="button">Manage Shops</a>
	</div>
</div>
<div class="row">
	<div class="col-12 col-md-6 mb-3 mx-auto">
	<a class="btn btn-primary bg-gradient-primary shadow-lg rounded p-2 dash-button" href="managecustomers.php" role="button">Manage Customers</a>
	</div>
</div>	
<div class="row">
	<div class="col-12 col-md-6 mb-3 mx-auto">
	<a class="btn btn-primary bg-gradient-primary shadow-lg rounded p-2 dash-button" href="pendingjobs.php" role="button">Pending Jobs</a>
	</div>
</div>

<div class="row">
	<div class="col-12 col-md-6 mb-3 mx-auto">
	<a class="btn btn-primary bg-gradient-primary shadow-lg rounded p-2 dash-button" href="completedjobs.php" role="button">Completed Jobs</a>
	</div>
</div>

<?php } else if($_SESSION['usertype'] == 'shop'){ ?>

<div class="row">
	<div class="col-12 col-md-6 mb-3 mx-auto">
	<a class="btn btn-primary bg-gradient-primary shadow-lg rounded p-2 dash-button" href="addorder.php" role="button">Order Products</a>
	</div>
</div>	


<div class="row">
	<div class="col-12 col-md-6 mb-3 mx-auto">
	<a class="btn btn-primary bg-gradient-primary shadow-lg rounded p-2 dash-button" href="manageorders.php" role="button">Manage Orders</a>
	</div>
</div>

<div class="row">
	<div class="col-12 col-md-6 mb-3 mx-auto">
	<a class="btn btn-primary bg-gradient-primary shadow-lg rounded p-2 dash-button" href="managecustomers.php" role="button">Manage Customers</a>
	</div>
</div>	
<div class="row">
	<div class="col-12 col-md-6 mb-3 mx-auto">
	<a class="btn btn-primary bg-gradient-primary shadow-lg rounded p-2 dash-button" href="pendingjobs.php" role="button">Pending Jobs</a>
	</div>
</div>

<div class="row">
	<div class="col-12 col-md-6 mb-3 mx-auto">
	<a class="btn btn-primary bg-gradient-primary shadow-lg rounded p-2 dash-button" href="completedjobs.php" role="button">Completed Jobs</a>
	</div>
</div>

<?php } else if($_SESSION['usertype'] == 'technician'){ ?>

<div class="row">
	<div class="col-12 col-md-6 mb-3 mx-auto">
	<a class="btn btn-primary bg-gradient-primary shadow-lg rounded p-2 dash-button" href="pendingjobs.php" role="button">Pending Jobs</a>
	</div>
</div>

<div class="row">
	<div class="col-12 col-md-6 mb-3 mx-auto">
	<a class="btn btn-primary bg-gradient-primary shadow-lg rounded p-2 dash-button" href="completedjobs.php" role="button">Completed Jobs</a>
	</div>
</div>

<?php } ?>


<?php require_once "common/footer.php" ?>