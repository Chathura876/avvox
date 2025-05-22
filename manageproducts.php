<?php require_once "common/header.php" ?>
<?php
$permissions = array("admin","accountant","director","operator");

if (!(in_array($_SESSION['usertype'], $permissions))){
    header("Location: index.php");  
}

?>
<?php require_once "common/nav.php" ?>

<link rel="stylesheet" href="css/ekko-lightbox.css">
<script src="js/ekko-lightbox.min.js" type="text/javascript"></script>

<div class="row">

<div class="col-12">
  <h5>Manage Products</h5>
  <div id="PeopleTableContainer" style="width: 100%"></div>
</div>

</div>



<script type="text/javascript">
  
  function checkmodelname(field, rules, i, options){
   //alert(options);
   console.log(i);
   var taken = false;
    $.ajax({
      type: 'POST',
      async: false,
      url: 'process/checkmodelname.php',
      data: { model: field.val()},
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
      return "Product is already system";
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
              defaultSorting: 'model ASC', //Set default sorting
              dialogShowEffect: 'explode',
              dialogHideEffect: 'explode',
              saveUserPreferences: false,
        actions: {
          listAction: 'process/products.inc.php?action=list',
          createAction: 'process/products.inc.php?action=create',
          updateAction: 'process/products.inc.php?action=update',
          deleteAction: 'process/products.inc.php?action=delete'
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
          model: {
            title: 'Product Name',
            edit: true
          },
          productimage: {
            title: 'Product Image',
            edit: false,
            create: false,
            list: true,
            sorting: false
          },           
          imageupload: {
            title: 'Upload Image',
            edit: false,
            create: false,
            list: true,
            sorting: false
          },
          pricedefault: {
            title: 'Default',
            width: '10%',
            edit: true
          },
          pricesilver: {
            title: 'Silver',
            width: '10%',
            edit: true
          },
          pricegold: {
            title: 'Gold',
            width: '10%',
            edit: true
          },
           priceplatinum: {
            title: 'Platinum',
            width: '10%',
            edit: true
          }, 
          cmb: {
            title: 'CBM',
            width: '10%',
            edit: true
          },                                                        
         status: {
              title: 'Status',
              list: true,
              options: {
                Active: "Active",
                Inactive: "Inactive"
              }
         }                                 
        },
              //Initialize validation logic when a form is created
              formCreated: function (event, data) {
                  //data.form.find('input[name="model"]').addClass('validate[required,funcCall[checkmodelname]]');
                  data.form.find('input[name="model"]').addClass('validate[required]');
                  //data.form.validationEngine();
                  data.form.validationEngine({promptPosition : "inline"});
                  //data.form.css('width','900px');
                  //data.form.find('input[name=model]').css('width','600px');
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