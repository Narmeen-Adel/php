<?php
session_start();
if (isset($_SESSION["user_id"]) && $_SESSION["is_admin"] === true) {
    require_once './templetes/nav.php';
    require_once '..\..\autoload.php';
    $con = new MySQLI_DB("users");

    $user_id = (isset($_GET['user_id']) && is_numeric($_GET['user_id'])) ? $_GET['user_id'] : 0;
//    echo "<h2>$user_id</h2>";
    $current_item_arr = [];
    $current_item_arr = $con->get_record_by_id($user_id, "id");
    ?>

    <div class="container" style="margin-top: 80px;">
        <br>
        <h2 class="text-center">User Data</h2>
        <br>
        <br>
            <div class="row">
                <div class="col-md-6" style=" margin-bottom: 50px;margin-left: 22%;"><img class="img-responsive" src="../../upload/imgs/3-Tacos-on-White-Plate.jpg"/></div>
            <div class="col-md-8" style="margin-left: 15%;">

                <span class="counter pull-right"></span>
                <table class="table table-hover table-bordered results">
                    <thead>

                    <th>#</th>
                    <th class="col-md-3 col-xs-3">Name </th>
                    <th class="col-md-3 col-xs-3">user name</th>
                    <th class="col-md-3 col-xs-3">job</th>

                    </thead>
                    <tbody>
                        <?php foreach ($current_item_arr as $value) : ?>
                            <tr>
                                <td ><?= $value["id"] ?></td>    
                                <td ><?= $value["name"] ?></td>    
                                <td ><?= $value["username"] ?></td> 
                                <td ><?= $value["job"] ?></td>    

                            </tr>
                        <?php endforeach; ?>

                    </tbody>
                </table>
                <embed height="600px;" width="100%" src="CV fresh graduate.pdf" />
                <br>
                <p>Hello</p>
            </div>
        </div>

    </div>
   



    <?php
}else {
    require_once './templetes/header.php';
    echo '<div class="container" style="margin-top:150px;"><div class="alert alert-danger"style="font-size:30px;text-align:center">You Can not access This Page</div></div>';
}
?>
