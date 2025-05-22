<?php require_once "common/header.php" ?>
<?php require_once "common/nav.php" ?>

<div class="row">

<div class="col-12 col md-6">



<?php 
//running script accorind to get variable
//added more commments
//added more commments
//added more commments
//added more commments
//added more commments
//crm_edited_files
//uhjkhjkjhkjh
//tjhkgjhgkjhgkhj
//ghkjgkjgkjhkjhg
//sdsfdsfsdfd
//5354354
//44324324342
//dfsfdfsfdsdf
if(isset($_GET['action'])){


?>

      <script>
         setTimeout(function(){
            window.location.href = '<?php echo $_GET['action'] ?>';
         }, 5000);
      </script>


<?php
  if($_GET['action'] =='manageorders.php'){//end if 1,start if 2
    echo "<div class='alert alert-success' role='alert'>
            Items have been ordered successfuly. You will be sent to the order management page Soon
          </div>";
  }
  else if($_GET['action'] =='issued'){//end if 1,start if 2
    echo "<div class='alert alert-success' role='alert'>
            Items have been issued successfuly.
          </div>";
  }
   else if($_GET['action'] =='issuecomplete'){//end if 1,start if 2
    echo "<div class='alert alert-success' role='alert'>
            Items have been issued successfuly.
          </div>";
  }
   else if($_GET['action'] =='addjob.php'){//end if 1,start if 2
    echo "<div class='alert alert-success' role='alert'>
            Job Added Successfully. You will be sent to the original page Soon
          </div>";

  }
   else if($_GET['action'] =='jobupdatecomplete'){//end if 1,start if 2
    echo "<div class='alert alert-success' role='alert'>
           Job Update Added Successfully. <a href='pendingjobs.php'>Click here</a> to go back to Pending Jobs
          </div>";
  }
    else if($_GET['action'] =='jobcompleted'){//end if 1,start if 2
    echo "<div class='alert alert-success' role='alert'>
            Job Successfully marked as completed. <a href='pendingjobs.php'>Click here</a> to go back to Pending Jobs
          </div>";
  }  
}
 ?>


</div>

</div>


<?php require_once "common/footer.php" ?>