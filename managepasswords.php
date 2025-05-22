<?php require_once "common/header.php" ?>
<?php
$permissions = array("admin");

if (!(in_array($_SESSION['usertype'], $permissions))){
    header("Location: index.php");  
}

?>
<?php require_once "common/nav.php" ?>

<div class="row">

<div class="col-12">
  <h5>Change Passwords</h5>
  <div id="PeopleTableContainer" style="width: 100%"></div>
</div>

</div>



<script type="text/javascript">
  
  function checkusername(field, rules, i, options){
   //alert(field.val());
   var taken = false;
    $.ajax({
      type: 'POST',
      async: false,
      url: 'process/checkusername.php',
      data: { username: field.val()},
      dataType: 'html',
      success: function (data) {
        //alert(data);
        if(data == 'taken'){
          taken = true;
          //alert("Username taken");

        }
        else{
          //alert("Username available");
        }
      },
      error: function () {
          alert('An unknown error occoured, Please try again Later...!');
          
      }
    });


    if(taken == true){
      return "Username already taken, Try another value";
    }
  }
  //==================================================
  function checklengthequals(field, rules, i, options){
    //alert(rules);
    if(field.val().length != 10){
      return "* Number must have exactly 10 digits";
    }

  }
</script>




 <script type="text/javascript">

    $(document).ready(function () {

        //Prepare jTable
      $('#PeopleTableContainer').jtable({
        //title: 'a',
        paging: true, //Enable paging
              pageSize: 10, //Set page size (default: 10)
              sorting: true, //Enable sorting
              defaultSorting: 'fullname ASC', //Set default sorting
              dialogShowEffect: 'explode',
              dialogHideEffect: 'explode',
              saveUserPreferences: false,
        actions: {
          listAction: 'process/passwords.inc.php?action=list',
          updateAction: 'process/passwords.inc.php?action=update'
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
            title:'ID',
            key: true,
            create: false,
            edit: false,
            list: false//show in table or not
          },
          username: {
            title: 'Username',
            edit: false
          },         
          fullname: {
            title: 'Full Name',
            edit: false
          },
          password: {
            title: 'New Password',
            edit: true,
            list: false
          }                           
        },
              //Initialize validation logic when a form is created
              formCreated: function (event, data) {
                  data.form.find('input[name="fullname"]').addClass('validate[required,custom[onlyLetterSp]]');
                  data.form.find('input[name="nic"]').addClass('validate[required]');
                  data.form.find('textarea[name="address"]').addClass('validate[required]');
                  data.form.find('input[name="phone1"]').addClass('validate[required,custom[number], funcCall[checklengthequals]]');
                  data.form.find('input[name="phone2"]').addClass('validate[required,custom[number], funcCall[checklengthequals]]');
                  data.form.find('input[name="username"]').addClass('validate[required,funcCall[checkusername]]');
                  data.form.find('input[name="password"]').addClass('validate[required, minSize[6]]');                  
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