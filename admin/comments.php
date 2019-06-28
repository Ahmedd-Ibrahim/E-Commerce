<?php
/**
 * manage comments [ Edit || update || Delete || Add || status]
 */
session_start();
if (isset($_SESSION['username'])) {
    $page_title = 'Mange Comments';
    include 'ini.php';

    $do = (isset($_GET['do']) ? $_GET['do'] : 'manage');

    if ($do == 'manage') { // start manage comments  dashboard page
        $queu = '';
        if (isset($_GET['page']) && $_GET['page'] == 'pending') {  // check if will display only activate comments
            $queu = ' WHERE comments.status = 0';
        }
        // $q = "SELECT * FROM `comments`  $queu";
        $sql = "SELECT comments.*,users.username, items.name FROM comments  INNER JOIN users ON users.userId = comments.user_id
        INNER JOIN items ON items.item_id = comments.id_item  $queu ORDER BY comments.comment_id DESC ";
        $query = $con->prepare($sql);
        $update = $query->execute();
        $fetchComments = $query->fetchAll();
        $totalCount = $query->rowCount();
        ?>
        <div class="container comment">
            <h1 class="text-center">Mange comments</h1>
            <!-- mange table -->
            <div class="table-responsive comment-table">
                <table class="table table-dark table-bordered ">
                    <thead>
                        <tr>
                            <th scope="col">Id</th>
                            <th scope="col">comment</th>
                            <th scope="col">username</th>
                            <th scope="col">items</th>
                            <th scope="col">comment Date</th>
                            <th scope="col">Control</th>
                        </tr>
                    </thead>

                    <?php if (isset($fetchComments)) {  // loop to catch all users information
                        foreach ($fetchComments as $comment) {
                            ?>
                            <tbody>
                                <tr>
                                    <th scope="row"><?php echo $comment['comment_id']; ?></th>
                                    <td class="comment-text"><?php echo $comment['comment']; ?></td>
                                    <td><?php echo $comment['username'] ?></td>
                                    <td><?php echo $comment['name'] ?></td>
                                    <td><?php echo
                                            $comment['date'] ?></td>
                                    <td>
                                        <a href="comments.php?do=delete&id=<?php echo $comment['comment_id']; ?>" class="btn btn-danger ">Delete</a>
                                        <a href="comments.php?do=edit&id=<?php echo $comment['comment_id']; ?>" class="btn btn-success">Edit </a>
                                        <?php if ($comment['status'] == 0) {
                                            ?>
                                            <a href="comments.php?do=active&id=<?php echo $comment['comment_id']; ?>" class="btn btn-info ">active</a>
                                        <?php
                                    } else {  ?>
                                            <a href="comments.php?do=deactive&id=<?php echo $comment['comment_id']; ?>" class="btn btn-info ">deactive</a>
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
             <!--End mange table -->
        </div>

    <?php
}  // End manage page && dashboard
elseif ($do == 'edit') { // edit page 
    // get data which will edit and display inside inputs and catch id which will controlled
    if (isset($_GET['id']) && is_numeric($_GET['id'])) {
        $id =  intval($_GET['id']);
        $stmt = "SELECT comments.*,users.fullName, items.name FROM comments INNER JOIN items 
        ON items.item_id = comments.id_item inner JOIN users on items.user_id = users.userId WHERE comments.comment_id=:comment_id";
        $query = $con->prepare($stmt);
        $query->bindparam(':comment_id', $_GET['id'], PDO::PARAM_INT);
        $insert = $query->execute();
        $fetch = $query->fetch();
        
    } else {
        echo 0;
    }
    ?>
    <!--Start Edit form -->
        <form class="form-group edit-form" action="?do=update" method="POST">
            <div class="container">
                <h1>Edit comment</h1>
                <div class="form-group row ">
                    <label for="username" class="col-sm-1 col-label">user: </label>
                    <div class="col-sm-4  ">
                        <?php echo $fetch['fullName']; ?>
                    </div>
                </div>
                <input type="hidden" name='comment_id' value="<?php echo $id ?>">
                <div class="form-group row">
                    <label for="comment" class="col-sm-1 col-form-label">comment</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" autocomplete="off" id="comment" required name='comment' placeholder="<?php echo  $fetch['comment']; ?>">
                    </div>
                </div>
                <div class="form-group row ">
                </div>

                <div class="form-group row">
                    <div class="col-sm-5">
                        <button type="submit" name='update' class="btn btn-primary btn-block btn-lg">UpDate Comment</button>
                    </div>
                </div>
            </div>
        </form>
    <!--End Edit form -->
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
            (empty($user) ? $error[] = "<div class='alert alert-danger' >User is empty </div>" : null);
            (strlen($user) <= 3 ? $error[] = '<div class="alert alert-danger" >User must be longer than 3 </div> ' : null);
            (empty($pass) ? $error[] = '<div class="alert alert-danger" >password is empty </div>' : null);
            (empty($email) ? $error[] = '<div class="alert alert-danger" >Email is empty </div>' : null);
            (empty($fullName) ? $error[] = '<div class="alert alert-danger" >full name is empty</div>' : null);
            foreach ($error as $oneError) {
                if (!empty($oneError)) {
                    echo $oneError;
                }
            }
            if (empty($oneError) && $_SERVER['REQUEST_METHOD'] == 'POST') {
                $q = "UPDATE users SET username=:username, password=:password, email=:email, fullName=:fullName WHERE userId=:user_id";
                $query = $con->prepare($q);
                $query->bindparam(':username', $user, PDO::PARAM_STR);
                $query->bindparam(':password', $pass, PDO::PARAM_STR);
                $query->bindparam(':email', $email, PDO::PARAM_STR);
                $query->bindparam(':fullName', $fullName, PDO::PARAM_STR);
                $query->bindparam(':user_id', $user_id, PDO::PARAM_INT);
                $update = $query->execute();
                if ($update == true) {
                    echo '<div class="alert alert-success">success</div>';
                } else {
                    echo 'erorr can';
                }
            }
            echo "</div>";
        }
    } elseif ($do == 'update'){
        $errorComment = '';
        $comment_id = $_POST['comment_id'];
        $comment =  $_POST['comment'];
        (empty($comment) ? $errorComment = "<div class='alert alert-danger' >Comment is empty </div>" : null);
        if (empty($errorComment) && $_SERVER['REQUEST_METHOD'] == 'POST') {
            $q = "UPDATE comments SET comment=:comment WHERE comment_id=:comment_id";
            $query = $con->prepare($q);
            $query->bindparam(':comment', $comment, PDO::PARAM_STR);
            $query->bindparam(':comment_id', $comment_id, PDO::PARAM_INT);
            $update = $query->execute();
            if ($update == true) {
                $msg =  '<div class="alert alert-success">success</div>';
                echo myDirect($msg,'comments.php');
                exit();
            } else {
                echo 'erorr within update';
            }
    }}
    elseif ($do == 'delete') { // start delete script
        $stmt = "DELETE FROM `comments` WHERE comment_id=:comment_id";
        $comment_id = intval($_GET['id']);
        $query = $con->prepare($stmt);
        $query->bindparam(':comment_id', $comment_id, PDO::PARAM_INT);
        $query->execute();
        $count = $query->rowCount();
        $msg = '<div class="alert alert-success">success Delete comment </div>';
        echo myDirect($msg, 'back');
    }
    // end delete script
    elseif ($do == 'active') { // start activate script
        $comment_id = intval($_GET['id']);
        $q = "UPDATE comments SET status=1 WHERE comment_id=:user_id";
        $query = $con->prepare($q);
        $query->bindparam(':user_id', $comment_id, PDO::PARAM_INT);
        $query->execute();
        $msg = '<div class="alert alert-success">success active comment </div>';
        myDirect($msg,'back',0.5);
       
        exit();
    } elseif ($do == 'deactive') {// start deactive script
        $comment_id = intval($_GET['id']);
       
        $q = "UPDATE comments SET status=0 WHERE comment_id=:user_id";
        $query = $con->prepare($q);
        $query->bindparam(':user_id', $comment_id, PDO::PARAM_INT);
        $query->execute();
        $msg = '<div class="alert alert-success">success deactive comment </div>';
        myDirect($msg,'back',0.5);
        
        exit();
    }
    // end activate script
    else {
        if ($do != 'update') { // error when direct url
            $mesg = '<div class="alert alert-danger">can\'t access to this page directly </div>';
            echo myDirect($mesg, 'back');
        }
    }
}
include $temp .'footer.php';
