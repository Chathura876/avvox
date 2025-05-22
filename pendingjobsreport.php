<?php require_once "common/header.php" ?>
<?php
$permissions = array("admin", "salesrep");

if (!(in_array($_SESSION['usertype'], $permissions))){
    header("Location: index.php");  
}

?>
<?php require_once "common/nav.php" ?>

<style>
#udaratable {
  /*font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;*/
  border-collapse: collapse;
  width: 100%;
}

#udaratable td, #udaratable th {
  border: 1px solid #ddd;
  padding: 8px;
}

#udaratable tr:nth-child(even){background-color: #f2f2f2;}

#udaratable tr:hover {background-color: #ddd;}

#udaratable th {
  padding-top: 12px;
  padding-bottom: 12px;
  text-align: left;
  background-color: #4CAF50;
  color: white;
}
</style>


<!-- <h5>Pending Jobs Report</h5> -->
<form>
<div class="row">
  <div class="form-group col-md-6 d-print-none">
    <label for="dealerid">Dealer</label>
    <select class="form-control" id="dealerid" name="dealerid">
    <option value='0'>All</option>
    <?php
    $query = "SELECT id, shopname FROM user WHERE usertype IN ('dealer', 'shop') ORDER BY shopname ASC";
    if ($result = $mysqli->query($query)) {
      while ($objectname = $result->fetch_object()) {
           echo "<option value='$objectname->id'>$objectname->shopname</option>";
      }
    }
    ?>
    </select>
  </div>

    <div class="form-group col-md-6 d-print-none">
    <label for="techid">Technician</label>
    <select class="form-control" id="techid" name="techid">
    <option value='0'>All</option>
    <?php
    $query = "SELECT id, fullname FROM user WHERE usertype='technician' ORDER BY fullname ASC";
    if ($result = $mysqli->query($query)) {
      while ($objectname = $result->fetch_object()) {
           echo "<option value='$objectname->id'>$objectname->fullname</option>";
      }
    }
    ?>
    </select>
  </div>
</div>

<div class="row">
  <div class="form-group col-md-6 d-print-none">
    <label for="dealerid">Start Date</label>
    <input type="text"  class="form-control" id="from" name="from" value="<?php echo date('Y-m-d', strtotime('-1 month')) ?>" data-validation-engine="validate[required]">
  </div>

    <div class="form-group col-md-6 d-print-none">
    <label for="techid">End Date</label>
    <input type="text"  class="form-control" id="to" name="to" value="<?php echo date('Y-m-d') ?>"data-validation-engine="validate[required]">
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


</form>

 <script>
$( document ).ready(function() {
  getpendingjosbreport();
  function getpendingjosbreport(){
        $.ajax({
          type: 'POST',
          async: false,
          url: 'process/getjobsreport.php?status=1',
          data: { dealerid: $("#dealerid").val(), 
          techid: $("#techid").val(),
          dealername: $( "#dealerid option:selected" ).text() , 
          techname: $( "#techid option:selected" ).text(),
          from: $("#from").val(),
          to: $("#to").val()
        },
          dataType: 'html',
          success: function (data) {
            $("#reporttable").html(data);

          },
          error: function () {
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



    var dateFormat = "mm/dd/yy",
      from = $( "#from" )
        .datepicker({
          dateFormat: "yy-mm-dd",
          defaultDate: 0,
          maxDate: 0,
          changeMonth: true,
          changeYear: true,
          numberOfMonths: 3
        })
        .on( "change", function() {
          to.datepicker( "option", "minDate", getDate( this ) );
        }),
      to = $( "#to" ).datepicker({
        dateFormat: "yy-mm-dd",
        defaultDate: 0,
        maxDate: 0,
        changeMonth: true,
        changeYear: true,
        numberOfMonths: 3
      })
      .on( "change", function() {
        from.datepicker( "option", "maxDate", getDate( this ) );
      });
 
    function getDate( element ) {
      var date;
      try {
        date = $.datepicker.parseDate( dateFormat, element.value );
      } catch( error ) {
        date = null;
      }
 
      return date;
    }  

});
</script>


<?php require_once "common/footer.php" ?>