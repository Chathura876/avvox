<?php require_once "common/header.php" ?>
<?php require_once "common/nav.php" ?>

<link rel="stylesheet" href="css/all.min.css">

<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
<!-- Theme style -->
<link rel="stylesheet" href="css/adminlte.min.css">
<link rel="stylesheet" href="css/adminlte2.min.css">

<link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">

<style>
  .icon1:hover {
    transform: scale(1.5);
    filter: invert(0.5) sepia(1);
  }

  @media only screen and (max-width: 600px) {
    .dou {
      height: auto !important;
    }

    #canvas1 {
      height="90%";
    }
  }
</style>

<script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.3/dist/Chart.min.js"></script>

<script src="scripts/utils.js"></script>


<!--<div class='col-12 mb-2 text-center text-primary'>-->
<?php $permissions = array("dealer", "shop");
if (in_array($_SESSION['usertype'], $permissions)) { ?>
  <!--<h4> Hello <?php echo $_SESSION['shopname'] ?>, Welecome To Avvox CRM!</h4>-->
<?php } else { ?>
  <!--<h4> Hello <?php echo $_SESSION['fullname'] ?>, Welecome To Avvox CRM!</h4>-->


<?php } ?>
<!--</div>-->


<?php if (($_SESSION['usertype'] == "admin") ||
    ($_SESSION['usertype'] == "accountant") ||
 ($_SESSION['usertype'] == "director") ||
    ($_SESSION['usertype'] == "operator")
    || ($_SESSION['usertype'] == "salesrep")) { ?>

  <?php $permissions = array("admin", "accountant", "director","operator","salesrep");
  if (in_array($_SESSION['usertype'], $permissions)) {

    $jobtotal = "";
    $query = "SELECT COUNT(*) as total FROM job WHERE status=1";
    if ($result = $mysqli->query($query)) {
      $objectname = $result->fetch_object();
      $jobtotal = $objectname->total;
    }
  ?>

    <div class="container-fluid">
      <div class="row pt-2">
        <div class="col-lg-3 col-sm-12 col-xs-12 col-12">
          <!-- small box -->
          <div class="small-box bg-info">
            <?php
            $labelstring2 = '';
            $datastring2 = '';
            for ($i = 0; $i > -1; $i--) {
              //echo date(', F Y', strtotime("-$i month"));
              $labelstring2 .= '\'' . date('Y F', strtotime("-$i month")) . '\',';

              $startdate2 = date('Y-m-', strtotime("-$i month")) . '01 00:00:00';
              $enddate2 = date('Y-m-t', strtotime("-$i month")) . ' 23:59:59';
              $datastring2 .= gettotalsales($startdate2, $enddate2, 1) . ' ,';
            }
            $labelstring2 = rtrim($labelstring2, ',');
            $datastring2 = rtrim($datastring2, ' ,');
            $datastring2 = number_format($datastring2, 2);
            ?>
            <div class="inner">
              <h3><?php echo $datastring2 ?></h3>

              <h5>Total Sales</h5>
            </div>
            <div class="icon">
              <i class="fas fa-coins"></i>
            </div>
            <a class="small-box-footer"></a>
          </div>
        </div>

        <div class="col-lg-3 col-sm-12 col-xs-12 col-12">
          <!-- small box -->
          <div class="small-box bg-warning">
            <?php
            $labelstring2 = '';
            $datastring2 = '';
            $datastring2 .= getpendingordersales(1) . ' ,';

            $labelstring2 = rtrim($labelstring2, ',');
            $datastring2 = rtrim($datastring2, ' ,');
            $datastring2 = number_format($datastring2, 2);
            ?>
            <div class="inner">
              <h3><?php echo $datastring2 ?></h3>

              <h5>Pending Orders</h5>
            </div>
            <div class="icon">
              <i class="fas fa-coins"></i>
            </div>
            <a class="small-box-footer"></a>
          </div>
        </div>

        <div class="col-lg-3 col-sm-12 col-xs-12 col-12">
          <!-- small box -->
          <div class="small-box bg-danger">
            <?php
            $query30 = "SELECT COUNT(id) AS jobcount FROM job WHERE status=1";

            if ($result = $mysqli->query($query30)) {
              if ($job = $result->fetch_object()) {
                $data = $job->jobcount;
              } else {
                return false;
              }
            }
            ?>
            <div class="inner">
              <h3><?php echo $data ?></h3>

              <h5>Pending Jobs</h5>
            </div>
            <div class="icon">
              <i class="fas fa-hourglass-half"></i>
            </div>
            <a class="small-box-footer"></a>
          </div>
        </div>

        <div class="col-lg-3 col-sm-12 col-xs-12 col-12">
          <!-- small box -->
          <div class="small-box bg-success">
            <?php
            $query30 = "SELECT COUNT(id) AS jobcount FROM job WHERE (timecompleted between  DATE_FORMAT(NOW() ,'%Y-%m-01') AND NOW() ) AND status=2";

            if ($result = $mysqli->query($query30)) {
              if ($job = $result->fetch_object()) {
                $data = $job->jobcount;
              } else {
                return false;
              }
            }
            ?>
            <div class="inner">
              <h3><?php echo $data ?></h3>

              <h5>Completed Jobs</h5>
            </div>
            <div class="icon">
              <i class="far fa-check-circle"></i>
            </div>
            <a class="small-box-footer"></a>
          </div>
        </div>
      </div>


      <div class="row">
        <div class='col-12 col-md-9 pt-4 pr-4'>
          <!-- main div for all charts section -->

          <div class="row">
            <!-- START NESTED ROW FOR BAR, COLUMN CHARTS -->
            <div class='col-12 col-lg-6'>


              <!-- START FIRST CHART  --------------------------------------------------------------------------------------------->
              <div class="card shadow" style="width:100%;">
                <canvas id="canvas1" width="100%" height="80%" class="mob"></canvas>
              </div>
              <br>
              <br>

              <?php
              $labelstring1 = '';
              $datastringsec1 = '';
              $datastringsec2 = '';
              $datastringsec3 = '';
              $datastringsec4 = '';

              for ($i = 5; $i > -1; $i--) {
                //echo date(', F Y', strtotime("-$i month"));
                $labelstring1 .= '\'' . date('Y F', strtotime("-$i month")) . '\',';

                $startdate1 = date('Y-m-', strtotime("-$i month")) . '01 00:00:00';
                $enddate1 = date('Y-m-t', strtotime("-$i month")) . ' 23:59:59';
                // $datastringsec1 .= gettotalsalesbysection($startdate1, $enddate1, 1, -1).' ,';
                // $datastringsec2 .= gettotalsalesbysection($startdate1, $enddate1, 2, -1).' ,';
                // $datastringsec3 .= gettotalsalesbysection($startdate1, $enddate1, 3, -1).' ,';
                // $datastringsec4 .= gettotalsalesbysection($startdate1, $enddate1, 4, -1).' ,';
                $datastringsec1 .= gettotalsalesbysection($startdate1, $enddate1, 1, 3) . ' ,';
                $datastringsec2 .= gettotalsalesbysection($startdate1, $enddate1, 2, 3) . ' ,';
                $datastringsec3 .= gettotalsalesbysection($startdate1, $enddate1, 3, 3) . ' ,';
                $datastringsec4 .= gettotalsalesbysection($startdate1, $enddate1, 4, 3) . ' ,';
              }
              $labelstring1 = rtrim($labelstring1, ',');
              $datastringsec1 = rtrim($datastringsec1, ' ,');
              $datastringsec2 = rtrim($datastringsec2, ' ,');
              $datastringsec3 = rtrim($datastringsec3, ' ,');
              $datastringsec4 = rtrim($datastringsec4, ' ,');

              ?>

              <script>
                var MONTHS = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
                var config = {
                  type: 'line',
                  data: {
                    labels: [<?php echo $labelstring1 ?>],
                    datasets: [{
                      label: 'DR',
                      //lineTension: 0, to remove curvness of individual elements
                      backgroundColor: window.chartColors.red,
                      borderColor: window.chartColors.red,
                      data: [<?php echo $datastringsec1 ?>],
                      fill: false,
                    }, {
                      label: 'SK',
                      fill: false,
                      backgroundColor: window.chartColors.blue,
                      borderColor: window.chartColors.blue,
                      data: [<?php echo $datastringsec2 ?>],
                    }, {
                      label: 'COP',
                      fill: false,
                      backgroundColor: window.chartColors.yellow,
                      borderColor: window.chartColors.yellow,
                      data: [<?php echo $datastringsec3 ?>],
                    }, {
                      label: 'DZ',
                      fill: false,
                      backgroundColor: window.chartColors.green,
                      borderColor: window.chartColors.green,
                      data: [<?php echo $datastringsec4 ?>],
                    }]
                  },
                  options: {
                    elements: {
                      line: {
                        tension: 0.4
                      }
                    },
                    responsive: true,
                    bezierCurve: false,
                    title: {
                      display: true,
                      text: 'Sales by Section',
                      fontSize: 15
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


                var ctx2 = document.getElementById('canvas1').getContext('2d');
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

            <!-- END FIRST CHART---------------------------------------------------------------------------------------------

START SECOND CHART -->

            <div class='col-12 col-lg-6'>

              <div class="card shadow" style="width:100%;">
                <canvas id="canvas" width="100%" height="80%" class="mob"></canvas>
              </div>
              <br>
              <br>

              <script>
                var MONTHS = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];




                <?php
                $labelstring2 = '';
                $datastring2 = '';
                for ($i = 5; $i > -1; $i--) {
                  //echo date(', F Y', strtotime("-$i month"));
                  $labelstring2 .= '\'' . date('Y F', strtotime("-$i month")) . '\',';

                  $startdate2 = date('Y-m-', strtotime("-$i month")) . '01 00:00:00';
                  $enddate2 = date('Y-m-t', strtotime("-$i month")) . ' 23:59:59';
                  $datastring2 .= gettotalsales($startdate2, $enddate2, 1) . ' ,';
                }
                $labelstring2 = rtrim($labelstring2, ',');
                $datastring2 = rtrim($datastring2, ' ,');

                ?>
                var config = {
                  type: 'line',
                  data: {
                    labels: [<?php echo $labelstring2 ?>],
                    datasets: [{
                      label: 'Sec A',
                      //lineTension: 0, to remove curvness of individual elements
                      backgroundColor: window.chartColors.red,
                      borderColor: window.chartColors.red,
                      data: [<?php echo $datastring2 ?>],
                      fill: false,
                    }]
                  },
                  options: {
                    legend: {
                      display: false
                    },
                    elements: {
                      line: {
                        tension: 0.4,
                        borderCapStyle: "round",
                      }
                    },
                    responsive: true,
                    bezierCurve: false,
                    title: {
                      display: true,
                      text: 'Total Sales',
                      fontSize: 15
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


          <!-- END SECOND CHART---------------------------------------------------------------------------------------------

START THIRD CHART -->

          <!-- -------------------------------------------------------------------------------------------------------------- -->
          <div class="row">
            <!-- START NESTED ROW FOR TWO PIE DOUGNUT CHARTS -->
            <div class='col-12 col-lg-6 mb-5 pt-0'>
              <div class="card shadow dou" id="canvas-holder" style="width:100%; height:340px;">
                <!--<div class="card-header text-muted text-left py-0"><h6><img class="pr-2" src="https://img.icons8.com/ios-filled/24/000000/doughnut-chart.png"/> Order Summary</h6></div>-->
                <canvas id="chart-area" width="100%" height="50%"></canvas>
              </div>
              <script>
                <?php
                $newcount = 0;
                $mediumcount = 0;
                $oldcount = 0;
                $query = "SELECT * FROM job WHERE status<2";
                if ($result = $mysqli->query($query)) {
                  while ($job = $result->fetch_object()) {
                    $currenttimestamp = time();
                    if (strtotime($job->timeadded) > $currenttimestamp - 60 * 60 * 24 * 7) {
                      $newcount++;
                    } else if (strtotime($job->timeadded) > $currenttimestamp - 60 * 60 * 24 * 14) {
                      $mediumcount++;
                    } else {
                      $oldcount++;
                    }
                  }
                }
                $datastring3 = $newcount . "," . $mediumcount . "," . $oldcount;


                ?>
                var randomScalingFactor = function() {
                  return Math.round(Math.random() * 100);
                };

                var config = {
                  type: 'doughnut',
                  data: {
                    datasets: [{
                      data: [<?php echo $datastring3 ?>],
                      backgroundColor: [
                        window.chartColors.green,
                        window.chartColors.orange,
                        window.chartColors.red,
                      ],
                      label: 'Dataset 1'
                    }],
                    labels: [
                      '< 7 days',
                      '7 -14 days',
                      '>14 days'
                    ]
                  },
                  options: {
                    responsive: true,
                    legend: {
                      position: 'top',
                    },
                    title: {
                      display: true,
                      text: 'Pending Jobs',
                      fontSize: 15
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

            <!-- END THIRD CHART---------------------------------------------------------------------------------------------

START FOURTH CHART -->


            <div class='col-12 col-md-6 pt-0'>
              <div class="card shadow dou" id="canvas-holder" style="width:100%; height:340px;">
                <!--<div class="card-header text-muted text-left py-0"><h6><img class="pr-2" src="https://img.icons8.com/ios-filled/24/000000/doughnut-chart.png"/> Pending Jobs</h6></div>-->
                <canvas id="pieChart" width="100%" height="50%"></canvas>
              </div>
              <script>
                <?php
                $datastringsec1 = '';
                $datastringsec2 = '';
                $datastringsec3 = '';
                $datastringsec4 = '';

                $datastringsec1 .= getpendingsalesbysection(1, 1) . ' ,';
                $datastringsec1 .= getpendingsalesbysection(2, 1) . ' ,';
                $datastringsec1 .= getpendingsalesbysection(3, 1) . ' ,';
                $datastringsec1 .= getpendingsalesbysection(4, 1) . ' ,';

                $datastringsec1 = rtrim($datastringsec1, ' ,');
                $datastringsec2 = rtrim($datastringsec2, ' ,');
                $datastringsec3 = rtrim($datastringsec3, ' ,');
                $datastringsec4 = rtrim($datastringsec4, ' ,');

                ?>
                var randomScalingFactor = function() {
                  return Math.round(Math.random() * 100);
                };

                var config = {
                  type: 'doughnut',
                  data: {
                    datasets: [{
                      data: [<?php echo $datastringsec1 ?>, <?php echo $datastringsec2 ?>, <?php echo $datastringsec3 ?>, <?php echo $datastringsec4 ?>],
                      backgroundColor: [
                        window.chartColors.red,
                        window.chartColors.orange,
                        window.chartColors.green,
                        window.chartColors.blue
                      ],
                      label: 'Dataset 1'
                    }],
                    labels: [
                      'DR',
                      'SK',
                      'COP',
                      'DZ',
                    ]
                  },
                  options: {
                    responsive: true,
                    legend: {
                      position: 'top',
                    },
                    title: {
                      display: true,
                      text: 'Pending Orders By Section',
                      fontSize: 15
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

        <div class='col-12 col-md-3'>
          <!-- START main div for all widgets -->

          <br>

          <?php $permissions = array("admin","operator");
          if (in_array($_SESSION['usertype'], $permissions)) { ?>
            <div class="col-12 mb-2">
              <a href='addjob.php'><button type="button" class="btn btn-block btn-warning bg-maroon btn-lg text-left">
                  <svg class="icon1 mr-2" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="32" height="32" viewBox="0 0 172 172" style=" fill:#000000;">
                    <g fill="none" fill-rule="nonzero" stroke="none" stroke-width="1" stroke-linecap="butt" stroke-linejoin="miter" stroke-miterlimit="10" stroke-dasharray="" stroke-dashoffset="0" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode: normal">
                      <path d="M0,172v-172h172v172z" fill="none"></path>
                      <g fill="#ffffff">
                        <path d="M18.8125,16.125c-4.44512,0 -8.0625,3.61737 -8.0625,8.0625v123.625c0,4.44513 3.61738,8.0625 8.0625,8.0625h129c4.44513,0 8.0625,-3.61737 8.0625,-8.0625v-123.625c0,-4.44513 -3.61737,-8.0625 -8.0625,-8.0625zM18.8125,21.5h129c1.48081,0 2.6875,1.20669 2.6875,2.6875v123.625c0,1.48081 -1.20669,2.6875 -2.6875,2.6875h-129c-1.48081,0 -2.6875,-1.20669 -2.6875,-2.6875v-123.625c0,-1.48081 1.20669,-2.6875 2.6875,-2.6875zM32.25,32.25c-2.96431,0 -5.375,2.41069 -5.375,5.375v96.75c0,2.96431 2.41069,5.375 5.375,5.375h13.4375c1.4835,0 2.6875,-1.204 2.6875,-2.6875c0,-1.4835 -1.204,-2.6875 -2.6875,-2.6875h-13.4375v-96.75h102.125v96.75h-13.4375c-1.4835,0 -2.6875,1.204 -2.6875,2.6875c0,1.4835 1.204,2.6875 2.6875,2.6875h13.4375c2.96431,0 5.375,-2.41069 5.375,-5.375v-96.75c0,-2.96431 -2.41069,-5.375 -5.375,-5.375zM77.9375,48.375c-1.4835,0 -2.6875,1.204 -2.6875,2.6875v24.1875h-24.1875c-1.4835,0 -2.6875,1.204 -2.6875,2.6875v10.75c0,1.4835 1.204,2.6875 2.6875,2.6875h24.1875v24.1875c0,1.4835 1.204,2.6875 2.6875,2.6875h10.75c1.4835,0 2.6875,-1.204 2.6875,-2.6875v-24.1875h24.1875c1.4835,0 2.6875,-1.204 2.6875,-2.6875v-10.75c0,-1.4835 -1.204,-2.6875 -2.6875,-2.6875h-24.1875v-24.1875c0,-1.4835 -1.204,-2.6875 -2.6875,-2.6875zM80.625,53.75h5.375v24.1875c0,1.4835 1.204,2.6875 2.6875,2.6875h24.1875v5.375h-24.1875c-1.4835,0 -2.6875,1.204 -2.6875,2.6875v24.1875h-5.375v-24.1875c0,-1.4835 -1.204,-2.6875 -2.6875,-2.6875h-24.1875v-5.375h24.1875c1.4835,0 2.6875,-1.204 2.6875,-2.6875zM56.4375,131.6875c-1.4835,0 -2.6875,1.204 -2.6875,2.6875v5.375c0,1.4835 1.204,2.6875 2.6875,2.6875c1.4835,0 2.6875,-1.204 2.6875,-2.6875v-5.375c0,-1.4835 -1.204,-2.6875 -2.6875,-2.6875zM69.875,131.6875c-1.4835,0 -2.6875,1.204 -2.6875,2.6875v5.375c0,1.4835 1.204,2.6875 2.6875,2.6875c1.4835,0 2.6875,-1.204 2.6875,-2.6875v-5.375c0,-1.4835 -1.204,-2.6875 -2.6875,-2.6875zM83.3125,131.6875c-1.4835,0 -2.6875,1.204 -2.6875,2.6875v5.375c0,1.4835 1.204,2.6875 2.6875,2.6875c1.4835,0 2.6875,-1.204 2.6875,-2.6875v-5.375c0,-1.4835 -1.204,-2.6875 -2.6875,-2.6875zM96.75,131.6875c-1.4835,0 -2.6875,1.204 -2.6875,2.6875v5.375c0,1.4835 1.204,2.6875 2.6875,2.6875c1.4835,0 2.6875,-1.204 2.6875,-2.6875v-5.375c0,-1.4835 -1.204,-2.6875 -2.6875,-2.6875zM110.1875,131.6875c-1.4835,0 -2.6875,1.204 -2.6875,2.6875v5.375c0,1.4835 1.204,2.6875 2.6875,2.6875c1.4835,0 2.6875,-1.204 2.6875,-2.6875v-5.375c0,-1.4835 -1.204,-2.6875 -2.6875,-2.6875z"></path>
                      </g>
                    </g>
                  </svg> Add New Job</button></a>

            </div>
          <?php  } ?>


          <div class="col-12 mb-2">
            <a href='pendingjobs.php'><button type="button" class="btn btn-block btn-success btn-lg text-left">
                <svg class="icon1 mr-2" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="32" height="32" viewBox="0 0 172 172" style=" fill:#000000;">
                  <g fill="none" fill-rule="nonzero" stroke="none" stroke-width="1" stroke-linecap="butt" stroke-linejoin="miter" stroke-miterlimit="10" stroke-dasharray="" stroke-dashoffset="0" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode: normal">
                    <path d="M0,172v-172h172v172z" fill="none"></path>
                    <g fill="#ffffff">
                      <path d="M32.25,10.75c-4.44067,0 -8.0625,3.62183 -8.0625,8.0625c0,4.44067 3.62183,8.0625 8.0625,8.0625h8.68189l6.29883,23.86206c2.70849,10.29859 9.23828,18.95947 18.39258,24.38696l5.62695,3.33838c0.80835,0.48291 1.31226,1.36474 1.31226,2.30957v10.30908c0,0.93433 -0.47241,1.78467 -1.25977,2.27808l-6.38281,3.98926c-8.70288,5.43799 -14.94922,13.88892 -17.59473,23.79907l-6.38281,23.97754h-8.69238c-4.44067,0 -8.0625,3.62183 -8.0625,8.0625c0,4.44067 3.62183,8.0625 8.0625,8.0625h112.875c4.44067,0 8.0625,-3.62183 8.0625,-8.0625c0,-4.44067 -3.62183,-8.0625 -8.0625,-8.0625h-8.68189l-6.36182,-24.00903c-2.66651,-10.03613 -9.00733,-18.56055 -17.86768,-23.99853l-6.12036,-3.7688c-0.78735,-0.48291 -1.28076,-1.36474 -1.28076,-2.28857v-9.86816c0,-0.93433 0.49341,-1.81616 1.30176,-2.29907l5.83691,-3.52734c9.01782,-5.44849 15.47412,-14.07788 18.14063,-24.27148l6.35132,-24.21899h8.68189c4.44067,0 8.0625,-3.62183 8.0625,-8.0625c0,-4.44067 -3.62183,-8.0625 -8.0625,-8.0625zM32.25,16.125h112.875c1.48022,0 2.6875,1.20728 2.6875,2.6875c0,1.48022 -1.20728,2.6875 -2.6875,2.6875h-112.875c-1.48022,0 -2.6875,-1.20728 -2.6875,-2.6875c0,-1.48022 1.20728,-2.6875 2.6875,-2.6875zM46.48535,26.875h84.4043l-5.99439,22.84375c-2.30957,8.84985 -7.90503,16.31397 -15.72607,21.03809l-5.83691,3.52734c-2.40405,1.45923 -3.89478,4.10474 -3.89478,6.90772v0.94482c-7.07568,1.53272 -14.42432,1.53272 -21.5,0v-1.36474c0,-2.83447 -1.51172,-5.49048 -3.94727,-6.93921l-5.62695,-3.32788c-7.92603,-4.71362 -13.59497,-12.21973 -15.94653,-21.13257l-3.08642,-11.74732h50.10718c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875h-51.0625c-0.15747,0 -0.29395,0.06299 -0.45142,0.08398zM110.1875,32.25c-1.48022,0 -2.6875,1.19678 -2.6875,2.6875c0,1.49072 1.20728,2.6875 2.6875,2.6875h10.75c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875zM77.9375,87.64819c3.54834,0.68238 7.14917,1.03931 10.75,1.03931c3.60083,0 7.20166,-0.35693 10.75,-1.03931v3.41187c0,2.78198 1.46973,5.40649 3.84229,6.86572l6.12036,3.7688c7.67407,4.71362 13.17505,12.10425 15.48462,20.79663l2.01563,7.60059c-0.34643,0.45142 -0.58789,0.98682 -0.58789,1.5957v5.375c0,1.49072 1.20728,2.6875 2.6875,2.6875c0.15747,0 0.28345,-0.06299 0.43042,-0.08398l1.44873,5.45898h-84.3833l1.45923,-5.45898c0.14697,0.021 0.27295,0.08398 0.41992,0.08398c1.48022,0 2.6875,-1.19678 2.6875,-2.6875v-5.375c0,-0.59839 -0.23096,-1.12329 -0.5564,-1.56421l2.01563,-7.59009c2.28857,-8.5874 7.70557,-15.91504 15.24316,-20.61816l6.38281,-3.98926c2.37256,-1.49072 3.78979,-4.04175 3.78979,-6.84473zM61.8125,129c-1.48022,0 -2.6875,1.19678 -2.6875,2.6875v5.375c0,1.49072 1.20728,2.6875 2.6875,2.6875c1.48022,0 2.6875,-1.19678 2.6875,-2.6875v-5.375c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875zM75.25,129c-1.48022,0 -2.6875,1.19678 -2.6875,2.6875v5.375c0,1.49072 1.20728,2.6875 2.6875,2.6875c1.48022,0 2.6875,-1.19678 2.6875,-2.6875v-5.375c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875zM88.6875,129c-1.48022,0 -2.6875,1.19678 -2.6875,2.6875v5.375c0,1.49072 1.20728,2.6875 2.6875,2.6875c1.48022,0 2.6875,-1.19678 2.6875,-2.6875v-5.375c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875zM102.125,129c-1.48022,0 -2.6875,1.19678 -2.6875,2.6875v5.375c0,1.49072 1.20728,2.6875 2.6875,2.6875c1.48022,0 2.6875,-1.19678 2.6875,-2.6875v-5.375c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875zM115.5625,129c-1.48022,0 -2.6875,1.19678 -2.6875,2.6875v5.375c0,1.49072 1.20728,2.6875 2.6875,2.6875c1.48022,0 2.6875,-1.19678 2.6875,-2.6875v-5.375c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875zM32.25,150.5h112.875c1.48022,0 2.6875,1.20728 2.6875,2.6875c0,1.48022 -1.20728,2.6875 -2.6875,2.6875h-112.875c-1.48022,0 -2.6875,-1.20728 -2.6875,-2.6875c0,-1.48022 1.20728,-2.6875 2.6875,-2.6875z"></path>
                    </g>
                  </g>
                </svg>
                Pending Jobs</button></a>

          </div>

          <div class="col-12 mb-2">
            <a href='alljobs.php'><button type="button" class="btn btn-block btn-success bg-orange btn-lg text-left">
                <svg class="icon1 mr-2" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="32" height="32" viewBox="0 0 172 172" style=" fill:#000000;">
                  <g fill="none" fill-rule="nonzero" stroke="none" stroke-width="1" stroke-linecap="butt" stroke-linejoin="miter" stroke-miterlimit="10" stroke-dasharray="" stroke-dashoffset="0" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode: normal">
                    <path d="M0,172v-172h172v172z" fill="none"></path>
                    <g fill="#ffffff">
                      <path d="M8.0625,16.125c-4.43437,0 -8.0625,3.62813 -8.0625,8.0625v112.875c0,4.43437 3.62813,8.0625 8.0625,8.0625h109.05896l20.71789,20.72315c0.5375,0.51062 1.2119,0.77685 1.91065,0.77685c0.69875,0 1.37315,-0.26623 1.91065,-0.77685l29.5625,-29.5625c1.04812,-1.04813 1.04812,-2.77317 0,-3.82129l-10.75,-10.75c-1.04813,-1.04812 -2.77317,-1.04812 -3.82129,0l-6.15185,6.18335v-33.83521v-69.875c0,-4.43437 -3.62813,-8.0625 -8.0625,-8.0625zM8.0625,21.5h134.375c1.47813,0 2.6875,1.20937 2.6875,2.6875v67.1875h-13.4375c-1.47813,0 -2.6875,1.20938 -2.6875,2.6875v33.83521l-6.15185,-6.18335c-1.04813,-1.04812 -2.77317,-1.04812 -3.82129,0l-10.75,10.75c-1.04812,1.04813 -1.04812,2.77316 0,3.82129l3.46961,3.46435h-103.68396c-1.47812,0 -2.6875,-1.20937 -2.6875,-2.6875v-112.875c0,-1.47813 1.20938,-2.6875 2.6875,-2.6875zM29.5625,53.75c-1.4835,0 -2.6875,1.20131 -2.6875,2.6875c0,1.48619 1.204,2.6875 2.6875,2.6875h5.375c1.4835,0 2.6875,-1.20131 2.6875,-2.6875c0,-1.48619 -1.204,-2.6875 -2.6875,-2.6875zM51.0625,53.75c-1.4835,0 -2.6875,1.20131 -2.6875,2.6875c0,1.48619 1.204,2.6875 2.6875,2.6875h64.5c1.4835,0 2.6875,-1.20131 2.6875,-2.6875c0,-1.48619 -1.204,-2.6875 -2.6875,-2.6875zM29.5625,75.25c-1.4835,0 -2.6875,1.20131 -2.6875,2.6875c0,1.48619 1.204,2.6875 2.6875,2.6875h5.375c1.4835,0 2.6875,-1.20131 2.6875,-2.6875c0,-1.48619 -1.204,-2.6875 -2.6875,-2.6875zM51.0625,75.25c-1.4835,0 -2.6875,1.20131 -2.6875,2.6875c0,1.48619 1.204,2.6875 2.6875,2.6875h64.5c1.4835,0 2.6875,-1.20131 2.6875,-2.6875c0,-1.48619 -1.204,-2.6875 -2.6875,-2.6875zM29.5625,96.75c-1.4835,0 -2.6875,1.20131 -2.6875,2.6875c0,1.48619 1.204,2.6875 2.6875,2.6875h5.375c1.4835,0 2.6875,-1.20131 2.6875,-2.6875c0,-1.48619 -1.204,-2.6875 -2.6875,-2.6875zM51.0625,96.75c-1.4835,0 -2.6875,1.20131 -2.6875,2.6875c0,1.48619 1.204,2.6875 2.6875,2.6875h43c1.4835,0 2.6875,-1.20131 2.6875,-2.6875c0,-1.48619 -1.204,-2.6875 -2.6875,-2.6875zM134.375,96.75h10.75v37.625c0,1.075 0.64269,2.06917 1.66394,2.47229c0.99437,0.43 2.15483,0.19085 2.9342,-0.56164l0.77685,-0.78211l8.0625,-8.08875l6.96021,6.96021l-25.77271,25.77271l-25.77271,-25.77271l6.96021,-6.96021l8.83935,8.87085c0.77937,0.7525 1.93983,0.99164 2.9342,0.56164c1.02125,-0.40312 1.66394,-1.39729 1.66394,-2.47229zM16.125,123.625c-1.4835,0 -2.6875,1.20131 -2.6875,2.6875v5.375c0,1.48619 1.204,2.6875 2.6875,2.6875c1.4835,0 2.6875,-1.20131 2.6875,-2.6875v-5.375c0,-1.48619 -1.204,-2.6875 -2.6875,-2.6875zM29.5625,123.625c-1.4835,0 -2.6875,1.20131 -2.6875,2.6875v5.375c0,1.48619 1.204,2.6875 2.6875,2.6875c1.4835,0 2.6875,-1.20131 2.6875,-2.6875v-5.375c0,-1.48619 -1.204,-2.6875 -2.6875,-2.6875zM43,123.625c-1.4835,0 -2.6875,1.20131 -2.6875,2.6875v5.375c0,1.48619 1.204,2.6875 2.6875,2.6875c1.4835,0 2.6875,-1.20131 2.6875,-2.6875v-5.375c0,-1.48619 -1.204,-2.6875 -2.6875,-2.6875zM56.4375,123.625c-1.4835,0 -2.6875,1.20131 -2.6875,2.6875v5.375c0,1.48619 1.204,2.6875 2.6875,2.6875c1.4835,0 2.6875,-1.20131 2.6875,-2.6875v-5.375c0,-1.48619 -1.204,-2.6875 -2.6875,-2.6875zM69.875,123.625c-1.4835,0 -2.6875,1.20131 -2.6875,2.6875v5.375c0,1.48619 1.204,2.6875 2.6875,2.6875c1.4835,0 2.6875,-1.20131 2.6875,-2.6875v-5.375c0,-1.48619 -1.204,-2.6875 -2.6875,-2.6875zM83.3125,123.625c-1.4835,0 -2.6875,1.20131 -2.6875,2.6875v5.375c0,1.48619 1.204,2.6875 2.6875,2.6875c1.4835,0 2.6875,-1.20131 2.6875,-2.6875v-5.375c0,-1.48619 -1.204,-2.6875 -2.6875,-2.6875zM96.75,123.625c-1.4835,0 -2.6875,1.20131 -2.6875,2.6875v5.375c0,1.48619 1.204,2.6875 2.6875,2.6875c1.4835,0 2.6875,-1.20131 2.6875,-2.6875v-5.375c0,-1.48619 -1.204,-2.6875 -2.6875,-2.6875z"></path>
                    </g>
                  </g>
                </svg>
                View All Jobs</button></a>

          </div>

          <div class="col-12 mb-2">
            <a href='manageproducts.php'><button type="button" class="btn btn-block btn-primary btn-lg text-left">
                <svg class="icon1 mr-2" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="32" height="32" viewBox="0 0 172 172" style=" fill:#000000;">
                  <g fill="none" fill-rule="nonzero" stroke="none" stroke-width="1" stroke-linecap="butt" stroke-linejoin="miter" stroke-miterlimit="10" stroke-dasharray="" stroke-dashoffset="0" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode: normal">
                    <path d="M0,172v-172h172v172z" fill="none"></path>
                    <g fill="#ffffff">
                      <path d="M43,5.375c-2.96045,0 -5.375,2.41455 -5.375,5.375v5.375c0,2.96045 2.41455,5.375 5.375,5.375v34.9375c0,4.44067 3.62183,8.0625 8.0625,8.0625h2.6875v5.375c0,2.96045 2.41455,5.375 5.375,5.375v51.0625c0,0.94483 0.18897,1.84766 0.49341,2.6875h-16.61841c-3.11792,0 -5.83691,1.80566 -7.18066,4.40918c-1.15478,-1.82666 -1.84766,-3.92627 -2.01562,-6.18335l-5.9314,-88.1731c-0.49341,-7.42212 -5.30151,-13.62646 -11.88379,-16.20898c-0.61939,-3.82129 -3.94727,-6.71875 -7.92603,-6.71875c-4.43017,0 -8.0625,3.63233 -8.0625,8.0625c0,4.43018 3.63233,8.0625 8.0625,8.0625c2.96045,0 5.56397,-1.6167 6.96021,-3.99976c4.16772,2.06811 7.14917,6.23584 7.5061,11.14892l5.8999,88.1731c0.35693,5.19653 2.82397,9.78418 6.50879,12.95459v7.28564c0,4.43018 3.63233,8.0625 8.0625,8.0625h5.63745c-0.17847,0.86084 -0.26245,1.77417 -0.26245,2.6875c0,7.42212 6.01538,13.4375 13.4375,13.4375c7.42212,0 13.4375,-6.01538 13.4375,-13.4375c0,-0.91333 -0.08398,-1.82666 -0.26245,-2.6875h59.6499c-0.17847,0.86084 -0.26245,1.77417 -0.26245,2.6875c0,7.42212 6.01538,13.4375 13.4375,13.4375c7.42212,0 13.4375,-6.01538 13.4375,-13.4375c0,-0.91333 -0.08398,-1.82666 -0.26245,-2.6875h2.94995c4.43018,0 8.0625,-3.63232 8.0625,-8.0625v-10.75c0,-3.70581 -2.55103,-6.81323 -5.96289,-7.75806c0.36743,-0.92383 0.58789,-1.93164 0.58789,-2.99194v-51.0625c2.96045,0 5.375,-2.41455 5.375,-5.375v-5.375c0,-2.96045 -2.41455,-5.375 -5.375,-5.375h-16.61841c0.30445,-0.83984 0.49341,-1.74267 0.49341,-2.6875v-34.9375c2.96045,0 5.375,-2.41455 5.375,-5.375v-5.375c0,-2.96045 -2.41455,-5.375 -5.375,-5.375zM43,10.75h107.5v5.375h-8.0625c-1.48022,0 -2.6875,1.20728 -2.6875,2.6875c0,1.48022 1.20728,2.6875 2.6875,2.6875h2.6875v34.9375c0,1.48022 -1.20728,2.6875 -2.6875,2.6875h-91.375c-1.48022,0 -2.6875,-1.20728 -2.6875,-2.6875v-34.9375h61.8125c1.48022,0 2.6875,-1.20728 2.6875,-2.6875c0,-1.48022 -1.20728,-2.6875 -2.6875,-2.6875h-67.1875zM120.9375,16.125c-1.48022,0 -2.6875,1.20728 -2.6875,2.6875c0,1.48022 1.20728,2.6875 2.6875,2.6875h10.75c1.48022,0 2.6875,-1.20728 2.6875,-2.6875c0,-1.48022 -1.20728,-2.6875 -2.6875,-2.6875zM8.0625,21.5c1.48022,0 2.6875,1.20728 2.6875,2.6875c0,1.48022 -1.20728,2.6875 -2.6875,2.6875c-1.48022,0 -2.6875,-1.20728 -2.6875,-2.6875c0,-1.48022 1.20728,-2.6875 2.6875,-2.6875zM88.6875,26.875c-4.44067,0 -8.0625,3.62183 -8.0625,8.0625c0,4.44067 3.62183,8.0625 8.0625,8.0625h16.125c4.44067,0 8.0625,-3.62183 8.0625,-8.0625c0,-4.44067 -3.62183,-8.0625 -8.0625,-8.0625zM88.6875,32.25h16.125c1.48022,0 2.6875,1.20728 2.6875,2.6875c0,1.48022 -1.20728,2.6875 -2.6875,2.6875h-16.125c-1.48022,0 -2.6875,-1.20728 -2.6875,-2.6875c0,-1.48022 1.20728,-2.6875 2.6875,-2.6875zM59.125,64.5h107.5v5.375h-5.375v56.4375c0,1.48022 -1.20728,2.6875 -2.6875,2.6875h-91.375c-1.48022,0 -2.6875,-1.20728 -2.6875,-2.6875v-51.0625h61.8125c1.48022,0 2.6875,-1.20728 2.6875,-2.6875c0,-1.48022 -1.20728,-2.6875 -2.6875,-2.6875h-67.1875zM137.0625,69.875c-1.48022,0 -2.6875,1.20728 -2.6875,2.6875c0,1.48022 1.20728,2.6875 2.6875,2.6875h10.75c1.48022,0 2.6875,-1.20728 2.6875,-2.6875c0,-1.48022 -1.20728,-2.6875 -2.6875,-2.6875zM104.8125,80.625c-4.44067,0 -8.0625,3.62183 -8.0625,8.0625c0,4.44067 3.62183,8.0625 8.0625,8.0625h16.125c4.44067,0 8.0625,-3.62183 8.0625,-8.0625c0,-4.44067 -3.62183,-8.0625 -8.0625,-8.0625zM104.8125,86h16.125c1.48022,0 2.6875,1.20728 2.6875,2.6875c0,1.48022 -1.20728,2.6875 -2.6875,2.6875h-16.125c-1.48022,0 -2.6875,-1.20728 -2.6875,-2.6875c0,-1.48022 1.20728,-2.6875 2.6875,-2.6875zM72.5625,112.875c-1.48022,0 -2.6875,1.20728 -2.6875,2.6875v5.375c0,1.48022 1.20728,2.6875 2.6875,2.6875c1.48022,0 2.6875,-1.20728 2.6875,-2.6875v-5.375c0,-1.48022 -1.20728,-2.6875 -2.6875,-2.6875zM86,112.875c-1.48022,0 -2.6875,1.20728 -2.6875,2.6875v5.375c0,1.48022 1.20728,2.6875 2.6875,2.6875c1.48022,0 2.6875,-1.20728 2.6875,-2.6875v-5.375c0,-1.48022 -1.20728,-2.6875 -2.6875,-2.6875zM99.4375,112.875c-1.48022,0 -2.6875,1.20728 -2.6875,2.6875v5.375c0,1.48022 1.20728,2.6875 2.6875,2.6875c1.48022,0 2.6875,-1.20728 2.6875,-2.6875v-5.375c0,-1.48022 -1.20728,-2.6875 -2.6875,-2.6875zM112.875,112.875c-1.48022,0 -2.6875,1.20728 -2.6875,2.6875v5.375c0,1.48022 1.20728,2.6875 2.6875,2.6875c1.48022,0 2.6875,-1.20728 2.6875,-2.6875v-5.375c0,-1.48022 -1.20728,-2.6875 -2.6875,-2.6875zM126.3125,112.875c-1.48022,0 -2.6875,1.20728 -2.6875,2.6875v5.375c0,1.48022 1.20728,2.6875 2.6875,2.6875c1.48022,0 2.6875,-1.20728 2.6875,-2.6875v-5.375c0,-1.48022 -1.20728,-2.6875 -2.6875,-2.6875zM139.75,112.875c-1.48022,0 -2.6875,1.20728 -2.6875,2.6875v5.375c0,1.48022 1.20728,2.6875 2.6875,2.6875c1.48022,0 2.6875,-1.20728 2.6875,-2.6875v-5.375c0,-1.48022 -1.20728,-2.6875 -2.6875,-2.6875zM153.1875,112.875c-1.48022,0 -2.6875,1.20728 -2.6875,2.6875v5.375c0,1.48022 1.20728,2.6875 2.6875,2.6875c1.48022,0 2.6875,-1.20728 2.6875,-2.6875v-5.375c0,-1.48022 -1.20728,-2.6875 -2.6875,-2.6875zM43,134.375h120.9375c1.48022,0 2.6875,1.20728 2.6875,2.6875v10.75c0,1.48022 -1.20728,2.6875 -2.6875,2.6875h-5.375c-2.44604,-3.25439 -6.37232,-5.375 -10.75,-5.375c-4.37768,0 -8.30396,2.12061 -10.75,5.375h-64.5c-2.44604,-3.25439 -6.37232,-5.375 -10.75,-5.375c-4.37768,0 -8.30396,2.12061 -10.75,5.375h-8.0625c-1.48022,0 -2.6875,-1.20728 -2.6875,-2.6875v-10.75c0,-1.48022 1.20728,-2.6875 2.6875,-2.6875zM61.8125,150.5c3.49585,0 6.47729,2.25708 7.57959,5.375c0.32544,0.82935 0.48291,1.74268 0.48291,2.6875c0,4.43018 -3.63232,8.0625 -8.0625,8.0625c-4.43017,0 -8.0625,-3.63232 -8.0625,-8.0625c0,-0.94482 0.15747,-1.85815 0.48291,-2.6875c1.10229,-3.11792 4.08374,-5.375 7.57959,-5.375zM147.8125,150.5c3.49585,0 6.47729,2.25708 7.57959,5.375c0.32544,0.82935 0.48291,1.74268 0.48291,2.6875c0,4.43018 -3.63232,8.0625 -8.0625,8.0625c-4.43017,0 -8.0625,-3.63232 -8.0625,-8.0625c0,-0.94482 0.15747,-1.85815 0.48291,-2.6875c1.10229,-3.11792 4.08374,-5.375 7.57959,-5.375z"></path>
                    </g>
                  </g>
                </svg>
                Product Management</button></a>

          </div>

          <?php $permissions = array("admin");
          if (in_array($_SESSION['usertype'], $permissions)) { ?>
          <div class="col-12 mb-2">
            <a href='manageStaff.php'><button type="button" class="btn btn-block btn-danger  btn-lg text-left">
                <svg class="icon1 mr-2" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="32" height="32" viewBox="0 0 172 172" style=" fill:#000000;">
                  <g fill="none" fill-rule="nonzero" stroke="none" stroke-width="1" stroke-linecap="butt" stroke-linejoin="miter" stroke-miterlimit="10" stroke-dasharray="" stroke-dashoffset="0" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode: normal">
                    <path d="M0,172v-172h172v172z" fill="none"></path>
                    <g fill="#ffffff">
                      <path d="M16.125,26.875c-7.40944,0 -13.4375,6.02806 -13.4375,13.4375v91.375c0,7.40944 6.02806,13.4375 13.4375,13.4375h139.75c7.40944,0 13.4375,-6.02806 13.4375,-13.4375v-91.375c0,-7.40944 -6.02806,-13.4375 -13.4375,-13.4375zM16.125,32.25h139.75c4.44513,0 8.0625,3.61738 8.0625,8.0625v91.375c0,4.44513 -3.61737,8.0625 -8.0625,8.0625h-139.75c-4.44512,0 -8.0625,-3.61737 -8.0625,-8.0625v-91.375c0,-4.44512 3.61738,-8.0625 8.0625,-8.0625zM18.8125,37.625c-1.48619,0 -2.6875,1.204 -2.6875,2.6875v5.375c0,1.4835 1.20131,2.6875 2.6875,2.6875c1.48619,0 2.6875,-1.204 2.6875,-2.6875v-5.375c0,-1.4835 -1.20131,-2.6875 -2.6875,-2.6875zM32.25,37.625c-1.48619,0 -2.6875,1.204 -2.6875,2.6875v5.375c0,1.4835 1.20131,2.6875 2.6875,2.6875c1.48619,0 2.6875,-1.204 2.6875,-2.6875v-5.375c0,-1.4835 -1.20131,-2.6875 -2.6875,-2.6875zM45.6875,37.625c-1.48619,0 -2.6875,1.204 -2.6875,2.6875v5.375c0,1.4835 1.20131,2.6875 2.6875,2.6875c1.48619,0 2.6875,-1.204 2.6875,-2.6875v-5.375c0,-1.4835 -1.20131,-2.6875 -2.6875,-2.6875zM59.125,37.625c-1.48619,0 -2.6875,1.204 -2.6875,2.6875v5.375c0,1.4835 1.20131,2.6875 2.6875,2.6875c1.48619,0 2.6875,-1.204 2.6875,-2.6875v-5.375c0,-1.4835 -1.20131,-2.6875 -2.6875,-2.6875zM72.5625,37.625c-1.48619,0 -2.6875,1.204 -2.6875,2.6875v5.375c0,1.4835 1.20131,2.6875 2.6875,2.6875c1.48619,0 2.6875,-1.204 2.6875,-2.6875v-5.375c0,-1.4835 -1.20131,-2.6875 -2.6875,-2.6875zM86,37.625c-1.48619,0 -2.6875,1.204 -2.6875,2.6875v5.375c0,1.4835 1.20131,2.6875 2.6875,2.6875c1.48619,0 2.6875,-1.204 2.6875,-2.6875v-5.375c0,-1.4835 -1.20131,-2.6875 -2.6875,-2.6875zM99.4375,37.625c-1.48619,0 -2.6875,1.204 -2.6875,2.6875v5.375c0,1.4835 1.20131,2.6875 2.6875,2.6875c1.48619,0 2.6875,-1.204 2.6875,-2.6875v-5.375c0,-1.4835 -1.20131,-2.6875 -2.6875,-2.6875zM112.875,37.625c-1.48619,0 -2.6875,1.204 -2.6875,2.6875v5.375c0,1.4835 1.20131,2.6875 2.6875,2.6875c1.48619,0 2.6875,-1.204 2.6875,-2.6875v-5.375c0,-1.4835 -1.20131,-2.6875 -2.6875,-2.6875zM126.3125,37.625c-1.48619,0 -2.6875,1.204 -2.6875,2.6875v5.375c0,1.4835 1.20131,2.6875 2.6875,2.6875c1.48619,0 2.6875,-1.204 2.6875,-2.6875v-5.375c0,-1.4835 -1.20131,-2.6875 -2.6875,-2.6875zM139.75,37.625c-1.48619,0 -2.6875,1.204 -2.6875,2.6875v5.375c0,1.4835 1.20131,2.6875 2.6875,2.6875c1.48619,0 2.6875,-1.204 2.6875,-2.6875v-5.375c0,-1.4835 -1.20131,-2.6875 -2.6875,-2.6875zM153.1875,37.625c-1.48619,0 -2.6875,1.204 -2.6875,2.6875v5.375c0,1.4835 1.20131,2.6875 2.6875,2.6875c1.48619,0 2.6875,-1.204 2.6875,-2.6875v-5.375c0,-1.4835 -1.20131,-2.6875 -2.6875,-2.6875zM53.75,56.4375c-10.38987,0 -18.8125,8.42262 -18.8125,18.8125v5.375c0.08062,4.52575 1.47338,8.93514 4.005,12.68689c-8.79081,3.27337 -15.93318,9.89164 -19.8623,18.40832c-0.73369,1.29 -0.28219,2.93013 1.00781,3.66382c1.29,0.73369 2.93538,0.28219 3.66907,-1.00781c0.0645,-0.11019 0.11434,-0.22818 0.16272,-0.34643c3.60394,-7.912 10.4705,-13.86565 18.8125,-16.31397c3.00463,2.77887 6.93257,4.35005 11.02295,4.40918c4.08231,-0.06719 7.99489,-1.63837 10.99146,-4.40918c8.34469,2.44562 15.21125,8.39928 18.8125,16.31397c0.44612,0.94331 1.39805,1.54078 2.4408,1.53271c1.4835,-0.00538 2.68238,-1.2145 2.677,-2.698c0,-0.39775 -0.08789,-0.78685 -0.2572,-1.14429c-3.93719,-8.50862 -11.07687,-15.11408 -19.8623,-18.38208c2.537,-3.75981 3.92975,-8.17664 4.005,-12.71314v-5.375c0,-10.38988 -8.42262,-18.8125 -18.8125,-18.8125zM53.75,61.8125c7.42019,0 13.4375,6.01731 13.4375,13.4375v5.375c0,7.31 -5.99312,16.125 -13.4375,16.125c-7.44438,0 -13.4375,-8.815 -13.4375,-16.125v-5.375c0,-7.42019 6.01731,-13.4375 13.4375,-13.4375zM102.125,67.1875c-1.4835,0 -2.6875,1.204 -2.6875,2.6875c0,1.4835 1.204,2.6875 2.6875,2.6875h26.875c1.4835,0 2.6875,-1.204 2.6875,-2.6875c0,-1.4835 -1.204,-2.6875 -2.6875,-2.6875zM139.75,67.1875c-1.4835,0 -2.6875,1.204 -2.6875,2.6875c0,1.4835 1.204,2.6875 2.6875,2.6875h10.75c1.4835,0 2.6875,-1.204 2.6875,-2.6875c0,-1.4835 -1.204,-2.6875 -2.6875,-2.6875zM102.125,83.3125c-1.4835,0 -2.6875,1.204 -2.6875,2.6875c0,1.4835 1.204,2.6875 2.6875,2.6875h48.375c1.4835,0 2.6875,-1.204 2.6875,-2.6875c0,-1.4835 -1.204,-2.6875 -2.6875,-2.6875zM102.125,99.4375c-1.4835,0 -2.6875,1.204 -2.6875,2.6875c0,1.4835 1.204,2.6875 2.6875,2.6875h32.25c1.4835,0 2.6875,-1.204 2.6875,-2.6875c0,-1.4835 -1.204,-2.6875 -2.6875,-2.6875zM18.8125,123.625c-1.48619,0 -2.6875,1.204 -2.6875,2.6875v5.375c0,1.4835 1.20131,2.6875 2.6875,2.6875c1.48619,0 2.6875,-1.204 2.6875,-2.6875v-5.375c0,-1.4835 -1.20131,-2.6875 -2.6875,-2.6875zM32.25,123.625c-1.48619,0 -2.6875,1.204 -2.6875,2.6875v5.375c0,1.4835 1.20131,2.6875 2.6875,2.6875c1.48619,0 2.6875,-1.204 2.6875,-2.6875v-5.375c0,-1.4835 -1.20131,-2.6875 -2.6875,-2.6875zM45.6875,123.625c-1.48619,0 -2.6875,1.204 -2.6875,2.6875v5.375c0,1.4835 1.20131,2.6875 2.6875,2.6875c1.48619,0 2.6875,-1.204 2.6875,-2.6875v-5.375c0,-1.4835 -1.20131,-2.6875 -2.6875,-2.6875zM59.125,123.625c-1.48619,0 -2.6875,1.204 -2.6875,2.6875v5.375c0,1.4835 1.20131,2.6875 2.6875,2.6875c1.48619,0 2.6875,-1.204 2.6875,-2.6875v-5.375c0,-1.4835 -1.20131,-2.6875 -2.6875,-2.6875zM72.5625,123.625c-1.48619,0 -2.6875,1.204 -2.6875,2.6875v5.375c0,1.4835 1.20131,2.6875 2.6875,2.6875c1.48619,0 2.6875,-1.204 2.6875,-2.6875v-5.375c0,-1.4835 -1.20131,-2.6875 -2.6875,-2.6875zM86,123.625c-1.48619,0 -2.6875,1.204 -2.6875,2.6875v5.375c0,1.4835 1.20131,2.6875 2.6875,2.6875c1.48619,0 2.6875,-1.204 2.6875,-2.6875v-5.375c0,-1.4835 -1.20131,-2.6875 -2.6875,-2.6875zM99.4375,123.625c-1.48619,0 -2.6875,1.204 -2.6875,2.6875v5.375c0,1.4835 1.20131,2.6875 2.6875,2.6875c1.48619,0 2.6875,-1.204 2.6875,-2.6875v-5.375c0,-1.4835 -1.20131,-2.6875 -2.6875,-2.6875zM112.875,123.625c-1.48619,0 -2.6875,1.204 -2.6875,2.6875v5.375c0,1.4835 1.20131,2.6875 2.6875,2.6875c1.48619,0 2.6875,-1.204 2.6875,-2.6875v-5.375c0,-1.4835 -1.20131,-2.6875 -2.6875,-2.6875zM126.3125,123.625c-1.48619,0 -2.6875,1.204 -2.6875,2.6875v5.375c0,1.4835 1.20131,2.6875 2.6875,2.6875c1.48619,0 2.6875,-1.204 2.6875,-2.6875v-5.375c0,-1.4835 -1.20131,-2.6875 -2.6875,-2.6875zM139.75,123.625c-1.48619,0 -2.6875,1.204 -2.6875,2.6875v5.375c0,1.4835 1.20131,2.6875 2.6875,2.6875c1.48619,0 2.6875,-1.204 2.6875,-2.6875v-5.375c0,-1.4835 -1.20131,-2.6875 -2.6875,-2.6875zM153.1875,123.625c-1.48619,0 -2.6875,1.204 -2.6875,2.6875v5.375c0,1.4835 1.20131,2.6875 2.6875,2.6875c1.48619,0 2.6875,-1.204 2.6875,-2.6875v-5.375c0,-1.4835 -1.20131,-2.6875 -2.6875,-2.6875z"></path>
                    </g>
                  </g>
                </svg>
                Staff Working</button></a>

          </div>
          <?php  } ?>

          <?php $permissions = array("admin");
          if (in_array($_SESSION['usertype'], $permissions)) { ?>
          <div class="col-12 mb-2">
            <a href='managePermission.php'><button type="button" class="btn btn-block btn-danger  btn-lg text-left">
                <svg class="icon1 mr-2" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="32" height="32" viewBox="0 0 172 172" style=" fill:#000000;">
                  <g fill="none" fill-rule="nonzero" stroke="none" stroke-width="1" stroke-linecap="butt" stroke-linejoin="miter" stroke-miterlimit="10" stroke-dasharray="" stroke-dashoffset="0" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode: normal">
                    <path d="M0,172v-172h172v172z" fill="none"></path>
                    <g fill="#ffffff">
                      <path d="M16.125,26.875c-7.40944,0 -13.4375,6.02806 -13.4375,13.4375v91.375c0,7.40944 6.02806,13.4375 13.4375,13.4375h139.75c7.40944,0 13.4375,-6.02806 13.4375,-13.4375v-91.375c0,-7.40944 -6.02806,-13.4375 -13.4375,-13.4375zM16.125,32.25h139.75c4.44513,0 8.0625,3.61738 8.0625,8.0625v91.375c0,4.44513 -3.61737,8.0625 -8.0625,8.0625h-139.75c-4.44512,0 -8.0625,-3.61737 -8.0625,-8.0625v-91.375c0,-4.44512 3.61738,-8.0625 8.0625,-8.0625zM18.8125,37.625c-1.48619,0 -2.6875,1.204 -2.6875,2.6875v5.375c0,1.4835 1.20131,2.6875 2.6875,2.6875c1.48619,0 2.6875,-1.204 2.6875,-2.6875v-5.375c0,-1.4835 -1.20131,-2.6875 -2.6875,-2.6875zM32.25,37.625c-1.48619,0 -2.6875,1.204 -2.6875,2.6875v5.375c0,1.4835 1.20131,2.6875 2.6875,2.6875c1.48619,0 2.6875,-1.204 2.6875,-2.6875v-5.375c0,-1.4835 -1.20131,-2.6875 -2.6875,-2.6875zM45.6875,37.625c-1.48619,0 -2.6875,1.204 -2.6875,2.6875v5.375c0,1.4835 1.20131,2.6875 2.6875,2.6875c1.48619,0 2.6875,-1.204 2.6875,-2.6875v-5.375c0,-1.4835 -1.20131,-2.6875 -2.6875,-2.6875zM59.125,37.625c-1.48619,0 -2.6875,1.204 -2.6875,2.6875v5.375c0,1.4835 1.20131,2.6875 2.6875,2.6875c1.48619,0 2.6875,-1.204 2.6875,-2.6875v-5.375c0,-1.4835 -1.20131,-2.6875 -2.6875,-2.6875zM72.5625,37.625c-1.48619,0 -2.6875,1.204 -2.6875,2.6875v5.375c0,1.4835 1.20131,2.6875 2.6875,2.6875c1.48619,0 2.6875,-1.204 2.6875,-2.6875v-5.375c0,-1.4835 -1.20131,-2.6875 -2.6875,-2.6875zM86,37.625c-1.48619,0 -2.6875,1.204 -2.6875,2.6875v5.375c0,1.4835 1.20131,2.6875 2.6875,2.6875c1.48619,0 2.6875,-1.204 2.6875,-2.6875v-5.375c0,-1.4835 -1.20131,-2.6875 -2.6875,-2.6875zM99.4375,37.625c-1.48619,0 -2.6875,1.204 -2.6875,2.6875v5.375c0,1.4835 1.20131,2.6875 2.6875,2.6875c1.48619,0 2.6875,-1.204 2.6875,-2.6875v-5.375c0,-1.4835 -1.20131,-2.6875 -2.6875,-2.6875zM112.875,37.625c-1.48619,0 -2.6875,1.204 -2.6875,2.6875v5.375c0,1.4835 1.20131,2.6875 2.6875,2.6875c1.48619,0 2.6875,-1.204 2.6875,-2.6875v-5.375c0,-1.4835 -1.20131,-2.6875 -2.6875,-2.6875zM126.3125,37.625c-1.48619,0 -2.6875,1.204 -2.6875,2.6875v5.375c0,1.4835 1.20131,2.6875 2.6875,2.6875c1.48619,0 2.6875,-1.204 2.6875,-2.6875v-5.375c0,-1.4835 -1.20131,-2.6875 -2.6875,-2.6875zM139.75,37.625c-1.48619,0 -2.6875,1.204 -2.6875,2.6875v5.375c0,1.4835 1.20131,2.6875 2.6875,2.6875c1.48619,0 2.6875,-1.204 2.6875,-2.6875v-5.375c0,-1.4835 -1.20131,-2.6875 -2.6875,-2.6875zM153.1875,37.625c-1.48619,0 -2.6875,1.204 -2.6875,2.6875v5.375c0,1.4835 1.20131,2.6875 2.6875,2.6875c1.48619,0 2.6875,-1.204 2.6875,-2.6875v-5.375c0,-1.4835 -1.20131,-2.6875 -2.6875,-2.6875zM53.75,56.4375c-10.38987,0 -18.8125,8.42262 -18.8125,18.8125v5.375c0.08062,4.52575 1.47338,8.93514 4.005,12.68689c-8.79081,3.27337 -15.93318,9.89164 -19.8623,18.40832c-0.73369,1.29 -0.28219,2.93013 1.00781,3.66382c1.29,0.73369 2.93538,0.28219 3.66907,-1.00781c0.0645,-0.11019 0.11434,-0.22818 0.16272,-0.34643c3.60394,-7.912 10.4705,-13.86565 18.8125,-16.31397c3.00463,2.77887 6.93257,4.35005 11.02295,4.40918c4.08231,-0.06719 7.99489,-1.63837 10.99146,-4.40918c8.34469,2.44562 15.21125,8.39928 18.8125,16.31397c0.44612,0.94331 1.39805,1.54078 2.4408,1.53271c1.4835,-0.00538 2.68238,-1.2145 2.677,-2.698c0,-0.39775 -0.08789,-0.78685 -0.2572,-1.14429c-3.93719,-8.50862 -11.07687,-15.11408 -19.8623,-18.38208c2.537,-3.75981 3.92975,-8.17664 4.005,-12.71314v-5.375c0,-10.38988 -8.42262,-18.8125 -18.8125,-18.8125zM53.75,61.8125c7.42019,0 13.4375,6.01731 13.4375,13.4375v5.375c0,7.31 -5.99312,16.125 -13.4375,16.125c-7.44438,0 -13.4375,-8.815 -13.4375,-16.125v-5.375c0,-7.42019 6.01731,-13.4375 13.4375,-13.4375zM102.125,67.1875c-1.4835,0 -2.6875,1.204 -2.6875,2.6875c0,1.4835 1.204,2.6875 2.6875,2.6875h26.875c1.4835,0 2.6875,-1.204 2.6875,-2.6875c0,-1.4835 -1.204,-2.6875 -2.6875,-2.6875zM139.75,67.1875c-1.4835,0 -2.6875,1.204 -2.6875,2.6875c0,1.4835 1.204,2.6875 2.6875,2.6875h10.75c1.4835,0 2.6875,-1.204 2.6875,-2.6875c0,-1.4835 -1.204,-2.6875 -2.6875,-2.6875zM102.125,83.3125c-1.4835,0 -2.6875,1.204 -2.6875,2.6875c0,1.4835 1.204,2.6875 2.6875,2.6875h48.375c1.4835,0 2.6875,-1.204 2.6875,-2.6875c0,-1.4835 -1.204,-2.6875 -2.6875,-2.6875zM102.125,99.4375c-1.4835,0 -2.6875,1.204 -2.6875,2.6875c0,1.4835 1.204,2.6875 2.6875,2.6875h32.25c1.4835,0 2.6875,-1.204 2.6875,-2.6875c0,-1.4835 -1.204,-2.6875 -2.6875,-2.6875zM18.8125,123.625c-1.48619,0 -2.6875,1.204 -2.6875,2.6875v5.375c0,1.4835 1.20131,2.6875 2.6875,2.6875c1.48619,0 2.6875,-1.204 2.6875,-2.6875v-5.375c0,-1.4835 -1.20131,-2.6875 -2.6875,-2.6875zM32.25,123.625c-1.48619,0 -2.6875,1.204 -2.6875,2.6875v5.375c0,1.4835 1.20131,2.6875 2.6875,2.6875c1.48619,0 2.6875,-1.204 2.6875,-2.6875v-5.375c0,-1.4835 -1.20131,-2.6875 -2.6875,-2.6875zM45.6875,123.625c-1.48619,0 -2.6875,1.204 -2.6875,2.6875v5.375c0,1.4835 1.20131,2.6875 2.6875,2.6875c1.48619,0 2.6875,-1.204 2.6875,-2.6875v-5.375c0,-1.4835 -1.20131,-2.6875 -2.6875,-2.6875zM59.125,123.625c-1.48619,0 -2.6875,1.204 -2.6875,2.6875v5.375c0,1.4835 1.20131,2.6875 2.6875,2.6875c1.48619,0 2.6875,-1.204 2.6875,-2.6875v-5.375c0,-1.4835 -1.20131,-2.6875 -2.6875,-2.6875zM72.5625,123.625c-1.48619,0 -2.6875,1.204 -2.6875,2.6875v5.375c0,1.4835 1.20131,2.6875 2.6875,2.6875c1.48619,0 2.6875,-1.204 2.6875,-2.6875v-5.375c0,-1.4835 -1.20131,-2.6875 -2.6875,-2.6875zM86,123.625c-1.48619,0 -2.6875,1.204 -2.6875,2.6875v5.375c0,1.4835 1.20131,2.6875 2.6875,2.6875c1.48619,0 2.6875,-1.204 2.6875,-2.6875v-5.375c0,-1.4835 -1.20131,-2.6875 -2.6875,-2.6875zM99.4375,123.625c-1.48619,0 -2.6875,1.204 -2.6875,2.6875v5.375c0,1.4835 1.20131,2.6875 2.6875,2.6875c1.48619,0 2.6875,-1.204 2.6875,-2.6875v-5.375c0,-1.4835 -1.20131,-2.6875 -2.6875,-2.6875zM112.875,123.625c-1.48619,0 -2.6875,1.204 -2.6875,2.6875v5.375c0,1.4835 1.20131,2.6875 2.6875,2.6875c1.48619,0 2.6875,-1.204 2.6875,-2.6875v-5.375c0,-1.4835 -1.20131,-2.6875 -2.6875,-2.6875zM126.3125,123.625c-1.48619,0 -2.6875,1.204 -2.6875,2.6875v5.375c0,1.4835 1.20131,2.6875 2.6875,2.6875c1.48619,0 2.6875,-1.204 2.6875,-2.6875v-5.375c0,-1.4835 -1.20131,-2.6875 -2.6875,-2.6875zM139.75,123.625c-1.48619,0 -2.6875,1.204 -2.6875,2.6875v5.375c0,1.4835 1.20131,2.6875 2.6875,2.6875c1.48619,0 2.6875,-1.204 2.6875,-2.6875v-5.375c0,-1.4835 -1.20131,-2.6875 -2.6875,-2.6875zM153.1875,123.625c-1.48619,0 -2.6875,1.204 -2.6875,2.6875v5.375c0,1.4835 1.20131,2.6875 2.6875,2.6875c1.48619,0 2.6875,-1.204 2.6875,-2.6875v-5.375c0,-1.4835 -1.20131,-2.6875 -2.6875,-2.6875z"></path>
                    </g>
                  </g>
                </svg>
                Permission Management</button></a>

          </div>
          <?php  } ?>

          <?php $permissions = array("admin");
          if (in_array($_SESSION['usertype'], $permissions)) { ?>
          <div class="col-12 mb-2">
            <a href='roleManagement.php'><button type="button" class="btn btn-block btn-danger  btn-lg text-left">
                <svg class="icon1 mr-2" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="32" height="32" viewBox="0 0 172 172" style=" fill:#000000;">
                  <g fill="none" fill-rule="nonzero" stroke="none" stroke-width="1" stroke-linecap="butt" stroke-linejoin="miter" stroke-miterlimit="10" stroke-dasharray="" stroke-dashoffset="0" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode: normal">
                    <path d="M0,172v-172h172v172z" fill="none"></path>
                    <g fill="#ffffff">
                      <path d="M16.125,26.875c-7.40944,0 -13.4375,6.02806 -13.4375,13.4375v91.375c0,7.40944 6.02806,13.4375 13.4375,13.4375h139.75c7.40944,0 13.4375,-6.02806 13.4375,-13.4375v-91.375c0,-7.40944 -6.02806,-13.4375 -13.4375,-13.4375zM16.125,32.25h139.75c4.44513,0 8.0625,3.61738 8.0625,8.0625v91.375c0,4.44513 -3.61737,8.0625 -8.0625,8.0625h-139.75c-4.44512,0 -8.0625,-3.61737 -8.0625,-8.0625v-91.375c0,-4.44512 3.61738,-8.0625 8.0625,-8.0625zM18.8125,37.625c-1.48619,0 -2.6875,1.204 -2.6875,2.6875v5.375c0,1.4835 1.20131,2.6875 2.6875,2.6875c1.48619,0 2.6875,-1.204 2.6875,-2.6875v-5.375c0,-1.4835 -1.20131,-2.6875 -2.6875,-2.6875zM32.25,37.625c-1.48619,0 -2.6875,1.204 -2.6875,2.6875v5.375c0,1.4835 1.20131,2.6875 2.6875,2.6875c1.48619,0 2.6875,-1.204 2.6875,-2.6875v-5.375c0,-1.4835 -1.20131,-2.6875 -2.6875,-2.6875zM45.6875,37.625c-1.48619,0 -2.6875,1.204 -2.6875,2.6875v5.375c0,1.4835 1.20131,2.6875 2.6875,2.6875c1.48619,0 2.6875,-1.204 2.6875,-2.6875v-5.375c0,-1.4835 -1.20131,-2.6875 -2.6875,-2.6875zM59.125,37.625c-1.48619,0 -2.6875,1.204 -2.6875,2.6875v5.375c0,1.4835 1.20131,2.6875 2.6875,2.6875c1.48619,0 2.6875,-1.204 2.6875,-2.6875v-5.375c0,-1.4835 -1.20131,-2.6875 -2.6875,-2.6875zM72.5625,37.625c-1.48619,0 -2.6875,1.204 -2.6875,2.6875v5.375c0,1.4835 1.20131,2.6875 2.6875,2.6875c1.48619,0 2.6875,-1.204 2.6875,-2.6875v-5.375c0,-1.4835 -1.20131,-2.6875 -2.6875,-2.6875zM86,37.625c-1.48619,0 -2.6875,1.204 -2.6875,2.6875v5.375c0,1.4835 1.20131,2.6875 2.6875,2.6875c1.48619,0 2.6875,-1.204 2.6875,-2.6875v-5.375c0,-1.4835 -1.20131,-2.6875 -2.6875,-2.6875zM99.4375,37.625c-1.48619,0 -2.6875,1.204 -2.6875,2.6875v5.375c0,1.4835 1.20131,2.6875 2.6875,2.6875c1.48619,0 2.6875,-1.204 2.6875,-2.6875v-5.375c0,-1.4835 -1.20131,-2.6875 -2.6875,-2.6875zM112.875,37.625c-1.48619,0 -2.6875,1.204 -2.6875,2.6875v5.375c0,1.4835 1.20131,2.6875 2.6875,2.6875c1.48619,0 2.6875,-1.204 2.6875,-2.6875v-5.375c0,-1.4835 -1.20131,-2.6875 -2.6875,-2.6875zM126.3125,37.625c-1.48619,0 -2.6875,1.204 -2.6875,2.6875v5.375c0,1.4835 1.20131,2.6875 2.6875,2.6875c1.48619,0 2.6875,-1.204 2.6875,-2.6875v-5.375c0,-1.4835 -1.20131,-2.6875 -2.6875,-2.6875zM139.75,37.625c-1.48619,0 -2.6875,1.204 -2.6875,2.6875v5.375c0,1.4835 1.20131,2.6875 2.6875,2.6875c1.48619,0 2.6875,-1.204 2.6875,-2.6875v-5.375c0,-1.4835 -1.20131,-2.6875 -2.6875,-2.6875zM153.1875,37.625c-1.48619,0 -2.6875,1.204 -2.6875,2.6875v5.375c0,1.4835 1.20131,2.6875 2.6875,2.6875c1.48619,0 2.6875,-1.204 2.6875,-2.6875v-5.375c0,-1.4835 -1.20131,-2.6875 -2.6875,-2.6875zM53.75,56.4375c-10.38987,0 -18.8125,8.42262 -18.8125,18.8125v5.375c0.08062,4.52575 1.47338,8.93514 4.005,12.68689c-8.79081,3.27337 -15.93318,9.89164 -19.8623,18.40832c-0.73369,1.29 -0.28219,2.93013 1.00781,3.66382c1.29,0.73369 2.93538,0.28219 3.66907,-1.00781c0.0645,-0.11019 0.11434,-0.22818 0.16272,-0.34643c3.60394,-7.912 10.4705,-13.86565 18.8125,-16.31397c3.00463,2.77887 6.93257,4.35005 11.02295,4.40918c4.08231,-0.06719 7.99489,-1.63837 10.99146,-4.40918c8.34469,2.44562 15.21125,8.39928 18.8125,16.31397c0.44612,0.94331 1.39805,1.54078 2.4408,1.53271c1.4835,-0.00538 2.68238,-1.2145 2.677,-2.698c0,-0.39775 -0.08789,-0.78685 -0.2572,-1.14429c-3.93719,-8.50862 -11.07687,-15.11408 -19.8623,-18.38208c2.537,-3.75981 3.92975,-8.17664 4.005,-12.71314v-5.375c0,-10.38988 -8.42262,-18.8125 -18.8125,-18.8125zM53.75,61.8125c7.42019,0 13.4375,6.01731 13.4375,13.4375v5.375c0,7.31 -5.99312,16.125 -13.4375,16.125c-7.44438,0 -13.4375,-8.815 -13.4375,-16.125v-5.375c0,-7.42019 6.01731,-13.4375 13.4375,-13.4375zM102.125,67.1875c-1.4835,0 -2.6875,1.204 -2.6875,2.6875c0,1.4835 1.204,2.6875 2.6875,2.6875h26.875c1.4835,0 2.6875,-1.204 2.6875,-2.6875c0,-1.4835 -1.204,-2.6875 -2.6875,-2.6875zM139.75,67.1875c-1.4835,0 -2.6875,1.204 -2.6875,2.6875c0,1.4835 1.204,2.6875 2.6875,2.6875h10.75c1.4835,0 2.6875,-1.204 2.6875,-2.6875c0,-1.4835 -1.204,-2.6875 -2.6875,-2.6875zM102.125,83.3125c-1.4835,0 -2.6875,1.204 -2.6875,2.6875c0,1.4835 1.204,2.6875 2.6875,2.6875h48.375c1.4835,0 2.6875,-1.204 2.6875,-2.6875c0,-1.4835 -1.204,-2.6875 -2.6875,-2.6875zM102.125,99.4375c-1.4835,0 -2.6875,1.204 -2.6875,2.6875c0,1.4835 1.204,2.6875 2.6875,2.6875h32.25c1.4835,0 2.6875,-1.204 2.6875,-2.6875c0,-1.4835 -1.204,-2.6875 -2.6875,-2.6875zM18.8125,123.625c-1.48619,0 -2.6875,1.204 -2.6875,2.6875v5.375c0,1.4835 1.20131,2.6875 2.6875,2.6875c1.48619,0 2.6875,-1.204 2.6875,-2.6875v-5.375c0,-1.4835 -1.20131,-2.6875 -2.6875,-2.6875zM32.25,123.625c-1.48619,0 -2.6875,1.204 -2.6875,2.6875v5.375c0,1.4835 1.20131,2.6875 2.6875,2.6875c1.48619,0 2.6875,-1.204 2.6875,-2.6875v-5.375c0,-1.4835 -1.20131,-2.6875 -2.6875,-2.6875zM45.6875,123.625c-1.48619,0 -2.6875,1.204 -2.6875,2.6875v5.375c0,1.4835 1.20131,2.6875 2.6875,2.6875c1.48619,0 2.6875,-1.204 2.6875,-2.6875v-5.375c0,-1.4835 -1.20131,-2.6875 -2.6875,-2.6875zM59.125,123.625c-1.48619,0 -2.6875,1.204 -2.6875,2.6875v5.375c0,1.4835 1.20131,2.6875 2.6875,2.6875c1.48619,0 2.6875,-1.204 2.6875,-2.6875v-5.375c0,-1.4835 -1.20131,-2.6875 -2.6875,-2.6875zM72.5625,123.625c-1.48619,0 -2.6875,1.204 -2.6875,2.6875v5.375c0,1.4835 1.20131,2.6875 2.6875,2.6875c1.48619,0 2.6875,-1.204 2.6875,-2.6875v-5.375c0,-1.4835 -1.20131,-2.6875 -2.6875,-2.6875zM86,123.625c-1.48619,0 -2.6875,1.204 -2.6875,2.6875v5.375c0,1.4835 1.20131,2.6875 2.6875,2.6875c1.48619,0 2.6875,-1.204 2.6875,-2.6875v-5.375c0,-1.4835 -1.20131,-2.6875 -2.6875,-2.6875zM99.4375,123.625c-1.48619,0 -2.6875,1.204 -2.6875,2.6875v5.375c0,1.4835 1.20131,2.6875 2.6875,2.6875c1.48619,0 2.6875,-1.204 2.6875,-2.6875v-5.375c0,-1.4835 -1.20131,-2.6875 -2.6875,-2.6875zM112.875,123.625c-1.48619,0 -2.6875,1.204 -2.6875,2.6875v5.375c0,1.4835 1.20131,2.6875 2.6875,2.6875c1.48619,0 2.6875,-1.204 2.6875,-2.6875v-5.375c0,-1.4835 -1.20131,-2.6875 -2.6875,-2.6875zM126.3125,123.625c-1.48619,0 -2.6875,1.204 -2.6875,2.6875v5.375c0,1.4835 1.20131,2.6875 2.6875,2.6875c1.48619,0 2.6875,-1.204 2.6875,-2.6875v-5.375c0,-1.4835 -1.20131,-2.6875 -2.6875,-2.6875zM139.75,123.625c-1.48619,0 -2.6875,1.204 -2.6875,2.6875v5.375c0,1.4835 1.20131,2.6875 2.6875,2.6875c1.48619,0 2.6875,-1.204 2.6875,-2.6875v-5.375c0,-1.4835 -1.20131,-2.6875 -2.6875,-2.6875zM153.1875,123.625c-1.48619,0 -2.6875,1.204 -2.6875,2.6875v5.375c0,1.4835 1.20131,2.6875 2.6875,2.6875c1.48619,0 2.6875,-1.204 2.6875,-2.6875v-5.375c0,-1.4835 -1.20131,-2.6875 -2.6875,-2.6875z"></path>
                    </g>
                  </g>
                </svg>
                Role Management</button></a>

          </div>
          <?php  } ?>

          <?php $permissions = array("admin","operator");
          if (in_array($_SESSION['usertype'], $permissions)) { ?>
            <div class="col-12 mb-2">
              <a href='addorder.php'><button type="button" class="btn btn-block btn-success bg-maroon btn-lg text-left">
                  <svg class="icon1 mr-2" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="32" height="32" viewBox="0 0 172 172" style=" fill:#000000;">
                    <g fill="none" fill-rule="nonzero" stroke="none" stroke-width="1" stroke-linecap="butt" stroke-linejoin="miter" stroke-miterlimit="10" stroke-dasharray="" stroke-dashoffset="0" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode: normal">
                      <path d="M0,172v-172h172v172z" fill="none"></path>
                      <g fill="#ffffff">
                        <path d="M137.48242,5.41699c-1.46973,-0.23096 -2.84497,0.77686 -3.06543,2.24658l-1.97363,12.72363l-39.11572,-4.3252c-3.26489,-0.35693 -6.4668,0.76636 -8.78687,3.08642l-75.17651,75.17651c-4.19922,4.18872 -4.19922,11.01245 0,15.20117l57.01489,57.01489c2.02612,2.02612 4.72412,3.14941 7.60059,3.14941c2.86597,0 5.56396,-1.12329 7.60059,-3.14941l21.5,-21.5105c3.61133,15.43213 17.46875,26.96948 33.98218,26.96948c19.26392,0 34.9375,-15.67358 34.9375,-34.9375c0,-16.51343 -11.53735,-30.36035 -26.95898,-33.98218l11.71582,-11.71582c2.32007,-2.33057 3.44336,-5.52197 3.07593,-8.78686l-4.26221,-38.59082l13.94141,-0.98682c1.48022,-0.10498 2.59302,-1.39624 2.48804,-2.87646c-0.10498,-1.48023 -1.37524,-2.62451 -2.87646,-2.48804l-14.14087,1.00781l-0.81885,-7.40112c-0.56689,-5.03906 -4.47217,-8.94434 -9.50073,-9.50073l-6.86572,-0.75586l1.92114,-12.50317c0.23096,-1.46973 -0.77685,-2.84497 -2.23608,-3.06543zM91.53247,21.39502c0.38843,-0.04199 0.79785,-0.04199 1.19678,0.0105l51.33545,5.67944c2.51953,0.27295 4.47217,2.22559 4.75561,4.74512l0.79785,7.19116l-8.09399,0.57739c-0.50391,-1.0708 -1.16528,-2.08911 -2.05762,-2.98145c-4.18872,-4.18872 -11.00195,-4.18872 -15.20117,0c-4.18872,4.19922 -4.18872,11.01245 0,15.20117c2.09961,2.09961 4.8501,3.14941 7.60059,3.14941c2.76099,0 5.51148,-1.0498 7.60059,-3.14941c1.92114,-1.91064 2.91846,-4.37768 3.08643,-6.89722l7.65308,-0.5459l4.2832,38.80078c0.18897,1.6272 -0.37793,3.2229 -1.54321,4.37768l-14.62378,14.64478c-0.41992,-0.021 -0.83984,-0.07349 -1.25977,-0.07349c-19.26392,0 -34.9375,15.67358 -34.9375,34.9375c0,0.41992 0.04199,0.83984 0.06299,1.25977l-24.41846,24.40796c-2.02612,2.03662 -5.56396,2.03662 -7.60059,0l-57.00439,-57.00439c-2.09961,-2.09961 -2.09961,-5.51147 0,-7.60059l75.17651,-75.17651c0.86084,-0.88184 1.99463,-1.41724 3.19141,-1.55371zM131.86597,38.84277c1.37524,0 2.75049,0.5249 3.80029,1.57471c2.09961,2.08911 2.09961,5.50098 0,7.60059c-2.08911,2.08911 -5.50098,2.08911 -7.60059,0c-2.08911,-2.09961 -2.08911,-5.51148 0,-7.60059c1.0498,-1.0498 2.42505,-1.57471 3.80029,-1.57471zM22.75977,93.63208c-0.69287,0 -1.37524,0.26245 -1.90015,0.78735l-3.80029,3.80029c-1.0498,1.0498 -1.0498,2.75049 0,3.80029c0.5249,0.5249 1.20728,0.78735 1.90015,0.78735c0.69287,0 1.37524,-0.26245 1.90015,-0.78735l3.80029,-3.80029c1.0498,-1.0498 1.0498,-2.75049 0,-3.80029c-0.5249,-0.5249 -1.20727,-0.78735 -1.90015,-0.78735zM32.2605,103.13281c-0.68237,0 -1.37524,0.26245 -1.90015,0.78735l-3.80029,3.78979c-1.0498,1.0603 -1.0498,2.75049 0,3.81079c0.5249,0.5144 1.20727,0.77685 1.90015,0.77685c0.69287,0 1.37524,-0.26245 1.90015,-0.77685l3.80029,-3.81079c1.0498,-1.0498 1.0498,-2.73999 0,-3.78979c-0.5249,-0.5249 -1.21777,-0.78735 -1.90015,-0.78735zM137.0625,107.5c16.30347,0 29.5625,13.25903 29.5625,29.5625c0,16.30347 -13.25903,29.5625 -29.5625,29.5625c-16.30347,0 -29.5625,-13.25903 -29.5625,-29.5625c0,-16.30347 13.25903,-29.5625 29.5625,-29.5625zM41.76123,112.63354c-0.68238,0 -1.37524,0.26245 -1.90015,0.78735l-3.78979,3.80029c-1.0603,1.0498 -1.0603,2.75049 0,3.80029c0.5144,0.5249 1.20728,0.78735 1.88965,0.78735c0.69287,0 1.37524,-0.26245 1.90015,-0.78735l3.80029,-3.80029c1.0498,-1.0498 1.0498,-2.75049 0,-3.80029c-0.5249,-0.5249 -1.21777,-0.78735 -1.90015,-0.78735zM137.0625,118.25c-1.49072,0 -2.6875,1.19678 -2.6875,2.6875v13.4375h-13.4375c-1.49072,0 -2.6875,1.19678 -2.6875,2.6875c0,1.49072 1.19678,2.6875 2.6875,2.6875h13.4375v13.4375c0,1.49072 1.19678,2.6875 2.6875,2.6875c1.49072,0 2.6875,-1.19678 2.6875,-2.6875v-13.4375h13.4375c1.49072,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.19678,-2.6875 -2.6875,-2.6875h-13.4375v-13.4375c0,-1.49072 -1.19678,-2.6875 -2.6875,-2.6875zM51.26196,122.13428c-0.68237,0 -1.37524,0.26245 -1.90015,0.78735l-3.80029,3.80029c-1.0498,1.0498 -1.0498,2.75049 0,3.80029c0.5249,0.5249 1.20728,0.78735 1.90015,0.78735c0.69287,0 1.37524,-0.26245 1.90015,-0.78735l3.80029,-3.80029c1.0498,-1.0498 1.0498,-2.75049 0,-3.80029c-0.5249,-0.5249 -1.21777,-0.78735 -1.90015,-0.78735zM60.7627,131.63501c-0.68237,0 -1.36474,0.26245 -1.88965,0.78735l-3.81079,3.80029c-1.0498,1.0498 -1.0498,2.75049 0,3.80029c0.5249,0.5249 1.20728,0.78735 1.90015,0.78735c0.69287,0 1.37524,-0.26245 1.90015,-0.78735l3.80029,-3.80029c1.0603,-1.0498 1.0603,-2.75049 0,-3.80029c-0.5249,-0.5249 -1.20727,-0.78735 -1.90015,-0.78735zM70.26343,141.13574c-0.68237,0 -1.36474,0.26245 -1.90015,0.79785l-3.78979,3.78979c-1.0603,1.0603 -1.0603,2.75049 0,3.81079c0.5144,0.5144 1.20728,0.78735 1.90015,0.78735c0.68237,0 1.37524,-0.27295 1.88965,-0.78735l3.81079,-3.81079c1.0498,-1.0498 1.0498,-2.73999 0,-3.78979c-0.5354,-0.5354 -1.21777,-0.79785 -1.91065,-0.79785zM79.77466,150.63647c-0.69287,0 -1.38574,0.26245 -1.91065,0.78735l-3.78979,3.81079c-1.0603,1.0498 -1.0603,2.73999 0,3.78979c0.5144,0.5249 1.20728,0.79785 1.88965,0.79785c0.69287,0 1.38574,-0.27295 1.90015,-0.79785l3.81079,-3.78979c1.0498,-1.0603 1.0498,-2.75049 0,-3.81079c-0.5354,-0.5249 -1.21777,-0.78735 -1.90015,-0.78735z"></path>
                      </g>
                    </g>
                  </svg>
                  Order Products</button></a>

            </div>
          <?php  } ?>

          <div class="col-12 mb-2">
            <a href='manageorders.php'><button type="button" class="btn btn-block btn-success  btn-lg text-left">
                <svg class="icon1 mr-2" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="32" height="32" viewBox="0 0 172 172" style=" fill:#000000;">
                  <g fill="none" fill-rule="nonzero" stroke="none" stroke-width="1" stroke-linecap="butt" stroke-linejoin="miter" stroke-miterlimit="10" stroke-dasharray="" stroke-dashoffset="0" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode: normal">
                    <path d="M0,172v-172h172v172z" fill="none"></path>
                    <g fill="#ffffff">
                      <path d="M79.44922,0c-3.71631,0 -6.92871,2.50903 -7.82104,6.10986l-4.65064,18.51855c-2.37256,0.80835 -4.76611,1.81616 -7.09668,2.99194l-16.40845,-9.85767c-3.18091,-1.90015 -7.22266,-1.40674 -9.84717,1.21777l-9.26978,9.26978c-2.62451,2.61401 -3.11792,6.66626 -1.21777,9.84717l9.83667,16.40845c-1.16528,2.35156 -2.1626,4.73462 -2.94995,7.10718l-18.53955,4.64014c-3.60083,0.89233 -6.10986,4.11523 -6.10986,7.82104v13.10156c0,3.71631 2.50903,6.92871 6.10986,7.82104l18.51855,4.65064c0.80835,2.36206 1.80566,4.74512 2.99194,7.09668l-9.85767,16.40845c-1.90015,3.18091 -1.40674,7.22266 1.21777,9.84717l9.26978,9.26978c2.62451,2.62451 6.66626,3.11792 9.84717,1.21777l16.40845,-9.83667c2.33057,1.15478 4.71362,2.1521 7.10718,2.94995l4.64014,18.53955c0.89233,3.60083 4.11523,6.10986 7.82104,6.10986h6.55078v2.6875c0,4.44067 3.62183,8.0625 8.0625,8.0625h69.875c4.44067,0 8.0625,-3.62183 8.0625,-8.0625v-64.5c0,-3.96826 -2.88696,-7.25415 -6.66626,-7.92603c0.80835,-1.25977 1.29126,-2.73999 1.29126,-4.33569v-13.10156c0,-3.71631 -2.50903,-6.92871 -6.09936,-7.82104l-18.52905,-4.65064c-0.81885,-2.38306 -1.81616,-4.76611 -2.99195,-7.09668l9.85767,-16.40845c1.90015,-3.18091 1.39624,-7.22266 -1.21777,-9.84717l-9.26978,-9.26978c-2.62451,-2.62451 -6.66626,-3.11792 -9.84717,-1.21777l-16.40845,9.83667c-2.34107,-1.16528 -4.73462,-2.1626 -7.10718,-2.96045l-4.64014,-18.52905c-0.89233,-3.60083 -4.11523,-6.10986 -7.82104,-6.10986zM79.44922,5.375h13.10156c1.23877,0 2.30957,0.83984 2.61401,2.03662l4.64014,18.53955c0.44092,1.76367 1.74267,3.17041 3.48535,3.7688c2.1416,0.72436 4.3042,1.6377 6.4353,2.698c1.65869,0.81885 3.57983,0.74536 5.16504,-0.19946l16.40845,-9.84717c1.0603,-0.64038 2.40405,-0.46191 3.27539,0.40942l9.26978,9.25928c0.87134,0.88184 1.0393,2.22559 0.39892,3.28589l-9.83667,16.40845c-0.94483,1.57471 -1.01831,3.50635 -0.19946,5.16504c1.0603,2.12061 1.96314,4.2832 2.698,6.4353c0.60889,1.74268 2.01563,3.05493 3.7688,3.48535l18.53955,4.64014c1.19678,0.30444 2.03662,1.37524 2.03662,2.61401v13.10156c0,1.23877 -0.83984,2.30957 -2.03662,2.60352l-5.97339,1.50122c-0.07348,0.02099 -0.12598,0.07349 -0.19946,0.09448h-30.97974c1.02881,-3.46435 1.56421,-7.07568 1.56421,-10.75c0,-17.37427 -11.76831,-32.39697 -28.60718,-36.5332c-1.45923,-0.34643 -2.89746,0.5249 -3.2544,1.96314c-0.35693,1.43823 0.5249,2.89746 1.96314,3.2439c14.43482,3.55884 24.52344,16.43994 24.52344,31.32617c0,3.70581 -0.65088,7.30664 -1.87915,10.75h-22.30835c-4.44067,0 -8.0625,3.62183 -8.0625,8.0625v56.4375h-6.55078c-1.23877,0 -2.30957,-0.83984 -2.60352,-2.03662l-4.64014,-18.52905c-0.44092,-1.76367 -1.74268,-3.18091 -3.49585,-3.7793c-2.1521,-0.73486 -4.3147,-1.6377 -6.4353,-2.698c-1.66919,-0.82935 -3.59033,-0.74536 -5.15454,0.19946l-16.41895,9.83667c-1.0498,0.64038 -2.40405,0.47241 -3.27539,-0.39892l-9.26977,-9.26978c-0.87134,-0.87134 -1.03931,-2.22559 -0.39893,-3.27539l9.83667,-16.41895c0.94483,-1.57471 1.01831,-3.49585 0.19946,-5.15454c-1.0603,-2.1416 -1.96314,-4.3042 -2.698,-6.4353c-0.59839,-1.75317 -2.01562,-3.05493 -3.7688,-3.49585l-18.53955,-4.64014c-1.19678,-0.29395 -2.03662,-1.36474 -2.03662,-2.60352v-13.10156c0,-1.23877 0.83984,-2.30957 2.03662,-2.60352l18.52905,-4.64014c1.76367,-0.44092 3.18091,-1.74268 3.7793,-3.49585c0.72436,-2.1311 1.6377,-4.2937 2.698,-6.4353c0.81885,-1.65869 0.74536,-3.57983 -0.19946,-5.15454l-9.83667,-16.41895c-0.64038,-1.0498 -0.47241,-2.40405 0.39893,-3.27539l9.25928,-9.26977c0.88184,-0.87134 2.22559,-1.03931 3.28589,-0.39893l16.40845,9.83667c1.57471,0.94483 3.50635,1.00781 5.16504,0.19946c2.12061,-1.0603 4.2832,-1.96314 6.4353,-2.698c1.75317,-0.59839 3.05493,-2.01562 3.48535,-3.7688l4.65064,-18.53955c0.29395,-1.19678 1.36475,-2.03662 2.60352,-2.03662zM80.96094,43.33594c-2.25708,0.29395 -4.49316,0.80835 -6.64526,1.51172c-1.40674,0.46191 -2.18359,1.98413 -1.72168,3.39087c0.36743,1.13379 1.42773,1.85815 2.56152,1.85815c0.27295,0 0.5459,-0.04199 0.82935,-0.13647c1.84766,-0.59839 3.7583,-1.03931 5.68994,-1.29126c1.46973,-0.19946 2.49854,-1.55371 2.30957,-3.02344c-0.19946,-1.48022 -1.56421,-2.50903 -3.02344,-2.30957zM61.2981,53.2356c-0.68237,0 -1.37524,0.26245 -1.90015,0.78735c-1.0498,1.0498 -1.0498,2.75049 0,3.80029l3.80029,3.80029c0.5249,0.5249 1.20728,0.78735 1.90015,0.78735c0.69287,0 1.37524,-0.26245 1.90015,-0.78735c1.0498,-1.0498 1.0498,-2.75049 0,-3.80029l-3.80029,-3.80029c-0.5249,-0.5249 -1.21777,-0.78735 -1.90015,-0.78735zM86,59.125c-11.85229,0 -21.5,9.64771 -21.5,21.5c0,8.18848 4.54565,15.55811 11.87329,19.23242c0.38843,0.18897 0.79785,0.28345 1.19678,0.28345c0.98682,0 1.94214,-0.5459 2.41455,-1.49072c0.66138,-1.32275 0.12598,-2.93945 -1.20728,-3.60083c-5.49048,-2.75049 -8.90234,-8.28296 -8.90234,-14.42432c0,-8.89185 7.23315,-16.125 16.125,-16.125c8.89185,0 16.125,7.23315 16.125,16.125c0,0.5249 -0.02099,1.0603 -0.07349,1.57471c-0.14697,1.48022 0.93433,2.78198 2.41455,2.92895c1.49072,0.11548 2.79248,-0.94482 2.93945,-2.41455c0.06299,-0.69287 0.09448,-1.38574 0.09448,-2.08911c0,-11.85229 -9.64771,-21.5 -21.5,-21.5zM53.84448,64.29004c-1.0393,-0.0105 -2.04712,0.60889 -2.48804,1.6377c-0.57739,1.36475 0.06299,2.93945 1.42773,3.52734l4.95508,2.09961c0.34643,0.13647 0.69287,0.20996 1.0498,0.20996c1.0498,0 2.04712,-0.61939 2.47754,-1.6377c0.57739,-1.36474 -0.06299,-2.94995 -1.42773,-3.52734l-4.95508,-2.09961c-0.33594,-0.14697 -0.68237,-0.20996 -1.03931,-0.20996zM86,75.25c-2.97095,0 -5.375,2.40405 -5.375,5.375c0,2.97095 2.40405,5.375 5.375,5.375c2.97095,0 5.375,-2.40405 5.375,-5.375c0,-2.97095 -2.40405,-5.375 -5.375,-5.375zM51.0625,77.9375c-1.49072,0 -2.6875,1.20728 -2.6875,2.6875c0,1.48022 1.19678,2.6875 2.6875,2.6875h5.375c1.49072,0 2.6875,-1.20728 2.6875,-2.6875c0,-1.48022 -1.19678,-2.6875 -2.6875,-2.6875zM58.63159,89.01294c-0.34643,-0.0105 -0.70337,0.05249 -1.0498,0.18896l-4.97607,2.01563c-1.38574,0.5564 -2.04712,2.12061 -1.49072,3.50635c0.41992,1.03931 1.42773,1.67969 2.49854,1.67969c0.33594,0 0.67188,-0.06299 1.00781,-0.19946l4.97607,-2.01562c1.37524,-0.5459 2.03662,-2.1206 1.49072,-3.49585c-0.41992,-1.02881 -1.40674,-1.65869 -2.45654,-1.67969zM94.0625,96.75h24.1875c0,0 0,0 0.0105,0c0.0105,0 0.0105,0 0.021,0h45.65601c1.48022,0 2.6875,1.20728 2.6875,2.6875v2.6875h-75.25v-2.6875c0,-1.48022 1.20728,-2.6875 2.6875,-2.6875zM65.08789,98.83911c-0.68237,0 -1.36474,0.26245 -1.88965,0.78735l-3.80029,3.80029c-1.0498,1.0498 -1.0498,2.75049 0,3.80029c0.5249,0.5249 1.20727,0.78735 1.90015,0.78735c0.69287,0 1.37524,-0.26245 1.90015,-0.78735l3.80029,-3.80029c1.0498,-1.0498 1.0498,-2.75049 0,-3.80029c-0.5249,-0.5249 -1.21777,-0.78735 -1.91065,-0.78735zM74.45215,105.14844c-1.03931,0 -2.04712,0.60889 -2.47754,1.6377l-2.09961,4.95508c-0.58789,1.36475 0.05249,2.93945 1.42773,3.52734c0.33594,0.13647 0.69287,0.20996 1.0498,0.20996c1.03931,0 2.03662,-0.61939 2.46704,-1.6377l2.09961,-4.95508c0.58789,-1.36474 -0.05249,-2.93945 -1.41724,-3.52734c-0.33594,-0.13647 -0.69287,-0.20996 -1.0498,-0.20996zM91.375,107.5h75.25v56.4375c0,1.48022 -1.20728,2.6875 -2.6875,2.6875h-69.875c-1.48022,0 -2.6875,-1.20728 -2.6875,-2.6875zM120.9375,118.25c-0.68237,0 -1.37524,0.26245 -1.90015,0.78735l-8.84985,8.84985l-3.47485,-3.47485c-1.0498,-1.0498 -2.75049,-1.0498 -3.80029,0c-1.0498,1.0498 -1.0498,2.75049 0,3.80029l5.375,5.375c0.5249,0.5249 1.20728,0.78735 1.90015,0.78735c0.69287,0 1.37524,-0.26245 1.90015,-0.78735l10.75,-10.75c1.0498,-1.0498 1.0498,-2.75049 0,-3.80029c-0.5249,-0.5249 -1.21777,-0.78735 -1.90015,-0.78735zM131.6875,123.625c-1.49072,0 -2.6875,1.20728 -2.6875,2.6875c0,1.48022 1.19678,2.6875 2.6875,2.6875h21.5c1.49072,0 2.6875,-1.20728 2.6875,-2.6875c0,-1.48022 -1.19678,-2.6875 -2.6875,-2.6875zM120.9375,139.75c-0.68237,0 -1.37524,0.26245 -1.90015,0.78735l-8.84985,8.84985l-3.47485,-3.47485c-1.0498,-1.0498 -2.75049,-1.0498 -3.80029,0c-1.0498,1.0498 -1.0498,2.75049 0,3.80029l5.375,5.375c0.5249,0.5249 1.20728,0.78735 1.90015,0.78735c0.69287,0 1.37524,-0.26245 1.90015,-0.78735l10.75,-10.75c1.0498,-1.0498 1.0498,-2.75049 0,-3.80029c-0.5249,-0.5249 -1.21777,-0.78735 -1.90015,-0.78735zM131.6875,145.125c-1.49072,0 -2.6875,1.20728 -2.6875,2.6875c0,1.48022 1.19678,2.6875 2.6875,2.6875h10.75c1.49072,0 2.6875,-1.20728 2.6875,-2.6875c0,-1.48022 -1.19678,-2.6875 -2.6875,-2.6875z"></path>
                    </g>
                  </g>
                </svg>
                Order Management</button></a>

          </div>

          <div class="col-12 mb-2">
            <a href='manageorders.php?status=0'><button type="button" class="btn btn-block btn-danger bg-orange btn-lg text-left">
                <svg class="icon1 mr-2" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="32" height="32" viewBox="0 0 172 172" style=" fill:#000000;">
                  <g fill="none" fill-rule="nonzero" stroke="none" stroke-width="1" stroke-linecap="butt" stroke-linejoin="miter" stroke-miterlimit="10" stroke-dasharray="" stroke-dashoffset="0" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode: normal">
                    <path d="M0,172v-172h172v172z" fill="none"></path>
                    <g fill="#ffffff">
                      <path d="M13.4375,21.5c-4.44067,0 -8.0625,3.62183 -8.0625,8.0625v96.75c0,4.44067 3.62183,8.0625 8.0625,8.0625h55.51367l-6.4563,21.5h-14.11987c-1.49072,0 -2.6875,1.20728 -2.6875,2.6875c0,1.48022 1.19678,2.6875 2.6875,2.6875h75.25c1.49072,0 2.6875,-1.20728 2.6875,-2.6875c0,-1.48022 -1.19678,-2.6875 -2.6875,-2.6875h-14.11987l-6.4563,-21.5h55.51367c4.44067,0 8.0625,-3.62183 8.0625,-8.0625v-96.75c0,-4.44067 -3.62183,-8.0625 -8.0625,-8.0625zM13.4375,26.875h145.125c1.48022,0 2.6875,1.20728 2.6875,2.6875v96.75c0,1.48022 -1.20728,2.6875 -2.6875,2.6875h-145.125c-1.48022,0 -2.6875,-1.20728 -2.6875,-2.6875v-96.75c0,-1.48022 1.20728,-2.6875 2.6875,-2.6875zM34.9375,32.25c-1.49072,0 -2.6875,1.20728 -2.6875,2.6875v86c0,1.48022 1.19678,2.6875 2.6875,2.6875c1.49072,0 2.6875,-1.20728 2.6875,-2.6875v-8.0625h96.75v8.0625c0,1.48022 1.19678,2.6875 2.6875,2.6875c1.49072,0 2.6875,-1.20728 2.6875,-2.6875v-86c0,-1.48022 -1.19678,-2.6875 -2.6875,-2.6875c-1.49072,0 -2.6875,1.20728 -2.6875,2.6875v8.0625h-96.75v-8.0625c0,-1.48022 -1.19678,-2.6875 -2.6875,-2.6875zM18.8125,34.9375c-1.49072,0 -2.6875,1.20728 -2.6875,2.6875c0,1.48022 1.19678,2.6875 2.6875,2.6875h5.375c1.49072,0 2.6875,-1.20728 2.6875,-2.6875c0,-1.48022 -1.19678,-2.6875 -2.6875,-2.6875zM147.8125,34.9375c-1.49072,0 -2.6875,1.20728 -2.6875,2.6875c0,1.48022 1.19678,2.6875 2.6875,2.6875h5.375c1.49072,0 2.6875,-1.20728 2.6875,-2.6875c0,-1.48022 -1.19678,-2.6875 -2.6875,-2.6875zM18.8125,48.375c-1.49072,0 -2.6875,1.20728 -2.6875,2.6875c0,1.48022 1.19678,2.6875 2.6875,2.6875h5.375c1.49072,0 2.6875,-1.20728 2.6875,-2.6875c0,-1.48022 -1.19678,-2.6875 -2.6875,-2.6875zM37.625,48.375h96.75v59.125h-96.75zM147.8125,48.375c-1.49072,0 -2.6875,1.20728 -2.6875,2.6875c0,1.48022 1.19678,2.6875 2.6875,2.6875h5.375c1.49072,0 2.6875,-1.20728 2.6875,-2.6875c0,-1.48022 -1.19678,-2.6875 -2.6875,-2.6875zM68.57324,57.82324c-0.68237,0 -1.37524,0.26245 -1.90015,0.78735c-1.0498,1.0498 -1.0498,2.75049 0,3.80029l15.52661,15.52661l-15.52661,15.52661c-1.0498,1.0498 -1.0498,2.75049 0,3.80029c0.5249,0.5249 1.20728,0.78735 1.90015,0.78735c0.69287,0 1.37524,-0.26245 1.90015,-0.78735l15.52661,-15.52661l15.52661,15.52661c0.5249,0.5249 1.20728,0.78735 1.90015,0.78735c0.69287,0 1.37524,-0.26245 1.90015,-0.78735c1.0498,-1.0498 1.0498,-2.75049 0,-3.80029l-15.52661,-15.52661l15.52661,-15.52661c1.0498,-1.0498 1.0498,-2.75049 0,-3.80029c-1.0498,-1.0498 -2.75049,-1.0498 -3.80029,0l-15.52661,15.52661l-15.52661,-15.52661c-0.5249,-0.5249 -1.21777,-0.78735 -1.90015,-0.78735zM18.8125,61.8125c-1.49072,0 -2.6875,1.20728 -2.6875,2.6875c0,1.48022 1.19678,2.6875 2.6875,2.6875h5.375c1.49072,0 2.6875,-1.20728 2.6875,-2.6875c0,-1.48022 -1.19678,-2.6875 -2.6875,-2.6875zM147.8125,61.8125c-1.49072,0 -2.6875,1.20728 -2.6875,2.6875c0,1.48022 1.19678,2.6875 2.6875,2.6875h5.375c1.49072,0 2.6875,-1.20728 2.6875,-2.6875c0,-1.48022 -1.19678,-2.6875 -2.6875,-2.6875zM18.8125,75.25c-1.49072,0 -2.6875,1.20728 -2.6875,2.6875c0,1.48022 1.19678,2.6875 2.6875,2.6875h5.375c1.49072,0 2.6875,-1.20728 2.6875,-2.6875c0,-1.48022 -1.19678,-2.6875 -2.6875,-2.6875zM147.8125,75.25c-1.49072,0 -2.6875,1.20728 -2.6875,2.6875c0,1.48022 1.19678,2.6875 2.6875,2.6875h5.375c1.49072,0 2.6875,-1.20728 2.6875,-2.6875c0,-1.48022 -1.19678,-2.6875 -2.6875,-2.6875zM18.8125,88.6875c-1.49072,0 -2.6875,1.20728 -2.6875,2.6875c0,1.48022 1.19678,2.6875 2.6875,2.6875h5.375c1.49072,0 2.6875,-1.20728 2.6875,-2.6875c0,-1.48022 -1.19678,-2.6875 -2.6875,-2.6875zM147.8125,88.6875c-1.49072,0 -2.6875,1.20728 -2.6875,2.6875c0,1.48022 1.19678,2.6875 2.6875,2.6875h5.375c1.49072,0 2.6875,-1.20728 2.6875,-2.6875c0,-1.48022 -1.19678,-2.6875 -2.6875,-2.6875zM18.8125,102.125c-1.49072,0 -2.6875,1.20728 -2.6875,2.6875c0,1.48022 1.19678,2.6875 2.6875,2.6875h5.375c1.49072,0 2.6875,-1.20728 2.6875,-2.6875c0,-1.48022 -1.19678,-2.6875 -2.6875,-2.6875zM147.8125,102.125c-1.49072,0 -2.6875,1.20728 -2.6875,2.6875c0,1.48022 1.19678,2.6875 2.6875,2.6875h5.375c1.49072,0 2.6875,-1.20728 2.6875,-2.6875c0,-1.48022 -1.19678,-2.6875 -2.6875,-2.6875zM18.8125,115.5625c-1.49072,0 -2.6875,1.20728 -2.6875,2.6875c0,1.48022 1.19678,2.6875 2.6875,2.6875h5.375c1.49072,0 2.6875,-1.20728 2.6875,-2.6875c0,-1.48022 -1.19678,-2.6875 -2.6875,-2.6875zM147.8125,115.5625c-1.49072,0 -2.6875,1.20728 -2.6875,2.6875c0,1.48022 1.19678,2.6875 2.6875,2.6875h5.375c1.49072,0 2.6875,-1.20728 2.6875,-2.6875c0,-1.48022 -1.19678,-2.6875 -2.6875,-2.6875zM74.56763,134.375h22.86474l6.4563,21.5h-35.77734z"></path>
                    </g>
                  </g>
                </svg>
                Pending Orders</button></a>

          </div>

          <div class="col-12 mb-2">
            <a href='manageorders.php?status=2'><button type="button" class="btn btn-block btn-primary btn-lg text-left">
                <svg class="icon1 mr-2" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="32" height="32" viewBox="0 0 172 172" style=" fill:#000000;">
                  <g fill="none" fill-rule="nonzero" stroke="none" stroke-width="1" stroke-linecap="butt" stroke-linejoin="miter" stroke-miterlimit="10" stroke-dasharray="" stroke-dashoffset="0" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode: normal">
                    <path d="M0,172v-172h172v172z" fill="none"></path>
                    <g fill="#ffffff">
                      <path d="M21.5,16.125c-2.96431,0 -5.375,2.41069 -5.375,5.375v129c0,2.96431 2.41069,5.375 5.375,5.375h129c2.96431,0 5.375,-2.41069 5.375,-5.375v-129c0,-2.96431 -2.41069,-5.375 -5.375,-5.375zM21.5,21.5h129l0.00525,129h-129.00525zM37.625,37.625c-2.96431,0 -5.375,2.41069 -5.375,5.375v21.5c0,2.96431 2.41069,5.375 5.375,5.375h21.5c2.96431,0 5.375,-2.41069 5.375,-5.375v-7.84204c0,-1.4835 -1.204,-2.6875 -2.6875,-2.6875c-1.4835,0 -2.6875,1.204 -2.6875,2.6875v7.84204h-21.5v-21.5h16.125c1.4835,0 2.6875,-1.204 2.6875,-2.6875c0,-1.4835 -1.204,-2.6875 -2.6875,-2.6875zM65.84375,38.96875c-0.68733,0 -1.37474,0.26195 -1.90015,0.78735l-15.5686,15.5686l-3.47485,-3.47485c-1.05081,-1.05081 -2.74948,-1.05081 -3.80029,0c-1.05081,1.05081 -1.05081,2.74948 0,3.80029l5.375,5.375c0.52406,0.52406 1.21215,0.78735 1.90015,0.78735c0.688,0 1.37608,-0.26329 1.90015,-0.78735l17.46875,-17.46875c1.05081,-1.05081 1.05081,-2.74948 0,-3.80029c-0.52541,-0.52541 -1.21282,-0.78735 -1.90015,-0.78735zM77.9375,43c-1.4835,0 -2.6875,1.204 -2.6875,2.6875c0,1.4835 1.204,2.6875 2.6875,2.6875h59.125c1.4835,0 2.6875,-1.204 2.6875,-2.6875c0,-1.4835 -1.204,-2.6875 -2.6875,-2.6875zM77.9375,53.75c-1.4835,0 -2.6875,1.204 -2.6875,2.6875c0,1.4835 1.204,2.6875 2.6875,2.6875h43c1.4835,0 2.6875,-1.204 2.6875,-2.6875c0,-1.4835 -1.204,-2.6875 -2.6875,-2.6875zM37.625,86c-2.96431,0 -5.375,2.41069 -5.375,5.375v21.5c0,2.96431 2.41069,5.375 5.375,5.375h21.5c2.96431,0 5.375,-2.41069 5.375,-5.375v-7.84204c0,-1.4835 -1.204,-2.6875 -2.6875,-2.6875c-1.4835,0 -2.6875,1.204 -2.6875,2.6875v7.84204h-21.5v-21.5h16.125c1.4835,0 2.6875,-1.204 2.6875,-2.6875c0,-1.4835 -1.204,-2.6875 -2.6875,-2.6875zM65.84375,87.34375c-0.68733,0 -1.37474,0.26195 -1.90015,0.78735l-15.5686,15.5686l-3.47485,-3.47485c-1.05081,-1.05081 -2.74948,-1.05081 -3.80029,0c-1.05081,1.05081 -1.05081,2.74948 0,3.80029l5.375,5.375c0.52406,0.52406 1.21215,0.78735 1.90015,0.78735c0.688,0 1.37608,-0.26329 1.90015,-0.78735l17.46875,-17.46875c1.05081,-1.05081 1.05081,-2.74948 0,-3.80029c-0.52541,-0.52541 -1.21282,-0.78735 -1.90015,-0.78735zM77.9375,91.375c-1.4835,0 -2.6875,1.204 -2.6875,2.6875c0,1.4835 1.204,2.6875 2.6875,2.6875h26.875c1.4835,0 2.6875,-1.204 2.6875,-2.6875c0,-1.4835 -1.204,-2.6875 -2.6875,-2.6875zM115.5625,91.375c-1.4835,0 -2.6875,1.204 -2.6875,2.6875c0,1.4835 1.204,2.6875 2.6875,2.6875h21.5c1.4835,0 2.6875,-1.204 2.6875,-2.6875c0,-1.4835 -1.204,-2.6875 -2.6875,-2.6875zM77.9375,102.125c-1.4835,0 -2.6875,1.204 -2.6875,2.6875c0,1.4835 1.204,2.6875 2.6875,2.6875h21.5c1.4835,0 2.6875,-1.204 2.6875,-2.6875c0,-1.4835 -1.204,-2.6875 -2.6875,-2.6875zM32.25,134.375c-1.4835,0 -2.6875,1.204 -2.6875,2.6875v5.375c0,1.4835 1.204,2.6875 2.6875,2.6875c1.4835,0 2.6875,-1.204 2.6875,-2.6875v-5.375c0,-1.4835 -1.204,-2.6875 -2.6875,-2.6875zM45.6875,134.375c-1.4835,0 -2.6875,1.204 -2.6875,2.6875v5.375c0,1.4835 1.204,2.6875 2.6875,2.6875c1.4835,0 2.6875,-1.204 2.6875,-2.6875v-5.375c0,-1.4835 -1.204,-2.6875 -2.6875,-2.6875zM59.125,134.375c-1.4835,0 -2.6875,1.204 -2.6875,2.6875v5.375c0,1.4835 1.204,2.6875 2.6875,2.6875c1.4835,0 2.6875,-1.204 2.6875,-2.6875v-5.375c0,-1.4835 -1.204,-2.6875 -2.6875,-2.6875zM72.5625,134.375c-1.4835,0 -2.6875,1.204 -2.6875,2.6875v5.375c0,1.4835 1.204,2.6875 2.6875,2.6875c1.4835,0 2.6875,-1.204 2.6875,-2.6875v-5.375c0,-1.4835 -1.204,-2.6875 -2.6875,-2.6875zM86,134.375c-1.4835,0 -2.6875,1.204 -2.6875,2.6875v5.375c0,1.4835 1.204,2.6875 2.6875,2.6875c1.4835,0 2.6875,-1.204 2.6875,-2.6875v-5.375c0,-1.4835 -1.204,-2.6875 -2.6875,-2.6875zM99.4375,134.375c-1.4835,0 -2.6875,1.204 -2.6875,2.6875v5.375c0,1.4835 1.204,2.6875 2.6875,2.6875c1.4835,0 2.6875,-1.204 2.6875,-2.6875v-5.375c0,-1.4835 -1.204,-2.6875 -2.6875,-2.6875zM112.875,134.375c-1.4835,0 -2.6875,1.204 -2.6875,2.6875v5.375c0,1.4835 1.204,2.6875 2.6875,2.6875c1.4835,0 2.6875,-1.204 2.6875,-2.6875v-5.375c0,-1.4835 -1.204,-2.6875 -2.6875,-2.6875zM126.3125,134.375c-1.4835,0 -2.6875,1.204 -2.6875,2.6875v5.375c0,1.4835 1.204,2.6875 2.6875,2.6875c1.4835,0 2.6875,-1.204 2.6875,-2.6875v-5.375c0,-1.4835 -1.204,-2.6875 -2.6875,-2.6875zM139.75,134.375c-1.4835,0 -2.6875,1.204 -2.6875,2.6875v5.375c0,1.4835 1.204,2.6875 2.6875,2.6875c1.4835,0 2.6875,-1.204 2.6875,-2.6875v-5.375c0,-1.4835 -1.204,-2.6875 -2.6875,-2.6875z"></path>
                    </g>
                  </g>
                </svg>
                Issued Orders</button></a>

          </div>

          <div class="col-12 mb-2">
            <a href='manageorders.php?status=3'><button type="button" class="btn btn-block btn-danger btn-lg text-left">
                <svg class="icon1 mr-2" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="32" height="32" viewBox="0 0 172 172" style=" fill:#000000;">
                  <g fill="none" fill-rule="nonzero" stroke="none" stroke-width="1" stroke-linecap="butt" stroke-linejoin="miter" stroke-miterlimit="10" stroke-dasharray="" stroke-dashoffset="0" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode: normal">
                    <path d="M0,172v-172h172v172z" fill="none"></path>
                    <g fill="#ffffff">
                      <path d="M86,0.23621c-5.54566,0 -11.09362,1.71358 -15.80481,5.13879l-7.25415,5.375h-38.75354c-4.45319,0 -8.0625,3.60931 -8.0625,8.0625v139.75c0,4.45319 3.60931,8.0625 8.0625,8.0625h123.625c4.45319,0 8.0625,-3.60931 8.0625,-8.0625v-139.75c0,-4.45319 -3.60931,-8.0625 -8.0625,-8.0625h-38.75354l-7.25415,-5.375c-4.71119,-3.42522 -10.25915,-5.13879 -15.80481,-5.13879zM86,5.71619c4.44311,0 8.88874,1.37251 12.66065,4.12048l1.25977,0.91333l7.36438,5.375l2.25708,1.6377c2.064,1.49425 3.29819,3.87705 3.33313,6.4248v5.375c0,1.4835 -1.204,2.6875 -2.6875,2.6875h-48.375c-1.4835,0 -2.6875,-1.204 -2.6875,-2.6875v-5.375c0,-2.58537 1.23957,-5.01404 3.33313,-6.52979l2.25708,-1.53271l7.36438,-5.375l1.25977,-0.91333c3.77191,-2.74797 8.21754,-4.12048 12.66065,-4.12048zM86,10.58728c-2.96853,0 -5.375,2.40647 -5.375,5.375c0.0015,0.02976 0.00325,0.0595 0.00525,0.08923c-0.00192,0.02448 -0.00367,0.04898 -0.00525,0.07349c0,2.96853 2.40647,5.375 5.375,5.375c2.96853,0 5.375,-2.40647 5.375,-5.375c-0.0015,-0.02976 -0.00325,-0.0595 -0.00525,-0.08923c0.00192,-0.02448 0.00367,-0.04898 0.00525,-0.07349c0,-2.96853 -2.40647,-5.375 -5.375,-5.375zM24.1875,16.125h32.25c-1.74419,2.32469 -2.6875,5.15462 -2.6875,8.0625v2.6875h-16.125c-2.96969,0 -5.375,2.40531 -5.375,5.375v112.875c0,2.96969 2.40531,5.375 5.375,5.375h75.70667c2.13656,-0.00269 4.18481,-0.85425 5.69519,-2.36731l18.35584,-18.35584c1.51306,-1.51037 2.36462,-3.55863 2.36731,-5.69519v-91.83167c0,-2.96969 -2.40531,-5.375 -5.375,-5.375h-16.125v-2.6875c0,-2.90788 -0.94331,-5.73781 -2.6875,-8.0625h32.25c1.4835,0 2.6875,1.204 2.6875,2.6875v139.75c0,1.4835 -1.204,2.6875 -2.6875,2.6875h-123.625c-1.4835,0 -2.6875,-1.204 -2.6875,-2.6875v-139.75c0,-1.4835 1.204,-2.6875 2.6875,-2.6875zM37.625,32.25h16.60791c1.13681,3.21425 4.17184,5.36425 7.57959,5.375h48.375c3.40775,-0.01075 6.44278,-2.16075 7.57959,-5.375h16.60791v91.375h-16.125c-2.96969,0 -5.375,2.40531 -5.375,5.375v16.125h-75.25zM45.6875,43c-1.4835,0 -2.6875,1.204 -2.6875,2.6875v5.375c0,1.4835 1.204,2.6875 2.6875,2.6875c1.4835,0 2.6875,-1.204 2.6875,-2.6875v-5.375c0,-1.4835 -1.204,-2.6875 -2.6875,-2.6875zM59.125,43c-1.4835,0 -2.6875,1.204 -2.6875,2.6875v5.375c0,1.4835 1.204,2.6875 2.6875,2.6875c1.4835,0 2.6875,-1.204 2.6875,-2.6875v-5.375c0,-1.4835 -1.204,-2.6875 -2.6875,-2.6875zM72.5625,43c-1.4835,0 -2.6875,1.204 -2.6875,2.6875v5.375c0,1.4835 1.204,2.6875 2.6875,2.6875c1.4835,0 2.6875,-1.204 2.6875,-2.6875v-5.375c0,-1.4835 -1.204,-2.6875 -2.6875,-2.6875zM86,43c-1.4835,0 -2.6875,1.204 -2.6875,2.6875v5.375c0,1.4835 1.204,2.6875 2.6875,2.6875c1.4835,0 2.6875,-1.204 2.6875,-2.6875v-5.375c0,-1.4835 -1.204,-2.6875 -2.6875,-2.6875zM99.4375,43c-1.4835,0 -2.6875,1.204 -2.6875,2.6875v5.375c0,1.4835 1.204,2.6875 2.6875,2.6875c1.4835,0 2.6875,-1.204 2.6875,-2.6875v-5.375c0,-1.4835 -1.204,-2.6875 -2.6875,-2.6875zM112.875,43c-1.4835,0 -2.6875,1.204 -2.6875,2.6875v5.375c0,1.4835 1.204,2.6875 2.6875,2.6875c1.4835,0 2.6875,-1.204 2.6875,-2.6875v-5.375c0,-1.4835 -1.204,-2.6875 -2.6875,-2.6875zM126.3125,43c-1.4835,0 -2.6875,1.204 -2.6875,2.6875v5.375c0,1.4835 1.204,2.6875 2.6875,2.6875c1.4835,0 2.6875,-1.204 2.6875,-2.6875v-5.375c0,-1.4835 -1.204,-2.6875 -2.6875,-2.6875zM86,61.8125c-16.29969,0 -29.5625,13.26281 -29.5625,29.5625c0,16.29969 13.26281,29.5625 29.5625,29.5625c16.29969,0 29.5625,-13.26281 29.5625,-29.5625c0,-16.29969 -13.26281,-29.5625 -29.5625,-29.5625zM86,67.1875c13.33806,0 24.1875,10.84944 24.1875,24.1875c0,13.33806 -10.84944,24.1875 -24.1875,24.1875c-13.33806,0 -24.1875,-10.84944 -24.1875,-24.1875c0,-13.33806 10.84944,-24.1875 24.1875,-24.1875zM99.77344,80.28906c-0.68733,0 -1.37474,0.26195 -1.90015,0.78735l-14.56079,14.56079l-6.16235,-6.16235c-1.05081,-1.05081 -2.74948,-1.05081 -3.80029,0c-1.05081,1.05081 -1.05081,2.74948 0,3.80029l8.0625,8.0625c0.52406,0.52406 1.21215,0.78735 1.90015,0.78735c0.688,0 1.37608,-0.26329 1.90015,-0.78735l16.46094,-16.46094c1.05081,-1.05081 1.05081,-2.74948 0,-3.80029c-0.52541,-0.52541 -1.21282,-0.78735 -1.90015,-0.78735zM118.25,129h12.33521l-12.33521,12.33521z"></path>
                    </g>
                  </g>
                </svg>
                Completed Orders</button></a>

          </div>


        </div> <!-- END main div for all WIDGETS  -->
      </div>

    </div>



  <?php } ?>
  <!-- ----------------------------------------------------------------------- -->

  <?php $permissions = array("admin");
  if (in_array($_SESSION['usertype'], $permissions)) {

    $ordertotal = "";
    $query = "SELECT COUNT(*) as total FROM orders WHERE issued<2";
    if ($result = $mysqli->query($query)) {
      $objectname = $result->fetch_object();
      $ordertotal = $objectname->total;
    }

  ?>



  <?php } ?>
  <!-- ----------------------------------------------------------------------- -->

<?php } else { ?>






  <div class="row pt-3">
    <?php $permissions = array("admin");
    if (in_array($_SESSION['usertype'], $permissions)) { ?>

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

    <?php } ?>
    <!-- ----------------------------------------------------------------------- -->

    <?php $permissions = array("admin");
    if (in_array($_SESSION['usertype'], $permissions)) { ?>

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

    <?php } ?>
    <!-- ----------------------------------------------------------------------- -->

    <?php $permissions = array("dealer", "shop", "salesrep");
    if (in_array($_SESSION['usertype'], $permissions)) { ?>
      <?php if (!in_array(1, $_SESSION['permissions'])) { ?>

        <?php } else { ?>
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
      <?php } ?>


    <?php } ?>
    <!-- ----------------------------------------------------------------------- -->

    <?php $permissions = array("admin", "dealer", "shop", "salesrep", "storeskeeper");
    if (in_array($_SESSION['usertype'], $permissions)) { ?>

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

    <?php } ?>
    <!-- ----------------------------------------------------------------------- -->

    <?php $permissions = array("admin", "salesrep");
    if (in_array($_SESSION['usertype'], $permissions)) { ?>

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

    <?php } ?>
    <!-- ----------------------------------------------------------------------- -->

    <?php $permissions = array("admin", "dealer");
    if (in_array($_SESSION['usertype'], $permissions)) { ?>

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

    <?php } ?>
    <!-- ----------------------------------------------------------------------- -->

    <?php $permissions = array("salesrep", "storeskeeper");
    if (in_array($_SESSION['usertype'], $permissions)) { ?>

      <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-danger">
          <div class="inner">
            <h3>..</h3>

            <h5>&nbsp;Manage &nbsp;&nbsp;Main Inventory</h5>
          </div>
          <div class="icon">
            <i class="fas fa-store-alt"></i>
          </div>
          <a href="managemaininventory.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>

    <?php } ?>
    <!-- ----------------------------------------------------------------------- -->

    <?php $permissions = array("admin");
    if (in_array($_SESSION['usertype'], $permissions)) { ?>

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

    <?php } ?>
    <!-- ----------------------------------------------------------------------- -->

    <?php $permissions = array("admin");
    if (in_array($_SESSION['usertype'], $permissions)) { ?>

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

    <?php } ?>
    <!-- ----------------------------------------------------------------------- -->

    <?php $permissions = array("admin", "dealer", "shop", "salesrep");
    if (in_array($_SESSION['usertype'], $permissions)) { ?>

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

    <?php } ?>
    <!-- ----------------------------------------------------------------------- -->

    <?php $permissions = array("admin");
    if (in_array($_SESSION['usertype'], $permissions)) { ?>

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

    <?php } ?>
    <!-- ----------------------------------------------------------------------- -->

    <?php $permissions = array("admin");
    if (in_array($_SESSION['usertype'], $permissions)) { ?>

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

    <?php } ?>
    <!-- ----------------------------------------------------------------------- -->

    <?php $permissions = array("admin", "dealer", "shop", "technician");
    if (in_array($_SESSION['usertype'], $permissions)) { ?>

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

    <?php } ?>
    <!-- ----------------------------------------------------------------------- -->

    <?php $permissions = array("admin", "dealer", "shop", "technician");
    if (in_array($_SESSION['usertype'], $permissions)) { ?>

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

    <?php } ?>
    <!-- ----------------------------------------------------------------------- -->

    <?php $permissions = array("admin", "salesrep");
    if (in_array($_SESSION['usertype'], $permissions)) { ?>

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

    <?php } ?>
    <!-- ----------------------------------------------------------------------- -->

    <?php $permissions = array("admin", "salesrep");
    if (in_array($_SESSION['usertype'], $permissions)) { ?>

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
          <a href="pending_job_report.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>

    <?php } ?>
    <!-- ----------------------------------------------------------------------- -->

    <?php $permissions = array("admin", "salesrep");
    if (in_array($_SESSION['usertype'], $permissions)) { ?>

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
          <a href="complete_job_report.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>

    <?php } ?>
    <!-- ----------------------------------------------------------------------- -->

  <?php }  ?>
  </div>

  <!-- ./col -->

  <!-- <div class="col-12 text-center text-primary" id="clockdiv">-->
  <!--</div>  -->

  <!--            <div class="alert alert-primary" id="clockdiv">
          </div>   -->



  <script type="text/javascript">
    $(document).ready(function() {
      startTime();

      function startTime() {

        var days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
        var months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

        var today = new Date();
        var h = today.getHours();
        var m = today.getMinutes();
        var s = today.getSeconds();
        var daynumber = today.getDate();
        var day = days[today.getDay()];
        var month = months[today.getMonth()];
        var year = today.getFullYear();
        m = checkTime(m);
        s = checkTime(s);
        daynumber = checkTime(daynumber);
        document.getElementById('clockdiv').innerHTML = "<h4>" + day + ", " + daynumber + " " + month + " " + year + " " +
          h + ":" + m + ":" + s + "</h4>";
        var t = setTimeout(startTime, 500);
      }

      function checkTime(i) {
        if (i < 10) {
          i = "0" + i
        }; // add zero in front of numbers < 10
        return i;
      }

    });
  </script>

  <?php require_once "common/footer.php" ?>