<?php
session_name('admin_session');
session_start();
include('includes/config.php');
error_reporting(0);

// Check if admin is logged in
if (strlen($_SESSION['login']) == 0) {
    header('location:index.php');
} else {

?>
    <!-- Top Bar Start -->
    <?php include('includes/topheader.php'); ?>
    <!-- ========== Left Sidebar Start ========== -->
    <?php include('includes/leftsidebar.php'); ?>
    <!-- Left Sidebar End -->

    <div class="content-page">
        <div class="content">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="page-title-box">
                            <h4 class="page-title">Manage Product Ratings</h4>
                            <ol class="breadcrumb p-0 m-0">
                                <li>
                                    <a href="#">Admin</a>
                                </li>
                                <li>
                                    <a href="#">Products</a>
                                </li>
                                <li class="active">
                                    Manage Ratings
                                </li>
                            </ol>
                            <div class="clearfix"></div>
                        </div>
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
                                            <th>Product Name</th>
                                            <th>User</th>
                                            <th>Rating</th>
                                            <th>Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        // Prepare the SQL query to fetch ratings along with product and user names
                                        $query = mysqli_prepare($con, "
                                            SELECT 
                                                p.name as product_name,
                                                u.username as user_name,
                                                pr.rating,
                                                pr.created_at
                                            FROM 
                                                PRODUCT_RATINGS pr
                                            JOIN 
                                                PRODUCTS p ON pr.product_id = p.product_id
                                            JOIN 
                                                USERS u ON pr.user_id = u.user_id
                                            ORDER BY 
                                                pr.created_at DESC
                                        ");
                                        mysqli_stmt_execute($query);
                                        $result = mysqli_stmt_get_result($query);
                                        $cnt = 1;
                                        if (mysqli_num_rows($result) == 0) {
                                        ?>
                                            <tr>
                                                <td colspan="5" align="center">No ratings found.</td>
                                            </tr>
                                        <?php
                                        } else {
                                            while ($row = mysqli_fetch_array($result)) {
                                        ?>
                                                <tr>
                                                    <th scope="row"><?php echo htmlentities($cnt); ?></th>
                                                    <td><?php echo htmlentities($row['product_name']); ?></td>
                                                    <td><?php echo htmlentities($row['user_name']); ?></td>
                                                    <td style="color: #ffc107;">
                                                        <?php 
                                                            // Display stars based on the rating number
                                                            for ($i = 0; $i < 5; $i++) {
                                                                if ($i < $row['rating']) {
                                                                    echo '<i class="fa fa-star"></i>';
                                                                } else {
                                                                    echo '<i class="fa fa-star-o"></i>';
                                                                }
                                                            }
                                                        ?>
                                                    </td>
                                                    <td><?php echo date('F j, Y', strtotime($row['created_at'])); ?></td>
                                                </tr>
                                        <?php
                                                $cnt++;
                                            }
                                        } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- container -->
        </div> <!-- content -->
        <?php include('includes/footer.php'); ?>
    </div>
<?php } ?>