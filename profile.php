<?php
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
        <h1 class="text-center">My profile</h1>
        <!-- iformation block -->
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
        <div class="panel panel-primary">
            <div class="panel-heading">My ADs</div>
            <div class="panel-body">
                
                <?php if(! empty(getItem('user_id', $get['userId']))){
                foreach(getItem('user_id', $get['userId']) as $userAds){?>
                     <div class="col-sm-6 col-md-3">
                <div class="thumbnail item-box">
                    <span class="price"> <?php echo $userAds['price'] ?></span>
                    <img src="computer.png" class="img-fluid img-thumbnail" alt="Responsive image">
                    <div class="caption">
                        <h3 class="name text-center">  <?php echo $userAds['name'] ?></h3>
                        <p class="description text-center"><?php echo $userAds['description'] ?></p>
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
            <div class="panel-heading">My latest Comments</div>
            <div class="panel-body">
                
                <?php 
                $q = "SELECT * FROM comments WHERE user_id =:user_id";
                $queri = $con->prepare($q);
                $queri->bindparam(':user_id', $get['userId'], PDO::PARAM_INT);
                $queri->execute();
                $comments = $queri->fetchAll();
                if(! empty($comments)){
                    foreach($comments as $comment){
                        echo '<p>' . $comment['comment'] . '</p>';
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
?>