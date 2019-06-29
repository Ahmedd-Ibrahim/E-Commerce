<?php
ob_start();
session_start();
$page_title = (isset($_GET['pagename']) ? str_replace('-', ' ', $_GET['pagename']) : 'E-commerce');
include 'ini.php';
if (! isset($_SESSION['user'])) {
    header('location: login.php');
    exit();
}

  
?>
<div class="container item">
    <?php
    // if action to  any item
    if (isset($_GET['do']) && $_GET['do'] == 'item') {
        // check if will display only activate comments
        $commentId = $_GET['id'];        
        $sql = "SELECT comments.*,users.username, items.name FROM comments  INNER JOIN users ON users.userId = comments.user_id
        INNER JOIN items ON items.item_id = comments.id_item  WHERE comments.id_item =:id AND .comments.status=1 ";
        $query = $con->prepare($sql);
        $query->bindparam(':id', $commentId, PDO::PARAM_INT);
        $update = $query->execute();
        $fetchComments = $query->fetchAll();
        $totalCount = $query->rowCount();
        // End comments
        if (! empty(get_all('*','items', 'WHERE status = 1', '',''))) {
            foreach (get_all('*', 'items', "WHERE item_id = {$_GET['id']}  AND status =1" ) as $userAds) {
                ?>
                <!-- single page for one item -->
                <div class="panel panel-primary">
                    <div class="panel-heading text-center"><?php echo $userAds['name'] ?></div>
                    <div class="panel-body">
                        <div class="thumbnail item-box">
                            <div class="row">
                                <div class="col-md-4 col-sm-4">
                                <img src="<?php echo 'uploads\item\\'. $userAds['avater_item']; ?>" class="img-fluid img-thumbnail" alt="Responsive image">
                                </div>
                                <div class="col-md-4 col-sm-4">
                                    <div class="caption">
                                        <h3 class="name"> <?php echo $userAds['name']  ?></h3>
                                        <p class="description "><?php echo $userAds['description'] ?></p>
                                        <ul class="item-ul list-unstyled">
                                            <li>
                                                <p class="description"><span>price</span><?php echo $userAds['price'] ?></p>
                                            </li>
                                            <li>
                                                <p><span>date </span><?php echo $userAds['add_date'] ?></p>
                                            </li>
                                            <li>
                                                <p><span>Made In </span><?php echo $userAds['country_made'] ?></p>
                                            </li>
                                            <?php 
                                            $cats = get_all('*', 'categories', "WHERE id={$userAds['cat_id']}",'','' );
                                            $adUser = get_all('username', 'users', "WHERE userId = {$userAds['user_id']}", '','');
                                            foreach ($cats as $cat){ ?>
                                            <li>
                                                <p><span>Category </span>
                                                    <a href="categories.php?pageid=<?php echo $cat['id']  . '&pagename=' . str_replace(' ', '-',$cat['name']); ?>">
                                                        <?php echo $cat['name']; ?>
                                                    </a></p>
                                            </li>
                                           
                                            <li>
                                                <p><span>ADD By </span><a href="#"><?php foreach ($adUser as $user){ echo  $user['username'];} ?></a></p>
                                            </li>
                                            <?php
                                            }
                                            ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
<!-- End single page for one item -->
                <div class="container comment">
                    <!-- Start Add comment -->
                    <?php
                    if (isset($_SESSION['user'])) {
                        $itemidApp =  get_all('item_id', 'items', "WHERE item_id = {$userAds['item_id']}",'','');
                                foreach ($itemidApp as $item){
                                    $itemid = $item['item_id'];
                                };
                        ?>
                        <h3 class="text-center">Add Your comment </h3>
                        <div class="col-md-offset-4">
                            <form method="POST" action="<?php echo $_SERVER['PHP_SELF'] . '?do=item&id=' . $itemid  ?>">
                                <textarea name="textarea"></textarea>
                                <input type="submit" value="Add comment" name="add-comment" class="btn btn-primary">
                            </form>
                        </div>
                        <?php
                    }
                    ?>
                    <!-- End add comment -->          
                            <?php // add comment do database 
                               if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add-comment'])) {
                                $ucomment = $_POST['textarea'];
                                $userid = $_SESSION['user-id'];
                                if (!empty($ucomment) && isset($userid)) {
                                    $q = "INSERT INTO `comments` ( user_id, id_item , date,  comment) VALUES (:user_id, :id_item, now(), :comment)";
                                    $insert = $con->prepare($q);
                                    $insert->bindparam(':user_id', $userid, PDO::PARAM_INT);
                                    $insert->bindparam(':id_item', $itemid, PDO::PARAM_INT);
                                    $insert->bindparam(':comment', $ucomment, PDO::PARAM_STR);
                                    $insert->execute();
                                   if($insert == true){
                                       $msg = '<div class="alert alert-success text-center">Your comment is pending to admin</div>';
                                       echo myDirect($msg, 'back', 2);
                                   }
                                }
                            }   
                                 // end add comments to database from user
                                 // show comments 
                            if (isset($fetchComments)) {  // loop to catch all users information
                                foreach ($fetchComments as $comment) {
                                    ?>
                    <div class="row comment-row">
                        <div class="col-md-3 col-xs-3">
                            <div class="avatar ">
                                <img class="img-thumbnail img-circle img-responsive center-block" src="avatar.png" alt="avatar">
                                <div class="avater-info text-center">
                                <p class="lead"><?php echo $comment['username'] ?></p>
                                <p class="date"><?php echo $comment['date'] ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-9 col-xs-9  comment-content">
                            <p class="lead">
                            <?php echo $comment['comment']; ?>
                            </p>
                        </div>
                    </div>
                    <hr class="custom-hr">
                                <?php }
                        } ?>
                    <!-- End show comments -->
                </div>
            <?php 
        }
    } else { 
        echo 'there are no ads to show';
    } // when select any categories from navbar
} elseif (isset($_GET['pagename']) && isset($_GET['pageid'])){ ?>  
    <div class="panel panel-primary">
<div class="panel-heading text-center"><?php echo $page_title; ?></div>
<div class="panel-body">
<div class="row">
        <?php
        
        foreach (get_all('*', 'items', "WHERE cat_id = {$_GET['pageid']} ",'','') as $item) {
            $unByItem = get_all('username', 'users', "WHERE userId = {$item['user_id']}", '','');
            foreach ($unByItem as $username) {
                 $userN = $username['username'];
            }
            ?>
            <div class="col-sm-6 col-md-3">
                <div class="thumbnail item-box">
                    <span class="price"> <?php echo $item['price'] ?></span>
                    <img src="<?php echo 'uploads\item\\'. $item['avater_item']; ?>" class="img-fluid img-thumbnail" alt="Responsive image">
                    <div class="caption">
                        <h3 class="name text-center"> <a href="index.php?do=item&id=<?php echo $item['item_id']; ?>"> <?php echo $item['name'] ?></a></h3>
                        <p class="description text-center"><?php echo $item['description'] ?></p>
                        <p class="add-date text-center"><?php echo $item['add_date'] ?></p>
                        <span class="add-by">Added By <?php echo $userN;?></span>
                    </div>

                </div>
            </div>
            <?php
        }
        ?>
    </div>
</div>
    <?php
}
 else { // Show  all items 
    ?>
        <div class="panel panel-primary">
            <div class="panel-heading text-center all-item">ALL Items</div>
            <div class="panel-body">
                <?php   if (! empty(get_all('*','items', 'WHERE status = 1', '',''))) {
            foreach (get_all('*', 'items', "WHERE status =1" ) as $userAds) {
                $unames = get_all('username', 'users', "WHERE userId={$userAds['user_id']}");
                foreach ($unames as $names){
                    $name = $names['username'];
                }
                ?>
                        <div class="col-sm-6 col-md-3">
                            <div class="thumbnail item-box">
                                <span class="price"> <?php echo $userAds['price'] ?></span>
                                <img src="<?php echo 'uploads\item\\'. $userAds['avater_item']; ?>" class="img-fluid img-thumbnail" alt="Responsive image">
                                <div class="caption">
                                    <h3 class="name text-center"> <a href="index.php?do=item&id=<?php echo $userAds['item_id']; ?>"><?php echo $userAds['name'] ?></a> </h3>
                                    <p class="description text-center"><?php echo $userAds['description'] ?></p>
                                    <p class="add-date text-center"><?php echo $userAds['add_date'] ?></p>
                                    <span class="add-by">Added By <?php echo $name; ?></span>
                                </div>
                            </div>
                        </div>
                    <?php
                }
            } else {
                echo 'there are no ads to show';
            }
        }
        ?>
        </div>
    </div>
</div>
<?php
include $temp . 'footer.php';
ob_end_flush();
?>