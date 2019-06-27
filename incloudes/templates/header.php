<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- <link rel="stylesheet" href="theme/defualt/css/all.min.css"> -->
    <link rel="stylesheet" href="theme/defualt/css/bootstrap.min.css">
    <link rel="stylesheet" href="theme/defualt/css/front.css">
    <title><?php getTitle(); ?></title>
</head>

<body>
    <!-- uppear navbar -->
    <div class="upper-nav">
        <div class="container">
            <div class="upper-cat">
             <?php if (isset($_SESSION['user'])) { ?>
            <div class=" btn-group">
  <button class="btn  dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
  <img src="avatar.png" class=" img-thumbnail img-circle" alt="Responsive image">
    <?php echo  $_SESSION['user'] . ' <i class="fas fa-caret-down"></i>';?>
  </button>
  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
      <li><a class="dropdown-item" href="profile.php">Profile</a></li>
      <li><a class="dropdown-item" href="ads.php">New ADS</a></li>
      <li><a class="dropdown-item" href="logout.php">logout</a></li>
  </div>
             </div> <?php }else{
     echo '<a href="login.php" class="log "><span class="pull-right">Login | singUp</span></a>';
} ?>
            </div>
        </div>
    </div>
    <!-- End  uppear navbar -->
    <!-- default navbar -->
    <nav class="navbar navbar-inverse">

        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php"> Home</a>

            </div>
            <div class="collapse navbar-collapse " id="app-nav">
                <ul class="nav navbar-nav ml-auto">
                    <li class="nav-item ">
                        <a class="nav-link" href="item.php">All Items</a>
                    </li>
                    <?php
                    $getCats = getCat();
                    foreach ($getCats as $cat) { ?>
                        <li class="nav-item ">
                            <a class="nav-link" href="item.php?pageid=<?php echo $cat['id'] . '&pagename=' . str_replace(' ', '-', $cat['name']); ?>"> <?php echo $cat['name']; ?></a>
                        </li>
                    <?php
                }
                ?>
                </ul>
            </div>
        </div>
    </nav>
      <!--End default navbar -->