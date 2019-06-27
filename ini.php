<?php
include 'admin/conf.php';
$temp = 'incloudes/templates/';
$lang = 'incloudes/language/';
include  'incloudes/functions/function.php';
include $lang . 'english.php';
include $temp . 'header.php';
$action = (isset($_GET['action'])? $_GET['action'] : 'index.php' );
include 'controller.php';
