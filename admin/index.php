<?php
session_start();
include('includes/config.php');

if (isset($_POST['login'])) {
    $uname = $_POST['username'];
    // $password = md5($_POST['password']);
    $password = $_POST['password'];

    $sql = mysqli_query($con, "SELECT user_id, username, email, password_hash, role FROM USERS WHERE (username = '$uname' OR email = '$uname') AND password_hash = '$password' AND role = 'admin' ");
    $user = mysqli_fetch_array($sql);

    if ($user) {
        $_SESSION['login'] = $user['username'];
        $_SESSION['userid'] = $user['user_id'];
        echo "<script type='text/javascript'> document.location = 'dashboard.php'; </script>";
    } else {
        echo "<script>alert('Invalid username or password');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="101 + Belleville Dental.">
    <meta name="author" content="xyz">

    <!-- App title -->
    <link rel="shortcut icon" href="assets/images/Belleville Dental logo transparent.png" type="image/x-icon">
    <title> Belleville Dental | Admin Panel</title>

    <!-- App css -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/core.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/components.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/icons.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/pages.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/menu.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/responsive.css" rel="stylesheet" type="text/css" />

    <script src="assets/js/modernizr.min.js"></script>
</head>

<style>
.account-logo-box {
    display: flex;
    justify-content: center;
    align-items: center;
    margin-bottom: 30px; /* Optional spacing below the logo */
}

.account-logo-box img {
    max-width: 100%;
    height: auto;
}
</style>

<body class="bg-transparent">
    <!-- HOME -->
    <section>
        <div class="container">
            <div class="">
                <div class="">
                    <div class="wrapper-page">
                        <div class="">
                            <div class="account-logo-box">
                                <h2 class="text-uppercase">
                                    <a href="index.php" class="brand">
                                        <span><img src="assets/images/Belleville Dental logo transparent.png" alt=""
                                                width="300px"></span>
                                    </a>
                                </h2>
                            </div>
                            <div class="account-content">
                                <form class="form-horizontal" method="post">
                                    <div class="form-group ">
                                        <div class="col-xs-12">
                                            <input class="form-control" type="text" required="" name="username"
                                                placeholder="Username or email" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="text-right mb-2"><a href="forgot-password.php"><i
                                                class="mdi mdi-lock"></i>Forgot Your Password?</a></div>
                                    <div class="form-group">
                                        <div class="col-xs-12">
                                            <input class="form-control" type="password" name="password" required=""
                                                placeholder="Password" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="form-group account-btn text-center m-t-10">
                                        <div class="col-xs-12">
                                            <button class="btn btn-custom waves-effect waves-light btn-md w-100"
                                                type="submit" name="login">Log In</button>
                                        </div>
                                    </div>
                                </form>
                                <div class="text-center">
                                    <a href="../index.php"><i class="mdi mdi-home"></i>Back to Website</a>
                                </div>
                            </div>
                        </div>
                        <!-- end card-box-->
                    </div>
                    <!-- end wrapper -->
                </div>
            </div>
        </div>
    </section>
    <!-- END HOME -->
    <script>
        var resizefunc = [];
    </script>
    <!-- jQuery  -->
    <script src="assets/js/jquery.min.js"></script>
    <!-- <script src="assets/js/bootstrap.min.js"></script> -->
    <script src="assets/js/detect.js"></script>
    <script src="assets/js/fastclick.js"></script>
    <script src="assets/js/jquery.blockUI.js"></script>
    <script src="assets/js/waves.js"></script>
    <script src="assets/js/jquery.slimscroll.js"></script>
    <script src="assets/js/jquery.scrollTo.min.js"></script>

    <!-- App js -->
    <script src="assets/js/jquery.core.js"></script>
    <script src="assets/js/jquery.app.js"></script>
</body>

</html>