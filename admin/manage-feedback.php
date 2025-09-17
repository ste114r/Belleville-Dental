<?php
session_start();
include('includes/config.php');
error_reporting(0);

if (strlen($_SESSION['login']) == 0) {
    header('location:index.php');
} else {

    // Code for marking as replied
    if ($_GET['action'] == 'reply' && $_GET['fid']) {
        $feedbackid = intval($_GET['fid']);
        $query = mysqli_query($con, "UPDATE FEEDBACK SET status = 'replied' WHERE feedback_id = '$feedbackid'");
        $msg = "Feedback marked as replied.";
    }

    // Code for undoing reply
    if ($_GET['action'] == 'undo' && $_GET['fid']) {
        $feedbackid = intval($_GET['fid']);
        $query = mysqli_query($con, "UPDATE FEEDBACK SET status = 'pending' WHERE feedback_id = '$feedbackid'");
        $msg = "Feedback status changed back to pending.";
    }

    // Code for permanent delete
    if ($_GET['action'] == 'del' && $_GET['fid']) {
        $feedbackid = intval($_GET['fid']);
        $query = mysqli_query($con, "DELETE FROM FEEDBACK WHERE feedback_id = '$feedbackid'");
        $delmsg = "Feedback deleted permanently.";
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
                            <h4 class="page-title">Manage Feedback</h4>
                            <ol class="breadcrumb p-0 m-0">
                                <li><a href="#">Admin</a></li>
                                <li><a href="#">Feedback</a></li>
                                <li class="active">Manage Feedback</li>
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
                            <div class="m-b-30">
                                <h4><i class="ion-chatbox-working"></i> Pending Feedback</h4>
                            </div>
                            <div class="table-responsive">
                                <table class="table m-0 table-bordered" id="example">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Subject</th>
                                            <th>Message</th>
                                            <th>Date Sent</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $query = mysqli_query($con, "SELECT feedback_id, name, email, subject, message, created_at FROM FEEDBACK WHERE status = 'pending'");
                                        $cnt = 1;
                                        while ($row = mysqli_fetch_array($query)) {
                                        ?>
                                            <tr>
                                                <th scope="row"><?php echo htmlentities($cnt); ?></th>
                                                <td><?php echo htmlentities($row['name']); ?></td>
                                                <td><?php echo htmlentities($row['email']); ?></td>
                                                <td><?php echo htmlentities($row['subject']); ?></td>
                                                <td><?php echo substr(htmlentities($row['message']), 0, 50); ?>...</td>
                                                <td><?php echo htmlentities($row['created_at']); ?></td>
                                                <td>
                                                    <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#messageModal" data-message="<?php echo htmlentities($row['message']); ?>" title="View Full Message">
                                                        <i class="fa fa-eye"></i>
                                                    </button>
                                                    &nbsp;
                                                    <a class="btn btn-success btn-sm" href="manage-feedback.php?fid=<?php echo htmlentities($row['feedback_id']); ?>&&action=reply" title="Mark as Replied"><i class="fa fa-check"></i> Replied</a>
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
                                <h4><i class="ion-checkmark-circled"></i> Replied Feedback</h4>
                            </div>
                            <div class="table-responsive">
                                <table class="table m-0 table-bordered" id="example1">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Subject</th>
                                            <th>Message</th>
                                            <th>Date Sent</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $query = mysqli_query($con, "SELECT feedback_id, name, email, subject, message, created_at FROM FEEDBACK WHERE status = 'replied'");
                                        $cnt = 1;
                                        while ($row = mysqli_fetch_array($query)) {
                                        ?>
                                            <tr>
                                                <th scope="row"><?php echo htmlentities($cnt); ?></th>
                                                <td><?php echo htmlentities($row['name']); ?></td>
                                                <td><?php echo htmlentities($row['email']); ?></td>
                                                <td><?php echo htmlentities($row['subject']); ?></td>
                                                <td><?php echo substr(htmlentities($row['message']), 0, 50); ?>...</td>
                                                <td><?php echo htmlentities($row['created_at']); ?></td>
                                                <td>
                                                    <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#messageModal" data-message="<?php echo htmlentities($row['message']); ?>" title="View Full Message">
                                                        <i class="fa fa-eye"></i>
                                                    </button>
                                                    &nbsp;
                                                    <a class="btn btn-primary btn-sm" href="manage-feedback.php?fid=<?php echo htmlentities($row['feedback_id']); ?>&&action=undo" title="Mark as Pending"><i class="fa fa-undo"></i> Undo</a>
                                                    &nbsp;
                                                    <a class="btn btn-danger btn-sm" href="manage-feedback.php?fid=<?php echo htmlentities($row['feedback_id']); ?>&&action=del" onclick="return confirm('Do you really want to delete this feedback?')" title="Delete Permanently"><i class="fa fa-trash-o"></i></a>
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
        </div>

        <div class="modal fade" id="messageModal" tabindex="-1" role="dialog" aria-labelledby="messageModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="messageModalLabel">Full Feedback Message</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" style="white-space: pre-wrap;">
                        </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <?php include('includes/footer.php'); ?>

        <script>
            $('#messageModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget); // Button that triggered the modal
                var message = button.data('message'); // Extract info from data-* attributes
                var modal = $(this);
                modal.find('.modal-body').text(message);
            });
        </script>

    </div>
<?php } ?>