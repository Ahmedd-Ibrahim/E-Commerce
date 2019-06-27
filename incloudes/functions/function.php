<?php
/**
 * function to get any one data from any database by [id]
 * @par your selector in any table
 * @par any table from database
 * @par your Where selector
 * @par your value assign to where selector
 * @return string [info from database]
 */
function getDataById($selector, $table, $where, $value){
    global $con;
    $q = "SELECT $selector FROM $table WHERE $where=:id";
    $query = $con->prepare($q);
    $query->bindParam(':id', $value, PDO::PARAM_INT);
    $query->execute();
    $data = $query->fetch();
    return $data[$selector];
}

/**
 * function to get  catogeries only activated
 * @return array
 */
function getCat(){
    global $con;
    $q = "SELECT * FROM categories WHERE visibility = 1";
    $query = $con->prepare($q);
    $query->execute();
    $categories = $query->fetchAll();
    return $categories;
}

/**
 * function to get items
 * @par where selector
 * @par value for where selectoe 
 * @return array
 * 
 * [use (all) in 2 @par if u wanna all items without where selctor ]
 */
function getItem($where, $value){
    global $con;

    if ( $where == 'all' && $value == 'all'){
        $q = "SELECT * FROM items  WHERE status= 1";
        $query = $con->prepare($q);
    $query->bindParam(':id', $value,PDO::PARAM_INT);
    $query->execute();
    $items = $query->fetchAll();
    } else{
        $q = "SELECT * FROM items  WHERE $where =:id AND status= 1";
        $query = $con->prepare($q);
        $query->bindParam(':id', $value,PDO::PARAM_INT);
        $query->execute();
        $items = $query->fetchAll();
    }
    return $items;
}
/**
 * function to check user status if not active
 * @par uername
 * @return number [rowCount from database]  [1 (user is not active) || 0 (user is active) ]
 */
function getStatus($user){
    global $con;
    $stmt = "SELECT username, regStatus FROM `users` WHERE username=:user AND regStatus=0";
    $query = $con->prepare($stmt);
    $query->bindParam(':user', $user, PDO::PARAM_STR);
    $query->execute();
    $count = $query->rowCount();
    return $count;
}

/** ADMIN Functions */

/**
 * get title page 
 * @return string
 */
function getTitle()
{
    global $page_title;

    if (isset($page_title)) {
        echo $page_title;
    } else {
        echo 'default';
    }
}

/**
 * redirect function
 * @par message to show 
 * @par url which will direct to it
 * @par secends before direct
 * @return redirect 
 */
function myDirect($mesg, $url = null, $seconeds = 1){
    $var = '';
    if ($url ==  null){
        $var = 'index.php';
    } elseif($url == 'back'){
        $var = (isset($_SERVER['HTTP_REFERER'])&& $_SERVER['HTTP_REFERER']  != ''? $_SERVER['HTTP_REFERER'] : 'index.php');
      }else{
        $var = $url;
    }
    header("refresh:$seconeds;url=$var");
    echo  $mesg;
    exit();
}