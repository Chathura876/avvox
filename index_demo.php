<?php require_once "common/header.php" ?>
<?php require_once "common/nav.php" ?>

  <link rel="stylesheet" href="css/all.min.css">

  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
<!--   <link rel="stylesheet" href="css/adminlte.min.css"> -->
  <link rel="stylesheet" href="css/adminlte2.min.css">

<link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">


<script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.3/dist/Chart.min.js"></script>

<script src="scripts/utils.js"></script>

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

<div class='col-12 col-lg-8'> <!-- main div for all charts section -->

<div class="row"> <!-- START NESTED ROW FOR BAR, COLUMN CHARTS -->
<div class='col-12 col-lg-6'>

<canvas id="myChart" width="100%"></canvas>
<script>
var ctx = document.getElementById('myChart').getContext('2d');
var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
        datasets: [{
            label: '# of Votes',
            data: [12, 19, 3, 5, 2, 3],
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)'
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        }
    }
});
</script>

</div>



<div class='col-12 col-lg-6'>


	<div style="width:100%;">
		<canvas id="canvas"></canvas>
	</div>
	<br>
	<br>

	<script>
		var MONTHS = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
		var config = {
			type: 'line',
			data: {
				labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
				datasets: [{
					label: 'Sec A',
					//lineTension: 0, to remove curvness of individual elements
					backgroundColor: window.chartColors.red,
					borderColor: window.chartColors.red,
					data: [
						randomScalingFactor(),
						randomScalingFactor(),
						randomScalingFactor(),
						randomScalingFactor(),
						randomScalingFactor(),
						randomScalingFactor(),
						randomScalingFactor()
					],
					fill: false,
				}, {
					label: 'Sec B',
					fill: false,
					backgroundColor: window.chartColors.blue,
					borderColor: window.chartColors.blue,
					data: [
						randomScalingFactor(),
						randomScalingFactor(),
						randomScalingFactor(),
						randomScalingFactor(),
						randomScalingFactor(),
						randomScalingFactor(),
						randomScalingFactor()
					],
				}, {
					label: 'Sec C',
					fill: false,
					backgroundColor: window.chartColors.yellow,
					borderColor: window.chartColors.yellow,
					data: [
						randomScalingFactor(),
						randomScalingFactor(),
						randomScalingFactor(),
						randomScalingFactor(),
						randomScalingFactor(),
						randomScalingFactor(),
						randomScalingFactor()
					],
				}]
			},
			options: {
			    elements: {
			        line: {
			            tension: 0
			        }
			    },				
				responsive: true,
				bezierCurve: false,
				title: {
					display: true,
					text: 'Sales by Month'
				},
				tooltips: {
					mode: 'index',
					intersect: false,
				},
				hover: {
					mode: 'nearest',
					intersect: true
				},
				scales: {
					xAxes: [{
						display: true,
						scaleLabel: {
							display: true,
							labelString: 'Month'
						}
					}],
					yAxes: [{
						display: true,
						scaleLabel: {
							display: true,
							labelString: 'Value'
						}
					}]
				}
			}
		};


			var ctx2 = document.getElementById('canvas').getContext('2d');
			window.myLine = new Chart(ctx2, config);


		document.getElementById('randomizeData').addEventListener('click', function() {
			config.data.datasets.forEach(function(dataset) {
				dataset.data = dataset.data.map(function() {
					return randomScalingFactor();
				});

			});

			window.myLine.update();
		});

		var colorNames = Object.keys(window.chartColors);
		document.getElementById('addDataset').addEventListener('click', function() {
			var colorName = colorNames[config.data.datasets.length % colorNames.length];
			var newColor = window.chartColors[colorName];
			var newDataset = {
				label: 'Dataset ' + config.data.datasets.length,
				backgroundColor: newColor,
				borderColor: newColor,
				data: [],
				fill: false
			};

			for (var index = 0; index < config.data.labels.length; ++index) {
				newDataset.data.push(randomScalingFactor());
			}

			config.data.datasets.push(newDataset);
			window.myLine.update();
		});

		document.getElementById('addData').addEventListener('click', function() {
			if (config.data.datasets.length > 0) {
				var month = MONTHS[config.data.labels.length % MONTHS.length];
				config.data.labels.push(month);

				config.data.datasets.forEach(function(dataset) {
					dataset.data.push(randomScalingFactor());
				});

				window.myLine.update();
			}
		});

		document.getElementById('removeDataset').addEventListener('click', function() {
			config.data.datasets.splice(0, 1);
			window.myLine.update();
		});

		document.getElementById('removeData').addEventListener('click', function() {
			config.data.labels.splice(-1, 1); // remove the label first

			config.data.datasets.forEach(function(dataset) {
				dataset.data.pop();
			});

			window.myLine.update();
		});
	</script>
