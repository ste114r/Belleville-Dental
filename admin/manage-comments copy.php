<?php
session_start();
include('includes/config.php');
error_reporting(0);

// Check if admin is logged in
if (strlen($_SESSION['login']) == 0) {
    header('location:index.php');
} else {

    $msg = '';
    $delmsg = '';

    // Action handler
    if (isset($_GET['action']) && isset($_GET['cid'])) {
        $comment_id = intval($_GET['cid']);
        $action = $_GET['action'];

        // Approve a comment
        if ($action == 'approve') {
            $query = mysqli_query($con, "UPDATE PRODUCT_COMMENTS SET status = 'approved' WHERE comment_id = '$comment_id'");
            if ($query) {
                $msg = "Comment has been approved successfully.";
            } else {
                $delmsg = "Error: Could not approve comment.";
            }
        }
        // Unapprove a comment
        elseif ($action == 'unapprove') {
            $query = mysqli_query($con, "UPDATE PRODUCT_COMMENTS SET status = 'pending' WHERE comment_id = '$comment_id'");
            if ($query) {
                $msg = "Comment has been unapproved and moved to pending.";
            } else {
                $delmsg = "Error: Could not unapprove comment.";
            }
        }
        // Delete a comment
        elseif ($action == 'del') {
            $query = mysqli_query($con, "DELETE FROM PRODUCT_COMMENTS WHERE comment_id = '$comment_id'");
            if ($query) {
                $delmsg = "Comment has been deleted permanently.";
            } else {
                $delmsg = "Error: Could not delete comment.";
            }
        }
        // Redirect to the same page to show the message and prevent resubmission
        header("Location: manage-product-comments.php");
        exit();
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
                            <h4 class="page-title">Manage Product Comments</h4>
                            <ol class="breadcrumb p-0 m-0">
                                <li><a href="#">Admin</a></li>
                                <li><a href="#">Comments</a></li>
                                <li class="active">Manage Comments</li>
                            </ol>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12">
                        <?php if (isset($_SESSION['msg'])) { ?>
                            <div class="alert alert-success" role="alert">
                                <strong><?php echo htmlentities($_SESSION['msg']); ?></strong>
                            </div>
                            <?php unset($_SESSION['msg']);
                        } ?>

                        <?php if (isset($_SESSION['delmsg'])) { ?>
                            <div class="alert alert-danger" role="alert">
                                <strong><?php echo htmlentities($_SESSION['delmsg']); ?></strong>
                            </div>
                            <?php unset($_SESSION['delmsg']);
                        } ?>
                    </div>
                </div>

                <!-- Pending Comments Table -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="card-box m-t-20">
                            <div class="m-b-30">
                                <h4><i class="ion-chatbox-working"></i> Pending Comments for Approval</h4>
                            </div>
                            <div class="table-responsive">
                                <table class="table m-0 table-bordered" id="example">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>User</th>
                                            <th>Email</th>
                                            <th>Comment</th>
                                            <th>Product</th>
                                            <th>Date</th>
                                            <th style="width: 150px;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $query_pending = mysqli_query($con, "SELECT pc.comment_id, u.username, u.email, pc.comment, p.name as product_name, pc.created_at FROM PRODUCT_COMMENTS pc JOIN USERS u ON pc.user_id = u.user_id JOIN PRODUCTS p ON pc.product_id = p.product_id WHERE pc.status = 'pending' ORDER BY pc.created_at DESC");
                                        $cnt = 1;
                                        if (mysqli_num_rows($query_pending) == 0) {
                                            echo '<tr><td colspan="7" class="text-center">No pending comments found.</td></tr>';
                                        } else {
                                            while ($row = mysqli_fetch_array($query_pending)) {
                                                ?>
                                                <tr>
                                                    <th scope="row"><?php echo htmlentities($cnt); ?></th>
                                                    <td><?php echo htmlentities($row['username']); ?></td>
                                                    <td><?php echo htmlentities($row['email']); ?></td>
                                                    <td><?php echo substr(htmlentities($row['comment']), 0, 40); ?>...</td>
                                                    <td><?php echo htmlentities($row['product_name']); ?></td>
                                                    <td><?php echo date('M d, Y', strtotime($row['created_at'])); ?></td>
                                                    <td>
                                                        <button type="button" class="btn btn-info btn-sm" data-toggle="modal"
                                                            data-target="#commentModal"
                                                            data-comment="<?php echo htmlentities($row['comment']); ?>"
                                                            title="View Full Comment"><i class="fa fa-eye"></i></button>
                                                        &nbsp;
                                                        <a class="btn btn-success btn-sm"
                                                            href="manage-product-comments.php?cid=<?php echo htmlentities($row['comment_id']); ?>&action=approve"
                                                            title="Approve Comment"><i class="fa fa-check"></i></a>
                                                        &nbsp;
                                                        <a class="btn btn-danger btn-sm"
                                                            href="manage-product-comments.php?cid=<?php echo htmlentities($row['comment_id']); ?>&action=del"
                                                            onclick="return confirm('Do you really want to delete this comment?')"
                                                            title="Delete Permanently"><i class="fa fa-trash-o"></i></a>
                                                    </td>
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

                <!-- Approved Comments Table -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="card-box m-t-20">
                            <div class="m-b-30">
                                <h4><i class="ion-checkmark-circled"></i> Approved Comments</h4>
                            </div>
                            <div class="table-responsive">
                                <table class="table m-0 table-bordered" id="example1">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>User</th>
                                            <th>Email</th>
                                            <th>Comment</th>
                                            <th>Product</th>
                                            <th>Date</th>
                                            <th style="width: 150px;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $query_approved = mysqli_query($con, "SELECT pc.comment_id, u.username, u.email, pc.comment, p.name as product_name, pc.created_at FROM PRODUCT_COMMENTS pc JOIN USERS u ON pc.user_id = u.user_id JOIN PRODUCTS p ON pc.product_id = p.product_id WHERE pc.status = 'approved' ORDER BY pc.created_at DESC");
                                        $cnt = 1;
                                        if (mysqli_num_rows($query_approved) == 0) {
                                            echo '<tr><td colspan="7" class="text-center">No approved comments found.</td></tr>';
                                        } else {
                                            while ($row = mysqli_fetch_array($query_approved)) {
                                                ?>
                                                <tr>
                                                    <th scope="row"><?php echo htmlentities($cnt); ?></th>
                                                    <td><?php echo htmlentities($row['username']); ?></td>
                                                    <td><?php echo htmlentities($row['email']); ?></td>
                                                    <td><?php echo substr(htmlentities($row['comment']), 0, 40); ?>...</td>
                                                    <td><?php echo htmlentities($row['product_name']); ?></td>
                                                    <td><?php echo date('M d, Y', strtotime($row['created_at'])); ?></td>
                                                    <td>
                                                        <button type="button" class="btn btn-info btn-sm" data-toggle="modal"
                                                            data-target="#commentModal"
                                                            data-comment="<?php echo htmlentities($row['comment']); ?>"
                                                            title="View Full Comment"><i class="fa fa-eye"></i></button>
                                                        &nbsp;
                                                        <a class="btn btn-warning btn-sm"
                                                            href="manage-product-comments.php?cid=<?php echo htmlentities($row['comment_id']); ?>&action=unapprove"
                                                            title="Unapprove Comment"><i class="fa fa-times"></i></a>
                                                        &nbsp;
                                                        <a class="btn btn-danger btn-sm"
                                                            href="manage-product-comments.php?cid=<?php echo htmlentities($row['comment_id']); ?>&action=del"
                                                            onclick="return confirm('Do you really want to delete this comment?')"
                                                            title="Delete Permanently"><i class="fa fa-trash-o"></i></a>
                                                    </td>
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

            </div>
        </div>

        <!-- Comment Modal -->
        <div class="modal fade" id="commentModal" tabindex="-1" role="dialog" aria-labelledby="commentModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="commentModalLabel">Full Comment</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" style="white-space: pre-wrap;">
                        <!-- Comment content will be injected here by jQuery -->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <?php include('includes/footer.php'); ?>

        <script>
            // Script to populate the modal with the full comment text
            $('#commentModal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget);
                var comment = button.data('comment');
                var modal = $(this);
                modal.find('.modal-body').text(comment);
            });
        </script>
    </div>
<?php } ?>