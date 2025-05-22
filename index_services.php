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

                <h5>Add &nbsp;New &nbsp;&nbsp;&nbsp;&nbsp;Job&nbsp;&nbsp;</h5>
              </div>
              <div class="icon">
                <i class="fas fa-tools"></i>
              </div>
              <a href="addjob.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
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

                <h5>Non-Approved Jobs</h5>
              </div>
              <div class="icon">
                <i class="fas fa-tools"></i>
              </div>
              <a href="nonapprovedjobs.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>  

<?php } ?> <!-- ----------------------------------------------------------------------- -->

<?php $permissions = array("admin", "dealer", "shop", "technician");
if (in_array($_SESSION['usertype'], $permissions)){ ?>
 
           <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3>..</h3>

                <h5>Pending&nbsp;&nbsp;&nbsp;&nbsp; Jobs&nbsp;&nbsp;</h5>
              </div>
              <div class="icon">
                <i class="fas fa-tools"></i>
              </div>
              <a href="pendingjobs.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>  

<?php } ?> <!-- ----------------------------------------------------------------------- -->

<?php $permissions = array("admin", "dealer", "shop", "technician");
if (in_array($_SESSION['usertype'], $permissions)){ ?>
 
           <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3>..</h3>

                <h5>Completed Jobs</h5>
              </div>
              <div class="icon">
                <i class="fas fa-check"></i>
              </div>
              <a href="completedjobs.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>  

<?php } ?> <!-- ----------------------------------------------------------------------- -->

<?php $permissions = array("admin");
if (in_array($_SESSION['usertype'], $permissions)){ ?>
 
           <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3>..</h3>

                <h5>All Jobs</h5>
              </div>
              <div class="icon">
                <i class="fas fa-check"></i>
              </div>
              <a href="alljobs.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>  

<?php } ?> <!-- ----------------------------------------------------------------------- -->



          <!-- ./col -->
        </div>


<?php require_once "common/footer.php" ?>