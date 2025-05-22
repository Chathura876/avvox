<?php require_once "common/header.php" ?>
<?php require_once "common/nav.php" ?>


<div class="row">

    <form>
        Name: <input type="text" name="name" id="name" />
        <button type="submit" id="LoadRecordsButton">Load records</button>
    </form>
</div>


<div class="row">
<div class="col-sm-12 col-md-12">
  <div id="PeopleTableContainer" style="width:100%"></div>
</div>

</div>








 <script type="text/javascript">

    $(document).ready(function () {

        //Prepare jTable
      $('#PeopleTableContainer').jtable({
        title: 'Table of people',
        paging: true, //Enable paging
              pageSize: 10, //Set page size (default: 10)
              sorting: true, //Enable sorting
              defaultSorting: 'Name ASC', //Set default sorting
              dialogShowEffect: 'explode',
              dialogHideEffect: 'explode',
              saveUserPreferences: false,
        actions: {
          listAction: 'PersonActions.php?action=list',
          createAction: 'PersonActions.php?action=create',
          updateAction: 'PersonActions.php?action=update',
          deleteAction: 'PersonActions.php?action=delete'
        },
        fields: {
          PersonId: {
            key: true,
            create: false,
            edit: false,
            list: false//show in table or not
          },
          Name: {
            title: 'Author Name',
            edit: true
          },
          Age: {
            title: 'Age',
          },
          RecordDate: {
            title: 'Record date',
            type: 'date'
            //create: false,//show in add new record form or not
            //edit: false // show in edit record or not
          },
          sex: {
              title: 'Sex',
              list: true,
              options: { 'Male': 'Male', 'Female': 'Female' }
          },
          about: {
              title: 'About this person',
              type: 'textarea',
              list: true
          },
          profilelink: {
              title: 'Profile',
              list: true,
              edit: false,
              create:false
          }                              
        },
              //Initialize validation logic when a form is created
              formCreated: function (event, data) {
                  data.form.find('input[name="Name"]').addClass('validate[required]');
                  data.form.find('input[name="Age"]').addClass('validate[required,custom[number]]');
                  data.form.find('input[name="RecordDate"]').addClass('validate[required]');
                  //data.form.validationEngine();
                  data.form.validationEngine({promptPosition : "bottomLeft"});
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