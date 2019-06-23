<?php
session_start();
if (isset($_SESSION['username'])) {
    $page_title = 'Dashboard';
    include 'ini.php';
    $limit = 3;
    $lastUser = latest('*', 'users', 'userId', $limit);
    $lastItem= latest('*', 'items', 'item_id', $limit);
    $sql = "SELECT comments.*,users.fullName, items.name FROM comments  INNER JOIN users ON users.userId = comments.user_id
    INNER JOIN items ON items.item_id = comments.id_item limit $limit";
    $query = $con->prepare($sql);
    $update = $query->execute();
    $lastComment = $query->fetchAll();
    ?>
    <div class="dashboard text-center">
        <div class="container">
            <h1 class="dash text-center">Dashboard</h1>
            <div class="row">
                <div class="col-md-3">
                    <div class="box ">
                        total members
                        <span><a href="members.php"><?php echo countItem('userId', 'users'); ?></a></span>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="box">
                        pending members
                        <span><a href="members.php?page=pending"><?php echo countItem('userId', 'users', 'WHERE regStatus = 0') ?></a></span>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="box">
                        total items
                        <span><a href="items.php"><?php echo countItem('item_id', 'items') ?> </a></span>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="box">
                        Pending Items
                        <span><a href="items.php?page=pending"><?php echo countItem('item_id', 'items', 'WHERE status = 0') ?></a></span>
                    </div>
                </div>
            </div>
            <div class="row">
            <div class="col-md-3">
                    <div class="box ">
                        total comments
                        <span><a href="comments.php"><?php echo countItem('comment_id', 'comments'); ?></a></span>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="box">
                        Pending comments
                        <span><a href="comments.php?page=pending"><?php echo countItem('comment_id', 'comments', 'WHERE status = 0') ?></a></span>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="box ">
                        total members
                        <span><a href="members.php"><?php echo countItem('userId', 'users'); ?></a></span>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="box ">
                        total members
                        <span><a href="members.php"><?php echo countItem('userId', 'users'); ?></a></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="feature">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="box">
                        <h4>latest <?php echo $limit; ?> users</h4>
                        <div class="users"><?php foreach ($lastUser as $users) { ?>
<?php
                                echo'<div class="user">' ;
                                        echo $users['fullName'] ; ?>
                                        <span class="latest-span">
                                         <a href="members.php?do=edit&id=<?php echo $users['userId']; ?>" class="btn btn-success">Edit </a>
                                         <a href="members.php?do=delete&id=<?php echo $users['userId']; ?>" class="btn btn-danger ">Delete</a>
                                         </span>
                               <?php  echo '</div>';
                            } ?></div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="box">
                        <h4>latest <?php echo $limit; ?> items</h4>
                        <div class="users"><?php foreach ($lastItem as $item) { ?>
<?php
                                echo'<div class="user">' ;
                                        echo $item['name'] ; ?>
                                        <span class="latest-span">
                                         <a href="items.php?do=edit&id=<?php echo $item['item_id']; ?>" class="btn btn-success">Edit </a>
                                         <a href="items.php?do=delete&id=<?php echo $item['item_id']; ?>" class="btn btn-danger ">Delete</a>
                                         </span>
                               <?php  echo '</div>';
                            } ?></div>
                    </div>
                </div>
            </div>
            <!-- second row -->
            <div class="row">
            <div class="col-md-6">
                    <div class="box box-comment">
                        <h4>latest <?php echo $limit; ?> comments</h4>
                        <div class="users"><?php foreach ($lastComment as $comment) { ?>
<?php
                                echo'<div class="last-comment">' ;
                                        echo "<span class='comment-user'>".
                                         $comment['fullName'] . " on: <span class='comment-item-name'>" . $comment['name'].
                                          "</span></span> <div class='comment-content'>" .
                                          $comment['comment'] .
                                          "</div><div class='comment-date'>".
                                          $comment['date']  ; ?>
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
                                          </div>

                                        
                                        <span class="latest-span">
                                         <!-- <a href="members.php?do=edit&id=<?php echo $comment['comment_id']; ?>" class="btn btn-success">Edit </a>
                                         <a href="members.php?do=delete&id=<?php echo $comment['comment_id']; ?>" class="btn btn-danger ">Delete</a> -->
                                         </span>
                               <?php  echo '</div>';
                            } ?></div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="box">
                        <h4>latest <?php echo $limit; ?> users</h4>
                        <div class="users"><?php foreach ($lastUser as $users) { ?>
<?php
                                echo'<div class="user">' ;
                                        echo $users['username'] ; ?>
                                        <span class="latest-span">
                                         <a href="members.php?do=edit&id=<?php echo $users['userId']; ?>" class="btn btn-success">Edit </a>
                                         <a href="members.php?do=delete&id=<?php echo $users['userId']; ?>" class="btn btn-danger ">Delete</a>
                                         </span>
                               <?php  echo '</div>';
                            } ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php

} else {
    header('location: index.php');
}


?>