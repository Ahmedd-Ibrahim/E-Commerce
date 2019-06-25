<?php

session_start();

$page_title = 'Item';
include 'ini.php';
if(isset($_SESSION['user'])){
    $stat = "SELECT * FROM `users` WHERE username=:username";
    $query = $con->prepare($stat);
    $query->bindparam(':username', $_SESSION['user'], PDO::PARAM_STR);
    $query->execute();
    $get = $query->fetch();
}

?> 
<div class="container">
<?php 
// if target any item
    if( isset($_GET['do']) && $_GET['do'] == 'item'){
        // comments
        $queu = '';
        if (isset($_GET['page']) && $_GET['page'] == 'pending') {  // check if will display only activate comments
            $queu = ' WHERE comments.status = 0';
        }
        // $q = "SELECT * FROM `comments`  $queu";
        $sql = "SELECT comments.*,users.username, items.name FROM comments  INNER JOIN users ON users.userId = comments.user_id
        INNER JOIN items ON items.item_id = comments.id_item  $queu";
        $query = $con->prepare($sql);
        $update = $query->execute();
        $fetchComments = $query->fetchAll();
        $totalCount = $query->rowCount();
        // End comments

        if(! empty(getItem('item_id', $_GET['id']))){
            foreach(getItem('item_id', $_GET['id']) as $userAds){
    ?>
<div class="panel panel-primary">
            <div class="panel-heading text-center"><?php echo $userAds['name'] ?></div>
            <div class="panel-body">
                
                     <div class="col-sm-12 col-md-12">
                <div class="thumbnail item-box">
                    <span class="price"> <?php echo $userAds['price'] ?></span>
                    <img src="computer.png" class="img-fluid img-thumbnail" alt="Responsive image">
                    <div class="caption">
                        <h3 class="name text-center">  <?php echo $userAds['name'] ?></h3>
                        <p class="description text-center"><?php echo $userAds['description'] ?></p>
                    </div>
                </div>
            </div>
            </div>
            </div>
            <div class="container comment">
            
            <div class="table-responsive">
                <table class="table table-striped table-dark table-bordered ">
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
                                        
                                        <a href="comments.php?do=edit&id=<?php echo $comment['comment_id']; ?>" class="btn btn-success">Edit </a>
                                      
                                    </td>
                                </tr>
                            </tbody>
                        <?php }
                } ?>
                </table>
            </div>
        </div>
<?php                }
                } else{
                    echo 'there are no ads to show';
                } 
            } else{ // all items
                 ?>
<div class="panel panel-primary">

  <div class="panel-heading text-center">ALL Items</div>
  <div class="panel-body">
      
  <?php if(! empty(getItem('user_id', $get['userId']))){
                foreach(getItem('user_id', $get['userId']) as $userAds){?>
           <div class="col-sm-6 col-md-3">
      <div class="thumbnail item-box">
          <span class="price"> <?php echo $userAds['price'] ?></span>
          <img src="computer.png" class="img-fluid img-thumbnail" alt="Responsive image">
          <div class="caption">
              <h3 class="name text-center"> <a href="item.php?do=item&id=<?php echo $userAds['item_id']; ?>"><?php echo $userAds['name'] ?></a> </h3>
              <p class="description text-center"><?php echo $userAds['description'] ?></p>
          </div>
      </div>
  </div>
<?php                }
      } else {
          echo 'there are no ads to show';
      } 
            }
                ?>
            </div>
        </div>
        </div>