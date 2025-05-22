<?php require_once "common/header.php" ?>
<?php
$permissions = array("admin", "shop", "dealer", "salesrep","director");

if (!(in_array($_SESSION['usertype'], $permissions))){
    header("Location: index.php");  
}

?>
<?php require_once "common/nav.php" ?>

<div class="row">

<div class="col-12">
  <h5>Manage Customers</h5>
  <div id="PeopleTableContainer" style="width: 100%"></div>
</div>

</div>



<script type="text/javascript">
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
          listAction: 'process/customers.inc.php?action=list',
 
          createAction: 'process/customers.inc.php?action=create',

          updateAction: 'process/customers.inc.php?action=update',
          deleteAction: 'process/customers.inc.php?action=delete'
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
          warrantyid: {
            title: 'Warranty Card No',
            edit: true,
            key: true,
            create: true,
            edit: false,
            list: true//show in table or not            
          },          
          fullname: {
            title: 'Full Name',
            edit: true
          },
          nic: {
            title: 'NIC',
            edit: true
          },
          phone: {
            title: 'Phone',
            edit: true
          },                     
          address: {
            title: 'Address',
            type: 'textarea',
            edit: true
          },
          purdate: {
            title: 'Purchased Date',
            type: 'date',
            edit: false
          },
          modelid: {
            title: 'Model',
            list: false,
            options: { 
              <?php 
              $query = "SELECT * FROM product WHERE status='Active' ORDER BY model ASC";
              $productstring = "";
              if ($result = $mysqli->query($query)) {
                while ($product = $result->fetch_object()) {
                  $productstring .= "'{$product->id}': '{$product->model}',";
                     //echo $product->Name;
                     //echo "<br>";
                }
                $productstring = rtrim($productstring, ",");
                echo $productstring;
              }
              ?>

            },
            edit: false
          },
          modelname: {
            //width: '20%',
            title: 'Model',
            list: true,
            edit: false,
            create:false,
            sorting: false
          }
         <?php if($_SESSION['usertype'] !='shop' || $_SESSION['usertype'] !='dealer'){  ?>




          ,
           area: {
                  title: 'District',
              options: {
                Ampara: "Ampara",
                Anuradhapura: "Anuradhapura",
                Badulla: "Badulla",
                Batticaloa: "Batticaloa",
                Colombo: "Colombo",
                Galle: "Galle",
                Gampaha: "Gampaha",
                Hambantota: "Hambantota",
                Jaffna: "Jaffna",
                Kalutara: "Kalutara",
                Kandy: "Kandy",
                Kegalle: "Kegalle",
                Kilinochchi: "Kilinochchi",
                Kurunegala: "Kurunegala",
                Mannar: "Mannar",
                Matale: "Matale",
                Matara: "Matara",
                Monaragala: "Monaragala",
                Mulativu: "Mulativu",
                Nuwaraeliya: "Nuwaraeliya",
                Polonnaruwa: "Polonnaruwa",
                Puttalam: "Puttalam",
                Rathnapura: "Rathnapura",
                Trincomalee: "Trincomalee",
                Vavuniya: "Vavuniya"
              },
                  list: false
              },
              dealerid: {
                  title: 'Dealer',
                  dependsOn: 'area', //Cities depends on countries. Thus, jTable builds cascade dropdowns!
                  options: function (data) {
                      if (data.source == 'list') {
                          //Return url of all cities for optimization. 
                          //This method is called for each row on the table and jTable caches options based on this url.
                          return 'process/getdealersjson.php?area=Ampara';
                      }

                      //This code runs when user opens edit/create form or changes country combobox on an edit/create form.
                      //data.source == 'edit' || data.source == 'create'
                      //alert("Hi");
                      return 'process/getdealersjson.php?area=' + data.dependedValues.area;
                  },
                  list: false
              }







         <?php } ?>                                                                          
        },
              //Initialize validation logic when a form is created
              formCreated: function (event, data) {
                  data.form.find('input[name="fullname"]').addClass('validate[required, custom[onlyLetterSp]]');
                  data.form.find('input[name="warrantyid"]').addClass('validate[required]');
                  //data.form.find('input[name="nic"]').addClass('validate[required]');
                  //data.form.find('textarea[name="address"]').addClass('validate[required]');
                  data.form.find('input[name="phone"]').addClass('validate[required,custom[number], funcCall[checklengthequals]]');
                  data.form.find('input[name="purdate"]').addClass('validate[required]');                 
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