<?php

class User {

//    private $userName;
//    private $password;
//    private $is_admin;

    private $con;

    public function __construct() {
        $this->con = new MySQLI_DB("users");
    }

    function validate_user() {
        if (isset($_POST['loginForm'])) {
            $user = $_POST['username'];
            $pass = $_POST['password'];

            $result = $this->con->check_login($user, $pass);
            if ($result) {
                foreach ($result as $record) {
                    echo $record['id'];
                    echo $record['username'];
                    $_SESSION['user_id'] = $record['id'];
                    if ($record['is_admin'] == TRUE) {
                        $_SESSION['is_admin'] = TRUE;
                    } else {
                        $_SESSION['is_admin'] = FALSE;
                        echo '<h1>session created</h1>';
                    }
                    //header('location:index.php');
                    //exit();
                }
            }

//         else {
//
//            $formerrors [] = "you don't  have account ";
//        }
        }
    }

    function validation($profile = array()) {
        $error = [];
        $con = new MySQLI_DB("users");

        if (isset($_POST['firstname']) && empty($_POST["firstname"])) {
            $error[] = 'no name';
        }
        if (isset($_POST["userame"]) && empty($_POST["username"])) {
            $error[] = 'no username';
        }
        if (isset($_POST["job"]) && empty($_POST["job"])) {
            $error[] = 'no job';
        }
        $isvalidname = $con->check_userName($_POST["username"]);
        if ($isvalidname) {

            if (isset($_POST["pwd"]) && isset($_POST["rpwd"])) {

                if (empty($_POST["pwd"]) || empty($_POST["rpwd"])) {

                    $error[] = "must Enter both password";
                } elseif ($_POST["pwd"] != $_POST["rpwd"]) {
                    $error[] = "two password must be identical ";
                } elseif (strlen($_POST["pwd"]) < __MIN_PASWORD_LENGTH__ || strlen($_POST["pwd"]) > __MAX_PASWORD_LENGTH__) {
                    $error[] = "Passsword should be in range 8:16 ";
                }
            }



            if (isset($_FILES['image']['tmp_name']) && !empty($_FILES['image']['tmp_name'])) {


                $__ALLOW_IMAGE_SIZE = 1048576;
                $__Allow_IMAGE_TYPES = array('jpg');
                $image_name = $_FILES['image']['name'];
                $image_size = $_FILES['image']['size'];
                $image_tmp = $_FILES['image']['tmp_name'];

                $image_ext = strtolower(end(explode('.', $_FILES['image']['name'])));

                if ($_FILES["image"]["size"] > $__ALLOW_IMAGE_SIZE) {
                    echo 'not allowed imge size ';
                    $error[] = 'not allowed image size ';
                }
                if (!in_array($image_ext, $__Allow_IMAGE_TYPES)) {
                    echo 'not allowed image type ';
                    $error[] = 'not allowed image type ';
                }
                $field["img"] = $_FILES["image"]["name"];
            } else {
                $field["img"] = $profile[0]['image'];
//       $error[] = 'must insert cv  ';
            }



            if (isset($_FILES['cv']['tmp_name']) && !empty($_FILES['cv']['tmp_name'])) {
                $__ALLOW_CV_TYPES = array('pdf');
                $file_name = $_FILES['cv']['name'];
                $file_tmp = $_FILES['cv']['tmp_name'];
                $file_ext = strtolower(end(explode('.', $_FILES['cv']['name'])));
                $cvName = basename($_FILES["cv"]["name"]);
                $targetcvPath = "upload/cv/" . $cvName;
                //$cvType = pathinfo($targetcvPath, PATHINFO_EXTENSION);

                if (!in_array($file_ext, $__ALLOW_CV_TYPES)) {
                    $error[] = 'not allowed file type ';
                    echo 'not allowed file type ';
                }

                $field["cv"] = $_FILES["cv"]["name"];
            } else {


                //$error[] = 'must insert cv  ';
                $field["cv"] = $profile[0]['cv'];
            }
        } else {

            $error[] = "invalide name";
        }
        return $error;
    }

}
