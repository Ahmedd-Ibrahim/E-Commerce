<?php
/**
 * manage memmbers [ Edit || update || Delete || Add || status]
 */
session_start();
if(isset($_SESSION['username'])){
    
    $page_title = 'members';
    include 'ini.php';
    
    $do = (isset($_GET['do'])? $_GET['do'] : 'manage' );
   
    if($do == 'manage'){ // start manage member  dashboard page
   
      $queu = '';
      if(isset($_GET['page']) && $_GET['page'] == 'pending'){  // check if will display only activate members
        $queu = 'WHERE regStatus = 0';
      }
            $q = "SELECT * FROM `users`  $queu";
            $query = $con->prepare($q);
            $update = $query->execute();
            $fetchUsers = $query->fetchAll();
            $totalCount = $query->rowCount();
    ?>
        <div class="container">
            <h1 class="text-center">Mange Member</h1>
            <div class="table-responsive member-table">
        <table class="table table-dark table-bordered ">
  <thead>
    <tr>
      <th scope="col">User Id</th>
      <th scope="col">Username</th>
      <th scope="col">Email</th>
      <th scope="col">full Name</th>
      <th scope="col">Regestir Data</th>
      <th scope="col">Control</th>
    </tr>
  </thead>
  
 <?php if(isset($fetchUsers )){  // loop to catch all users information
foreach($fetchUsers as $member){ 
  ?>
    <tbody>
    <tr>
    <th scope="row"><?php echo $member['userId'];?></th>
    <td><?php echo $member['username'];?></td>
    <td><?php echo $member['email'];?></td>
    <td><?php echo $member['fullName'];?></td>
    <td><?php echo 
    $member['date'] ?></td>
    <td>
        <a href="members.php?do=edit&id=<?php echo $member['userId']; ?>" class="btn btn-success">Edit </a>
        <a href="members.php?do=delete&id=<?php echo $member['userId']; ?>" class="btn btn-danger ">Delete</a>
        <?php if($member['regStatus'] == 0){  ?>
          <a href="members.php?do=active&id=<?php echo $member['userId']; ?>" class="btn btn-info ">active</a>
          <?php
        }
          ?>
    </td>
  </tr>
</tbody>
  <?php }}?>
</table>
</div>
<a href="members.php?do=add" class="btn btn-primary">Add New members</a>
        </div>
       
        <?php
    }  // End manage page && dashboard

    elseif($do == 'add'){ // start add members script
       if (isset($_POST['add']) && $do == 'add') {
        echo "<div class='container'>";
        echo "<h1 class='text-center'></h1>";
        $user = $_POST['username'];
        $pass = $_POST['password'];
        $email = $_POST['email'];
        $fullName = $_POST['fullName'];
          // form errors messages
          $error[] = ''; 
          (empty($user)? $error[] = "<div class='alert alert-danger' >User is empty </div>": null);
          (strlen($user) <= 3 ? $error[] = '<div class="alert alert-danger" >User must be longer than 3 </div> ': null);
          (empty($pass)? $error[] = '<div class="alert alert-danger" >password is empty </div>': null);
          (empty($email)? $error[] = '<div class="alert alert-danger" >Email is empty </div>': null);
          (empty($fullName)? $error[] = '<div class="alert alert-danger" >full name is empty</div>': null);
          foreach($error as $oneError){
              if(!empty($oneError)){ // show errors if exists
                  echo $oneError ;
              } 
          }
        if(empty($oneError) && $_SERVER['REQUEST_METHOD'] == 'POST'){ // if no error and method POST insert this user
          $userExist = checkUsername('username', 'users',$user); 
          if($userExist == true){  // if user exists display an error message and stop script
            $mesg = '<div class="alert alert-danger">This user is exist </div>';
            echo myDirect($mesg,'back');
          } else{  // insert user data after everything fits
            $q = "INSERT INTO `users` (username, password, email, fullName,regStatus ,date) values(:username, :password, :email, :fullName, 1 ,now())";
            $query = $con->prepare($q);
            $query->bindparam(':username', $user, PDO::PARAM_STR);
            $query->bindparam(':password', $pass, PDO::PARAM_STR);
            $query->bindparam(':email', $email, PDO::PARAM_STR);
            $query->bindparam(':fullName', $fullName, PDO::PARAM_STR);
            $update = $query->execute();
            if($update == true){ 
              echo '<div class="alert alert-success">success and will inserted</div>';
            }
          }
        } 
      echo "</div>";
    }
       ?>
       <form class="form-group edit-form" action="?do=add" method="POST">
       <div class="container">
       <h1>add New Member</h1>
<div class="form-group row ">
 <label for="username" class="col-sm-1 col-label">username</label>
 <div class="col-sm-4  ">
   <input type="text" class="form-control" id="username" autocomplete="off" name='username' required placeholder='Username'>
 </div>
</div>
<div class="form-group row">
 <label for="password" class="col-sm-1 col-form-label">Password</label>
 <div class="col-sm-4">
   <input type="password" class="form-control" autocomplete="off" id="password" required name='password' placeholder="Add New password">
 </div>
</div>
<div class="form-group row ">
 <label for="email" class="col-sm-1 col-label">Email</label>
 <div class="col-sm-4  ">
   <input type="email" class="form-control" id="email" autocomplete="off" name="email" required placeholder='Email' >
 </div>
</div>
<div class="form-group row ">
 <label for="fullName" class="col-sm-1 col-label">Full Name</label>
 <div class="col-sm-4  ">
   <input type="text" class="form-control" id="fullName" name='fullName' required autocomplete="off" placeholder='full Name'>
 </div>
</div>

<div class="form-group row">
 <div class="col-sm-5">
   <button type="submit" name='add' class="btn btn-primary btn-block btn-lg">Add New member</button>
 </div>
</div>
</div>
</form>
<?php
    }// end add script
    
    elseif ($do == 'edit'){   // Edit page  start script
      
       // get data which will edit and display inside inputs and catch id which will controlled
        if(isset($_GET['id']) && is_numeric($_GET['id'])){
            $id =  intval($_GET['id']);
            $stmt = "SELECT * FROM users  WHERE userId=:userId";
            $query = $con->prepare($stmt);
            $query->bindparam(':userId',$_GET['id'], PDO::PARAM_INT);
            $insert = $query->execute();
            $fetch = $query->fetch();
        } else{
            echo 0;
        }
    ?>
      <form class="form-group edit-form" action="?do=update" method="POST">
          <div class="container">
          <h1>Edit Member</h1>
  <div class="form-group row ">
    <label for="username" class="col-sm-1 col-label">username</label>
    <div class="col-sm-4  ">
      <input type="text" class="form-control" id="username" autocomplete="off" name='username' required value="<?php echo $fetch['username']; ?>">
    </div>
  </div>
  <input type="hidden" name='userId' value="<?php echo $id ?>">
  <div class="form-group row">
    <label for="password" class="col-sm-1 col-form-label">Password</label>
    <div class="col-sm-4">
      <input type="password" class="form-control" autocomplete="off" id="password" required name='password' placeholder="Add New password">
    </div>
  </div>
  <div class="form-group row ">
    <label for="email" class="col-sm-1 col-label">Email</label>
    <div class="col-sm-4  ">
      <input type="email" class="form-control" id="email" autocomplete="off" name="email" required value="<?php echo  $fetch['email']; ?>">
    </div>
  </div>
  <div class="form-group row ">
    <label for="fullName" class="col-sm-1 col-label">Full Name</label>
    <div class="col-sm-4  ">
      <input type="text" class="form-control" id="fullName" name='fullName' required autocomplete="off" value="<?php echo $fetch['fullName']; ?>">
    </div>
  </div>

  <div class="form-group row">
    <div class="col-sm-5">
      <button type="submit" name='update' class="btn btn-primary btn-block btn-lg">UpDate</button>
    </div>
  </div>
  </div>
</form>

        <?php
        if (isset($_POST['update']) && $do == 'update') { // when update profile or update any members
    echo "<div class='container'>";
    echo "<h1 class='text-center'>Update Members</h1>";
    $user = $_POST['username'];
    $pass = $_POST['password'];
    $email = $_POST['email'];
    $fullName = $_POST['fullName'];
    $user_id = $_POST['userId'];
      // form errors messages
      $error[] = ''; 
      (empty($user)? $error[] = "<div class='alert alert-danger' >User is empty </div>": null);
      (strlen($user) <= 3 ? $error[] = '<div class="alert alert-danger" >User must be longer than 3 </div> ': null);
      (empty($pass)? $error[] = '<div class="alert alert-danger" >password is empty </div>': null);
      (empty($email)? $error[] = '<div class="alert alert-danger" >Email is empty </div>': null);
      (empty($fullName)? $error[] = '<div class="alert alert-danger" >full name is empty</div>': null);
      foreach($error as $oneError){
          if(!empty($oneError)){
              echo $oneError ;
          } 
      }
    if(empty($oneError) && $_SERVER['REQUEST_METHOD'] == 'POST'){
        $q = "UPDATE users SET username=:username, password=:password, email=:email, fullName=:fullName WHERE userId=:user_id";
        $query = $con->prepare($q);
        $query->bindparam(':username', $user, PDO::PARAM_STR);
        $query->bindparam(':password', $pass, PDO::PARAM_STR);
        $query->bindparam(':email', $email, PDO::PARAM_STR);
        $query->bindparam(':fullName', $fullName, PDO::PARAM_STR);
        $query->bindparam(':user_id', $user_id, PDO::PARAM_INT);
        $update = $query->execute();
        if($update == true){
          echo '<div class="alert alert-success">success</div>';
        } else{
            echo 'erorr can';
        }
    } 
  echo "</div>";
   
} 
    } // end edit condition
    // start delete script
elseif($do == 'delete'){
  $stmt = "DELETE FROM `users` WHERE userId=:userId";
  $userId = intval($_GET['id']);
  $query = $con->prepare($stmt);
  $query->bindparam(':userId', $userId, PDO::PARAM_INT);
  $query->execute();
  $count = $query->rowCount();
  $msg = '<div class="alert alert-success">success Delete Member </div>';
  echo myDirect($msg,'back');
}
// end delete script
elseif($do == 'active'){ // start activate script
  $userId = intval($_GET['id']);
  echo 'active';
  $q = "UPDATE users SET regStatus=1 WHERE userId=:user_id";
  $query = $con->prepare($q);
  $query->bindparam(':user_id',$userId, PDO::PARAM_INT);
  $query->execute();
  header('location:members.php');
  exit();
}
// end activate script

 else{
   if($do != 'update'){
    $mesg = '<div class="alert alert-danger">can\'t access to this page directly </div>';
    echo myDirect($mesg, 'back' );
   }
}

if (isset($_POST['update']) && $do == 'update') {
    echo "<div class='container'>";
    echo "<h1 class='text-center'>Update Members</h1>";
    $user = $_POST['username'];
    $pass = $_POST['password'];
    $email = $_POST['email'];
    $fullName = $_POST['fullName'];
    $user_id = $_POST['userId'];
      // form errors messages
      $error[] = ''; 
      (empty($user)? $error[] = "<div class='alert alert-danger' >User is empty </div>": null);
      (strlen($user) <= 3 ? $error[] = '<div class="alert alert-danger" >User must be longer than 3 </div> ': null);
      (empty($pass)? $error[] = '<div class="alert alert-danger" >password is empty </div>': null);
      (empty($email)? $error[] = '<div class="alert alert-danger" >Email is empty </div>': null);
      (empty($fullName)? $error[] = '<div class="alert alert-danger" >full name is empty</div>': null);
     
      foreach($error as $oneError){
          if(!empty($oneError)){
              echo $oneError ;
          } 
      }
    if(empty($oneError) && $_SERVER['REQUEST_METHOD'] == 'POST'){
        $q = "UPDATE users SET username=:username, password=:password, email=:email, fullName=:fullName WHERE userId=:user_id";
        $query = $con->prepare($q);
        $query->bindparam(':username', $user, PDO::PARAM_STR);
        $query->bindparam(':password', $pass, PDO::PARAM_STR);
        $query->bindparam(':email', $email, PDO::PARAM_STR);
        $query->bindparam(':fullName', $fullName, PDO::PARAM_STR);
        $query->bindparam(':user_id', $user_id, PDO::PARAM_INT);
        $update = $query->execute();
        if($update == true){
          $sg = '<div class="alert alert-success">success</div>';
          echo myDirect($sg, 'back');
        } else{
            echo 'erorr can';
        }
    } 
  echo "</div>";
   
}
}
include $temp . 'footer.php';