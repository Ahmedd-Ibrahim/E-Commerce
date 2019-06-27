<?php
session_start();

$page_title = 'index';

include 'ini.php';
if(isset($_SESSION['user-id'])){
    echo ' Your Id user set and is' . $_SESSION['user-id'] ;
} else{
    echo 'not set';
}

include $temp . 'footer.php';
?>