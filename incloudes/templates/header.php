<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="theme/defualt/css/fontawesome.min.css">
    <link rel="stylesheet" href="theme/defualt/css/bootstrap.min.css">
    <link rel="stylesheet" href="theme/defualt/css/front.css">
    <title><?php getTitle(); ?></title>
</head>

<body>
    <div class="upper-nav">
        <div class="container">
            <div class="upper-cat">
                <div class="login ">
                    <?php
                    if(isset($_SESSION['user'])){
                        echo 'Welcome '. $_SESSION['user'];
                    } else{
                        echo '<a href="login.php" class="log "><span class="pull-right">Login | singUp</span></a>';
                    }
                    ?>
                    
                </div>
            </div>
        </div>
    </div>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">

        <div class="container">

            <a class="navbar-brand" href="index.php"> Home</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#app-nav" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse " id="app-nav">
                <ul class="nav navbar-nav ml-auto">
                    <?php
                    $getCats = getCat();
                    foreach ($getCats as $cat) { ?>
                        <li class="nav-item ">
                            <a class="nav-link" href="categories.php?pageid=<?php echo $cat['id'] . '&pagename=' . str_replace(' ', '-', $cat['name']); ?>"> <?php echo $cat['name']; ?></a>
                        </li>
                    <?php
                }
                ?>

                </ul>

            </div>
        </div>
    </nav>