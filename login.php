<?php

session_start();
$noNav = '';
$page_title = 'Login';
if (isset($_SESSION['user'])) {

  header('location: index.php');
}
include 'ini.php';
// login form 
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {

  $user = filter_var( $_POST['user'], FILTER_SANITIZE_STRING);
  $pass = filter_var( $_POST['pass'], FILTER_SANITIZE_STRING);
  
  $hash = sha1($pass);
  $stmt  = "SELECT * FROM users WHERE  password=:password AND username =:username ";
  $query = $con->prepare($stmt);
  $query->bindparam(':username', $user, PDO::PARAM_STR);
  $query->bindparam(':password', $pass, PDO::PARAM_STR);
  $insert = $query->execute();
  $count = $query->rowCount();
  $fetch = $query->fetch();
  echo $fetch['userId'];
  if ($count == true) {
    echo 'checked and it\'s true';
    $_SESSION['user'] = $user;
    $_SESSION['user-id'] =  $fetch['userId'] ;
    header('location: index.php');
    exit();
  }else{
    echo 'can not';
  }
} 
// End login form 
// sign new user
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['signup'])){

  $email = filter_var( $_POST['email'], FILTER_SANITIZE_EMAIL);
  $user = filter_var( $_POST['username'], FILTER_SANITIZE_STRING);
  $pass = filter_var( $_POST['pass'], FILTER_SANITIZE_STRING);
  $re_pass = filter_var( $_POST['re-pass'], FILTER_SANITIZE_STRING);
  $hash = sha1($pass);
  $errors[] = '';
  ($pass !== $re_pass ? $errors[] = "<div class='alert alert-danger'>password  is not eqaul re-password! </div>" : null);
  (empty($email) ? $errors[] =   "<div class='alert alert-danger'> email  is empty! </div>" : null);
  (empty($pass) ? $errors[] =  "<div class='alert alert-danger'> password  is empty! </div>" : null);
  (empty($re_pass) ? $errors[] =  "<div class='alert alert-danger'> re_password  is empty! </div>" : null);
  (empty($user) ? $errors[] =  "<div class='alert alert-danger'> username  is empty! </div>" : null);
  foreach ($errors as $error) {
    if (!empty($error)) {
      echo $error;
      // echo myDirect($error, 'back');
    }
  }
  if(empty($error)){
    $stmt  = "INSERT INTO `users`  (username, email, password, date ) VALUES (:username, :email, :password, now())";
    $query = $con->prepare($stmt);
    $query->bindparam(':username', $user, PDO::PARAM_STR);
    $query->bindparam(':email', $email, PDO::PARAM_STR);
    $query->bindparam(':password', $pass, PDO::PARAM_STR);
    $insert = $query->execute();
    $count = $query->rowCount();
    if ($count == true) {
      
  
      header('location: login.php');
      exit();
    }
  }
}
// End sign new user
?>
<div class="container login-page">
  <h2 class="text-center">
    <span class='login-span active' data-class='login'>Login </span> | <span data-class="signup"> signup</span>
  </h2>
  <!-- login Form -->
  <form class="login" method="POST" action="<?php echo $_SERVER['PHP_SELF'] ?>">
    <div class="form-group">

      <input type="username" name='user' class="form-control" placeholder="Write your username">
    </div>
    <div class="form-group">
      <input type="password" name='pass' class="form-control" placeholder="Password">
    </div>
    <div class="form-group">
      <input type="submit" name='login' class="form-control btn-primary" value="login">
    </div>
  </form>
  <!-- End login Form -->
  <!-- start signup form -->
  <form class="signup" method="POST" action="<?php echo $_SERVER['PHP_SELF'] ?>">
    <div class="form-group">
      <input type="username" class="form-control" placeholder="Write your username" name="username" minlength="4" requird>
    </div>
    <div class="form-group">
      
      <input type="email" class="form-control" placeholder="Write your Email" name="email" minlength="4" requird>
    </div>
    <div class="form-group">
      <input type="password" class="form-control" placeholder="Password" name="pass" minlength="4" requird>
    </div>
    <div class="form-group">
      <input type="password" class="form-control" placeholder="Re-Password again" name="re-pass">
     </div> 
     <div class="form-group">
      <input type="submit" class="form-control btn-success " name="signup" value="signup">
    </div>
  </form>
  <!-- End signup form -->
</div>
<?php
include $temp . 'footer.php';
?>