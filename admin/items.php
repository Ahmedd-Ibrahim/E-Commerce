<?php

$page_title = 'Items';
session_start();
include 'ini.php';
if (isset($_SESSION['username'])) {
  

  if ($do == 'manage') {
    // start view Item and manage script 

    $queu = '';
    if (isset($_GET['page']) && $_GET['page'] == 'pending') {  // check if will display only activate members
      $queu = 'WHERE status = 0';
    }
    $q = "SELECT items.*, users.username , categories.name as catName FROM items INNER JOIN users on users.userId = user_id
    INNER JOIN categories ON categories.id = cat_id  $queu ORDER BY items.item_id DESC";
    $query = $con->prepare($q);
    $update = $query->execute();
    $fetchitems = $query->fetchAll();
    $totalCount = $query->rowCount();
    ?>
    <div class="container">
      <h1 class="text-center">Mange Items</h1>
      <div class="table-responsive item-table">
        <table class="table table-dark table-bordered ">
          <thead>
            <tr>
              <th scope="col">Id</th>
              <th scope="col">Name </th>
              <th scope="col">Description</th>
              <th scope="col">Country</th>
              <th scope="col">price</th>
              <th scope="col">Member Name</th>
              <th scope="col">Catogary</th>
              <th scope="col">status</th>
              <th scope="col">Control</th>
            </tr>
          </thead>

          <?php if (isset($fetchitems)) {  // loop to catch all users information
            foreach ($fetchitems as $item) {
              ?>
              <tbody>
                <tr>
                  <th scope="row"><?php echo $item['item_id']; ?></th>
                  <td><?php echo $item['name']; ?></td>
                  <td><?php echo $item['description']; ?></td>
                  <td><?php echo $item['country_made']; ?></td>
                  <td><?php echo $item['price']; ?></td>
                  <td><?php echo $item['username']; ?></td>
                  <td><?php echo $item['catName']; ?></td>
                  <td><?php echo ($item['status'] == 1 ? 'Active' : 'Deactive'); ?></td>
                  <td>
                    <a href="?do=delete&id=<?php echo $item['item_id']; ?>" class="btn btn-danger edit">Delete</a>
                    <a href="?do=edit&id=<?php echo $item['item_id']; ?>" class="btn btn-success edit">Edit </a>
                    <?php if ($item['status'] == 0) {  ?>
                      <a href="items.php?do=active&id=<?php echo $item['item_id']; ?>" class="btn btn-info ">active</a>
                    <?php
                  } else {
                    ?>
                      <a href="items.php?do=deactive&id=<?php echo $item['item_id']; ?>" class="btn btn-info ">deactive</a>
                    <?php
                  }
                  ?>
                  </td>
                </tr>
              </tbody>
            <?php }
        } ?>
        </table>
      </div>
      <a href="items.php?do=add" class="btn btn-primary">Add New Item</a>
    </div>
  <?php

  // End view Item script


} elseif ($do == 'active') {
  $item_id = intval($_GET['id']);
  echo 'active';
  $q = "UPDATE items SET status=1 WHERE item_id=:item_id";
  $query = $con->prepare($q);
  $query->bindparam(':item_id', $item_id, PDO::PARAM_INT);
  $query->execute();
  header('location:items.php');
  exit();
} elseif ($do == 'deactive') {
  $item_id = intval($_GET['id']);
  echo 'active';
  $q = "UPDATE items SET status=0 WHERE item_id=:item_id";
  $query = $con->prepare($q);
  $query->bindparam(':item_id', $item_id, PDO::PARAM_INT);
  $query->execute();
  header('location:items.php');
  exit();
} elseif ($do == 'add') { ?>
    <!-- Start add script -->
    <form class="form-group add-form" action="?do=insert" method="POST">
      <div class="container">
        <h1>add New Item</h1>
        <div class="form-group row ">
          <label class="col-sm-1 col-label ">name</label>
          <div class="col-sm-4  ">
            <input type="name" class="form-control" autocomplete="off" name='name' placeholder='Name of Item' required>
          </div>
        </div>
        <div class="form-group row">
          <label class="col-sm-1 col-form-label  ">description</label>
          <div class="col-sm-4">
            <input type="text" class="form-control" autocomplete="off" name='description' placeholder="Add a description">
          </div>
        </div>
        <div class="form-group row ">
          <label class="col-sm-1 col-label  ">price</label>
          <div class="col-sm-4  ">
            <input type="text" class="form-control" autocomplete="off" name="price" placeholder='price of the item' required>
          </div>
        </div>
        <div class="form-group row ">
          <label class="col-sm-1 col-label  ">country</label>
          <div class="col-sm-4  ">
            <input type="text" class="form-control" autocomplete="off" name="country" placeholder='Country of made' required>
          </div>
        </div>
        <div class="form-group row ">
          <label class="col-sm-1 col-label">status</label>
          <div class="col-sm-4  ">
            <select class="form-control" name="status">
              <option value="1">new</option>
              <option value="2">like New</option>
              <option value="3">used</option>
              <option value="4">Old</option>
            </select>
          </div>
        </div>
        <div class="form-group row ">
          <label class="col-sm-1 col-label">members</label>
          <div class="col-sm-4  ">
            <select class="form-control" name="members">
              <option value="1">...</option>
              <?php
              $qu = "SELECT userId, username FROM `users`";
              $query = $con->prepare($qu);
              $query->execute();
              $fetchAll = $query->fetchAll();
              foreach ($fetchAll as $user) {
                echo '<option value="' . $user['userId'] . '">' . $user['username'] . '</option>';
              }
              ?>
            </select>
          </div>
        </div>
        <div class="form-group row ">
          <label class="col-sm-1 col-label">categories</label>
          <div class="col-sm-4  ">
            <select class="form-control" name="cat">
              <option value="1">...</option>
              <?php
              $qu = "SELECT id, name FROM `categories`";
              $query = $con->prepare($qu);
              $query->execute();
              $fetchAll = $query->fetchAll();
              foreach ($fetchAll as $item) {
                echo '<option value="' . $item['id'] . '">' . $item['name'] . '</option>';
              }
              ?>
            </select>
          </div>
        </div>
        <div class="form-group row">
          <div class="col-sm-5">
            <button type="submit" name='insert' class="btn btn-primary btn-block btn-lg">Add New item</button>
          </div>
        </div>
      </div>
    </form>
    <!-- End add script -->
  <?php

} elseif ($do == 'insert') {
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $status = $_POST['status'];
    $desc = $_POST['description'];
    $price = $_POST['price'];
    $made = $_POST['country'];
    $member_id = $_POST['members'];
    $cat_id = $_POST['cat'];
    // form errors messages
    $error[] = '';
    (empty($name) ? $error[] =  "<div class='alert alert-danger' >name is empty </div>" : null); // name can't empty
    (strlen($name) <= 3 ? $error[] = '<div class="alert alert-danger" >name must be longer than 3 </div> ' : null); // name must be longer than 3 char
    foreach ($error as $oneError) {
      if (!empty($oneError)) { // show errors if exists
        echo myDirect($oneError, 'back');
      }
    } // end error message 
    if (empty($oneError)) {  // if no error access into database
      $q = 'INSERT INTO `items` (name, price, add_date, country_made,status, description, user_id, cat_id)
        VALUES
        (:name, :price, now(), :country_made,:status, :description, :user_id, :cat_id)
        ';
      $query = $con->prepare($q);
      $query->bindparam(':name', $name, PDO::PARAM_STR);
      $query->bindparam(':price', $price, PDO::PARAM_STR);
      $query->bindparam(':country_made', $made, PDO::PARAM_STR);
      $query->bindparam(':status', $status, PDO::PARAM_STR);
      $query->bindparam(':description', $desc, PDO::PARAM_STR);
      $query->bindparam(':user_id', $member_id, PDO::PARAM_INT);
      $query->bindparam(':cat_id', $cat_id, PDO::PARAM_INT);
      $insert = $query->execute();
      if ($insert == true) {
        $mesg = '<div class="alert alert-success" >success add item </div>';
        echo myDirect($mesg, 'back');
      }
    }
  }
} elseif ($do == 'edit') {  // start Edit script
  // get data which will edit and display inside inputs and catch id which will controlled
  if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id =  intval($_GET['id']);
    $stmt = "SELECT * FROM items  WHERE item_id=:item_id";
    $query = $con->prepare($stmt);
    $query->bindparam(':item_id', $_GET['id'], PDO::PARAM_INT);
    $insert = $query->execute();
    $fetch = $query->fetch();
    $usId = $fetch['user_id'];
  } else {
    echo 0;
  }
  $rowCount = checkUsername('item_id', 'items', $id); // check if item exists
  if ($rowCount !== 0 && isset($_SERVER['HTTP_REFERER'])) {  ?>
  <!-- Form Edit item -->
      <form class="form-group edit-form" action="?do=update&id=<?php echo $_GET['id'] ?>" method="POST">
        <form class="form-group add-form" action="?do=insert" method="POST">
          <div class="container">
            <h1>Edit Item</h1>
            <div class="form-group row ">
              <label class="col-sm-1 col-label ">name</label>
              <div class="col-sm-4  ">
                <input type="name" class="form-control" autocomplete="off" name='name' placeholder='<?php echo $fetch['name']; ?>' required>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-1 col-form-label  ">description</label>
              <div class="col-sm-4">
                <input type="text" class="form-control" autocomplete="off" name='description' placeholder='<?php echo $fetch['description']; ?>'>
              </div>
            </div>
            <div class="form-group row ">
              <label class="col-sm-1 col-label  ">price</label>
              <div class="col-sm-4  ">
                <input type="text" class="form-control" autocomplete="off" name="price" placeholder='<?php echo $fetch['price']; ?>' required>
              </div>
            </div>
            <div class="form-group row ">
              <label class="col-sm-1 col-label  ">country</label>
              <div class="col-sm-4  ">
                <input type="text" class="form-control" autocomplete="off" name="country" placeholder='<?php echo $fetch['country_made']; ?>' required>
              </div>
            </div>
            <div class="form-group row ">
              <label class="col-sm-1 col-label">status</label>
              <div class="col-sm-4  ">
                <select class="form-control" name="status">
                  <option <?php echo ($fetch['status']) == 1 ? 'Selected' : null; ?> value="1">new</option>
                  <option <?php echo ($fetch['status']) == 2 ? 'Selected' : null; ?> value="2">like New</option>
                  <option <?php echo ($fetch['status']) == 3 ? 'Selected' : null; ?> value="3">used</option>
                  <option <?php echo ($fetch['status']) == 4 ? 'Selected' : null; ?> value="4">Old</option>
                </select>
              </div>
            </div>
            <div class="form-group row ">
              <label class="col-sm-1 col-label">members</label>
              <div class="col-sm-4  ">
                <select class="form-control" name="members">
                  <?php
                  $qu = "SELECT userId, username FROM `users`";
                  $query = $con->prepare($qu);
                  $query->execute();
                  $fetchAll = $query->fetchAll();
                  foreach ($fetchAll as $user) {
                    $select = ($fetch['user_id'] === $user['userId'] ? 'selected' : null);
                    echo '<option ' . $select .   ' value="' . $user['userId'] . '">' . $user['username'] . '</option>';
                  }
                  ?>
                </select>
              </div>
            </div>
            <div class="form-group row ">
              <label class="col-sm-1 col-label">categories</label>
              <div class="col-sm-4  ">
                <select class="form-control" name="cat">
                  <?php
                  $qu = "SELECT id, name FROM `categories`";
                  $query = $con->prepare($qu);
                  $query->execute();
                  $fetchAll = $query->fetchAll();
                  foreach ($fetchAll as $item) {
                    $select = ($fetch['cat_id'] === $item['id'] ? 'selected' : null);
                    echo '<option ' . $select . ' value="' . $item['id'] . '">' . $item['name'] . '</option>';
                  }
                  ?>
                </select>
              </div>
            </div>
            <div class="form-group row">
              <div class="col-sm-5">
                <button type="submit" name='update' class="btn btn-primary btn-block btn-lg">Edit item</button>
              </div>
            </div>
          </div>
        </form>
        <!-- End add script -->
      </form>
        <!--End Form Edit item -->
      <?php
      $item_id = $_GET['id'];
      $sq = "SELECT comments.*,users.fullName, items.name FROM comments INNER JOIN items ON items.item_id = comments.id_item inner JOIN users on items.user_id = users.userId WHERE items.item_id=:item_id ";
      $query = $con->prepare($sq);
      $query->bindparam(':item_id', $item_id, PDO::PARAM_INT);
      $update = $query->execute();
      $row = $query->rowCount();
      $lastComment = $query->fetchAll();
?>
<!-- start comments at edit page  -->
      <div class="box">   
                      
                         <div class="users"><?php foreach ($lastComment as $comment) { ?>
<?php
                                echo'<div class="last-comment">' ;
                                        echo "<span class='comment-user'>".
                                         $comment['fullName'] .
                                          "</span> <div class='comment-content'>" .
                                          $comment['comment'] .
                                          "</div><div class='comment-date'>".
                                          $comment['date']
                                          ."</div>" ; 
                                        ?>
                                        <span class="latest-span">
                                         <a href="comments.php?do=edit&id=<?php echo $comment['comment_id']; ?>" class="btn btn-success">Edit </a>
                                         <a href="comments.php?do=delete&id=<?php echo $comment['comment_id']; ?>" class="btn btn-danger ">Delete</a>
                                         </span>
                               <?php  echo '</div>';
                            } ?></div>
                    </div>
    <?php } else {
    $msg = '<div class="alert alert-info">no such id or username </div>';
    echo myDirect($msg, 'back');
  }
