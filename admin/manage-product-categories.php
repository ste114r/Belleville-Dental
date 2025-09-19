<?php
session_name('admin_session');
session_start();
include('includes/config.php');
error_reporting(0);

if (strlen($_SESSION['login']) == 0) {
    header('location:index.php');
} else {

    // Code for delete
    if ($_GET['action'] == 'del' && $_GET['rid']) {
        $id = intval($_GET['rid']);
        $query = mysqli_query($con, "UPDATE PRODUCT_CATEGORIES SET is_active = '0' WHERE pcategory_id = '$id'");
        $msg = "Product Category deleted successfully.";
    }
    // Code for restore
    if ($_GET['resid']) {
        $id = intval($_GET['resid']);
        $query = mysqli_query($con, "UPDATE PRODUCT_CATEGORIES SET is_active = '1' WHERE pcategory_id = '$id'");
        $msg = "Product Category restored successfully.";
    }

    // Code for permanent delete
    if ($_GET['action'] == 'permdel' && $_GET['rid']) {
        $id = intval($_GET['rid']);
        $query = mysqli_query($con, "DELETE FROM PRODUCT_CATEGORIES WHERE pcategory_id = '$id'");
        $delmsg = "Product Category deleted permanently.";
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
                            <h4 class="page-title">Manage Product Categories</h4>
                            <ol class="breadcrumb p-0 m-0">
                                <li><a href="#">Admin</a></li>
                                <li><a href="#">Product Category</a></li>
                                <li class="active">Manage Product Categories</li>
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
                                            <th>Category</th>
                                            <th>Description</th>
                                            <th>Posting Date</th>
                                            <th>Last Update Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $query = mysqli_query($con, "SELECT pcategory_id, name, description, created_at, updated_at FROM PRODUCT_CATEGORIES WHERE is_active = 1");
                                        $cnt = 1;
                                        while ($row = mysqli_fetch_array($query)) {
                                            ?>
                                            <tr>
                                                <th scope="row"><?php echo htmlentities($cnt); ?></th>
                                                <td><?php echo htmlentities($row['name']); ?></td>
                                                <td><?php echo htmlentities($row['description']); ?></td>
                                                <td><?php echo htmlentities($row['created_at']); ?></td>
                                                <td><?php echo htmlentities($row['updated_at']); ?></td>
                                                <td><a class="btn btn-primary btn-sm" href="edit-product-category.php?cid=<?php echo htmlentities($row['pcategory_id']); ?>"><i class="fa fa-pencil"></i></a>
                                                    &nbsp;<a class="btn btn-danger btn-sm" href="manage-product-categories.php?rid=<?php echo htmlentities($row['pcategory_id']); ?>&action=del"> <i class="fa fa-trash-o"></i></a>
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
                                <h4><i class="fa fa-trash-o"></i> Deleted Product Categories</h4>
                            </div>
                            <div class="table-responsive">
                                <table class="table m-0 table-bordered table-bordered-danger" id="example1">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Category</th>
                                            <th>Description</th>
                                            <th>Posting Date</th>
                                            <th>Last Update</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $query = mysqli_query($con, "SELECT pcategory_id, name, description, created_at, updated_at FROM PRODUCT_CATEGORIES WHERE is_active = 0");
                                        $cnt = 1;
                                        while ($row = mysqli_fetch_array($query)) {
                                            ?>
                                            <tr>
                                                <th scope="row"><?php echo htmlentities($cnt); ?></th>
                                                <td><?php echo htmlentities($row['name']); ?></td>
                                                <td><?php echo htmlentities($row['description']); ?></td>
                                                <td><?php echo htmlentities($row['created_at']); ?></td>
                                                <td><?php echo htmlentities($row['updated_at']); ?></td>
                                                <td><a class="btn btn-primary btn-sm" href="manage-product-categories.php?resid=<?php echo htmlentities($row['pcategory_id']); ?>"><i class="ion-arrow-return-right" title="Restore Category"></i></a>
                                                    &nbsp;<a class="btn btn-danger btn-sm" href="manage-product-categories.php?rid=<?php echo htmlentities($row['pcategory_id']); ?>&action=permdel" onclick="return confirm('Do you want to permanently delete this category?')"><i class="fa fa-trash-o" title="Permanently Delete Category"></i></a>
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