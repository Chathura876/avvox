<?php require_once "common/header.php" ?>
<?php
$permissions = array("admin","accountant","operator");

if (!(in_array($_SESSION['usertype'], $permissions))) {
  header("Location: index.php");
}

?>
<?php require_once "common/nav.php" ?>

<div class="row">

  <div class="col-12">
    <h5>Topup History</h5>
  </div>

</div>



<form>
  <div class="row">
    <div class="form-group col-md-4 d-print-none">
      <label for="modelid">Model</label>
      <select class="form-control" id="modelid" name="modelid">
        <option value='0'>All</option>
        <?php
        $query = "SELECT * FROM product ORDER BY model ASC";
        if ($result = $mysqli->query($query)) {
          while ($objectname = $result->fetch_object()) {
            echo "<option value='$objectname->id'>$objectname->model</option>";
          }
        }
        ?>
      </select>
    </div>

    <div class="form-group col-md-4 d-print-none">
      <label for="from">Start Date</label>
      <input type="text" class="form-control" id="from" name="from" value="<?php echo date('Y-m-d', strtotime('-1 month')) ?>" data-validation-engine="validate[required]">
    </div>

    <div class="form-group col-md-4 d-print-none">
      <label for="to">End Date</label>
      <input type="text" class="form-control" id="to" name="to" value="<?php echo date('Y-m-d') ?>" data-validation-engine="validate[required]">
    </div>
  </div>
</form>




<div class="row">

  <div class="col-12">
    <div id="PeopleTableContainer" style="width: 100%"></div>
  </div>

</div>



<!-- Modal -->
<div class="modal fade" id="ordersmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">View All Order Items</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id='ordersmodalbody'>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>



<script type="text/javascript">
  function checkusername(field, rules, i, options) {
    //alert(field.val());
    var taken = false;
    $.ajax({
      type: 'POST',
      async: false,
      url: 'process/checkusername.php',
      data: {
        username: field.val()
      },
      dataType: 'html',
      success: function(data) {
        //alert(data);
        if (data == 'taken') {
          taken = true;
          //alert("Username taken");

        } else {
          //alert("Username available");
        }
      },
      error: function() {
        alert('An unknown error occoured, Please try again Later...!');

      }
    });


    if (taken == true) {
      return "Username already taken, Try another value";
    }
  }
  //==================================================
  function checklengthequals(field, rules, i, options) {
    //alert(rules);
    if (field.val().length != 10) {
      return "* Number must have exactly 10 digits";
    }

  }
</script>




