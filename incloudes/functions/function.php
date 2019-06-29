<?php

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
/**
     * function to get all item from database
     * @par coulmn selector
     * @par teble selector
     * @par where selector
     * @par ordering data by
     * @par limit data
     * @return array
     */
function get_all($selector = '*' , $table, $Where = null , $order = null , $limit = null)
{
    global $con;
    $newStmt = "SELECT $selector FROM $table $Where  $order  $limit ";
    $query= $con->prepare($newStmt);
     $query->execute();
     $fetched = $query->fetchAll();
     return $fetched;
}