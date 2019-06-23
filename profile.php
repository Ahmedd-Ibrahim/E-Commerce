<?php
session_start();

$page_title = 'profile';

include 'ini.php';
?>

<div class="information block">
    <div class="container">
        <h1 class="text-center">My profile</h1>
        <!-- iformation block -->
        <div class="panel panel-primary">
            <div class="panel-heading">My Information</div>
            <div class="panel-body">
                information
            </div>
        </div>
        <!-- End information block -->
        <!-- ads block -->
        <div class="panel panel-primary">
            <div class="panel-heading">My ADs</div>
            <div class="panel-body">
                ads
            </div>
        </div>
        <!-- End ads block -->
        <!-- latest comments block -->
        <div class="panel panel-primary">
            <div class="panel-heading">My latest Comments</div>
            <div class="panel-body">
                comments
            </div>
        </div>
        <!-- End latest comments block -->
    </div>
</div>


<?php
include $temp . 'footer.php';
?>