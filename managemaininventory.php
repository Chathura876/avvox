<?php require_once "common/header.php" ?>
<?php
$permissions = array("admin", "salesrep", "accountant","storeskeeper","operator");

if (!(in_array($_SESSION['usertype'], $permissions))) {
  header("Location: index.php");
}
$todaydate = date("Y-m-d");
?>
<?php require_once "common/nav.php" ?>

<link rel="stylesheet" href="css/ekko-lightbox.css">
<script src="js/ekko-lightbox.min.js" type="text/javascript"></script>

<style type="text/css">
  div.jtable-main-container table.jtable tbody>tr>td .jtable-edit-command-button {
    /*background: url('scripts/jtable/themes/flick/add-32px.png') no-repeat;*/
    background: url('scripts/jtable/themes/flick/addorremove-32px.png') no-repeat;
    width: 32px;
    height: 32px;
  }
</style>

<div class="row">




  <?php if (isset($_GET['action'])) {

    if ($_GET['action'] == "inventoryadded") { ?>
      <div class='col-12' id='successmessage' style='display:none'>
        <div class='alert alert-success' role='alert'>
          <b>Inventory items successfully Updated.</b>
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




  <div class="col-12">
    <h5>Manage Main Inventory</h5>
    <div id="PeopleTableContainer" style="width: 100%"></div>
  </div>

</div>



<script type="text/javascript">
  function checkmodelname(field, rules, i, options) {
    //alert(options);
    console.log(i);
    var taken = false;
    $.ajax({
      type: 'POST',
      async: false,
      url: 'process/checkmodelname.php',
      data: {
        model: field.val()
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
      return "Product is already system";
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

    $(document).on('click', '[data-toggle="lightbox"]', function(event) {
      event.preventDefault();
      $(this).ekkoLightbox();
    });

    //Prepare jTable
    $('#PeopleTableContainer').jtable({
      //title: 'a',
      paging: true, //Enable paging
      pageSize: 10, //Set page size (default: 10)
      sorting: true, //Enable sorting
      defaultSorting: 'id ASC', //Set default sorting
      dialogShowEffect: 'explode',
      dialogHideEffect: 'explode',
      saveUserPreferences: false,

      actions: {
        listAction: 'process/managemaininventory.inc.php?action=list'
        <?php if ($_SESSION['usertype'] == "admin") { ?>,
          updateAction: 'process/managemaininventory.inc.php?action=update'
        <?php } ?>
      },

      // toolbar: {//custome toolbar icons
      //   hoverAnimation: true, //Enable/disable small animation on mouse hover to a toolbar item.
      //   hoverAnimationDuration: 60, //Duration of the hover animation.
      //   hoverAnimationEasing: undefined, //Easing of the hover animation. Uses jQuery's default animation ('swing') if set to undefined.
      //   items: [//Array of your custom toolbar items.
      //   {
      //     icon: '/images/excel.png',
      //     text: 'Export to Excel',
      //     click: function () {
      //         //perform your custom job...
      //     }
      //   },
      //   {
      //     icon: '/images/pdf.png',
      //     text: 'Export to Pdf',
      //     click: function () {
      //         //perform your custom job...
      //     }
      //   }] 
      // },
      fields: {
        id: {
          title: 'ID',
          key: true,
          create: false,
          edit: false,
          list: true //show in table or not
        },
        model: {
          title: 'Product Name',
          edit: false
        },
        productimage: {
          title: 'Product Image',
          edit: false,
          create: false,
          list: true,
          sorting: false
        },
        pricedefault: {
          title: 'Default',
          edit: false
        },
        <?php if ($_SESSION['usertype'] == "admin") { ?>
          pricesilver: {
            title: 'Silver',
            edit: false
          },
          pricegold: {
            title: 'Gold',
            edit: false
          },
          priceplatinum: {
            title: 'Platinum',
            edit: false
          },
        <?php } ?>
        cmb: {
          title: 'CBM',
          edit: false
        },
        quantity: {
          title: 'Quantity',
          edit: false
        },
        pending: {
          title: 'Pending',
          edit: false
        },
        quantitysellable: {
          title: 'Sellable',
          edit: false
        },
        addamount: {
          title: 'Quantity',
          edit: true,
          list: false
        },
        date: {
          title: 'Date',
          edit: true,
          defaultValue: '<?php echo $todaydate ?>',
          list: false
        },
        action: {
          title: 'Action',
          list: false,
          edit: true,
          options: {
            add: "Add",
            remove: "Remove"
          }
        },
        note: {
          title: 'Note',
          type: 'textarea',
          edit: true,
          list: false
        }
      },

      messages: {
        serverCommunicationError: 'An error occured while communicating to the server.',
        loadingMessage: 'Loading records...',
        noDataAvailable: 'No data available!',
        addNewRecord: 'Add new record',
        editRecord: 'Top Up',
        areYouSure: 'Are you sure?',
        deleteConfirmation: 'This record will be deleted. Are you sure?',
        save: 'Save',
        saving: 'Saving',
        cancel: 'Cancel',
        deleteText: 'Delete',
        deleting: 'Deleting',
        error: 'Error',
        close: 'Close',
        cannotLoadOptionsFor: 'Can not load options for field {0}',
        pagingInfo: 'Showing {0}-{1} of {2}',
        pageSizeChangeLabel: 'Row count',
        gotoPageLabel: 'Go to page',
        canNotDeletedRecords: 'Can not deleted {0} of {1} records!',
        deleteProggress: 'Deleted {0} of {1} records, processing...'
      },
      //Initialize validation logic when a form is created
      formCreated: function(event, data) {
        //data.form.find('input[name="model"]').addClass('validate[required,funcCall[checkmodelname]]');
        data.form.find('input[name="model"]').addClass('validate[required]');
        //data.form.validationEngine();
        data.form.validationEngine({
          promptPosition: "inline"
        });
        data.form.find('input[name="date"]').addClass('validate[required,custom[date],past[now]]');
        data.form.find('input[name="addamount"]').addClass('validate[required,custom[integer],min[1]]');
        data.form.find('textarea[name="note"]').addClass('validate[required]');
      },
      //Validate form when it is being submitted
      formSubmitting: function(event, data) {
        return data.form.validationEngine('validate');

      },
      //Dispose validation logic when form is closed
      formClosed: function(event, data) {
        data.form.validationEngine('hide');
        data.form.validationEngine('detach');


        $('#PeopleTableContainer').jtable('load', {
          // Name: $('#name').val(),
          // cityId: $('#cityId').val()
          Name: $('#name').val()
        });



      }
    });

    //Load person list from server
    $('#PeopleTableContainer').jtable('load');


    //Re-load records when user click 'load records' button.
    $('#LoadRecordsButton').click(function(e) {
      e.preventDefault();
      $('#PeopleTableContainer').jtable('load', {
        // Name: $('#name').val(),
        // cityId: $('#cityId').val()
        Name: $('#name').val()
      });
    });


    //Re-load records when user click 'load records' button.
    $('#name').keyup(function(e) {
      e.preventDefault();
      $('#PeopleTableContainer').jtable('load', {
        // Name: $('#name').val(),
        // cityId: $('#cityId').val()
        Name: $('#name').val()
      });
    });
    //Load all records when page is first shown
    //$('#LoadRecordsButton').click();

  });
</script>


<?php require_once "common/footer.php" ?>