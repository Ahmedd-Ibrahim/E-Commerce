<?php
session_start();

$page_title = 'ADS';

include 'ini.php';
if (isset($_SESSION['user'])) {
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['insert-item'])) {
        $name = $_POST['name'];
        $status = $_POST['status'];
        $desc = $_POST['description'];
        $price = $_POST['price'];
        $made = $_POST['country'];
        $member_id = $_SESSION["user-id"];
        $cat_id = $_POST['cat'];
        $errors[] = '';
        (empty($name) ? $errors[] =   "<div class='alert alert-danger'> name  is empty! </div>" : null);
        (empty($status) ? $errors[] =  "<div class='alert alert-danger'> status  is empty! </div>" : null);
        (empty($desc) ? $errors[] =  "<div class='alert alert-danger'> description  is empty! </div>" : null);
        (empty($price) ? $errors[] =  "<div class='alert alert-danger'> price  is empty! </div>" : null);
        foreach ($errors as $error) {
            if (!empty($error)) {
                echo $error;
                echo myDirect($error, 'back');
            }
        }
        if (empty($error)) {
            // if no error access into database
            $q = 'INSERT INTO `items` (name, price, add_date, country_made,status, description, user_id, cat_id)
      VALUES
      (:name, :price, now(), :country_made,:status, :description, :user_id, :cat_id)
      ';
            $query = $con->prepare($q);
            $query->bindparam(':name', $name, PDO::PARAM_STR);
            $query->bindparam(':price', $price, PDO::PARAM_STR);
            $query->bindparam(':country_made', $made, PDO::PARAM_STR);
            $query->bindparam(':status', $status, PDO::PARAM_STR);
            $query->bindparam(':description', $desc, PDO::PARAM_STR);
            $query->bindparam(':user_id', $member_id, PDO::PARAM_INT);
            $query->bindparam(':cat_id', $cat_id, PDO::PARAM_INT);
            $insert = $query->execute();
            if ($insert == true) {
                $mesg = '<div class="alert alert-success" >success add item </div>';
                echo myDirect($mesg, 'back');
            }
        }
    }


    ?>

    <div class="ads">
        <div class="container">
            <h1 class="text-center">Add New Ads</h1>
            <!-- iformation block -->
            <div class="panel panel-primary">
                <div class="panel-heading text-center">
                    <i class="fas fa-address-card fa-2x"></i>
                    <span class="info-head"> New Ads</span>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="box">
                                <!-- Start add script -->
                                <form class="form-group add-form" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
                                    <div class="container">
                                        <div class="form-group row ">
                                            <label class="col-sm-1 col-label ">name</label>
                                            <div class="col-sm-4  ">
                                                <input type="name" class="form-control live" data-class=".live-name" autocomplete="off" name='name' placeholder='Name of Item' required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-1 col-form-label  ">description</label>
                                            <div class="col-sm-4">
                                                <input type="text" class="form-control live" data-class=".live-description" autocomplete="off" name='description' placeholder="Add a description">
                                            </div>
                                        </div>
                                        <div class="form-group row ">
                                            <label class="col-sm-1 col-label  ">price</label>
                                            <div class="col-sm-4  ">
                                                <input type="text" class="form-control live" data-class=".live-price" autocomplete="off" name="price" placeholder='price of the item' required>
                                            </div>
                                        </div>
                                        <div class="form-group row ">
                                            <label class="col-sm-1 col-label  ">country</label>
                                            <div class="col-sm-4  ">
                                                <input type="text" class="form-control" autocomplete="off" name="country" placeholder='Country of made' required>
                                            </div>
                                        </div>
                                        <div class="form-group row ">
                                            <label class="col-sm-1 col-label">status</label>
                                            <div class="col-sm-4  ">
                                                <select class="form-control" name="status">
                                                    <option value="1">new</option>
                                                    <option value="2">like New</option>
                                                    <option value="3">used</option>
                                                    <option value="4">Old</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group row ">
                                            <label class="col-sm-1 col-label">categories</label>
                                            <div class="col-sm-4  ">
                                                <select class="form-control" name="cat">
                                                    <option value="1">...</option>
                                                    <?php
                                                    $qu = "SELECT id, name FROM `categories`";
                                                    $query = $con->prepare($qu);
                                                    $query->execute();
                                                    $fetchAll = $query->fetchAll();
                                                    foreach ($fetchAll as $item) {
                                                        echo '<option value="' . $item['id'] . '">' . $item['name'] . '</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-sm-5">
                                                <button type="submit" name='insert-item' class="btn btn-primary btn-block btn-lg">Add</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <!-- End add script -->
                            </div>
                        </div>
                        <!-- preview -->
                        <div class="col-md-6">
                            <div class="box">

                                <div class="thumbnail item-box">
                                    <span class="price">$
                                        <span class="live-price">
                                            price
                                        </span>
                                    </span>
                                    <img src="computer.png" class="img-fluid img-thumbnail" alt="Responsive image">
                                    <div class="caption">
                                        <h3 class="live-name text-center"> title </h3>
                                        <p class="live-description text-center">Description </p>
                                    </div>

                                </div>

                            </div>
                        </div>
                        <!-- end preview -->
                    </div>
                </div>
            </div>
            <!-- End Ads block -->


        </div>



    <?php
} else {
    header('location: login.php');
    exit();
}
include $temp . 'footer.php';
?>