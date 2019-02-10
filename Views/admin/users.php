<?php
session_start();

if (isset($_SESSION["user_id"]) && $_SESSION["is_admin"] === true) {
    require_once './templetes/nav.php';
    require_once '..\..\autoload.php';
    $con = new MySQLI_DB("users");
    $current_offset = (isset($_GET["next"]) && is_numeric($_GET["next"])) ? (int) $_GET["next"] : 0;
//echo $current_offset;
    $next_index = $current_offset + __RECORDS_PER_PAGE__;
    $prev_index = ($current_offset - __RECORDS_PER_PAGE__) > 0 ? $current_offset - __RECORDS_PER_PAGE__ : 0;
//echo $current_offset . '...' . $next_index;

    $resltArr = [];

//$resltArr=$con->get_all_users($current_offset);
    $resltArr = $con->get_all_users($current_offset);

//    $count=$con->get_users_count();
//    echo '<br>';
//    echo "All users count is : $count";
//    echo '<br>';
//    


    $arr = [];
//print_r($resltArr);
    ?>
    <div class="container" style="margin-top: 80px;">
        <div class="row">
            <div class="col-md-8" style="margin-left: 15%;">
                <div class="form-group pull-right" style="margin-bottom: 30px;">
                    <input id="myInputSearch" type="text" class="search form-control" placeholder="Search ">
                </div>
                <span class="counter pull-right"></span>
                <table class="table table-hover table-bordered results">
                    <thead>

                    <th>#</th>
                    <th class="col-md-6 col-xs-6">Name </th>
                    <th class="col-md-6 col-xs-6">More</th>

                    </thead>
                    <tbody>

                        <?php foreach ($resltArr as $value) : ?>
                            <tr>
                                <td class="tr"><?= $value["id"] ?></td>
                                <td class="tr"><?= $value["username"] ?></td> 
                                <td class="tr"><a href="user.php?user_id=<?php echo $value['id']; ?>">More</a></td>
                            </tr>
                        <?php endforeach; ?>

                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <script>
        $(document).ready(function () {
            $("#myInputSearch").on("keyup", function () {
                var value = $(this).val().toLowerCase();
                $("tbody tr").filter(function () {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });



        });



    </script>    


    <nav aria-label="Page navigation example" style="text-align: center; margin-left: 35%;">
        <ul class="pagination">
            <li class="page-item"><a class="page-link"  href="<?= $_SERVER['PHP_SELF'] . '?next=' . $prev_index ?>">Previous</a></li>
            <li class="page-item"><a class="page-link" href="<?= $_SERVER['PHP_SELF'] . '?next=' . $next_index ?>">Next</a></li>
        </ul>
    </nav>
    </body>
    </html>
    <?php
}else {
    require_once './templetes/header.php';
    echo '<div class="container" style="margin-top:150px;"><div class="alert alert-danger"style="font-size:30px;text-align:center">You Can not access This Page</div></div>';
}
?>











