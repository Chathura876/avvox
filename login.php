<?php
require_once("common/logincheck.php");
require_once("common/database.php");
if ($userloggedin) { //Prevent the user visiting the login page if he/she is already logged in 
  //Redirect to user account page
  header("Location: index.php");
  die();
}
$login_error = false;

//User has entered the creditentials
if (isset($_POST['username']) && isset($_POST['password'])) {

  $stmt = $mysqli->prepare("SELECT * FROM user WHERE username = ? LIMIT 1");
  $stmt->bind_param("s", $_POST['username']);
  $stmt->execute();
  $result = $stmt->get_result();


  if ($result->num_rows > 0) {
    $logged_in_user = $result->fetch_object();

    if (password_verify($_POST['password'], $logged_in_user->password)) {
      //echo 'Password is valid!';
      $_SESSION['loggedin'] = true;
      $_SESSION['id'] = $logged_in_user->id;
      $_SESSION['username'] = $logged_in_user->username;
      $_SESSION['shopname'] = $logged_in_user->shopname;
      $_SESSION['password'] = $logged_in_user->password;
      $_SESSION['fullname'] = $logged_in_user->fullname;
      $_SESSION['usertype'] = $logged_in_user->usertype;
      $_SESSION['mobileno'] = $logged_in_user->mobileno;

      $_SESSION['role_id'] = $logged_in_user->role_id;
      $_SESSION['permissions'] = [];

      $roleId = $logged_in_user->role_id;

      $stmt = $mysqli->prepare("SELECT * FROM `roles_permissions` WHERE `role_id`=?");
      $stmt->bind_param("i",$roleId);
      $stmt->execute();

      $result = $stmt->get_result();

      while ($row = $result->fetch_assoc()) {
        if (!isset($_SESSION['permissions'])) {
            $_SESSION['permissions'] = [];
          }
          $_SESSION['permissions'][] = $row['perm_id'];
      }
      session_regenerate_id();

      //Redirect to user account page
      header("Location: index.php");
    } else {
      //echo 'Invalid password.';
      $login_error = true;
    }
  } else {
    $login_error = true;
  }
  //$stmt = $mysqli->prepare("SELECT * FROM `user` LEFT JOIN `roles` USING (`role_id`) WHERE `username`=?");
  // $stmt = $mysqli->prepare("SELECT * FROM user LEFT JOIN roles WHERE `username`=?");

  // $stmt->bind_param("s", $_POST['username']);
  // $stmt->execute();
  //$user = $stmt->mysqli_fetch_all(MYSQLI_ASSOC);
  //$user = $stmt->bind_result($u, $p);
  //$user = $stmt->get_result();
  // $user = $result->fetch_object();
  // $pass = count($user) > 0;
  // if ($pass) {
  //   $pass = $user[0]['password'] == $_POST['password'];
  // }
  
  // (C) IF VERIFIED - WE PUT THE USER & PERMISSIONS INTO THE SESSION
  // if ($pass) {
  //   $_SESSION['user'] = $user[0];
  //   $_SESSION['user']['permissions'] = [];
  //   unset($_SESSION['user']['password']); // Security...
  //   $stmt = $mysqli->prepare("SELECT * FROM `roles_permissions` WHERE `role_id`=?");
  //   $stmt->bind_param("i", [$user[0]['role_id']]);
  //   $stmt->execute();

  //   $result = $stmt->get_result();
    
  //   while ($row = $result->fetch_assoc()) {
  //     if (!isset($_SESSION['user']['permissions'])) {
  //       $_SESSION['user']['permissions'] = [];
  //     }
  //     $_SESSION['user']['permissions'][] = $row['perm_id'];
  //   }
  //}
}

//require_once("models/header.php");
?>


<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="Udara Akalanka">
  <title>Please Sign in</title>


  <link rel="stylesheet" href="css/bootstrap.min.css">


  <style>
    .bd-placeholder-img {
      font-size: 1.125rem;
      text-anchor: middle;
      -webkit-user-select: none;
      -moz-user-select: none;
      -ms-user-select: none;
      user-select: none;
    }

    @media (min-width: 768px) {
      .bd-placeholder-img-lg {
        font-size: 3.5rem;
      }
    }
  </style>
  <!-- Custom styles for this template -->
  <link href="css/signin.css" rel="stylesheet">
</head>

<body class="text-center">
  <form class="form-signin" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
    <img class="mb-4" src="http://ajirpask97242.ipage.com/avvox/images/logo.jpg" alt="" width="72" height="72">
    <h1 class="h3 mb-3 font-weight-normal">Please sign in</h1>
    <label for="username" class="sr-only">Username</label>
    <input type="input" id="username" name="username" class="form-control mb-1" placeholder="Username" required autofocus>
    <label for="password" class="sr-only">Password</label>
    <input type="password" id="password" name="password" class="form-control" placeholder="Password" required>

    <?php if ($login_error == true) { ?>
      <br>
      <div class="alert alert-danger" role="alert">
        invalid username of Password. Please check again
      </div>
    <?php } ?>
    <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
    <p class="mt-5 mb-3 text-muted">&copy; <?php echo date("Y") ?> Avvox Inc.</p>
  </form>
</body>

</html>