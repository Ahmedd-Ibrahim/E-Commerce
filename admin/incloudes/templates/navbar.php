<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="dashboard.php"> <?php  echo lang('Dashboard');?></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#app-nav" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="app-nav">
            <ul class="navbar-nav mr-auto">
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
            <ul class="navbar-nav  nav-right">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        
                        <?php  echo lang('Profile');?>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="../index.php">Vist shop</a>
                        <a class="dropdown-item" href="members.php?do=edit&id=<?php echo $_SESSION['groupId']; ?>"><?php  echo lang('Edit Profile');?></a>
                        <a class="dropdown-item" href="#"> <?php  echo lang('Settings');?></a>
                        <a class="dropdown-item"  href="?action=logout"> <?php  echo lang('LogOut');?></a>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>