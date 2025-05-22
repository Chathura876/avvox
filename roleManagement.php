<?php require_once "common/header.php" ?>
<?php
$permissions = array("admin","director");

if (!(in_array($_SESSION['usertype'], $permissions))){
    header("Location: index.php");  
}

?>
<?php require_once "common/nav.php" ?>

<div class="row">

<?php if (isset($_GET['action'])) {

if ($_GET['action'] == "issuecomplete") { ?>

<?php } else if ($_GET['action'] == "updateaction") { ?>
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
      <b>Permission Successfully Added.</b>
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
  <h5>Manage Roles  </h5>
  <div id="PeopleTableContainer" style="width: 100%"></div>
</div>

</div>

 <script type="text/javascript">

    $(document).ready(function () {

        //Prepare jTable
      $('#PeopleTableContainer').jtable({
        //title: 'a',
        paging: true, //Enable paging
              pageSize: 10, //Set page size (default: 10)
              sorting: true, //Enable sorting
              defaultSorting: 'role_id ASC', //Set default sorting
              dialogShowEffect: 'explode',
              dialogHideEffect: 'explode',
              saveUserPreferences: false,
        actions: {
          listAction: 'process/role.inc.php?action=list',
          createAction: 'process/role.inc.php?action=create',
        //   updateAction: 'process/role.inc.php?action=update',
          deleteAction: 'process/role.inc.php?action=delete'
        },
        fields: {
          role_id: {
            title:'Role ID',
            key: true,
            create: false,
            edit: false,
            list: true//show in table or not
          },        
          role_name: {
            title: 'Role Name',
            type: 'textarea',
            edit: false,

          },
          actions: {
            title: 'Actions',
            list: true,
            edit: false,
            create: false,
            sorting: false
          }                          
        },
              //Initialize validation logic when a form is created
              formCreated: function (event, data) {
                  data.form.find('textarea[name="perm_desc"]').addClass('validate[required]');                  
                  //data.form.validationEngine();
                  data.form.validationEngine({promptPosition : "inline"});
              },
              //Validate form when it is being submitted
              formSubmitting: function (event, data) {
                  return data.form.validationEngine('validate');
              },
              //Dispose validation logic when form is closed
              formClosed: function (event, data) {
                  data.form.validationEngine('hide');
                  data.form.validationEngine('detach');
              }       
      });

      //Load person list from server
      $('#PeopleTableContainer').jtable('load');


          //Re-load records when user click 'load records' button.
          $('#LoadRecordsButton').click(function (e) {
              e.preventDefault();
              $('#PeopleTableContainer').jtable('load', {
                  // Name: $('#name').val(),
                  // cityId: $('#cityId').val()
                  Name: $('#name').val()
              });
          });


          //Re-load records when user click 'load records' button.
          $('#name').keyup(function (e) {
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