</div>

</div> <!-- END NESTED ROW FOR BAR, COLUMN CHARTS -->


<!-- -------------------------------------------------------------------------------------------------------------- -->
<div class="row"> <!-- START NESTED ROW FOR TWO PIE DOUGNUT CHARTS -->
<div class='col-12 col-lg-6 mb-5'>

	<div id="canvas-holder" style="width:100%">
		<canvas id="chart-area"></canvas>
	</div>
	<script>
		var randomScalingFactor = function() {
			return Math.round(Math.random() * 100);
		};

		var config = {
			type: 'doughnut',
			data: {
				datasets: [{
					data: [
						randomScalingFactor(),
						randomScalingFactor(),
						randomScalingFactor(),
					],
					backgroundColor: [
						window.chartColors.red,
						window.chartColors.orange,
						window.chartColors.green,
					],
					label: 'Dataset 1'
				}],
				labels: [
					'Pending',
					'Non- Approved',
					'Completed'
				]
			},
			options: {
				responsive: true,
				legend: {
					position: 'top',
				},
				title: {
					display: true,
					text: 'Job Summary'
				},
				animation: {
					animateScale: true,
					animateRotate: true
				}
			}
		};


		var ctx3 = document.getElementById('chart-area').getContext('2d');
		window.myDoughnut = new Chart(ctx3, config);

		document.getElementById('randomizeData').addEventListener('click', function() {
			config.data.datasets.forEach(function(dataset) {
				dataset.data = dataset.data.map(function() {
					return randomScalingFactor();
				});
			});

			window.myDoughnut.update();
		});

		var colorNames = Object.keys(window.chartColors);
		document.getElementById('addDataset').addEventListener('click', function() {
			var newDataset = {
				backgroundColor: [],
				data: [],
				label: 'New dataset ' + config.data.datasets.length,
			};

			for (var index = 0; index < config.data.labels.length; ++index) {
				newDataset.data.push(randomScalingFactor());

				var colorName = colorNames[index % colorNames.length];
				var newColor = window.chartColors[colorName];
				newDataset.backgroundColor.push(newColor);
			}

			config.data.datasets.push(newDataset);
			window.myDoughnut.update();
		});

		document.getElementById('addData').addEventListener('click', function() {
			if (config.data.datasets.length > 0) {
				config.data.labels.push('data #' + config.data.labels.length);

				var colorName = colorNames[config.data.datasets[0].data.length % colorNames.length];
				var newColor = window.chartColors[colorName];

				config.data.datasets.forEach(function(dataset) {
					dataset.data.push(randomScalingFactor());
					dataset.backgroundColor.push(newColor);
				});

				window.myDoughnut.update();
			}
		});

		document.getElementById('removeDataset').addEventListener('click', function() {
			config.data.datasets.splice(0, 1);
			window.myDoughnut.update();
		});

		document.getElementById('removeData').addEventListener('click', function() {
			config.data.labels.splice(-1, 1); // remove the label first

			config.data.datasets.forEach(function(dataset) {
				dataset.data.pop();
				dataset.backgroundColor.pop();
			});

			window.myDoughnut.update();
		});

		document.getElementById('changeCircleSize').addEventListener('click', function() {
			if (window.myDoughnut.options.circumference === Math.PI) {
				window.myDoughnut.options.circumference = 2 * Math.PI;
				window.myDoughnut.options.rotation = -Math.PI / 2;
			} else {
				window.myDoughnut.options.circumference = Math.PI;
				window.myDoughnut.options.rotation = -Math.PI;
			}

			window.myDoughnut.update();
		});
	</script>

</div>

<!-- ---------------------------------------------------------------------- -->


