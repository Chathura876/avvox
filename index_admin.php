<?php require_once "common/header.php" ?>
<?php require_once "common/nav.php" ?>

  <link rel="stylesheet" href="css/all.min.css">

  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="css/adminlte.min.css">

<link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">

        <div class="row">

<div class='col-12 mb-2 text-center text-primary'>
<?php $permissions = array("dealer", "shop");
if (in_array($_SESSION['usertype'], $permissions)){ ?> 
  <h4> Hello <?php echo $_SESSION['shopname'] ?>, Welecome To Avvox CRM!</h4>
<?php } else { ?> 
  <h4> Hello <?php echo $_SESSION['fullname'] ?>, Welecome To Avvox CRM!</h4>


<?php } ?>
</div>







      	


<?php $permissions = array("admin");
if (in_array($_SESSION['usertype'], $permissions)){ ?>
 
           <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3>..</h3>

                <h5>Manage Products</h5>
              </div>
              <div class="icon">
                <i class="fas fa-box-open"></i>
              </div>
              <a href="manageproducts.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>  

<?php } ?> <!-- ----------------------------------------------------------------------- -->




<?php $permissions = array("admin", "salesrep");
if (in_array($_SESSION['usertype'], $permissions)){ ?>
 
           <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3>..</h3>

                <h5>Manage Dealers</h5>
              </div>
              <div class="icon">
                <i class="fas fa-shipping-fast"></i>
              </div>
              <a href="managedealers.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>  

<?php } ?> <!-- ----------------------------------------------------------------------- -->

<?php $permissions = array("admin", "dealer", "salesrep");
if (in_array($_SESSION['usertype'], $permissions)){ ?>
 
           <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3>..</h3>

                <h5>&nbsp;Manage &nbsp;&nbsp;Shops</h5>
              </div>
              <div class="icon">
                <i class="fas fa-store-alt"></i>
              </div>
              <a href="manageshops.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>  

<?php } ?> <!-- ----------------------------------------------------------------------- -->

<?php $permissions = array("admin");
if (in_array($_SESSION['usertype'], $permissions)){ ?>
 
           <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3>..</h3>

                <h5>Manage Technicians</h5>
              </div>
              <div class="icon">
                <i class="fas fa-users-cog"></i>
              </div>
              <a href="managetechnicians.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>  

<?php } ?> <!-- ----------------------------------------------------------------------- -->

<?php $permissions = array("admin");
if (in_array($_SESSION['usertype'], $permissions)){ ?>
 
           <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3>..</h3>

                <h5>Manage Sales Reps</h5>
              </div>
              <div class="icon">
                <i class="fas fa-user-tie"></i>
              </div>
              <a href="managesalesreps.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>  

<?php } ?> <!-- ----------------------------------------------------------------------- -->

<?php $permissions = array("admin");
if (in_array($_SESSION['usertype'], $permissions)){ ?>
 
           <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3>..</h3>

                <h5>Add Inventory</h5>
              </div>
              <div class="icon">
                <i class="fas fa-dolly-flatbed"></i>
              </div>
              <a href="addinventory.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>  

<?php } ?> <!-- ----------------------------------------------------------------------- -->

<?php $permissions = array("admin", "dealer", "shop");
if (in_array($_SESSION['usertype'], $permissions)){ ?>
 
           <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3>..</h3>

                <h5>Manage Customers</h5>
              </div>
              <div class="icon">
                <i class="fas fa-users"></i>
              </div>
              <a href="managecustomers.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>  

<?php } ?> <!-- ----------------------------------------------------------------------- -->

<?php $permissions = array("admin");
if (in_array($_SESSION['usertype'], $permissions)){ ?>
 
           <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3>..</h3>

                <h5>Manage Passwords</h5>
              </div>
              <div class="icon">
                <i class="fas fa-key"></i>
              </div>
              <a href="managepasswords.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>  

<?php } ?> <!-- ----------------------------------------------------------------------- -->







          <!-- ./col -->
        </div>


<?php require_once "common/footer.php" ?>