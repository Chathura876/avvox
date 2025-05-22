<?php require_once "common/header.php" ?>
<?php require_once "common/nav.php" ?>

  <link rel="stylesheet" href="css/all.min.css">

  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="css/adminlte.min.css">

<link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">

        <div class="row">
      	
<?php $permissions = array("admin", "dealer", "shop", "technician", "salesrep");
if (in_array($_SESSION['usertype'], $permissions)){ ?>
 
           <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3>..</h3>

                <h5>Manage Products</h5>
              </div>
              <div class="icon">
                <i class="ion ion-radio"></i>
              </div>
              <a href="manageproducts.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>  

<?php } ?> <!-- ----------------------------------------------------------------------- -->

<?php $permissions = array("admin", "dealer", "shop", "technician", "salesrep");
if (in_array($_SESSION['usertype'], $permissions)){ ?>
 
           <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3>..</h3>

                <h5>&nbsp;Order &nbsp;&nbsp;Products</h5>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
              <a href="addorder.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>  

<?php } ?> <!-- ----------------------------------------------------------------------- -->

<?php $permissions = array("admin", "dealer", "shop", "technician", "salesrep");
if (in_array($_SESSION['usertype'], $permissions)){ ?>
 
           <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3>..</h3>

                <h5>&nbsp;Manage &nbsp;Orders</h5>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
              <a href="manageorders.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>  

<?php } ?> <!-- ----------------------------------------------------------------------- -->

<?php $permissions = array("admin", "dealer", "shop", "technician", "salesrep");
if (in_array($_SESSION['usertype'], $permissions)){ ?>
 
           <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3>..</h3>

                <h5>Manage Dealers</h5>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
              <a href="managedealers.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>  

<?php } ?> <!-- ----------------------------------------------------------------------- -->

<?php $permissions = array("admin", "dealer", "shop", "technician", "salesrep");
if (in_array($_SESSION['usertype'], $permissions)){ ?>
 
           <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3>..</h3>

                <h5>&nbsp;Manage &nbsp;&nbsp;Shops</h5>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
              <a href="manageshops.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>  

<?php } ?> <!-- ----------------------------------------------------------------------- -->

<?php $permissions = array("admin", "dealer", "shop", "technician", "salesrep");
if (in_array($_SESSION['usertype'], $permissions)){ ?>
 
           <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3>..</h3>

                <h5>Manage Technicians</h5>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
              <a href="managetechnicians.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>  

<?php } ?> <!-- ----------------------------------------------------------------------- -->

<?php $permissions = array("admin", "dealer", "shop", "technician", "salesrep");
if (in_array($_SESSION['usertype'], $permissions)){ ?>
 
           <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3>..</h3>

                <h5>Manage Sales Reps</h5>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
              <a href="managesalesreps.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>  

<?php } ?> <!-- ----------------------------------------------------------------------- -->

<?php $permissions = array("admin", "dealer", "shop", "technician", "salesrep");
if (in_array($_SESSION['usertype'], $permissions)){ ?>
 
           <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3>..</h3>

                <h5>Manage Customers</h5>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
              <a href="managecustomers.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>  

<?php } ?> <!-- ----------------------------------------------------------------------- -->

<?php $permissions = array("admin", "dealer", "shop", "technician", "salesrep");
if (in_array($_SESSION['usertype'], $permissions)){ ?>
 
           <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3>..</h3>

                <h5>Add &nbsp;New &nbsp;&nbsp;&nbsp;&nbsp;Job&nbsp;&nbsp;</h5>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
              <a href="addjob.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>  

<?php } ?> <!-- ----------------------------------------------------------------------- -->

<?php $permissions = array("admin", "dealer", "shop", "technician", "salesrep");
if (in_array($_SESSION['usertype'], $permissions)){ ?>
 
           <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3>..</h3>

                <h5>Non-Approved Jobs</h5>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
              <a href="nonapprovedjobs.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>  

<?php } ?> <!-- ----------------------------------------------------------------------- -->

<?php $permissions = array("admin", "dealer", "shop", "technician", "salesrep");
if (in_array($_SESSION['usertype'], $permissions)){ ?>
 
           <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3>..</h3>

                <h5>Pending&nbsp;&nbsp;&nbsp;&nbsp; Jobs&nbsp;&nbsp;</h5>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
              <a href="pendingjobs.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>  

<?php } ?> <!-- ----------------------------------------------------------------------- -->

<?php $permissions = array("admin", "dealer", "shop", "technician", "salesrep");
if (in_array($_SESSION['usertype'], $permissions)){ ?>
 
           <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3>..</h3>

                <h5>Completed Jobs</h5>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
              <a href="completedjobs.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>  

<?php } ?> <!-- ----------------------------------------------------------------------- -->

<?php $permissions = array("admin", "dealer", "shop", "technician", "salesrep");
if (in_array($_SESSION['usertype'], $permissions)){ ?>
 
           <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3>..</h3>

                <h5>Non-Approved Job Report</h5>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
              <a href="nonapprovedjobsreport.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>  

<?php } ?> <!-- ----------------------------------------------------------------------- -->

<?php $permissions = array("admin", "dealer", "shop", "technician", "salesrep");
if (in_array($_SESSION['usertype'], $permissions)){ ?>
 
           <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3>..</h3>

                <h5>Pending Jobs Report</h5>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
              <a href="pendingjobsreport.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>  

<?php } ?> <!-- ----------------------------------------------------------------------- -->

<?php $permissions = array("admin", "dealer", "shop", "technician", "salesrep");
if (in_array($_SESSION['usertype'], $permissions)){ ?>
 
           <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3>..</h3>

                <h5>Completed Job Report</h5>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
              <a href="completedjobsreport.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>  

<?php } ?> <!-- ----------------------------------------------------------------------- -->



          <!-- ./col -->
        </div>


<?php require_once "common/footer.php" ?>