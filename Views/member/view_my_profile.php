<?php
//require_once("../../../autoload.php");
session_start();
if (isset($_SESSION["user_id"]) && $_SESSION["is_admin"] === FALSE) {
    $id = $_SESSION['user_id'];
    require_once './templetes/nav.php';
    require_once '..\..\autoload.php';
    $con = new MySQLI_DB("users");

    $profile = $con->get_record_by_id($id, "id");
//    $name=$profile[0]["name"];

?>
<html>

    <header>
        <script src="style.css"></script>
        <style>
         .card {
                    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
                    max-width: 500px;
                    margin: auto;
                    /*margin-left: 35%;*/
                    text-align: center;
                    font-family: arial;
                    height: auto;
                    padding-bottom: 20px;
                    margin-top: 100px;
                }

                .title {
                    color: grey;
                    font-size: 18px;
                }

                button {
                    border: none;
                    outline: 0;
                    display: inline-block;
                    padding: 8px;
                    color: white;
                    background-color: #000;
                    text-align: center;
                    cursor: pointer;
                    width: 100%;
                    font-size: 18px;
                }

                a {
                    text-decoration: none;
                    font-size: 22px;
                    color: black;
                }

                button:hover, a:hover {
                    opacity: 0.7;
                }
                label {
                    float: left;
                    margin-left: 10px;
                    padding-right: 20px;
                }


        </style>
    </header>
    <body>

       <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
            <h2 class="text-center">Profile</h2>
            <br>
            <div class="row">


                <div class="col-md-5 col-xs-12" >
                    <div class="card">
                        <img  src="../../upload/imgs/<?php echo $profile[0]["img"]; ?>" alt="John" style="width:100%;height: 320px">
                        <h1><?php echo $profile[0]["name"]; ?></h1>
                        <label>User Name:</label>
                        <p class="title"><?php echo $profile[0]["username"]; ?></p>
                        <label>Job      :</label>
                        <p><?php echo $profile[0]["job"]; ?></p>
                        <label>cv       :</label>

                    </div>

                </div>
                <div class="col-md-5 col-xs-12">

                    <embed height="600px;" width="100%" src="../admin/CV fresh graduate.pdf" />
                </div>


            </div>
            <script >
            </script>
        </body>
    </html>

    <?php
} else {
    require_once './templetes/header.php';
    echo '<div class="container" style="margin-top:150px;"><div class="alert alert-danger"style="font-size:30px;text-align:center">You Can not access This Page</div></div>';
}
?>