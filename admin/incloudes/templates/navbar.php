<nav class="navbar navbar-inverse">

    <div class="container">
    <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="dashboard.php"> <?php  echo lang('Dashboard');?></a>
            </div>

     
        <div class="collapse navbar-collapse" id="app-nav">
            <ul class="nav navbar-nav ml-auto">
                <li class="nav-item ">
                    <a class="nav-link" href="categories.php"> <?php  echo lang('Categories');?></a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link" href="items.php"> <?php  echo lang('Items');?></a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link" href="members.php"> <?php  echo lang('Members');?></a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link" href="comments.php"> <?php  echo lang('comments');?></a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link" href="#"> <?php  echo lang('Statics');?></a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link" href="#"> <?php  echo lang('Logs');?></a>
                </li>
            </ul>
            <ul class="nav navbar-nav pull-right">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        
                        <?php  echo lang('Profile');?>
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="../index.php">Vist shop</a></li>
                        <li> <a class="dropdown-item" href="members.php?do=edit&id=<?php echo $_SESSION['groupId']; ?>"><?php  echo lang('Edit Profile');?></a></li>
                        <li><a class="dropdown-item" href="#"> <?php  echo lang('Settings');?></a></li>
                        <li><a class="dropdown-item"  href="?action=logout"> <?php  echo lang('LogOut');?></a></li>
                        
                        
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
