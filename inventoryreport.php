<?php
require_once "common/header.php" ;
require_once("common/database.php");

?>
<?php
$permissions = array("admin", "salesrep","accountant","director","operator");

if (!(in_array($_SESSION['usertype'], $permissions))) {
  header("Location: index.php");
}

?>
<?php require_once "common/nav.php" ?>
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

    <!-- jQuery (required by DataTables) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<style>
  #udaratable {
    /*font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;*/
    border-collapse: collapse;
    width: 100%;
  }

  #udaratable td,
  #udaratable th {
    border: 1px solid #ddd;
    padding: 8px;
  }

  #udaratable tr:nth-child(even) {
    background-color: #f2f2f2;
  }

  #udaratable tr:hover {
    background-color: #ddd;
  }

  #udaratable th {
    padding-top: 12px;
    padding-bottom: 12px;
    text-align: left;
    background-color: #4CAF50;
    color: white;
  }
</style>


<!-- <h5>Pending Jobs Report</h5> -->



<div class="row">
<!--    <div class="col-6 col-md-3 d-print-none px-3 mt-4">-->
<!--        <select name="shop" id="shop" onchange="getShopInventory()">-->
<!--            <option value="">Select Shop</option>-->
<!--            --><?php
//            $sql = "SELECT * FROM user where shopname !='' and shopname!='jjj'";
//            $result = $mysqli->query($sql);
//            while ($shop = $result->fetch_object()) {
//                echo "<option value=\"{$shop->id}\">{$shop->shopname}</option>";
//            }
//            ?>
<!--        </select>-->
<!---->
<!--    </div>-->
  <div class="col-6 mt-4 d-print-none">
      <form action="process/generateorderspdf.php" method="POST">
      <input type="hidden" id="printdatastring" name="printdatastring" value=""> &nbsp; &nbsp;
      <button type="button" class="btn btn-primary ml-3 float-right" onclick='window.print()'>Print</button>
      <button type="submit" class="btn btn-primary float-right">PDF</button>
    </form>
  </div>
</div>
    <div class="row">
  <div class="col-12" id="reporttable">
  </div>
</div>
 <div class="row">
  <div class="col-12" id="linkarea">

  </div>
</div>
    <script>
        $(document).ready(function () {
            $('#udaratable').DataTable();
        });
    </script>

<script>
  $(document).ready(function() {
    getpendingjosbreport();

    function getpendingjosbreport() {
      var jobstatus = $("#status").val();
      $.ajax({
        type: 'POST',
        async: false,
        url: 'process/getinventoryreport.php?status=3',
        data: {
          dealerid: $("#dealerid").val(),
          techid: $("#techid").val(),
          dealername: $("#dealerid option:selected").text(),
          orderstatus: $("#status option:selected").text(),
          from: $("#from").val(),
          to: $("#to").val(),
          modelid: $("#modelid").val()
        },
        dataType: 'html',
        success: function(data) {
            $("#reporttable").html(data);
            $("#printdatastring").val(data);
            $('#udaratable').DataTable(); // Initialize after loading

        },
        error: function() {
          alert('An unknown error occoured, Please try again Later...!');

        }
      });

    }

    $("#dealerid").change(function() {
      getpendingjosbreport();
    });

    $("#techid").change(function() {
      getpendingjosbreport();
    });

    $("#from").change(function() {
      getpendingjosbreport();
    });

    $("#to").change(function() {
      getpendingjosbreport();
    });

    $("#status").change(function() {
      getpendingjosbreport();
    });

    $("#modelid").change(function() {
      getpendingjosbreport();
    });


    var dateFormat = "mm/dd/yy",
      from = $("#from")
      .datepicker({
        dateFormat: "yy-mm-dd",
        defaultDate: 0,
        maxDate: 0,
        changeMonth: true,
        changeYear: true,
        numberOfMonths: 3
      })
      .on("change", function() {
        to.datepicker("option", "minDate", getDate(this));
      }),
      to = $("#to").datepicker({
        dateFormat: "yy-mm-dd",
        defaultDate: 0,
        maxDate: 0,
        changeMonth: true,
        changeYear: true,
        numberOfMonths: 3
      })
      .on("change", function() {
        from.datepicker("option", "maxDate", getDate(this));
      });

    function getDate(element) {
      var date;
      try {
        date = $.datepicker.parseDate(dateFormat, element.value);
      } catch (error) {
        date = null;
      }

      return date;
    }

  });
</script>
    <script>
        function getShopInventory(){
            alert();
            let selected_shop =document.getElementById('shop').value;
            $.ajax({
                url:'process/getinventoryreport.php',
                method:'POST',
                data:{
                    command:'selectShop',
                    shop:selected_shop
                },
                success: function(data) {
                    $("#reporttable").html(data);
                    $("#printdatastring").val(data);
                    $('#udaratable').DataTable();

                },
                error: function() {
                    alert('An unknown error occoured, Please try again Later...!');

                }

            });
        }
    </script>

<?php require_once "common/footer.php" ?>