<?php
require 'dbconn.php';
session_start();

if (isset($_POST['userName'])) {
    $Username = $_POST['userName'];
    $Password = md5($_POST['password']);

    $query = "SELECT * from user where userName='$Username' and password='$Password'";

    $result = mysqli_query($con, $query);
    $count = mysqli_num_rows($result);

    if ($count > 0) {
        $row = mysqli_fetch_row($result);
        // var_dump($row);
        // die;
        $_SESSION['userID'] = $row[0];
        $_SESSION['userName'] = $row[1];
        $_SESSION['userType'] = $row[3];

        header('location:role.php');
    } else
        echo "<script type='text/javascript'>alert('Account Invalid Please Contact Admin');</script>";
}
?>
<html lang="en">

<head>


    <meta charset="utf-8">
    <title>Payroll System</title>

    <link rel="stylesheet" href="indexstyle.css">


    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <style>

    </style>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-2"></div>
            <div class="col-lg-6 col-md-8 login-box">
                <div class="col-lg-12 login-key">
                    <i class="" aria-hidden="true"></i>
                </div>
                <div class="col-lg-12 login-title">
                    LOG IN
                </div>

                <div class="col-lg-12 login-form">
                    <div class="col-lg-12 login-form">
                        <form method="POST">
                            <div class="form-group">
                                <label class="form-control-label">User Name</label>
                                <input type="text" id="userName" name="userName" class="form-control">
                            </div>
                            <div class="form-group">
                                <label class="form-control-label">Password</label>
                                <input type="password" id="password" name="password" class="form-control">
                            </div>

                            <div class="col-lg-12 loginbttm">
                                <div class="col-lg-6 login-btm login-text">
                                    <!-- Error Message -->
                                </div>
                                <div class="col-lg-5 login-btm login-button">
                                    <button type="submit" class="btn btn-outline-primary">LOGIN</button>
                                </div>
                                <div class="col-lg-2 login-btm login-button">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>





</body>


</html>