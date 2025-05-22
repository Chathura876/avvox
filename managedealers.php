<?php require_once "common/header.php" ?>
<?php
$permissions = array("admin", "salesrep","director");

if (!(in_array($_SESSION['usertype'], $permissions))){
    header("Location: index.php");  
}
?>
<?php require_once "common/nav.php" ?>

<div class="row">

<div class="col-12">
  <h5>Manage Dealers</h5>
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
          listAction: 'process/dealers.inc.php?action=list',
          createAction: 'process/dealers.inc.php?action=create',
          updateAction: 'process/dealers.inc.php?action=update',
          deleteAction: 'process/dealers.inc.php?action=delete'
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
            width: '5%',
            list: true//show in table or not
          },
          fullname: {
            title: 'Full Name',
            edit: true
          },
          shopname: {
            title: 'Shop Name',
            edit: true
          },
          nic: {
            title: 'NIC',
            edit: true
          },          
          address: {
            title: 'Address',
            type: 'textarea',
            edit: true
          },
         area: {
              title: 'Area',
              list: true,
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
              }
          },                                           
          phone1: {
            title: 'Shop No',
            edit: true
          },
           phone2: {
            title: 'Mobile',
            edit: true
          },
           username: {
            list: false,
            title: 'Username',
            edit: false,
            create: true
          },
           password: {
            list: false,
            title: 'Password',
            edit: false,
            create: true
          },
          actions: {
            width: '15%',
            title: 'Actions',
            list: true,
            edit: false,
            create:false,
            sorting: false
          },
         pricing: {
              title: 'Pricing',
              list: true,
              options: {
                default: "default",
                silver: "silver",
                gold: "gold",
                platinum: "platinum"
              }
          },
         repid: {
              title: 'Rep',
              list: true,
              options: {
                <?php
                $query = "SELECT * FROM user WHERE usertype='salesrep' ORDER BY fullname";
                $repstring = "0: \"None\",";
                if ($result = $mysqli->query($query)) {
                  while ($objectname = $result->fetch_object()) {
                       //echo $objectname->Name;
                       //echo "<br>";
                    $repstring .= "{$objectname->id}: \"{$objectname->fullname}\",";
                  }
                  $repstring = rtrim($repstring, ",");
                }
                echo $repstring;
                ?>
              }
          }
        },
              //Initialize validation logic when a form is created
              formCreated: function (event, data) {
                  data.form.find('input[name="fullname"]').addClass('validate[required, custom[onlyLetterSp]');
                  data.form.find('input[name="shopname"]').addClass('validate[required]');
                  data.form.find('input[name="nic"]').addClass('validate[required]');
                  data.form.find('textarea[name="address"]').addClass('validate[required]');
                  data.form.find('input[name="phone1"]').addClass('validate[required,custom[number], funcCall[checklengthequals]]');
                  data.form.find('input[name="phone2"]').addClass('validate[required,custom[number], funcCall[checklengthequals]]');
                  data.form.find('input[name="username"]').addClass('validate[required,funcCall[checkusername]]');
                  data.form.find('input[name="password"]').addClass('validate[required, minSize[6]]');                  
                  //data.form.validationEngine();
                  data.form.validationEngine({promptPosition : "inline"});
                  //data.form.find('input[name=fullname]').css('width','400px');
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

          $('#exampleModal').on('show.bs.modal', function (event) {
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
            url: 'process/getinventorydata.php',
            data: { id: button.val()},
            dataType: 'html',
            success: function (data) {
              //alert(data);
              $("#akatablearea").html(data);
              $("#exampleModalLabel").html("Inventory Details - " + $(button).attr("data-shopname"));
              //alert($(button).attr("data-shopname"));

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




          })   


           $('#exampleModal2').on('show.bs.modal', function (event) {
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
            url: 'process/getsalesdata.php',
            data: { id: button.val()},
            dataType: 'html',
            success: function (data) {
              //alert(data);
              $("#akatablearea2").html(data);
              $("#exampleModalLabel2").html("Sales Details - " + $(button).attr("data-shopname"));

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




          })                      

    });

  </script>

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Inventory Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>
          <div class="form-group">
            <div id="akatablearea"></div>

          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel2">Sales Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>
          <div class="form-group">
            <div id="akatablearea2"></div>

          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<?php require_once "common/footer.php" ?>