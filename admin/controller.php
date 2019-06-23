<?php 
    
if($action == 'logout'){
    session_destroy();
    header('location: index.php');
    exit();
}