//  <!-- start comments at edit page  -->
} elseif ($do == 'delete') { // delet action
  $stmt = "DELETE FROM `items` WHERE item_id=:item_id";
  $item_id = intval($_GET['id']);
  $check = checkUsername('item_id', 'items', $item_id);
  if ($check == true) {
    $query = $con->prepare($stmt);
    $query->bindparam(':item_id', $item_id, PDO::PARAM_INT);
    $query->execute();
    $count = $query->rowCount();
    $msg = '<div class="alert alert-success">success Delete this Item </div>';
    echo myDirect($msg, 'back');
  } else {
    $msg = '<div class="alert alert-danger"> can\'t access to this file </div>';
    echo myDirect($msg, 'dashboard.php');
  }
} elseif ($do == 'update') { //start update script
  if (isset($_POST['update']) && $do == 'update') { // check if set update

    echo "<div class='container'>";
    echo "<h1 class='text-center'></h1>";
    $name = $_POST['name'];
    $desc = $_POST['description'];
    $price = intval($_POST['price']);
    $status = intval($_POST['status']);
    $userId = intval($_POST['members']);
    $cat = intval($_POST['cat']);
    $item_id = intval($_GET['id']);
    $country = $_POST['country'];

    // form errors messages
    $error[] = '';
    (empty($name) ? $error[] =  "<div class='alert alert-danger' >name is empty </div>" : null);
    (strlen($name) <= 3 ? $error[] = '<div class="alert alert-danger" >name must be longer than 3 </div> ' : null);
    foreach ($error as $oneError) {
      if (!empty($oneError)) { // show errors if exists
        echo myDirect($oneError, 'back');
      }
    }
    if (empty($oneError) && $_SERVER['REQUEST_METHOD'] == 'POST') { // if no error and method POST insert this user
      $catExist = checkUsername('name', 'categories', $name);
      if ($catExist == true) {  // if categories exists display an error message and stop script
        $mesg = '<div class="alert alert-danger">This categories is exist </div>';
        echo myDirect($mesg, 'back');
      } else {  // insert categories data
        $q = "UPDATE `items` SET name=:name, description=:description, price=:price, status=:status, country_made=:country, user_id=:user_id, cat_id=:cat_id, add_date=now() WHERE item_id=:item_id";
        $query = $con->prepare($q);
        $query->bindparam(':name', $name, PDO::PARAM_STR);
        $query->bindparam(':description', $desc, PDO::PARAM_STR);
        $query->bindparam(':price', $price, PDO::PARAM_INT);
        $query->bindparam(':status', $status, PDO::PARAM_INT);
        $query->bindparam(':country', $country, PDO::PARAM_STR);
        $query->bindparam(':user_id', $userId, PDO::PARAM_INT);
        $query->bindparam(':cat_id', $cat, PDO::PARAM_INT);
        $query->bindparam(':item_id', $item_id, PDO::PARAM_INT);
        $update = $query->execute();
        if ($update == true) {
          $success = '<div class="alert alert-success">success and will inserted</div>';
          echo myDirect($success, 'items.php');
        }
      }
    }
    echo "</div>";
  } else { // if come direct to page
    $direct = '<div class="alert alert-danger">can\'t browess this page dirctly </div>';
    echo myDirect($direct, 'back');
  }
  // end update script
} 
} else{
  $msg = '<div class="alert alert-danger">login to browess this page dirctly </div>';
    echo myDirect($msg, 'index.php');
    exit(); 
  
}
include $temp . 'footer.php';
