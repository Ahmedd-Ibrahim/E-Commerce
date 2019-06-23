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
            <div class="panel-heading">My Information</div>
            <div class="panel-body">
                name: <?php echo $get['username']; ?> <br>
                faull name: <?php echo $get['fullName']; ?> <br>
                Email: <?php echo $get['email']; ?> <br>
                regest date: <?php echo $get['date']; ?> 
            </div>
        </div>
        <!-- End information block -->
        <!-- ads block -->
        <div class="panel panel-primary">
            <div class="panel-heading">My ADs</div>
            <div class="panel-body">
                ads
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