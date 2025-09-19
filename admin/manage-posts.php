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
        $postid = intval($_GET['rid']);
        $query = mysqli_query($con, "UPDATE ARTICLES SET is_active = 0 WHERE article_id = '$postid';");
        $msg = "Article deleted successfully.";
    }
    // Code for restore
    if ($_GET['resid']) {
        $postid = intval($_GET['resid']);
        $query = mysqli_query($con, "UPDATE ARTICLES SET is_active = 1 WHERE article_id = '$postid'");
        $msg = "Article restored successfully.";
    }

    // Code for permanent delete
    if ($_GET['action'] == 'permdel' && $_GET['rid']) {
        $postid = intval($_GET['rid']);
        $query = mysqli_query($con, "DELETE FROM ARTICLES WHERE article_id = '$postid'");
        $delmsg = "Article deleted permanently.";
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
                            <h4 class="page-title">Manage Articles</h4>
                            <ol class="breadcrumb p-0 m-0">
                                <li>
                                    <a href="#">Admin</a>
                                </li>
                                <li>
                                    <a href="#">Articles</a>
                                </li>
                                <li class="active">
                                    Manage Articles
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
                        <!---Permanent Delete Message--->
                        <?php if ($delmsg) { ?>
                            <div class="alert alert-danger" role="alert">
                                <strong><?php echo htmlentities($delmsg); ?></strong>
                            </div>
                        <?php } ?>
                    </div>
                </div>
                <!-- end row -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="card-box m-t-20">
                            <div class="table-responsive">
                                <table class="table m-0 table-bordered" id="example">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Title</th>
                                            <th>Category</th>
                                            <th>Author</th>
                                            <th>Created Date</th>
                                            <th>Last Update</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $query = mysqli_query($con, "SELECT ARTICLES.article_id AS postid, ARTICLES.title AS title, ARTICLES.author, ARTICLES.created_at, ARTICLES.updated_at, ARTICLE_CATEGORIES.name AS category
                                                                                    FROM ARTICLES
                                                                                    LEFT JOIN ARTICLE_CATEGORIES ON ARTICLE_CATEGORIES.category_id = ARTICLES.category_id
                                                                                    WHERE ARTICLES.is_active = 1;");
                                        $cnt = 1;
                                        while ($row = mysqli_fetch_array($query)) {
                                            ?>
                                            <tr>
                                                <th scope="row"><?php echo htmlentities($cnt); ?></th>
                                                <td><?php echo htmlentities($row['title']); ?></td>
                                                <td><?php echo htmlentities($row['category']) ?></td>
                                                <td><?php echo htmlentities($row['author']); ?></td>
                                                <td><?php echo htmlentities($row['created_at']); ?></td>
                                                <td><?php echo htmlentities($row['updated_at']); ?></td>
                                                <td><a class="btn btn-primary btn-sm"
                                                        href="edit-post.php?pid=<?php echo htmlentities($row['postid']); ?>"><i
                                                            class="fa fa-pencil"></i></a>
                                                    &nbsp;<a class="btn btn-danger btn-sm"
                                                        href="manage-posts.php?rid=<?php echo htmlentities($row['postid']); ?>&&action=del">
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
                                <h4><i class="fa fa-trash-o"></i>Deleted Articles</h4>
                            </div>
                            <div class="table-responsive">
                                <table class="table m-0 table-bordered table-bordered-danger" id="example1">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Title</th>
                                            <th>Category</th>
                                            <th>Author</th>
                                            <th>Created Date</th>
                                            <th>Last Update</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $query = mysqli_query($con, "SELECT ARTICLES.article_id AS postid, ARTICLES.title AS title, ARTICLES.author, ARTICLES.created_at, ARTICLES.updated_at, ARTICLE_CATEGORIES.name AS category
                                                                                        FROM ARTICLES
                                                                                        LEFT JOIN ARTICLE_CATEGORIES ON ARTICLE_CATEGORIES.category_id = ARTICLES.category_id
                                                                                        WHERE ARTICLES.is_active = 0");
                                        $cnt = 1;
                                        while ($row = mysqli_fetch_array($query)) {
                                            ?>
                                            <tr>
                                                <th scope="row"><?php echo htmlentities($cnt); ?></th>
                                                <td><?php echo htmlentities($row['title']); ?></td>
                                                <td><?php echo htmlentities($row['category']) ?></td>
                                                <td><?php echo htmlentities($row['author']); ?></td>
                                                <td><?php echo htmlentities($row['created_at']); ?></td>
                                                <td><?php echo htmlentities($row['updated_at']); ?></td>
                                                <td><a class="btn btn-primary btn-sm" href="manage-posts.php?resid=<?php echo htmlentities($row['postid']); ?>">
                                                        <i class="ion-arrow-return-right" 
                                                        title="Restore Article"></i></a>
                                                    &nbsp;
                                                    <a class="btn btn-danger btn-sm" href="manage-posts.php?rid=<?php echo htmlentities($row['postid']); ?>&&action=permdel"
                                                        onclick="return confirm('Do you want to permanently delete this article?')"><i
                                                            class="fa fa-trash-o"
                                                            title="Permanently Delete Article"></i></a>
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