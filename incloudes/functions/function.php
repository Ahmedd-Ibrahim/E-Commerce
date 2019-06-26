<?php

/**
 * function to get comments by status
 * 
 */
function CommentsByStatus($status, $id_item)
{
    // $set = '';
    // if ($status == 'active') {
    //     $set = 1;
    // } else {
    //     $set = 0;
    // }
    global $con;
    $sql = "SELECT comments.*,users.username, items.name FROM comments  INNER JOIN users ON users.userId = comments.user_id
        INNER JOIN items ON items.item_id = comments.id_item  WHERE comments.id_item =:id AND comments.status =:status";
    $query = $con->prepare($sql);
    $query->bindParam(':status', $status, PDO::PARAM_INT);
    $query->bindParam(':id', $id_item, PDO::PARAM_INT);
    $query->execute();
    $fetchAll = $query->fetchAll();
    return $fetchAll;
}

/**
 * function to get any one data from any database by [id]
 * @par your selector in any table
 * @par any table from database
 * @par your Where selector
 * @par your value assign to where selector
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

// function to get only catogeries

function getCat(){
    global $con;
    $q = "SELECT * FROM categories";
    $query = $con->prepare($q);
    $query->execute();
    $categories = $query->fetchAll();
    return $categories;
}

/**
 * function to get items
 * @par item id
 * @return items
 */
function getItem($where, $value){
    global $con;
    $q = "SELECT * FROM items  WHERE $where =:id";
    $query = $con->prepare($q);
    $query->bindParam(':id', $value,PDO::PARAM_INT);
    $query->execute();
    $items = $query->fetchAll();

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
// get title page 
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
 * function to check if data exists in database
 * @par Selector from table on database
 * @par table which have a selector
 * @par value which checked
 * @return  (integer) number if true , zero if false [if data exists gives number if not exist gives zero]
 * 
 */
function checkUsername($select, $from, $value)
{
    global $con;
    $stmt = "SELECT $select FROM $from WHERE $select=:value";
    $query = $con->prepare($stmt);
    $query->bindparam(':value', $value, PDO::PARAM_STR);
    $query->execute();
    $checkCount = $query->rowCount();
    return $checkCount;
}

/**
 * redirect function
 * @par url which will direct to it
 * @par secends before direct
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
 * count Item
 * @par column name
 * @par table name
 * @return integer
 */
function countItem($column, $table, $where = null){
    global $con;
    $st = "SELECT COUNT($column) FROM $table " .' '."$where ";
    $query= $con->prepare($st);
    $query->execute();
    return $query->fetchColumn();
}
/**
 * function to get latest update on database
 * @par $select the row selector
 * @par $table (column name) table which contain a selector example [* , userId, username]
 * @par $order (column name) ordered by example [userId]  can use 'all' word to display all rows
 * @par $limit ( integer ) result limit exapmle [3]
 */

function latest($select = '*', $table, $order = 'id', $limit = '3', $oredring = 'DESC'){
    global $con;
    if ($limit == ' all'){ // add limit all to function
        $lim = '';
    }  else{
        $lim = 'LIMIT ' . $limit;
    }
    $newStmt = "SELECT $select FROM $table ORDER BY $order $oredring ";
    $query= $con->prepare($newStmt);
    $query->execute();
    $fetched = $query->fetchAll();
    return $fetched;
}
