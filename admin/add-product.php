<?php
session_start();
include('includes/config.php');
error_reporting(0);
if (strlen($_SESSION['login']) == 0) {
    header('location:index.php');
} else {

    // For adding product 
    if (isset($_POST['submit'])) {
        $productname = $_POST['productname'];
        $pcategoryid = $_POST['pcategory'];
        $productdetails = $_POST['productdescription'];
        $buyurl = $_POST['buyurl'];
        
        // Generate slug from product name
        $arr = explode(" ", $productname);
        $slug = implode("-", $arr);

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
            // Code for moving image into directory (assuming a 'productimages' directory exists)
            move_uploaded_file($_FILES["productimage"]["tmp_name"], "productimages/" . $imgnewfile);

            $status = 1;
            $query = mysqli_query($con, "INSERT INTO PRODUCTS(name, slug, description, pcategory_id, buy_url, image_url, is_active) 
                                        VALUES('$productname', '$slug', '$productdetails', '$pcategoryid', '$buyurl', '$imgnewfile', '$status')");
            if ($query) {
                $msg = "Product added successfully.";
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
                            <h4 class="page-title">Add Product</h4>
                            <ol class="breadcrumb p-0 m-0">
                                <li>
                                    <a href="#">Admin</a>
                                </li>
                                <li>
                                    <a href="#">Products</a>
                                </li>
                                <li class="active">
                                    Add Product
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
                                <strong>Well done!</strong> <?php echo htmlentities($msg); ?>
                            </div>
                        <?php } ?>
                        <?php if ($error) { ?>
                            <div class="alert alert-danger" role="alert">
                                <strong>Oh snap!</strong> <?php echo htmlentities($error); ?>
                            </div>
                        <?php } ?>
                    </div>
                </div>

                <form name="addproduct" method="post" class="row" enctype="multipart/form-data">
                    <div class="form-group col-md-6">
                        <label for="productname">Product Name</label>
                        <input type="text" class="form-control" id="productname" name="productname" placeholder="Enter product name" required>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="pcategory">Category</label>
                        <select class="form-control" name="pcategory" id="pcategory" required>
                            <option value="">Select Category</option>
                            <?php
                            // Fetching active product categories
                            $ret = mysqli_query($con, "SELECT pcategory_id, name FROM PRODUCT_CATEGORIES WHERE is_active = 1;");
                            while ($result = mysqli_fetch_array($ret)) {
                            ?>
                                <option value="<?php echo htmlentities($result['pcategory_id']); ?>">
                                    <?php echo htmlentities($result['name']); ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="form-group col-md-12">
                        <label for="buyurl">Buy URL</label>
                        <input type="url" class="form-control" id="buyurl" name="buyurl" placeholder="https://example.com/product-link" required>
                    </div>
                    
                    <div class="col-xs-12">
                        <div class="card-box">
                            <h4 class="m-b-30 m-t-0 header-title"><b>Product Description</b></h4>
                            <textarea class="summernote" name="productdescription" required></textarea>
                        </div>
                    </div>

                    <div class="col-xs-12">
                        <div class="card-box">
                            <h4 class="m-b-30 m-t-0 header-title"><b>Product Image</b></h4>
                            <input type="file" class="form-control" id="productimage" name="productimage" required>
                        </div>
                    </div>

                    <div class="col-xs-12">
                        <button type="submit" name="submit" class="btn btn-custom waves-effect waves-light btn-md">Submit</button>
                        <button type="button" class="btn btn-danger waves-effect waves-light">Discard</button>
                    </div>
                </form>
            </div> </div> <?php include('includes/footer.php'); ?>
    <?php }
?>