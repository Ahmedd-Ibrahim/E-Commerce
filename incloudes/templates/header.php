<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="theme/defualt/css/all.min.css">
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
                    if (isset($_SESSION['user'])) {

                        echo 'Welcome ' . $_SESSION['user'] . " <a href='profile.php'>Your profile</a> - <a href='logout.php'>logout </a><a href='ads.php'>new Ads</a>";
                    } else {
                        echo '<a href="login.php" class="log "><span class="pull-right">Login | singUp</span></a>';
                    }
                    ?>

                </div>
            </div>
        </div>
    </div>
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
    