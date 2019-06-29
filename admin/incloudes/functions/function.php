<?php
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
 * @return string with action
 */

  function myDirect($mesg, $url = null, $seconeds = 1)
  {
    $var = '';
      if ($url == null){
          $var = 'index.php';
      } elseif($url == 'back'){
          $var = (isset($_SERVER['HTTP_REFERER'])&& $_SERVER['HTTP_REFERER'] != ''? $_SERVER['HTTP_REFERER'] : 'index.php');
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
  function countItem($column, $table,$where = null)
  {
      global $con;
        $st = "SELECT COUNT($column) FROM $table".' '."$where ";
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
   * @return array
   */
   function latest($select = '*' , $table, $order = 'id', $limit = '3', $oredring = 'DESC', $pending = null)
   {
       global $con;
       if ($limit == 'all'){ // add limit all to function
           $lim = '';
       } else{
           $lim = 'LIMIT  ' . $limit;
       }
       if ( $pending == 'pending') {
          $pending = 'WHERE visibility = 0 ';
       } else{
        $pending = null;
       }
       
       $newStmt = "SELECT $select FROM $table $pending   ORDER BY $order   $oredring $lim ";
       $query= $con->prepare($newStmt);
        $query->execute();
        $fetched = $query->fetchAll();
        return $fetched;
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