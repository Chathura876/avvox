<?php require_once "common/header.php" ?>
<?php
$permissions = array("admin", "shop", "dealer", "technician", "accountant","director","operator");

if (!(in_array($_SESSION['usertype'], $permissions))) {
  header("Location: index.php");
}

?>
<?php require_once "common/nav.php" ?>

<div class="row">

  <div class="col-12">
    <h5>View All Jobs</h5>
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

    //Prepare jTable
    $('#PeopleTableContainer').jtable({
      //title: 'a',
      paging: true, //Enable paging
      pageSize: 10, //Set page size (default: 10)
      sorting: true, //Enable sorting
      defaultSorting: 'id DESC', //Set default sorting
      dialogShowEffect: 'explode',
      dialogHideEffect: 'explode',
      saveUserPreferences: false,
      actions: {
        listAction: 'process/alljobs.inc.php?action=list'
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
          width: '5%',
          create: false,
          edit: false,
          list: true //show in table or not
        },
        warrantyid: {
          title: 'Warranty ID',
          edit: true,
          width: '10%'
        },
        contactname: {
          title: 'Customer Name',
          edit: true,
          width: '20%'
        },
        contactno: {
          width: '20%',
          title: 'Customer Number',
          edit: true
        },
        address: {
          width: '25%',
          title: 'Address',
          edit: true
        },
        fullname: {
          width: '20%',
          title: 'Technician',
          edit: true
        },
        shopname: {
          width: '15%',
          title: 'Dealer',
          edit: true
        },
        model: {
          width: '20%',
          title: 'Model',
          edit: true
        },
        timeadded: {
          width: '25%',
          title: 'Date',
          edit: true
        },
        //   jobtype: {
        //      width: '5%',
        //      title: 'Job Type',
        //      edit: true
        //   },          
        actions: {
          width: '10%',
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



    })

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

<?php require_once "common/footer.php" ?>