<div class='col-12 col-md-6'>

	<div id="canvas-holder" style="width:100%">
		<canvas id="pieChart"></canvas>
	</div>
	<script>
		var randomScalingFactor = function() {
			return Math.round(Math.random() * 100);
		};

		var config = {
			type: 'pie',
			data: {
				datasets: [{
					data: [
						randomScalingFactor(),
						randomScalingFactor(),
						randomScalingFactor(),
						randomScalingFactor(),
					],
					backgroundColor: [
						window.chartColors.red,
						window.chartColors.orange,
						window.chartColors.yellow,
						window.chartColors.green,
					],
					label: 'Dataset 1'
				}],
				labels: [
					'Pending',
					'Approved',
					'Issued',
					'Completed'
				]
			},
			options: {
				responsive: true,
				legend: {
					position: 'top',
				},
				title: {
					display: true,
					text: 'Order Summary'
				},
				animation: {
					animateScale: true,
					animateRotate: true
				}
			}
		};


		var ctx4 = document.getElementById('pieChart').getContext('2d');
		window.myDoughnut = new Chart(ctx4, config);

		document.getElementById('randomizeData').addEventListener('click', function() {
			config.data.datasets.forEach(function(dataset) {
				dataset.data = dataset.data.map(function() {
					return randomScalingFactor();
				});
			});

			window.myDoughnut.update();
		});

		var colorNames = Object.keys(window.chartColors);
		document.getElementById('addDataset').addEventListener('click', function() {
			var newDataset = {
				backgroundColor: [],
				data: [],
				label: 'New dataset ' + config.data.datasets.length,
			};

			for (var index = 0; index < config.data.labels.length; ++index) {
				newDataset.data.push(randomScalingFactor());

				var colorName = colorNames[index % colorNames.length];
				var newColor = window.chartColors[colorName];
				newDataset.backgroundColor.push(newColor);
			}

			config.data.datasets.push(newDataset);
			window.myDoughnut.update();
		});

		document.getElementById('addData').addEventListener('click', function() {
			if (config.data.datasets.length > 0) {
				config.data.labels.push('data #' + config.data.labels.length);

				var colorName = colorNames[config.data.datasets[0].data.length % colorNames.length];
				var newColor = window.chartColors[colorName];

				config.data.datasets.forEach(function(dataset) {
					dataset.data.push(randomScalingFactor());
					dataset.backgroundColor.push(newColor);
				});

				window.myDoughnut.update();
			}
		});

		document.getElementById('removeDataset').addEventListener('click', function() {
			config.data.datasets.splice(0, 1);
			window.myDoughnut.update();
		});

		document.getElementById('removeData').addEventListener('click', function() {
			config.data.labels.splice(-1, 1); // remove the label first

			config.data.datasets.forEach(function(dataset) {
				dataset.data.pop();
				dataset.backgroundColor.pop();
			});

			window.myDoughnut.update();
		});

		document.getElementById('changeCircleSize').addEventListener('click', function() {
			if (window.myDoughnut.options.circumference === Math.PI) {
				window.myDoughnut.options.circumference = 2 * Math.PI;
				window.myDoughnut.options.rotation = -Math.PI / 2;
			} else {
				window.myDoughnut.options.circumference = Math.PI;
				window.myDoughnut.options.rotation = -Math.PI;
			}

			window.myDoughnut.update();
		});
	</script>

</div>

</div> <!-- END NESTED ROW FOR TWO PIE DOUGNUT CHARTS -->


</div> <!-- END main div for all charts section -->

<div class='col-12 col-lg-4'> <!-- START main div for all widgets -->

<br>

<div class="col-12 mb-4">
	<a href='index.php'><button type="button" class="btn btn-block btn-warning bg-maroon btn-lg">Pending Orders</button></a>
 
</div>

<div class="col-12 mb-4">
	<a href='index.php'><button type="button" class="btn btn-block btn-success btn-lg">Pending Jobs</button></a>
 
</div>

<div class="col-12 mb-4">
	<a href='index.php'><button type="button" class="btn btn-block btn-danger btn-lg">Inventory Report</button></a>
 
</div>

<div class="col-12 mb-4">
	<a href='index.php'><button type="button" class="btn btn-block btn-primary btn-lg">Sales Report</button></a>
 
</div>

<div class="col-12 mb-4">
	<a href='index.php'><button type="button" class="btn btn-block btn-warning bg-orange btn-lg">Staff Attendence</button></a>
 
</div>





</div> <!-- END main div for all WIDGETS  -->



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