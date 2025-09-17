<?php
session_start();
include('includes/config.php');
error_reporting(0);
if (strlen($_SESSION['login']) == 0) {
    header('location:index.php');
} else {
    if (isset($_POST['update'])) {
        $productid = intval($_GET['pid']);
        $productname = $_POST['productname'];
        $pcategoryid = $_POST['pcategory'];
        $productdetails = $_POST['productdescription'];
        $buyurl = $_POST['buyurl'];

        // Generate slug from product name
        $arr = explode(" ", $productname);
        $slug = implode("-", $arr);

        $query = mysqli_query($con, "UPDATE PRODUCTS 
                                    SET name = '$productname', 
                                        pcategory_id = '$pcategoryid', 
                                        description = '$productdetails', 
                                        buy_url = '$buyurl',
                                        slug = '$slug'
                                    WHERE product_id = '$productid'");
        if ($query) {
            $msg = "Product updated successfully.";
        } else {
            $error = "Something went wrong. Please try again.";
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
                            <h4 class="page-title">Edit Product</h4>
                            <ol class="breadcrumb p-0 m-0">
                                <li><a href="#">Admin</a></li>
                                <li><a href="#">Products</a></li>
                                <li class="active">Edit Product</li>
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

                <?php
                $productid = intval($_GET['pid']);
                $query = mysqli_query($con, "SELECT 
                                                PRODUCTS.product_id as prodid,
                                                PRODUCTS.name as productname,
                                                PRODUCTS.description as productdesc,
                                                PRODUCTS.buy_url,
                                                PRODUCTS.image_url,
                                                PRODUCT_CATEGORIES.name as category,
                                                PRODUCT_CATEGORIES.pcategory_id as catid
                                            FROM PRODUCTS
                                            LEFT JOIN PRODUCT_CATEGORIES ON PRODUCT_CATEGORIES.pcategory_id = PRODUCTS.pcategory_id
                                            WHERE PRODUCTS.product_id = '$productid' AND PRODUCTS.is_active = 1");
                while ($row = mysqli_fetch_array($query)) {
                    ?>
                    <form name="addproduct" method="post" class="row">
                        <div class="form-group col-md-6">
                            <label for="productname">Product Name</label>
                            <input type="text" class="form-control" id="productname"
                                value="<?php echo htmlentities($row['productname']); ?>" name="productname" required>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="pcategory">Category</label>
                            <select class="form-control" name="pcategory" id="pcategory" required>
                                <option value="<?php echo htmlentities($row['catid']); ?>">
                                    <?php echo htmlentities($row['category']); ?></option>
                                <?php
                                // Fetching all active product categories
                                $ret = mysqli_query($con, "SELECT pcategory_id, name FROM PRODUCT_CATEGORIES WHERE is_active = 1");
                                while ($result = mysqli_fetch_array($ret)) {
                                    if ($result['pcategory_id'] == $row['catid']) {
                                        continue;
                                    }
                                    ?>
                                    <option value="<?php echo htmlentities($result['pcategory_id']); ?>">
                                        <?php echo htmlentities($result['name']); ?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="form-group col-md-12">
                            <label for="buyurl">Buy URL</label>
                            <input type="url" class="form-control" id="buyurl"
                                value="<?php echo htmlentities($row['buy_url']); ?>" name="buyurl" required>
                        </div>

                        <div class="col-xs-12">
                            <div class="card-box">
                                <h4 class="m-b-30 m-t-0 header-title"><b>Product Description</b></h4>
                                <textarea class="summernote" name="productdescription"
                                    required><?php echo htmlentities($row['productdesc']); ?></textarea>
                            </div>
                        </div>

                        <div class="col-xs-12">
                            <div class="card-box">
                                <h4 class="m-b-30 m-t-0 header-title"><b>Product Image</b></h4>
                                <img src="productimages/<?php echo htmlentities($row['image_url']); ?>" width="300" />
                                <br />
                                <a href="change-product-image.php?pid=<?php echo htmlentities($row['prodid']); ?>">Update
                                    Image</a>
                            </div>
                        </div>

                    <?php } ?>
                    <div class="col-xs-12">
                        <button type="submit" name="update"
                            class="btn btn-custom waves-effect waves-light btn-md">Update</button>
                    </div>
                </form>
            </div>
        </div>
        <?php include('includes/footer.php'); ?>
    </div>
<?php } ?>