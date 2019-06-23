<?php



session_start();
$noNav = '';
$page_title = 'Login';
if(isset($_SESSION['user'])){
   
    header('location: index.php');
}
include 'ini.php';
// check if action come from http
// check form data from database
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login']) ){
  
    $user = $_POST['user'];
    $pass = $_POST['pass'];
    $hash = sha1($pass);
    $stmt  = "SELECT * FROM users WHERE username =:username AND password=:password ";
    $query = $con->prepare($stmt);
    
    $query->bindparam(':username', $user, PDO::PARAM_STR);
    $query->bindparam(':password', $pass, PDO::PARAM_STR);
    $insert = $query->execute();
    $count = $query->rowCount();
    $fetch = $query->fetch();
    
    if ($count == true){
        echo 'checked and it\'s true';
        $_SESSION['user'] = $user;
        
        header('location: index.php');
        exit();
    }

}

?>
<div class="container login-page">
    <h2 class="text-center">
    <span class='login-span active' data-class='login'>Login </span> | <span data-class="signup"> signup</span>
    </h2>
<form class="login" method="POST"  action="<?php echo $_SERVER['PHP_SELF'] ?>" >
  <div class="form-group">
   
    <input type="username" name='user' class="form-control"  placeholder="Write your username">
  </div>
  <div class="form-group">
    <input type="password" name='pass' class="form-control"  placeholder="Password">
  </div>
  <div class="form-group">
    <input type="submit" name='login' class="form-control btn-primary"  value="login">
  </div>
</form>
<form class="signup" method="POST" >
  <div class="form-group">
   
    <input type="username" class="form-control" placeholder="Write your Email">
  </div>
  <div class="form-group">
    <input type="password" class="form-control"  placeholder="Password">
  </div>
  <div class="form-group">
    <input type="password" class="form-control"  placeholder="Re-Password again">
  </div>
  <div class="form-group">
    <input type="submit" class="form-control btn-success"  value="login">
  </div>
</form>
</div>


<?php
include $temp . 'footer.php';
?>