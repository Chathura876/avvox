<?php
require_once("../common/logincheck.php");
require_once("../common/database.php");
require_once("../common/common_functions.php");
if (!($userloggedin)) { //Prevent the user visiting this page if not logged in 
    //Redirect to user account page
    //header("Location: login.php");
    http_response_code(403);
    die();
}
if (isset($_POST['role_id'])) {
    $roleID = $_POST['role_id'];
        $query1 = "DELETE FROM roles_permissions WHERE role_id = $roleID";
        if($result1 = $mysqli->query($query1)){

            foreach ($_POST['perm_id'] as $selected) {
                $mysqli->begin_transaction();
        
                $query = "INSERT INTO roles_permissions VALUES($roleID,$selected)";
                $result = $mysqli->query($query);
            }
        }
}

if($result){
    $mysqli->commit();
    header("Location: ../roleManagement.php?action=$updateaction");
    //echo "Success";
}else{
    $mysqli->rollback();
    echo "Fail";
}
