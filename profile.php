<?php
ob_start();
session_start();
$page_title = 'profile';

include 'ini.php';
if(isset($_SESSION['user'])){
    $stat = "SELECT * FROM `users` WHERE username=:username";
    $query = $con->prepare($stat);
    $query->bindparam(':username', $_SESSION['user'], PDO::PARAM_STR);
    $query->execute();
    $get = $query->fetch();
  
?>

<div class="information block">
    <div class="container">
        <h1 class="text-center"><i class="fas fa-user"></i>  <?php echo strtoupper($get['username']); ?></h1>
        <!-- information block -->
        <div class="panel panel-primary">
            <div class="panel-heading text-center"> 
            <i class="fas fa-address-card fa-2x"></i>
          <span class="info-head">  My Information</span>
        </div>
            <div class="panel-body">
                <ul class="list-unstyled">
                    <li>
                    <i class="fa fa-address-book"></i>
                        <span>name: </span><?php echo $get['username']; ?> </li>

                    <li>
                    <i class="fab fa-app-store"></i>    
                    <span>faull name:</span><?php echo $get['fullName']; ?></li>
                    <li>
                    <i class="far fa-envelope"></i>    
                    <span> Email:</span><?php echo $get['email']; ?></li>
                    <li>
                    <i class="far fa-clock"></i>    
                    <span>regest date:</span> <?php echo $get['date']; ?> </li>
                </ul>
            </div>
        </div>
        <!-- End information block -->
        <!-- ads block -->
        <div class="panel panel-primary ads">
            <div class="panel-heading text-center"> <i class="fas fa-cog"></i> My ADs</div>
            <div class="panel-body">
                
                <?php if(! empty(get_all('*', 'items', "WHERE user_id = {$get['userId']}",'',''))){
                foreach(get_all('*', 'items', "WHERE user_id = {$get['userId']}",'','') as $userAds){?>

                     <div class="col-sm-6 col-md-3">
                <div class="thumbnail item-box">
                    <span class="price"><?php echo $userAds['price'] ?></span>
                    <?php  if($userAds['status'] == 0){
                        echo '<span class="approval">Wating Approval</span>';
                    } ?>
                    <img src="<?php echo 'uploads\item\\'. $userAds['avater_item']; ?>" class="img-fluid img-thumbnail" alt="Responsive image">
                    <div class="caption">
                        <h3 class="name text-center"> <a href="index.php?do=item&id=<?php echo $userAds['item_id']; ?>" class="title"> <?php echo $userAds['name'] ?></a></h3>
                        <p class="description text-center"><?php echo $userAds['description'] ?></p>
                        <p class="add-date text-center"><?php echo $userAds['add_date'] ?></p>
                    </div>

                </div>
            </div>
<?php                }
                } else{
                    echo 'there are no ads to show';
                }
        
                ?>
            </div>
        </div>
        <!-- End ads block -->
        <!-- latest comments block -->
        <div class="panel panel-primary">
            <div class="panel-heading text-center"><i class="fas fa-comments"></i> My latest Comments</div>
            <div class="panel-body">
                <?php 
                
                $comments = get_all('*', 'comments', "WHERE user_id = {$get['userId']}", '','');
                if(! empty($comments)){
                    foreach($comments as $comment){
                        ?>
<!-- show  last comments on profile -->
<div class="row comment-row">
                        <div class="col-xs-3 col-md-2">
                            <div class="avatar text-center">
                                <img class="img-thumbnail img-circle img-responsive center-block" src="avatar.png" alt="avatar">
                                <div class="avater-info">
                                <p class="lead"><?php echo $_SESSION['user'] ?></p>
                                <p class="date"><?php echo $comment['date'] ?></p>
                                </div>
                            </div>
                        </div>
                        <div class=" col-xs-9 col-md-10 comment-content">
                            <p class="lead">
                            <?php echo $comment['comment']; ?>
                            </p>
                        </div>
                        
                    </div>
                    <hr class="custom-hr">

<?php
                    }
                } else{
                    echo 'ther\'e no comments to show' ;
                }
?>
            </div>
        </div>
        <!-- End latest comments block -->
    </div>
</div>


<?php
} else{
    header('location: login.php');
    exit();
}
include $temp . 'footer.php';
ob_end_flush();
?>