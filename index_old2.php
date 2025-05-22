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


<?php if ($_SESSION['usertype'] == "admin"){ ?>

<?php $permissions = array("admin");
if (in_array($_SESSION['usertype'], $permissions)){ 

  $jobtotal = "";
  $query = "SELECT COUNT(*) as total FROM job WHERE status=1";
  if ($result = $mysqli->query($query)) {
    $objectname = $result->fetch_object();
    $jobtotal = $objectname->total;
  }
  ?>
 
           <div class="col-lg-6 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3><?php echo $jobtotal ?></h3>

                <h5>Pending Jobs</h5>
              </div>
              <div class="icon">
                <i class="fas fa-briefcase"></i>
              </div>
              <a href="pendingjobs.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>  

<?php } ?> <!-- ----------------------------------------------------------------------- -->

<?php $permissions = array("admin");
if (in_array($_SESSION['usertype'], $permissions)){ 

  $ordertotal = "";
  $query = "SELECT COUNT(*) as total FROM orders WHERE issued<2";
  if ($result = $mysqli->query($query)) {
    $objectname = $result->fetch_object();
    $ordertotal = $objectname->total;
  }

  ?>
 
           <div class="col-lg-6 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3><?php echo $ordertotal ?></h3>

                <h5>Pending Orders</h5>
              </div>
              <div class="icon">
                <i class="fas fa-shipping-fast"></i>
              </div>
              <a href="manageorders.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>  

<?php } ?> <!-- ----------------------------------------------------------------------- -->

<?php $permissions = array("admin");
if (in_array($_SESSION['usertype'], $permissions)){ ?>
 
           <div class="col-lg-6 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3>..</h3>

                <h5>Admin</h5>
              </div>
              <div class="icon">
                <i class="fas fa-user-shield"></i>
              </div>
              <a href="index_admin.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>  

<?php } ?> <!-- ----------------------------------------------------------------------- -->

<?php $permissions = array("admin");
if (in_array($_SESSION['usertype'], $permissions)){ ?>
 
           <div class="col-lg-6 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3>..</h3>

                <h5>Order Management</h5>
              </div>
              <div class="icon">
                <i class="fas fa-dolly-flatbed"></i>
              </div>
              <a href="index_order.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>  

<?php } ?> <!-- ----------------------------------------------------------------------- -->

<?php $permissions = array("admin");
if (in_array($_SESSION['usertype'], $permissions)){ ?>
 
           <div class="col-lg-6 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3>..</h3>

                <h5>Services</h5>
              </div>
              <div class="icon">
                <i class="fas fa-tools"></i>
              </div>
              <a href="index_services.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>  

<?php } ?> <!-- ----------------------------------------------------------------------- -->

<?php $permissions = array("admin");
if (in_array($_SESSION['usertype'], $permissions)){ ?>
 
           <div class="col-lg-6 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3>..</h3>

                <h5>Job Reports</h5>
              </div>
              <div class="icon">
                <i class="fas fa-newspaper"></i>
              </div>
              <a href="completejobreport.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>  

<?php } ?> <!-- ----------------------------------------------------------------------- -->


<?php $permissions = array("admin");
if (in_array($_SESSION['usertype'], $permissions)){ ?>
 
           <div class="col-lg-6 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3>..</h3>

                <h5>Inventory</h5>
              </div>
              <div class="icon">
                <i class="fas fa-dolly-flatbed"></i>
              </div>
              <a href="index_inventory.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>  

<?php } ?> <!-- ----------------------------------------------------------------------- -->

<?php } else { ?>






      	
<?php $permissions = array("admin");
if (in_array($_SESSION['usertype'], $permissions)){ ?>
 
           <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3>..</h3>

                <h5>Reports</h5>
              </div>
              <div class="icon">
                <i class="fas fa-dolly-flatbed"></i>
              </div>
              <a href="addinventory.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>  

<?php } ?> <!-- ----------------------------------------------------------------------- -->

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

<?php $permissions = array("dealer", "shop", "salesrep");
if (in_array($_SESSION['usertype'], $permissions)){ ?>
 
           <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3>..</h3>

                <h5>&nbsp;Order &nbsp;&nbsp;Products</h5>
              </div>
              <div class="icon">
                <i class="fas fa-calendar-plus"></i>
              </div>
              <a href="addorder.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>  

<?php } ?> <!-- ----------------------------------------------------------------------- -->

<?php $permissions = array("admin", "dealer", "shop", "salesrep");
if (in_array($_SESSION['usertype'], $permissions)){ ?>
 
           <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3>..</h3>

                <h5>&nbsp;Manage &nbsp;Orders</h5>
              </div>
              <div class="icon">
                <i class="fas fa-people-carry"></i>
              </div>
              <a href="manageorders.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
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

<?php $permissions = array("admin", "dealer", "shop", "salesrep");
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

<?php $permissions = array("admin", "salesrep");
if (in_array($_SESSION['usertype'], $permissions)){ ?>
 
           <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3>..</h3>

                <h5>Non-Approved Job Report</h5>
              </div>
              <div class="icon">
                <i class="fas fa-file"></i>
              </div>
              <a href="nonapprovedjobsreport.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>  

<?php } ?> <!-- ----------------------------------------------------------------------- -->

<?php $permissions = array("admin", "salesrep");
if (in_array($_SESSION['usertype'], $permissions)){ ?>
 
           <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3>..</h3>

                <h5>Pending Jobs Report</h5>
              </div>
              <div class="icon">
                <i class="fas fa-file"></i>
              </div>
              <a href="pendingjobsreport.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>  

<?php } ?> <!-- ----------------------------------------------------------------------- -->

<?php $permissions = array("admin", "salesrep");
if (in_array($_SESSION['usertype'], $permissions)){ ?>
 
           <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3>..</h3>

                <h5>Completed Job Report</h5>
              </div>
              <div class="icon">
                <i class="fas fa-file"></i>
              </div>
              <a href="completedjobsreport.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>  

<?php } ?> <!-- ----------------------------------------------------------------------- -->

<?php }  ?>

          <!-- ./col -->

           <div class="col-12 text-center text-primary" id="clockdiv">
          </div>  

<!--            <div class="alert alert-primary" id="clockdiv">
          </div>   -->

        </div>


<script type="text/javascript">

   $(document).ready(function () {
    startTime();

      function startTime() {

        var days = ['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'];
        var months = ['January','February','March','April','May','June','July','August','September','October','November','December'];

        var today = new Date();
        var h = today.getHours();
        var m = today.getMinutes();
        var s = today.getSeconds();
        var daynumber = today.getDate();
        var day = days[ today.getDay() ];
        var month = months[ today.getMonth() ];
        var year = today.getFullYear();
        m = checkTime(m);
        s = checkTime(s);
        daynumber = checkTime(daynumber);
        document.getElementById('clockdiv').innerHTML ="<h4>"+ day + ", " + daynumber + " " + month + " " + year + " "+ 
        h + ":" + m + ":" + s + "</h4>";
        var t = setTimeout(startTime, 500);
      }
      function checkTime(i) {
        if (i < 10) {i = "0" + i};  // add zero in front of numbers < 10
        return i;
      }

});

</script>

<?php require_once "common/footer.php" ?>