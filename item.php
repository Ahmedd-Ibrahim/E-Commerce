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
    if( isset($_GET['do']) && $_GET['do'] == 'item'){
    ?>
<div class="panel panel-primary">
  
            <div class="panel-heading">My ADs</div>
            <div class="panel-body">
                
                <?php if(! empty(getItem('item_id', $_GET['id']))){
                foreach(getItem('item_id', $_GET['id']) as $userAds){?>
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
<?php                }
                } else{
                    echo 'there are no ads to show';
                } 
            } else{ ?>
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
                
            }
               
                ?>
            </div>
        </div>
        </div>