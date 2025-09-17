<?php
session_start();
include('includes/config.php');
error_reporting(0);
if (strlen($_SESSION['login']) == 0) {
    header('location:index.php');
} else {
    if (isset($_POST['submit'])) {
        $password = $_POST['password'];
        $adminid = $_SESSION['login'];
        $newpassword = $_POST['newpassword'];

        date_default_timezone_set('Asia/Hanoi'); // change according timezone
        $currentTime = date('d-m-Y h:i:s A', time());
        
        // Fixed query to use correct column name
        $sql = mysqli_query($con, "SELECT password_hash FROM USERS WHERE username='$adminid' OR email='$adminid'");
        $num = mysqli_fetch_array($sql);
        
        if ($num > 0) {
            $dbpassword = $num['password_hash'];

            // Since you're not using password hashing yet, use direct comparison
            if ($password === $dbpassword) {
                // Fixed variable name to avoid overwriting $con connection
                $updateQuery = mysqli_query($con, "UPDATE USERS SET password_hash='$newpassword', updated_at='$currentTime' WHERE username='$adminid' OR email='$adminid'");
                if($updateQuery) {
                    $msg = "Password Changed Successfully !!";
                } else {
                    $error = "Error updating password. Please try again.";
                }
            } else {
                $error = "Old Password does not match !!";
            }
        } else {
            $error = "User not found !!";
        }
    }
?>

    <?php include('includes/topheader.php'); ?>
    <!-- Top Bar End -->

    <script type="text/javascript">
        function valid() {
            if (document.chngpwd.password.value == "") {
                alert("Current Password Filed is Empty !!");
                document.chngpwd.password.focus();
                return false;
            } else if (document.chngpwd.newpassword.value == "") {
                alert("New Password Filed is Empty !!");
                document.chngpwd.newpassword.focus();
                return false;
            } else if (document.chngpwd.confirmpassword.value == "") {
                alert("Confirm Password Filed is Empty !!");
                document.chngpwd.confirmpassword.focus();
                return false;
            } else if (document.chngpwd.newpassword.value != document.chngpwd.confirmpassword.value) {
                alert("Password and Confirm Password Field do not match  !!");
                document.chngpwd.confirmpassword.focus();
                return false;
            }
            return true;
        }
    </script>

    <!-- ========== Left Sidebar Start ========== -->
    <?php include('includes/leftsidebar.php'); ?>
    <!-- Left Sidebar End -->

    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container">

                <div class="row">
                    <div class="col-xs-12">
                        <div class="page-title-box">
                            <h4 class="page-title">Change Password</h4>
                            <ol class="breadcrumb p-0 m-0">
                                <li>
                                    <a href="#">Admin</a>
                                </li>
                                <li class="active">
                                    Change Password
                                </li>
                            </ol>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
                <!-- end row -->

                <div class="card-box">
                    <h4 class="m-t-0 header-title"><b>Change Password </b></h4>
                    <hr />

                    <div class="row">
                        <div class="col-sm-6">
                            <!---Success Message--->
                            <?php if (isset($msg)) { ?>
                                <div class="alert alert-success" role="alert">
                                    <strong>Well done!</strong> <?php echo htmlentities($msg); ?>
                                </div>
                            <?php } ?>

                            <!---Error Message--->
                            <?php if (isset($error)) { ?>
                                <div class="alert alert-danger" role="alert">
                                    <strong>Oh snap!</strong> <?php echo htmlentities($error); ?>
                                </div>
                            <?php } ?>
                        </div>
                    </div>

                    <form class="row" name="chngpwd" method="post" onSubmit="return valid();">

                        <div class="form-group col-md-6">
                            <label class="control-label">Current Password</label>
                            <input type="password" class="form-control" value="" name="password" required>
                        </div>

                        <div class="form-group col-md-6">
                            <label class="control-label">New Password</label>
                            <input type="password" class="form-control" value="" name="newpassword" required>
                        </div>

                        <div class="form-group col-md-6">
                            <label class="control-label">Confirm Password</label>
                            <input type="password" class="form-control" value="" name="confirmpassword" required>
                        </div>

                        <div class="form-group col-md-12">
                            <button type="submit" class="btn btn-custom waves-effect waves-light btn-md" name="submit">
                                Submit
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
        <!-- end row -->

    </div> <!-- container -->

    <?php include('includes/footer.php'); ?>
<?php } ?>