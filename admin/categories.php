<?php
ob_start();
$page_title = 'Categories';
session_start();
include 'ini.php';
if (isset($_SESSION['username'])) {
  if ($do == 'manage') { // genral page
    $sort = 'DESC';
    $sortArray = array('desc', 'asc');
    if (isset($_GET['sort']) && in_array($_GET['sort'], $sortArray)) {
      $sort = $_GET['sort'];
    }
    // condiditon to dinimc categories if pending
      if (isset($_GET['page']) && $_GET['page'] == 'pending'){
       
        $categories = get_all('*', 'categories', 'WHERE visibility = 0',  "",'');
      } else{
       
        $categories = get_all('*', 'categories', 'WHERE parent = 0', "ORDER BY id {$sort}",'');
        $child_categories = get_all('*', 'categories', 'WHERE parent != 0', "ORDER BY id {$sort}",'');
      }
    ?>
    <!-- Start mange Categories -->
    <div class="container categories">
      <h1 class="text-center">Manage Categories</h1>
      <div class="panel panel-default">
        <div class="panel-heading">
          Manage Categories
          <span class="collection">
            Ordering: [
            <a href="?sort=asc">ASC</a> |
            <a href="?sort=desc">DESC</a> ]
            View: [
            <a class="full" href="#">full</a> |
            <a class="classic" href="#">Classic</a>
            ]
          </span>
        </div>
        <div class="panel-body">
          <?php
          foreach ( $categories as $cat) {
            echo '<div class="cat">';
            echo '<h4> '. $cat['name'] . '</h4>';
            ?>
            <a href="?do=delete&id=<?php echo $cat['id']; ?>" class="btn btn-danger edit"><i class="fas fa-trash-alt"></i> Delete</a>
            <a href="?do=edit&id=<?php echo $cat['id']; ?>" class="btn btn-success edit"><i class="fas fa-edit"></i> Edit </a>
            <?php
            echo "<div class='box'>";            echo "<p>" . ($cat['description'] == '' ? 'description is empty' : $cat['description']) . '</p>';
          
            echo '<a href="?do=visibility&id=' . $cat['id'] . ' &vis=' . $cat['visibility'] . '" class="btn btn-info"> ' . ($cat['visibility'] == 0 ? '<i class="fas fa-check-circle"></i> display' : '<i class="fas fa-times-circle"></i> hidden') . ' </a>';
            echo '<span class="btn btn-danger">' . ($cat['allow_comment'] == 0 ? 'Disable comment' : 'Enable') . ' </span>';
            echo '<span class="btn btn-secondary">' . ($cat['allow_ads'] == 0 ? 'Remove Ads' : 'Add') . '</span>';
            
            $id = $cat['id']; // category id
              $child_categories = get_all('*', 'categories', "WHERE parent = {$id}", "",''); // get category child
              echo '<p>';
              foreach ($child_categories as $child){
                echo '<a href="#">' . $child['name'] . ' </a> | ';
              }

            echo '</p></div><hr></div>';
          }
          ?>
        </div>
      </div>
      <a href="?do=add" class="btn btn-primary">Add New Categories</a>
    </div>
    <!-- End mange Categories -->

  <?php
  
} elseif ($do == 'add') {  ?>
    <!-- Start add script -->
    <form class="form-group edit-form" action="?do=insert" method="POST">
      <div class="container">
        <h1>add New Categories</h1>
        <div class="form-group row ">
          <label class="col-sm-2 col-label  text-center">name</label>
          <div class="col-sm-4  ">
            <input type="name" class="form-control" autocomplete="off" name='name' placeholder='Name of Category'>
          </div>
        </div>
        <div class="form-group row">
          <label class="col-sm-2 col-form-label  text-center">description</label>
          <div class="col-sm-4">
            <input type="text" class="form-control" autocomplete="off" name='description' placeholder="Add a description">
          </div>
        </div>
        <div class="form-group row ">
          <label class="col-sm-2 col-label  text-center">ordering</label>
          <div class="col-sm-4  ">
            <input type="text" class="form-control" autocomplete="off" name="ordering" placeholder='number of range ordering'>
          </div>
        </div>
        <div class="form-group row ">
          <label class="col-sm-2 col-label  text-center">parent ?</label>
          <div class="col-sm-4  ">
                                                <select class="form-control" name="parent">
                                                    <option value="0">none</option>
                                                    <?php
                                                  
                                                    $fetchAll = get_all('id, name', 'categories','','','');
                                                    foreach ($fetchAll as $item) {
                                                        echo '<option value="' . $item['id'] . '">' . $item['name'] . '</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
        </div>
        <!-- visible filed -->
        <div class="form-group row ">
          <label class="col-sm-2 control-label  text-center">Visible</label>
          <div class="col-sm-4  ">
            <div>
              <input type="radio" id="vis-yes" name='visible' checked value="1">
              <label for="vis-yes">Yes</label>
            </div>
            <div>
              <input type="radio" id="vis-no" name='visible' value="0">
              <label for="vis-no">no</label>
            </div>
          </div>
        </div>
        <!-- End visible filed -->
        <!-- allow comments filed -->
        <div class="form-group row ">
          <label class="col-sm-2 control-label text-center">Allow commenting</label>
          <div class="col-sm-4  ">
            <div>
              <input type="radio" id="comment-yes" name='allow-comment' checked value="1">
              <label for="comment-yes">Yes</label>
            </div>
            <div>
              <input type="radio" id="comment-no" name='allow-comment' value="0">
              <label for="comment-no">no</label>
            </div>
          </div>
        </div>
        <!-- End comments filed -->
        <!-- ads filed -->
        <div class="form-group row ">
          <label class="col-sm-2 control-label text-center">Allow ads</label>
          <div class="col-sm-4  ">
            <div>
              <input type="radio" id="ads-yes" name='allow-ads' checked value="0">
              <label for="ads-yes">Yes</label>
            </div>
            <div>
              <input type="radio" id="ads-no" name='allow-ads' value="1">
              <label for="ads-no">no</label>
            </div>
          </div>
        </div>
        <!-- End ads filed -->

        <div class="form-group row">
          <div class="col-sm-5 offset-1">
            <button type="submit" name='insert' class="btn btn-primary btn-block btn-lg">Add New Catogers</button>
          </div>
        </div>
      </div>
    </form>
    <!-- End add script -->
  <?php

} elseif ($do == 'insert') {  // Insert script
  if (isset($_POST['insert']) && $do == 'insert') {
    echo "<div class='container'>";
    echo "<h1 class='text-center'></h1>";
    $name = $_POST['name'];
    $desc = $_POST['description'];
    $ordering = intval($_POST['ordering']);
    $visible = intval($_POST['visible']);
    $comment = intval($_POST['allow-comment']);
    $ads = intval($_POST['allow-ads']);
    $parent = intval($_POST['parent']);
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
       
        
        $q = "INSERT INTO `categories` (name, description, ordering, visibility, allow_comment, allow_ads, date, user_id, parent) 
        values(:name, :description, :ordering, :visible, :allow_comment, :allow_ads , now(), :user_id, :parent)";
        $query = $con->prepare($q);
        $query->bindparam(':name', $name, PDO::PARAM_STR);
        $query->bindparam(':description', $desc, PDO::PARAM_STR);
        $query->bindparam(':ordering', $ordering, PDO::PARAM_INT);
        $query->bindparam(':visible', $visible, PDO::PARAM_INT);
        $query->bindparam(':allow_comment', $comment, PDO::PARAM_INT);
        $query->bindparam(':allow_ads', $ads, PDO::PARAM_INT);
        $query->bindparam(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
        $query->bindparam(':parent', $parent, PDO::PARAM_INT);
        
        $update = $query->execute();
        if ($update == true) {
          $success = '<div class="alert alert-success">success and will inserted</div>';
          echo myDirect($success, 'back');
        }
      }
    }
    echo "</div>";
  }
  
  else { // come direct to page
    $direct = '<div class="alert alert-danger">can\'t browess this page dirctly </div>';
    echo myDirect($direct, 'back');
  }
} // End insert script 
elseif ($do == 'edit') { // start Edit script
  // get data which will edit and display inside inputs and catch id which will controlled
  if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id =  intval($_GET['id']);
    $stmt = "SELECT * FROM categories  WHERE id=:userId";
    $query = $con->prepare($stmt);
    $query->bindparam(':userId', $_GET['id'], PDO::PARAM_INT);
    $insert = $query->execute();
    $fetch = $query->fetch();
  } else {
    echo 0;
  }
  ?>
  <!-- start Edit categories -->
    <form class="form-group edit-form" action="?do=update&id=<?php echo $_GET['id']?>" method="POST">
      <div class="container">
        <h1><i class="fas fa-edit"></i> Edit categories</h1>
        <div class="form-group row ">
          <label class="col-sm-2 col-label  text-center">name</label>
          <div class="col-sm-4  ">
            <input type="name" class="form-control" autocomplete="off" name='name' value="<?php echo $fetch['name']; ?>">
          </div>
        </div>
        <div class="form-group row">
          <label class="col-sm-2 col-form-label  text-center">description</label>
          <div class="col-sm-4">
            <input type="text" class="form-control" autocomplete="off" name='description' placeholder="Add a description" value="<?php echo $fetch['description']; ?>">
          </div>
        </div>
        <div class="form-group row ">
          <label class="col-sm-2 col-label  text-center">ordering</label>
          <div class="col-sm-4  ">
            <input type="text" class="form-control" autocomplete="off" name="ordering" placeholder='number of range ordering' value="<?php echo $fetch['ordering']; ?>">
          </div>
        </div>
        <!-- visible filed -->
        <div class="form-group row ">
          <label class="col-sm-2 control-label  text-center">Visible</label>
          <div class="col-sm-4  ">
            <div>
              <input type="radio" id="vis-yes" name='visible' <?php if ($fetch['visibility'] == 0) {
                                                                echo 'checked';
                                                              } ?> value="0">
              <label for="vis-yes">Yes</label>
            </div>
            <div>
              <input type="radio" id="vis-no" name='visible' <?php if ($fetch['visibility'] == 1) {
                                                                echo 'checked';
                                                              } ?> value="1">
              <label for="vis-no">no</label>
            </div>
          </div>
        </div>
        <!-- End visible filed -->
        <!-- allow comments filed -->
        <div class="form-group row ">
          <label class="col-sm-2 control-label text-center">Allow commenting</label>
          <div class="col-sm-4  ">
            <div>
              <input type="radio" id="comment-yes" name='allow-comment' value="0" <?php if ($fetch['allow_comment'] == 0) {
                                                                                    echo 'checked';
                                                                                  }  ?>>
              <label for="comment-yes">Yes</label>
            </div>
            <div>
              <input type="radio" id="comment-no" name='allow-comment' value="1" <?php if ($fetch['allow_comment'] == 1) {
                                                                                    echo 'checked';
                                                                                  } ?>>
              <label for="comment-no">no</label>
            </div>
          </div>
        </div>
        <!-- End comments filed -->
        <!-- ads filed -->
        <div class="form-group row ">
          <label class="col-sm-2 control-label text-center">Allow ads</label>
          <div class="col-sm-4  ">
            <div>
              <input type="radio" id="ads-yes" name='allow-ads' checked value="0" <?php if ($fetch['allow_ads'] == 0) {
                                                                                    echo 'checked';
                                                                                  } ?>>
              <label for="ads-yes">Yes</label>
            </div>
            <div>
              <input type="radio" id="ads-no" name='allow-ads' value="1" <?php if ($fetch['allow_ads'] == 1) {
                                                                            echo 'checked';
                                                                          } ?>>
              <label for="ads-no">no</label>
            </div>
          </div>
        </div>
        <!-- End ads filed -->
        <div class="form-group row">
          <div class="col-sm-5">
            <button type="submit" name='update' class="btn btn-primary btn-block btn-lg"><i class="fas fa-edit"></i> EDIT!</button>
          </div>
        </div>
      </div>
    </form>
  <!-- start Edit categories -->
    <?php
    }
  // End Edit script
  elseif ($do == 'update') {
    if (isset($_POST['update']) && $do == 'update') { // when update profile or update any members
      echo "<div class='container'>";
      echo "<h1 class='text-center'></h1>";
      $name = $_POST['name'];
      $desc = $_POST['description'];
      $ordering = intval($_POST['ordering']);
      $visible = intval($_POST['visible']);
      $comment = intval($_POST['allow-comment']);
      $ads = intval($_POST['allow-ads']);
      $id = intval($_GET['id']);
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
          $q = "UPDATE `categories` SET name=:name, description=:description, ordering=:ordering, visibility=:visible, allow_comment=:allow_comment, allow_ads=:allow_ads, data=now() WHERE id=:id";
          $query = $con->prepare($q);
          $query->bindparam(':name', $name, PDO::PARAM_STR);
          $query->bindparam(':description', $desc, PDO::PARAM_STR);
          $query->bindparam(':ordering', $ordering, PDO::PARAM_INT);
          $query->bindparam(':visible', $visible, PDO::PARAM_INT);
          $query->bindparam(':allow_comment', $comment, PDO::PARAM_INT);
          $query->bindparam(':allow_ads', $ads, PDO::PARAM_INT);
          $query->bindparam(':id', $id, PDO::PARAM_INT);
          $update = $query->execute();
          if ($update == true) {
            $success = '<div class="alert alert-success">success and will inserted</div>' ;
            echo myDirect($success, 'categories.php');
          }
        }
      }
      echo "</div>";
    } else { //come direct to page
       $direct = '<div class="alert alert-danger">can\'t browess this page dirctly </div>';
       echo myDirect($direct, 'back');
     }
   } elseif ($do == 'delete' &&  isset($_SERVER['HTTP_REFERER'])) {
    $stmt = "DELETE FROM `categories` WHERE id=:userId";
    $userId = intval($_GET['id']);
    $query = $con->prepare($stmt);
    $query->bindparam(':userId', $userId, PDO::PARAM_INT);
    $query->execute();
    $count = $query->rowCount();
    if($count == true){
      $msg = '<div class="alert alert-info">success Delete Member </div>';
      echo myDirect($msg,'back',1);
    }
    }
  // sub action
  if ($do == 'visibility') {
    if ($_GET['vis'] == 0) {
      $catId =  $_GET['id'];
      $q2 = "UPDATE categories SET  visibility=1 WHERE id =:id";
      $query = $con->prepare($q2);
      $query->bindparam(':id', $catId, PDO::PARAM_INT);
      $checked = $query->execute();
      if ($checked == true) {
        header('location:categories.php');
      }
    } elseif ($_GET['vis'] == 1) {
      $catId =  $_GET['id'];
      $q2 = "UPDATE categories SET  visibility=0 WHERE id =:id";
      $query = $con->prepare($q2);
      $query->bindparam(':id', $catId, PDO::PARAM_INT);
      $checked = $query->execute();
      if ($checked == true) {
        header('location:categories.php');
      }
    }
  }
  // end sub action
} else{
  $msg = '<div class="alert alert-danger">You don\'t Have permision to access to this page </div>';
  echo myDirect($msg, 'index.php');
}
include $temp . 'footer.php';
ob_end_flush();