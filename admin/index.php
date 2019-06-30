<?php
ob_start();
session_start();
$noNav = '';
$page_title = 'Login';
if(isset($_SESSION['username'])) {
    header('location: dashboard.php');
}
include 'ini.php';

// check if action come from http
// check form data from database
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    if(isset($_POST['submit'])) {
    $user = $_POST['username'];
    $pass = $_POST['pass'];
    $hash = sha1($pass);
    $stmt  = "SELECT * FROM `users` WHERE username =:username AND password=:password AND groupId = 1";
    $query = $con->prepare($stmt);
    $query->bindparam(':username', $user, PDO::PARAM_STR);
    $query->bindparam(':password', $pass, PDO::PARAM_STR);
    $insert = $query->execute();
    $count = $query->rowCount();
    $fetch = $query->fetch();
    if ($count == true) {
        
   $_SESSION['user_id'] = $fetch['userId'];
   $_SESSION['username'] = $fetch['username'];
        header('location: dashboard.php');
        exit();
    }
}
}
?>
<form class='login' action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
    <h4 class="text-center">Admin Login</h4>
    <input class="form-control input-lg" type="text" name="username" placeholder="Username Or Email" autocomplete="off">
    <input class="form-control input-lg" type="password" name="pass" placeholder="Enter Your Password">
    <input class="btn btn-primary btn-block btn-lg" type="submit" value="Login" name="submit" >
</form>

<?php
include $temp . 'footer.php';
ob_end_flush();
?>