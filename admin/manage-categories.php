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
        $query = mysqli_query($con, "UPDATE ARTICLE_CATEGORIES SET is_active = '0' WHERE category_id = '$id'");
        $msg = "Category " . mysqli_fetch_assoc(mysqli_query($con, "SELECT name FROM ARTICLE_CATEGORIES WHERE category_id = '$id'"))['name'] . " deleted successfully.";
    }
    // Code for restore
    if ($_GET['resid']) {
        $id = intval($_GET['resid']);
        $query = mysqli_query($con, "UPDATE ARTICLE_CATEGORIES SET is_active = '1' WHERE category_id = '$id'");
        $msg = "Category " . mysqli_fetch_assoc(mysqli_query($con, "SELECT name FROM ARTICLE_CATEGORIES WHERE category_id = '$id'"))['name'] . " restored successfully.";
    }

    // Code for permanent delete
    if ($_GET['action'] == 'permdel' && $_GET['rid']) {
        $id = intval($_GET['rid']);
        $query = mysqli_query($con, "DELETE FROM ARTICLE_CATEGORIES WHERE category_id = '$id'");
        $delmsg = "Category " . mysqli_fetch_assoc(mysqli_query($con, "SELECT name FROM ARTICLE_CATEGORIES WHERE category_id = '$id'"))['name'] . " deleted permanently.";
    }

    ?>
    <!-- Top Bar Start -->
    <?php include('includes/topheader.php'); ?>
    <!-- ========== Left Sidebar Start ========== -->
    <?php include('includes/leftsidebar.php'); ?>
    <!-- Left Sidebar End -->
    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="page-title-box">
                            <h4 class="page-title">Manage Categories</h4>
                            <ol class="breadcrumb p-0 m-0">
                                <li>
                                    <a href="#">Admin</a>
                                </li>
                                <li>
                                    <a href="#">Category</a>
                                </li>
                                <li class="active">
                                    Manage Categories
                                </li>
                            </ol>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <!---Success Message--->
                        <?php if ($msg) { ?>
                            <div class="alert alert-success" role="alert">
                                <strong><?php echo htmlentities($msg); ?></strong>
                            </div>
                        <?php } ?>
                        <!---Error Message--->
                        <?php if ($error) { ?>
                            <div class="alert alert-danger" role="alert">
                                <strong><?php echo htmlentities($error); ?></strong>
                            </div>
                        <?php } ?>
                    </div>
                </div>
                <!-- end row -->
                <div class="row">
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
                                            $query = mysqli_query($con, "SELECT category_id, name, description, created_at, updated_at FROM ARTICLE_CATEGORIES WHERE is_active = 1");
                                            $cnt = 1;
                                            while ($row = mysqli_fetch_array($query)) {
                                                ?>
                                                <tr>
                                                    <th scope="row"><?php echo htmlentities($cnt); ?></th>
                                                    <td><?php echo htmlentities($row['name']); ?></td>
                                                    <td><?php echo htmlentities($row['description']); ?></td>
                                                    <td><?php echo htmlentities($row['created_at']); ?></td>
                                                    <td><?php echo htmlentities($row['updated_at']); ?></td>
                                                    <td><a class="btn btn-primary btn-sm"
                                                            href="edit-category.php?cid=<?php echo htmlentities($row['category_id']); ?>"><i
                                                                class="fa fa-pencil"></i></a>
                                                        &nbsp;<a class="btn btn-danger btn-sm"
                                                            href="manage-categories.php?rid=<?php echo htmlentities($row['category_id']); ?>&&action=del">
                                                            <i class="fa fa-trash-o"></i></a>
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
                    <!--- end row -->

                    <div class="row">
                        <div class="col-md-12">
                            <div class="card-box m-t-20">
                                <div class="m-b-30">
                                    <h4><i class="fa fa-trash-o"></i>Deleted Categories</h4>
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
                                            $query = mysqli_query($con, "SELECT category_id, name, description, created_at, updated_at FROM ARTICLE_CATEGORIES WHERE is_active = 0");
                                            $cnt = 1;
                                            while ($row = mysqli_fetch_array($query)) {
                                                ?>
                                                <tr>
                                                    <th scope="row"><?php echo htmlentities($cnt); ?></th>
                                                    <td><?php echo htmlentities($row['name']); ?></td>
                                                    <td><?php echo htmlentities($row['description']); ?></td>
                                                    <td><?php echo htmlentities($row['created_at']); ?></td>
                                                    <td><?php echo htmlentities($row['updated_at']); ?></td>
                                                    <td><a class="btn btn-primary btn-sm" href="manage-categories.php?resid=<?php echo htmlentities($row['category_id']); ?>">
                                                            <i class="ion-arrow-return-right" 
                                                            title="Restore Category"></i></a>
                                                        &nbsp;
                                                        <a class="btn btn-danger btn-sm" href="manage-categories.php?rid=<?php echo htmlentities($row['category_id']); ?>&&action=permdel"
                                                            onclick="return confirm('Do you want to permanently delete this category?')"><i
                                                                class="fa fa-trash-o"
                                                                title="Permanently Delete Category"></i></a>
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
                </div>
                <!-- container -->
            </div>
            <!-- content -->
            <?php include('includes/footer.php'); ?>
        <?php }
?>