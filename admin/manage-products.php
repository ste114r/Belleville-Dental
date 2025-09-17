<?php
session_start();
include('includes/config.php');
error_reporting(0);

if (strlen($_SESSION['login']) == 0) {
    header('location:index.php');
} else {

    // Code for delete
    if ($_GET['action'] == 'del' && $_GET['rid']) {
        $productid = intval($_GET['rid']);
        $query = mysqli_query($con, "UPDATE PRODUCTS SET is_active = 0 WHERE product_id = '$productid'");
        $msg = "Product deleted successfully.";
    }
    // Code for restore
    if ($_GET['resid']) {
        $productid = intval($_GET['resid']);
        $query = mysqli_query($con, "UPDATE PRODUCTS SET is_active = 1 WHERE product_id = '$productid'");
        $msg = "Product restored successfully.";
    }

    // Code for permanent delete
    if ($_GET['action'] == 'permdel' && $_GET['rid']) {
        $productid = intval($_GET['rid']);
        $query = mysqli_query($con, "DELETE FROM PRODUCTS WHERE product_id = '$productid'");
        $delmsg = "Product deleted permanently.";
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
                            <h4 class="page-title">Manage Products</h4>
                            <ol class="breadcrumb p-0 m-0">
                                <li><a href="#">Admin</a></li>
                                <li><a href="#">Products</a></li>
                                <li class="active">Manage Products</li>
                            </ol>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <?php if ($msg) { ?>
                            <div class="alert alert-success" role="alert">
                                <strong><?php echo htmlentities($msg); ?></strong>
                            </div>
                        <?php } ?>
                        <?php if ($delmsg) { ?>
                            <div class="alert alert-danger" role="alert">
                                <strong><?php echo htmlentities($delmsg); ?></strong>
                            </div>
                        <?php } ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card-box m-t-20">
                            <div class="table-responsive">
                                <table class="table m-0 table-bordered" id="example">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Product Name</th>
                                            <th>Category</th>
                                            <th>Created Date</th>
                                            <th>Last Update</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $query = mysqli_query($con, "SELECT PRODUCTS.product_id as prodid, PRODUCTS.name as title, PRODUCTS.created_at, PRODUCTS.updated_at, PRODUCT_CATEGORIES.name as category
                                                                        FROM PRODUCTS
                                                                        LEFT JOIN PRODUCT_CATEGORIES ON PRODUCT_CATEGORIES.pcategory_id = PRODUCTS.pcategory_id
                                                                        WHERE PRODUCTS.is_active = 1");
                                        $cnt = 1;
                                        while ($row = mysqli_fetch_array($query)) {
                                            ?>
                                            <tr>
                                                <th scope="row"><?php echo htmlentities($cnt); ?></th>
                                                <td><?php echo htmlentities($row['title']); ?></td>
                                                <td><?php echo htmlentities($row['category']) ?></td>
                                                <td><?php echo htmlentities($row['created_at']); ?></td>
                                                <td><?php echo htmlentities($row['updated_at']); ?></td>
                                                <td><a class="btn btn-primary btn-sm" href="edit-product.php?pid=<?php echo htmlentities($row['prodid']); ?>"><i class="fa fa-pencil"></i></a>
                                                    &nbsp;<a class="btn btn-danger btn-sm" href="manage-products.php?rid=<?php echo htmlentities($row['prodid']); ?>&action=del"> <i class="fa fa-trash-o"></i></a>
                                                </td>
                                            </tr>
                                            <?php
                                            $cnt++;
                                        } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card-box m-t-20">
                            <div class="m-b-30">
                                <h4><i class="fa fa-trash-o"></i> Deleted Products</h4>
                            </div>
                            <div class="table-responsive">
                                <table class="table m-0 table-bordered table-bordered-danger" id="example1">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Product Name</th>
                                            <th>Category</th>
                                            <th>Created Date</th>
                                            <th>Last Update</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $query = mysqli_query($con, "SELECT PRODUCTS.product_id as prodid, PRODUCTS.name as title, PRODUCTS.created_at, PRODUCTS.updated_at, PRODUCT_CATEGORIES.name as category
                                                                        FROM PRODUCTS
                                                                        LEFT JOIN PRODUCT_CATEGORIES ON PRODUCT_CATEGORIES.pcategory_id = PRODUCTS.pcategory_id
                                                                        WHERE PRODUCTS.is_active = 0");
                                        $cnt = 1;
                                        while ($row = mysqli_fetch_array($query)) {
                                            ?>
                                            <tr>
                                                <th scope="row"><?php echo htmlentities($cnt); ?></th>
                                                <td><?php echo htmlentities($row['title']); ?></td>
                                                <td><?php echo htmlentities($row['category']) ?></td>
                                                <td><?php echo htmlentities($row['created_at']); ?></td>
                                                <td><?php echo htmlentities($row['updated_at']); ?></td>
                                                <td><a class="btn btn-primary btn-sm" href="manage-products.php?resid=<?php echo htmlentities($row['prodid']); ?>"><i class="ion-arrow-return-right" title="Restore Product"></i></a>
                                                    &nbsp;<a class="btn btn-danger btn-sm" href="manage-products.php?rid=<?php echo htmlentities($row['prodid']); ?>&action=permdel" onclick="return confirm('Do you want to permanently delete this product?')"><i class="fa fa-trash-o" title="Permanently Delete Product"></i></a>
                                                </td>
                                            </tr>
                                            <?php
                                            $cnt++;
                                        } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </div> </div> <?php include('includes/footer.php'); ?>
    <?php }
?>