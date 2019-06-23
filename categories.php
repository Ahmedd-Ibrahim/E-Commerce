<?php
session_start();

$page_title = str_replace('-', ' ', $_GET['pagename']);

include 'ini.php';
if(isset($_SESSION['user'])){


?>
<div class="container categories">
    <h1 class="text-center">
        <?php echo str_replace('-', ' ', $_GET['pagename']) ?>
    </h1>
    <div class="row">
        <?php

        foreach (getItem('cat_id', $_GET['pageid']) as $item) { ?>
            <div class="col-sm-6 col-md-3">
                <div class="thumbnail item-box">
                    <span class="price"> <?php echo $item['price'] ?></span>
                    <img src="computer.png" class="img-fluid img-thumbnail" alt="Responsive image">
                    <div class="caption">
                        <h3 class="name text-center">  <?php echo $item['name'] ?></h3>
                        <p class="description text-center"><?php echo $item['description'] ?></p>
                    </div>

                </div>
            </div>
            <?php
        }
        ?>
    </div>
</div>
<?php
} else{
    header('location: login.php');
    exit();
}
include $temp . 'footer.php';
?>