<?php

function lang($phrase)
{ 
    $lang = array(
        // dashboard page
        'Dashboard' => 'Dashboard',
        'Categories' => 'Categories',
        'Profile' => 'Profile',
        'Edit Profile' => 'Edit Profile',
        'Settings' => 'Settings',
        'LogOut' => 'LogOut',
        "Items" => "Items",
        "Members" => "Members",
        "Statics" => "Statics",
        "Logs" => "Logs",
        "comments" => "comments",
    );
    return $lang[$phrase];
}

