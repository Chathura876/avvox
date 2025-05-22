<?php require_once "common/header.php" ?>
<?php
$permissions = array("admin","director");

if (!(in_array($_SESSION['usertype'], $permissions))){
    header("Location: index.php");  
}

?>
<?php require_once "common/nav.php" ?>

<div class="row">

<div class="col-12">
  <h5>Manage Permission</h5>
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
              defaultSorting: 'perm_id ASC', //Set default sorting
              dialogShowEffect: 'explode',
              dialogHideEffect: 'explode',
              saveUserPreferences: false,
        actions: {
          listAction: 'process/permission.inc.php?action=list',
          createAction: 'process/permission.inc.php?action=create',
          updateAction: 'process/permission.inc.php?action=update',
          deleteAction: 'process/permission.inc.php?action=delete'
        },
        fields: {
          perm_id: {
            title:'ID',
            key: true,
            create: false,
            edit: false,
            list: true//show in table or not
          },
          perm_type: {
            title: 'Permission Type',
            type: 'textarea',
            edit: true,
          } ,        
          perm_desc: {
            title: 'Description',
            type: 'textarea',
            edit: true,

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