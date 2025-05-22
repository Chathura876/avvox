<?php require_once "common/header.php" ?>
<?php
$permissions = array("admin", "shop", "dealer", "technician","accountant","director","operator");

if (!(in_array($_SESSION['usertype'], $permissions))) {
  header("Location: index.php");
}

?>
<?php require_once "common/nav.php" ?>

<div class="row">

  <div class="col-12">
    <h5>Manage Pending Jobs</h5>
    <div id="PeopleTableContainer" style="width: 100%"></div>
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

    $("#addjoblogform").validationEngine();

    $("#completejobform").validationEngine();
    //$("#addjoblogform").validationEngine('attach', {promptPosition : "inline", validationEventTrigger: "keyup"});

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
        listAction: 'process/pendingjobs.inc.php?action=list',
        updateAction: 'process/pendingjobs.inc.php?action=update'
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
          width: '5%',
          list: true //show in table or not
        },
        contactname: {
          title: 'Customer Name',
          edit: true,
          width: '15%'
        },
        contactno: {
          width: '10%',
          title: 'Customer No',
          edit: true
        },
        address: {
          width: '10%',
          title: 'Address',
          edit: false
        },
        techid: {
          width: '15%',
          title: 'Technician',
          options: {

            <?php
            $query = "SELECT id, fullname from user WHERE usertype='technician' ORDER BY fullname ASC";
            if ($result = $mysqli->query($query)) {
              $optionsarray = array();
              while ($objectname = $result->fetch_object()) {
                $optionsarray[] =  $objectname->id . ':"' . $objectname->fullname . '"';
                //echo "<br>";
              }

              echo implode(',', $optionsarray);
            }

            ?>

          },
          edit: true
        },
        timeadded: {
          width: '10%',
          title: 'Job Date',
          edit: false
        },
        jobtype: {
          width: '5%',
          title: 'Job Type',
          edit: false
        },
        actions: {
          width: '30%',
          title: 'Actions',
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
    $('#PeopleTableContainer').jtable('load');

    //$('#PeopleTableContainer').jtable('udaragetsortingdata');


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
        url: 'process/getjoblog.php',
        data: {
          jobid: button.val()
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



    });

    $('#jobupdatemodal').on('show.bs.modal', function(event) {
      var button = $(event.relatedTarget) // Button that triggered the modal
      //alert($(button).val());
      $("#jobid").val($(button).val());
      $("#descdiv").hide();
      $("#description").prop('disabled', true); //disable description because it's hidden and dont' n
      $('#addjoblogform').trigger("reset");
      //$('#PeopleTableContainer').jtable('udaragetsortingdata');   
    })


    $("#addjoblogbutton").click(function() {
      //event.preventDefault();
      if ($("#addjoblogform").validationEngine('validate')) {
        var formdata = $("#addjoblogform").serialize();
        $.ajax({
          type: 'POST',
          async: false,
          url: 'process/jobupdate.inc.php',
          //data: { jobid: $("#jobid").val(), description: "2pm", 'choices[]': [ "Jon", "Susan" ]},
          data: formdata,
          dataType: 'html',
          success: function(data) {
            if (data == 'updated') {
              $('#jobupdatemodal').modal('hide');
              bootbox.alert("Job Updated successfully!");
            } else {

            }
          },
          error: function() {
            alert('An unknown error occoured, Please try again Later...!');

          }
        });
      }
    });








    $('#jobucompletemodal').on('show.bs.modal', function(event) {
      var button = $(event.relatedTarget) // Button that triggered the modal
      //alert($(button).val());
      $("#jobid2").val($(button).val());
      // $("#descdiv").hide();
      // $("#description").prop('disabled', true);//disable description because it's hidden and dont' n
      $('#completejobform').trigger("reset");
      //$('#PeopleTableContainer').jtable('udaragetsortingdata');   
    })


    $("#jobcompletebutton").click(function() {
      //event.preventDefault();
      if ($("#completejobform").validationEngine('validate')) {
        var formdata = $("#completejobform").serialize();
        $.ajax({
          type: 'POST',
          async: false,
          url: 'process/completejob.inc.php',
          //data: { jobid: $("#jobid").val(), description: "2pm", 'choices[]': [ "Jon", "Susan" ]},
          data: formdata,
          dataType: 'html',
          success: function(data) {
            if (data == 'completed') {
              $('#jobucompletemodal').modal('hide');
              bootbox.alert("Job Marked as Completed!");
              $('#PeopleTableContainer').jtable('load');
            } else {

            }
          },
          error: function() {
            alert('An unknown error occoured, Please try again Later...!');

          }
        });
      }
    });

    $('#jobverifymodal').on('show.bs.modal', function(event) {
      var button = $(event.relatedTarget) // Button that triggered the modal
      //alert($(button).val());
      $("#jobid3").val($(button).val());
      // $("#descdiv").hide();
      // $("#description").prop('disabled', true);//disable description because it's hidden and dont' n
      $('#completejobform').trigger("reset");
      //$('#PeopleTableContainer').jtable('udaragetsortingdata');   
    })


    $("#jobverifybutton").click(function() {
      //event.preventDefault();
      if ($("#completejobform").validationEngine('validate')) {
        var formdata = $("#completejobform").serialize();
        $.ajax({
          type: 'POST',
          async: false,
          url: 'process/verifyjob.inc.php',
          //data: { jobid: $("#jobid").val(), description: "2pm", 'choices[]': [ "Jon", "Susan" ]},
          data: formdata,
          dataType: 'html',
          success: function(data) {
            if (data == 'completed') {
              $('#jobverifymodal').modal('hide');
              bootbox.alert("Job Marked as Verified!");
              $('#PeopleTableContainer').jtable('load');
            } else {

            }
          },
          error: function() {
            alert('An unknown error occoured, Please try again Later...!');

          }
        });
      }
    });










    $('#log').on('change', function(e) {
      var optionSelected = $("option:selected", this);
      var selectedarea = this.value;
      if (selectedarea != "Other") {
        $("#descdiv").hide();
        $("#description").prop('disabled', true);
      } else {
        $("#descdiv").show();
        $("#description").prop('disabled', false);
      }

    });

  });

  function completejob(button) {
    bootbox.confirm("Mark this Job as Complete??", function(result) {
      if (result) {
        $.ajax({
          type: 'POST',
          async: false,
          url: 'process/completejob.inc.php',
          data: {
            "jobid": $(button).val()
          },
          dataType: 'html',
          success: function(data) {
            if (data == 'completed') {
              //bootbox.alert("Job Marked as Completed!", function(){ 
              //$(button).prev().hide("slow");
              $(button).prev().remove();
              //$(button).delay(300).hide("slow");
              $(button).prop("disabled", true);
              $(button).html("Completed");
              //});

            } else {
              alert("Error Updating database. Please try again later.");
            }
          },
          error: function() {
            alert('An unknown error occoured, Please try again Later...!');

          }
        });
      }
    });
  }
