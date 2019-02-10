<?php
if (isset($_SESSION["user_id"]) && $_SESSION["is_admin"] === false) {
    $message = 'Users is already logged in';
    header("location: profile.php");
    exit;
}
?>


<div class="container" style="width: 45%; float:left; background-color: antiquewhite;margin-left: 6%; margin-top: 70px; height: auto;">
    <h2 style="text-decoration: underline; margin-bottom: 35px;text-align: center;">Create An Account</h2>
    <form action=""  method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="fname">Full Name :</label>
            <input type="text" class="form-control" id="fname" placeholder="Enter Your Full Name" name="firstname"/>
        </div>  

        <div class="form-group">
            <label for="userName">User Name :</label>
            <input type="text" class="form-control" id="username" placeholder="Enter User Name" name="username"/>
        </div> 

        <div class="form-group">
            <label for="job">Job :</label>
            <input type="text" class="form-control" id="job" placeholder="Enter Your job" name="job"/>
        </div> 

        <div class="form-group">
            <label for="pwd">Password:</label>
            <input type="password" class="form-control" id="pwd" placeholder="Enter password" name="pwd">
        </div>

        <div class="form-group">
            <label for="pwd">Re-Enter_Password:</label>
            <input type="password" class="form-control" id="pwd" placeholder="Enter password" name="rpwd">
        </div>
        <br>
        <div class="form-group">
            <label for="fileSelect">Filename:</label>
            <input type="file" name="photo" id="fileSelect">
            <br>
            <input type="submit" name="submit" value="Upload">
            <p><strong>Note:</strong> Only .jpg formats allowed to a max size of 1 MB.</p>

        </div>


        <div class="form-group">
            <label for="fileSelect">Filename:</label>
            <input type="file" name="photo" id="fileSelect">
            <br>
            <input type="submit" name="submit" value="Upload">

        </div>

        <br>  
        <div class="checkbox">
            <label><input type="checkbox" name="remember"> Remember me</label>
        </div>


        <input value="Save" type="submit" name="signup_btn" class="btn btn-primary btn-lg" style="margin-left:35%; width: 30%; "/>
    </form>
</div>

<?php
$us = new User();
if (isset($_POST['signup_btn'])) {

//    if($_SESSION['user_id'] = $id && $_SESSION['is_admin'] = FALSE)
//    {
//         header("location:../../index.php");
//    
//    }              

    $arr = [];
//$error = $us ->validation($arr) ;
//$error = validation($profile);
    // Upload file to server
    $error = [];
    if (empty($error) == true) {
        $field['name'] = $_POST["firstname"];
        $field['username'] = $_POST["username"];
        $field["job"] = $_POST["job"];
        //$field["img"]=$profile[0]['img']; 
        $field["cv"] = round(microtime()) . $field["cv"];
        $field["img"] = round(microtime()) . $field["img"];
        $field["password"] = hash('sha256', $_POST['pwd']);
        move_uploaded_file($image_tmp, "../upload/imgs/" . $field["img"]);
        move_uploaded_file($file_tmp, "../upload/cv/" . $field["cv"]);
        //$field["cv"]=$profile[0]['cv'];

        if (file_exists("../upload/cv/" . $profile[0]["cv"])) {
            unlink("../upload/cv/" . $profile[0]["cv"]);
        }
        echo "../upload/imgs/" . $profile[0] . ["img"];
        if (file_exists("../upload/imgs/" . $profile[0]["img"])) {
            echo 'immmmmmmmmmmmmmmmmmmmmmmmmmgggggggggggggggggg';
            unlink("../upload/imgs/" . $profile[0]["img"]);
        }
        move_uploaded_file($image_tmp, "../upload/imgs/" . $field["img"]);
        move_uploaded_file($file_tmp, "../upload/cv/" . $field["cv"]);
        $insert = $con->insert_record($field);

        if ($insert) {
            $con = new MySQLI_DB("users");
            $username = $_POST["username"];
            echo "<h1>$username</h1>";
            $res = $con->get_user_id_by_userName($username);
            foreach ($res as $value) {
                $id = $value["id"];
//                 echo "<h1>From Sing up $id</h1>";
//                header("location:../member/view_my_profile.php");
                $_SESSION['user_id'] = $id;
                $_SESSION['is_admin'] = FALSE;
//                header("location: profile.php");
                header("Refresh:0; url=profile.php");
//                exit;
            }
        }
//        echo"succes";
    } else {
        echo"failed";
    }
} else {

    if (!empty($error)) {
        var_dump($error);
    }
}
?>
