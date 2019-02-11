<?php
//// $pass= hash('sha256',$pas);
// echo hash('sha256',"123");
session_start();

if (isset($_SESSION["user_id"]) && $_SESSION["is_admin"] === false) {
    $id = $_SESSION['user_id'];
    require_once './templetes/nav.php';
    require_once '..\..\autoload.php';
    $con = new MySQLI_DB("users");

    $profile = $con->get_record_by_id($id, "id");
    ?>


    <div class="container" style="width: 45%; float:left; background-color: antiquewhite;margin-left: 30%; margin-top: 70px; height: auto;">
        <h2 style="text-decoration: underline; margin-bottom: 35px;text-align: center;">Update Data</h2>
        <form action=""  method="POST" enctype="multipart/form-data" name="update_data">
            <div class="form-group">
                <label for="fname">Full Name :</label>
                <input type="text"class="form-control" name="firstname" id="fname" value="<?php echo $profile[0]["name"]; ?>" />
            </div>  

            <div class="form-group">
                <label for="userame">User Name :</label>
                <input type="text" class="form-control" name="username" id="username" value="<?php echo $profile[0]["username"]; ?>" />
            </div> 

            <div class="form-group">
                <label for="job">Job :</label>
                <input type="text" class="form-control" id="job" value="<?php echo $profile[0]["job"]; ?>" name="job"/>
            </div> 

            <!--    <div class="form-group">
                  <label for="pwd">Password:</label>
                  <input type="password" class="form-control" id="pwd" placeholder="Enter password" name="pwd">
                </div>-->
            <br>
            <div class="form-group">
                <label for="fileSelect">Filename:</label>
                <input type="file" name="cv" id="fileSelect" value="lllll">
                <br>
                <label for="fileSelect"> Photo:</label>
                <input type="file" name="image" value="Change Photo" <?php $_FILES['img'] = "../../upload/imgs/" . $profile[0]['img']; ?>>
                <p><strong>Note:</strong> Only .jpg formats allowed to a max size of 1 MB.</p>

            </div>



            <br>  
            <div class="checkbox">
                <label><input type="checkbox" name="remember"> Remember me</label>
            </div>


            <input value="Save" type="submit" name="updted_btn" class="btn btn-primary btn-lg" style="margin-left:35%; width: 30%; "/>
        </form>
    </div>
    <?php
    if (isset($_POST['updted_btn'])) {
        print_r($_POST);

        $us = new User();
        $error = $us->validation($profile);

        // Upload file to server
        if (empty($error) == true) {
            $field['name'] = $_POST["firstname"];
            $field['username'] = $_POST["username"];
            $field["job"] = $_POST["job"];
            //$field["img"]=$profile[0]['img']; 
            $field["cv"] = round(microtime()) . $field["cv"];
            $field["img"] = round(microtime()) . $field["img"];
            move_uploaded_file($image_tmp, "../../upload/imgs/" . $field["img"]);
            move_uploaded_file($file_tmp, "../../upload/cv/" . $field["cv"]);
            //$field["cv"]=$profile[0]['cv'];

            if (file_exists("../../upload/cv/" . $profile[0]["cv"])) {
                unlink("../../upload/cv/" . $profile[0]["cv"]);
            }
            echo "../../upload/imgs/" . $profile[0] . ["img"];
            if (file_exists("../../upload/imgs/" . $profile[0]["img"])) {
                echo 'immmmmmmmmmmmmmmmmmmmmmmmmmgggggggggggggggggg';
                unlink("../../upload/imgs/" . $profile[0]["img"]);
            }
            move_uploaded_file($image_tmp, "../../upload/imgs/" . $field["img"]);
            move_uploaded_file($file_tmp, "../../upload/cv/" . $field["cv"]);
//            print_r("iserted arrayyyyyyyyyyyyy", $field);
            $insert = $con->update_record($field, $profile[0]["id"]);

            if ($insert) {
                echo"succes";
            } else {
                echo"failed";
            }
        } else {


            echo 'errorrs is  >>>>>>>>>>>>>';
            print_r($error);
            ?>

            <script> alert(<?php implode("\n", $error) ?>)</script>
            <?php
        }
//    require_once  $_SERVER["SERVER"];
    }
}
?>
