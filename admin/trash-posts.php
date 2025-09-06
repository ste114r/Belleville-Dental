<?php
session_start();
include('includes/config.php');
error_reporting(0);

if (strlen($_SESSION['login']) == 0) {
    header('location:index.php');
} else {

    if ($_GET['action'] = 'restore') {
        $postid = intval($_GET['pid']);
        $query = mysqli_query($con, "UPDATE ARTICLES SET is_active = 1 WHERE article_id = '$postid'");
        if ($query) {
            $msg = "Post restored successfully.";
        } else {
            $error = "Something went wrong. Please try again.";
        }
    }

    if ($_GET['presid']) {
        $id = intval($_GET['presid']);
        $query = mysqli_query($con, "DELETE FROM ARTICLES WHERE article_id = '$id'");
        $delmsg = "Post deleted permanently.";
    }

    ?>

    <?php include('includes/topheader.php'); ?>
    <!-- ========== Left Sidebar Start ========== -->
    <?php include('includes/leftsidebar.php'); ?>

    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="page-title-box">
                            <h4 class="page-title">Trashed Articles</h4>
                            <ol class="breadcrumb p-0 m-0">
                                <li>
                                    <a href="#">Admin</a>
                                </li>
                                <li>
                                    <a href="#">Articles</a>
                                </li>
                                <li class="active">
                                    Trashed Articles
                                </li>
                            </ol>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
                <!-- end row -->
                <div class="row">
                    <div class="col-sm-6">
                        <?php if ($delmsg) { ?>
                            <div class="alert alert-danger" role="alert">
                                <strong>Oh snap!</strong> <?php echo htmlentities($delmsg); ?>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card-box">
                                <div class="table-responsive">
                                    <table class="table table-bordered  m-0" id="example">
                                        <thead>
                                            <tr>
                                                <th>Title</th>
                                                <th>Category</th>
                                                <!-- <th>Subcategory</th> -->
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $query = mysqli_query($con, "SELECT ARTICLES.article_id AS postid, 
                                                                                        ARTICLES.title AS title, 
                                                                                        ARTICLE_CATEGORIES.name AS category
                                                                                        FROM ARTICLES
                                                                                        LEFT JOIN ARTICLE_CATEGORIES ON ARTICLE_CATEGORIES.category_id = ARTICLES.category_id
                                                                                        WHERE ARTICLES.is_active = 0");
                                            $rowcount = mysqli_num_rows($query);
                                            if ($rowcount == 0) {
                                                ?>
                                                <tr>
                                                    <td colspan="4" align="center">
                                                        <h3 style="color:red">No record found</h3>
                                                    </td>
                                                <tr>
                                                    <?php
                                            } else {
                                                while ($row = mysqli_fetch_array($query)) {
                                                    ?>
                                                    <tr>

                                                        <td><b><?php echo htmlentities($row['title']); ?></b></td>
                                                        <td><?php echo htmlentities($row['category']) ?></td>
                                                        <!-- <td><?php echo htmlentities($row['subcategory']) ?></td> -->
                                                        <td>
                                                            <a href="trash-posts.php?pid=<?php echo htmlentities($row['postid']); ?>&&action=restore"
                                                                onclick="return confirm('Do you want to restore this article?')"> <i
                                                                    class="ion-arrow-return-right"
                                                                    title="Restore Article"></i></a>
                                                            &nbsp;
                                                            <a href="trash-posts.php?presid=<?php echo htmlentities($row['postid']); ?>&&action=perdel"
                                                                onclick="return confirm('Do you want to delete this article permanently?')"><i
                                                                    class="fa fa-trash-o" style="color: #f05050"
                                                                    title="Permanently Delete Article"></i></a>
                                                        </td>
                                                    </tr>
                                                <?php }
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