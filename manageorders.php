<?php require_once "common/header.php" ?>
<?php
$permissions = array("admin", "dealer", "shop", "salesrep", "accountant", "storeskeeper", "director", "operator");

if (!(in_array($_SESSION['usertype'], $permissions))) {
  header("Location: index.php");
}

?>
<?php require_once "common/nav.php" ?>

<div class="row">

  <?php if (isset($_GET['action'])) {

    if ($_GET['action'] == "issuecomplete") { ?>
      <div class='col-12' id='successmessage' style='display:none'>
        <div class='alert alert-success' role='alert'>
          <b>Order Successfully Issued.</b>
          <a class="btn btn-success btn-sm my-1" style="color:white" target="_blank" href="generateinvoice.php?orderid=<?php echo $_GET['orderid'] ?>" role="button">Invoice</a>
          <a class="btn btn-success btn-sm my-1" style="color:white" target="_blank" href="generatedeliveryorder.php?orderid=<?php echo $_GET['orderid'] ?>" role="button">Delivery Order</a>
        </div>
      </div>

    <?php } else if ($_GET['action'] == "editcomplete") { ?>
      <div class='col-12' id='successmessage' style='display:none'>
        <div class='alert alert-success' role='alert'>
          <b>Order Successfully Edited.</b>
        </div>
      </div>

    <?php } else if ($_GET['action'] == "orderapproved") { ?>
      <div class='col-12' id='successmessage' style='display:none'>
        <div class='alert alert-success' role='alert'>
          <b>Order Successfully Approved.</b>
        </div>
      </div>

    <?php } else if ($_GET['action'] == "ordercompleted") { ?>
      <div class='col-12' id='successmessage' style='display:none'>
        <div class='alert alert-success' role='alert'>
          <b>Order Successfully Completed.</b>
        </div>
      </div>

    <?php } else if ($_GET['action'] == "notdelivered") { ?>
      <div class='col-12' id='successmessage' style='display:none'>
        <div class='alert alert-success' role='alert'>
          <b>Order Successfully Marked as not delivered.</b>
        </div>
      </div>

    <?php } else if ($_GET['action'] == "ordercanceled") { ?>
      <div class='col-12' id='successmessage' style='display:none'>
        <div class='alert alert-success' role='alert'>
          <b>Order Successfully Canceled.</b>
        </div>
      </div>

    <?php } else { ?>
      <div class='col-12' id='successmessage' style='display:none'>
        <div class='alert alert-success' role='alert'>
          <b>Order Successfully Added.</b>
        </div>
      </div>

    <?php
    } ?>

    <script type="text/javascript">
      <?php if (isset($_GET['orderid'])) { //increse display time on issue 
      ?>
        $("#successmessage").show().delay(60000).fadeOut(2000);
      <?php } else { ?>
        $("#successmessage").show().delay(5000).fadeOut(2000);
      <?php } ?>
    </script>

  <?php
  }
  ?>

  <div class='col-12'>

  </div>



  <div class="col-12">
    <h5>Orders</h5>
  </div>


  <div class="col-12 mb-2 mt-2">

    Order Status: <select id="orderstatus" name="cityId">
      <option value="4">All</option>
      <option value="0">Pending</option>
      <option value="1">Approved</option>
      <option value="2">Issued</option>
      <option value="3">Completed</option>
    </select>


  </div>

  <div class="col-12 pb-5">
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

<style>
  .odd {
    background-color: white;
  }

  .even {
    background-color: gray;
  }
</style>

<script type="text/javascript">
  //   function alternate(#PeopleTableContainer){ 

  //   if(document.getElementsByTagName){  

  //     var table = document.getElementById(#PeopleTableContainer);   

  //     var rows = table.getElementsByTagName("tr");   

  //     for(i = 0; i < rows.length; i++){           

  //   //manipulate rows 

  //       if(i % 2 == 0){ 

  //         rows[i].className = "even"; 

  //       }else{ 

  //         rows[i].className = "odd"; 

  //       }       

  //     } 

  //   } 

  // }

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

  function cancelconfirm(orderid) {
    bootbox.confirm("Are you sure you want to cancel Order " + orderid, function(result) {
      if (result) {
        window.location.replace("process/cancelorder.inc.php?orderid=" + orderid);
      }

    });
  }
</script>




<script type="text/javascript">
  $(document).ready(function() {






    <?php if (isset($_GET['status'])) { ?>
      $("#orderstatus").val(<?php echo $_GET['status'] ?>);
    <?php } ?>


    //Prepare jTable
    $('#PeopleTableContainer').jtable({
      //title: 'a',
      paging: true, //Enable paging
      pageSize: 10, //Set page size (default: 10)
      sorting: true, //Enable sorting
      defaultSorting: 'lastupdate DESC', //Set default sorting
      dialogShowEffect: 'explode',
      dialogHideEffect: 'explode',
      saveUserPreferences: false,
      actions: {
        listAction: 'process/manageorders.inc.php?action=list'
      },
      <?php if ($_SESSION['usertype'] == 'admin') { ?>
        toolbar: {
          items: [{
            icon: '/images/excel.png',
            text: 'View All Orders',
            click: function() {
              $(this).addClass("btn btn-primary");
              $.ajax({
                type: 'POST',
                async: false,
                url: 'process/getpendingorderitems.php',
                dataType: 'html',
                success: function(data) {
                  //alert(data);
                  $("#ordersmodalbody").html(data);
                  $('#ordersmodal').modal('show');
                  //alert($(button).attr("data-shopname"));

                },
                error: function() {
                  alert('An unknown error occoured, Please try again Later...!');

                }
              });
            },
            fontSize: 15
          }]
        },
      <?php } ?>
      fields: {
        orderid: {
          title: 'ID',
          key: true,
          create: false,
          edit: false,
          list: true //show in table or not
        },
        fullname: {
          title: 'Dealer Name',
          //width: '25%',
          edit: false
        },
        shopname: {
          title: 'Shop Name',
          width: '20%',
          edit: false
        },
        area: {
          title: 'Area',
          //width: '10%',
          edit: false
        },
        ordertime: {
          title: 'Order Date',
          //width: '25%',
          edit: false
        },
        summary: {
          title: 'summary',
          //width: '10%',
          edit: false,
          sorting: false
        },
        actions: {
          title: 'Actions',
          //width: '15%',
          list: true,
          edit: false,
          create: false,
          sorting: false
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

    //Load person list from server
    $('#PeopleTableContainer').jtable('load', {
      orderstatus: $('#orderstatus').val()
    });


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
      $('#PeopleTableContainer').jtable('load', {
        // Name: $('#name').val(),
        // cityId: $('#cityId').val()
        Name: $('#name').val(),
        orderstatus: $('#orderstatus').val()
      });
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

  $("table > tbody").each(function() {
    $("tr:even:not(:first)", this).addClass("alternate-row");
  });
</script>




<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
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