<?php
session_name('admin_session');
session_start();
include('includes/config.php');
error_reporting(0);
if (strlen($_SESSION['login']) == 0) {
    header('location:index.php');
} else {
    if (isset($_POST['update'])) {

        $imgfile = $_FILES["productimage"]["name"];
        // get the image extension
        $extension = substr($imgfile, strlen($imgfile) - 4, strlen($imgfile));
        // allowed extensions
        $allowed_extensions = array(".jpg", "jpeg", ".png", ".gif");
        // Validation for allowed extensions
        if (!in_array($extension, $allowed_extensions)) {
            echo "<script>alert('Invalid format. Only jpg / jpeg/ png /gif format allowed');</script>";
        } else {
            //rename the image file
            $imgnewfile = md5($imgfile) . $extension;
            // Code for move image into directory
            move_uploaded_file($_FILES["productimage"]["tmp_name"], "productimages/" . $imgnewfile);

            $productid = intval($_GET['pid']);
            $query = mysqli_query($con, "UPDATE PRODUCTS SET image_url = '$imgnewfile' where product_id = '$productid'");
            if ($query) {
                $msg = "Product image updated successfully.";
            } else {
                $error = "Something went wrong. Please try again.";
            }
        }
    }
    ?>
    <?php include('includes/topheader.php'); ?>
    <?php include('includes/leftsidebar.php'); ?>
    <div class="content-page">
        <div class="content">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="page-title-box">
                            <h4 class="page-title">Update Product Image</h4>
                            <ol class="breadcrumb p-0 m-0">
                                <li>
                                    <a href="#">Admin</a>
                                </li>
                                <li>
                                    <a href="#">Products</a>
                                </li>
                                <li class="active">
                                    Update Product Image
                                </li>
                            </ol>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <?php if ($msg) { ?>
                            <div class="alert alert-success" role="alert">
                                <strong>Well done!</strong>
                                <?php echo htmlentities($msg); ?>
                            </div>
                        <?php } ?>
                        <?php if ($error) { ?>
                            <div class="alert alert-danger" role="alert">
                                <strong>Oh snap!</strong>
                                <?php echo htmlentities($error); ?>
                            </div>
                        <?php } ?>
                    </div>
                </div>
                <form name="updateproductimage" method="post" enctype="multipart/form-data">
                    <?php
                    $productid = intval($_GET['pid']);
                    $query = mysqli_query($con, "SELECT image_url, name FROM PRODUCTS WHERE product_id = '$productid' AND is_active = 1");
                    while ($row = mysqli_fetch_array($query)) {
                        ?>
                        <div class="row">
                            <div class="col-md-10 col-md-offset-1">
                                <div class="p-6">
                                    <div class="">
                                        <div class="form-group m-b-20">
                                            <label for="productname">Product Name</label>
                                            <input type="text" class="form-control" id="productname"
                                                value="<?php echo htmlentities($row['name']); ?>" name="productname" readonly>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="card-box">
                                                    <h4 class="m-b-30 m-t-0 header-title"><b>Current Product Image</b></h4>
                                                    <img src="productimages/<?php echo htmlentities($row['image_url']); ?>"
                                                        width="300" />
                                                    <br />
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="card-box">
                                                <h4 class="m-b-30 m-t-0 header-title"><b>New Product Image</b></h4>
                                                <p>Product image should be in 16:9 aspect ratio for the best display</p>
                                                <input type="file" class="form-control" id="productimage"
                                                    name="productimage" required>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" name="update"
                                        class="btn btn-success waves-effect waves-light">Update</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <?php include('includes/footer.php'); ?>
    <?php } ?>