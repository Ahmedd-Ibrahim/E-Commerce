<?php
include 'conf.php';
$temp = 'incloudes/templates/';
$lang = 'incloudes/language/';
// $func = 'incloudes/functions/';
include  'incloudes/functions/function.php';
include $lang . 'english.php';
include $temp . 'header.php';
if(!isset($noNav)){include $temp . 'navbar.php';}

$action = (isset($_GET['action'])? $_GET['action'] : 'index.php' );
$do = (isset($_GET['do'])? $_GET['do'] : 'manage' );
include 'controller.php';
include $temp .'footer.php';