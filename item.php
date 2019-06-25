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
<div class="container item">
<?php 
// if target any item
    if( isset($_GET['do']) && $_GET['do'] == 'item'){
        // comments
        
         // check if will display only activate comments
            $commentId = $_GET['id'];
        
        // $q = "SELECT * FROM `comments`  $queu";
        $sql = "SELECT comments.*,users.username, items.name FROM comments  INNER JOIN users ON users.userId = comments.user_id
        INNER JOIN items ON items.item_id = comments.id_item  WHERE comments.id_item =:id";
        $query = $con->prepare($sql);
        $query->bindparam(':id', $commentId, PDO::PARAM_INT);
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
            <div class="thumbnail item-box">
                <div class="row">
                    <div class="col-md-4 col-sm-4">
                    
                    
                    <img src="computer.png" class="img-fluid img-thumbnail" alt="Responsive image">
                  
                </div>
                    <div class="col-md-4 col-sm-4">
                    <div class="caption">
                    <h3 class="name">  <?php echo $userAds['name'] ?></h3>
                    <p class="description "><?php echo $userAds['description'] ?></p>
                        <ul class="item-ul list-unstyled">
                            <li><p class="description"><span>price</span><?php echo $userAds['price'] ?></p></li>
                            <li><p><span>date </span><?php echo $userAds['add_date'] ?></p></li>
                            <li><p><span>Made In  </span><?php echo $userAds['country_made'] ?></p></li>
                            <?php
                             $getCats = getCat();
                             foreach ($getCats as $cat) { }
                            ?>
                            <li>
                                <p><span>Category  </span>
                                <a href="categories.php?pageid=<?php echo getDataById('id', 'categories', 'id', $userAds['cat_id'])  . '&pagename=' . str_replace(' ', '-', getDataById('name', 'categories', 'id', $userAds['cat_id']) ); ?>">
                                <?php echo getDataById('name', 'categories', 'id', $userAds['cat_id']) ?>
                            </a></p>
                            </li>
                            <li>
                                <p><span>ADD By  </span><a href="#"><?php echo getDataById('username', 'users', 'userId', $userAds['user_id']) ?></a></p>
                            </li>
                           
                        </ul>
                    
    
                        
                        
                    </div>

                    </div>
                    </div>
                </div>
            </div>
            </div>
            
            <div class="container comment">
                <!-- Start Add comment -->
                <h3 class="text-center">Add Your comment </h3>
               <div class="col-md-offset-4">
               <form action="">
               <textarea ></textarea>
               <input type="submit" value="Add comment" name="add-comment" class="btn btn-primary">
               </form>
               </div>
               <!-- End add comment -->
            <hr class="custom-hr">
            <div class="table-responsive">
                <table class="table table-striped table-dark table-bordered ">
                    <thead>
                        <tr>
                            
                            
                            <th scope="col">username</th>
                            <th scope="col">comments</th>
                            <th scope="col">comment Date</th>
                            
                        </tr>
                    </thead>

                    <?php if (isset($fetchComments)) {  // loop to catch all users information
                        foreach ($fetchComments as $comment) {
                            ?>
                            <tbody>
                                <tr>
                                    
                                    
                                    <td><?php echo $comment['username'] ?></td>
                                    <td class="comment-text"><?php echo $comment['comment']; ?></td>
                                    <td><?php echo
                                            $comment['date'] ?></td>
                                   
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