<script type="text/javascript">
  $(document).ready(function() {


    function reloaddata() {
      $('#PeopleTableContainer').jtable('load', {
        Name: $('#name').val(),
        modelid: $('#modelid').val(),
        from: $('#from').val(),
        to: $('#to').val()
      });
    }



    $("#modelid, #from, #to").change(function() {
      reloaddata();
    });

    //Prepare jTable
    $('#PeopleTableContainer').jtable({
      //title: 'a',
      paging: true, //Enable paging
      pageSize: 10, //Set page size (default: 10)
      sorting: true, //Enable sorting
      defaultSorting: 'topupid DESC', //Set default sorting
      dialogShowEffect: 'explode',
      dialogHideEffect: 'explode',
      saveUserPreferences: false,
      actions: {
        listAction: 'process/inventoryhistory.inc.php?action=list'
      },
      toolbar: {
        items: [
          //   {
          //     //icon: '/images/excel.png',
          //     text: 'View All Orders',
          //     click: function () {
          //     	$(this).addClass("btn btn-primary");
          //       $.ajax({
          //         type: 'POST',
          //         async: false,
          //         url: 'process/getpendingorderitems.php',
          //         dataType: 'html',
          //         success: function (data) {
          //           //alert(data);
          //           $("#ordersmodalbody").html(data);
          //           $('#ordersmodal').modal('show');
          //           //alert($(button).attr("data-shopname"));

          //         },
          //         error: function () {
          //             alert('An unknown error occured, Please try again Later...!');

          //         }
          //       });		        	
          //     }
          // }
        ]
      },
      fields: {
        topupid: {
          title: 'ID',
          key: true,
          create: false,
          edit: false,
          width: '10%',
          list: true //show in table or not
        },
        topupdate: {
          title: 'Order Date',
          //width: '25%',
          edit: false
        },
        model: {
          title: 'Model',
          //width: '25%',
          edit: false
        },
        quantity: {
          title: 'Quantity',
          //width: '25%',
          edit: false
        },
        note: {
          title: 'Note',
          type: 'textarea',
          edit: false
        },
        fullname: {
          title: 'Added By',
          //width: '10%',
          edit: false
        }
      },
      //Initialize validation logic when a form is created
      formCreated: function(event, data) {
        data.form.find('input[name="fullname"]').addClass('validate[required]');
        data.form.find('input[name="shopname"]').addClass('validate[required]');
        data.form.find('input[name="nic"]').addClass('validate[required]');
        data.form.find('textarea[name="address"]').addClass('validate[required]');
        data.form.find('input[name="phone1"]').addClass('validate[required,custom[number], funcCall[checklengthequals]]');
        data.form.find('input[name="phone2"]').addClass('validate[required,custom[number], funcCall[checklengthequals]]');
        data.form.find('input[name="username"]').addClass('validate[required,funcCall[checkusername]]');
        data.form.find('input[name="password"]').addClass('validate[required, minSize[6]]');
        //data.form.validationEngine();
        data.form.validationEngine({
          promptPosition: "inline"
        });
      },
      //Validate form when it is being submitted
      formSubmitting: function(event, data) {
        return data.form.validationEngine('validate');
      },
      //Dispose validation logic when form is closed
      formClosed: function(event, data) {
        data.form.validationEngine('hide');
        data.form.validationEngine('detach');
      }
    });

    //Load person list from server at the begining
    /*      $('#PeopleTableContainer').jtable('load',{
            orderstatus: $('#orderstatus').val()
          });*/

    //Load person list from server at the begining
    reloaddata();

    //Re-load records when user click 'load records' button.
    $('#LoadRecordsButton').click(function(e) {
      e.preventDefault();
      $('#PeopleTableContainer').jtable('load', {
        // Name: $('#name').val(),
        // cityId: $('#cityId').val()
        Name: $('#name').val()
      });
    });


    $('#orderstatus').change(function(e) {
      e.preventDefault();
      $('#PeopleTableContainer').jtable('load', {
        Name: $('#name').val(),
        orderstatus: $('#orderstatus').val()
      });
    });


    //Re-load records when user click 'load records' button.
    $('#name').keyup(function(e) {
      e.preventDefault();
      reloaddata();

    });
    //Load all records when page is first shown
    //$('#LoadRecordsButton').click();

    $('#exampleModal').on('show.bs.modal', function(event) {
      var button = $(event.relatedTarget) // Button that triggered the modal
      var recipient = button.data('whatever') // Extract info from data-* attributes
      // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
      // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
      var modal = $(this)
      //modal.find('.modal-title').text('New message to ' + recipient)
      //modal.find('.modal-body input').val(recipient)

      $.ajax({
        type: 'POST',
        async: false,
        url: 'process/getorderdetails.php',
        data: {
          orderid: button.val()
        },
        dataType: 'html',
        success: function(data) {
          //alert(data);
          $("#akatablearea").html(data);

          if (data == 'taken') {
            taken = true;
            //alert("Username taken");

          } else {
            //alert("Username available");
          }
        },
        error: function() {
          alert('An unknown error occoured, Please try again Later...!');

        }
      });



    })



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
</script>


<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Order Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>
          <div class="form-group">
            <div id="akatablearea"> Hello</div>

          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>


<script>


</script>

<?php require_once "common/footer.php" ?>