</script>

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Job Logs</h5>
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

<!-- ----------------------------------------------------------------------------------------------------- -->


<div class="modal fade" id="jobupdatemodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Job Update</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">



        <form id="addjoblogform" method="POST">



          <div class="form-group">
            <label for="recipient-name" class="col-form-label">Select one of the options below or add description</label>
            <select class="form-control" id="log" name="log">
               <option>Customer Was not at home</option>
               <option>Customer Didn't Answer the Call</option>
               <option>Warranty Card missing</option>
               <option>Warranty Expired</option>
               <option>Brought item home for repair</option>
               <option>Can't Repair. Item returned to office</option>
              <option>Item Repaired successfully</option>
              <option>Item Replaced with a new Item</option>
              <option>Entered by Mistake</option>
              <option>Cancelled Job</option>
              <option>Other</option>
            </select>
          </div>
          <div class="form-group" id="descdiv" style="display:none">
            <label for="message-text" class="col-form-label">Description</label>
            <textarea class="form-control" id="description" name="description" data-validation-engine="validate[required]" rows="4"></textarea>
          </div>
          <input id="jobid" name="jobid" type="hidden">
          <div class="modal-footer">
            <button type="button" id="addjoblogbutton" class="btn btn-primary">Update</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          </div>
        </form>
      </div>

    </div>
  </div>
</div>




<!-- ----------------------------------------------------------------------------------------------------- -->



<div class="modal fade" id="jobucompletemodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel3" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Complete Job</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">



        <form id="completejobform" method="POST">




          <div class="form-group" id="descdiv2">
            <label for="message-text" class="col-form-label">Description</label>
            <textarea class="form-control" id="description2" name="description2" data-validation-engine="validate[required]" rows="4"></textarea>
          </div>
          <input id="jobid2" name="jobid2" type="hidden">
          <div class="modal-footer">
            <button type="button" id="jobcompletebutton" class="btn btn-primary">Complete</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          </div>
        </form>
      </div>

    </div>
  </div>
</div>

<div class="modal fade" id="jobverifiedmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel3" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Verify Job</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">



        <form id="completejobform" method="POST">




          <div class="form-group" id="descdiv3">
            <label for="message-text" class="col-form-label">Description</label>
            <textarea class="form-control" id="description3" name="description2" data-validation-engine="validate[required]" rows="4"></textarea>
          </div>
          <input id="jobid3" name="jobid3" type="hidden">
          <div class="modal-footer">
            <button type="button" id="jobverifybutton" class="btn btn-primary">Verify</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          </div>
        </form>
      </div>

    </div>
  </div>
</div>


<?php require_once "common/footer.php" ?>