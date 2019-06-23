<?php
session_start();

$page_title = 'index';

include 'ini.php';

echo getStatus($_SESSION['user']);


include $temp . 'footer.php';
?>