<?php
session_name('admin_session');
session_start();
include('includes/config.php');
error_reporting(0);

// Check if admin is logged in
if (strlen($_SESSION['login']) == 0) {
    header('location:index.php');
} else {

    // Action handler
    if (isset($_GET['action']) && isset($_GET['uid'])) {
        $userid = intval($_GET['uid']);
        $action = $_GET['action'];

        // Get the username of the target user to prevent self-action
        $user_query = mysqli_query($con, "SELECT username FROM USERS WHERE user_id = '$userid'");
        $target_user = mysqli_fetch_array($user_query);
        $target_username = $target_user['username'];

        // Prevent admin from acting on their own account
        if ($target_username == $_SESSION['login']) {
            $error = "Error: You cannot perform this action on your own account.";
        } else {
            // Deactivate a user (soft delete)
            if ($action == 'del') {
                $query = mysqli_query($con, "UPDATE USERS SET status = 'inactive' WHERE user_id = '$userid'");
                $msg = "User has been deactivated successfully.";
            }
            // Restore a user
            elseif ($action == 'restore') {
                $query = mysqli_query($con, "UPDATE USERS SET status = 'active' WHERE user_id = '$userid'");
                $msg = "User has been restored successfully.";
            }
            // Permanently delete a user
            elseif ($action == 'permdel') {
                $query = mysqli_query($con, "DELETE FROM USERS WHERE user_id = '$userid'");
                $delmsg = "User has been permanently deleted.";
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
                            <h4 class="page-title">Manage Users</h4>
                            <ol class="breadcrumb p-0 m-0">
                                <li><a href="#">Admin</a></li>
                                <li><a href="#">Users</a></li>
                                <li class="active">Manage Users</li>
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
                        <?php if ($error) { ?>
                            <div class="alert alert-danger" role="alert">
                                <strong><?php echo htmlentities($error); ?></strong>
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
                                <h4><i class="ion-person-stalker"></i> Active Users</h4>
                            </div>
                            <div class="table-responsive">
                                <table class="table m-0 table-bordered" id="example">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Username</th>
                                            <th>Email</th>
                                            <th>Role</th>
                                            <th>Registered On</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $query_active = mysqli_query($con, "SELECT user_id, username, email, role, created_at FROM USERS WHERE status = 'active'");
                                        $cnt = 1;
                                        while ($row = mysqli_fetch_array($query_active)) {
                                        ?>
                                            <tr>
                                                <th scope="row"><?php echo htmlentities($cnt); ?></th>
                                                <td><?php echo htmlentities($row['username']); ?></td>
                                                <td><?php echo htmlentities($row['email']); ?></td>
                                                <td><?php echo htmlentities($row['role']); ?></td>
                                                <td><?php echo date('M d, Y', strtotime($row['created_at'])); ?></td>
                                                <td>
                                                    <?php if ($row['username'] !== $_SESSION['login']) { // Hide button for the logged-in admin ?>
                                                        <a class="btn btn-danger btn-sm" href="manage-users.php?uid=<?php echo htmlentities($row['user_id']); ?>&action=del" onclick="return confirm('Do you really want to deactivate this user?')" title="Deactivate User">
                                                            <i class="fa fa-trash-o"></i> Deactivate
                                                        </a>
                                                    <?php } else { echo "N/A"; } ?>
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
                                <h4><i class="fa fa-trash-o"></i> Inactive Users</h4>
                            </div>
                            <div class="table-responsive">
                                <table class="table m-0 table-bordered table-bordered-danger" id="example1">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Username</th>
                                            <th>Email</th>
                                            <th>Role</th>
                                            <th>Registered On</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $query_inactive = mysqli_query($con, "SELECT user_id, username, email, role, created_at FROM USERS WHERE status = 'inactive'");
                                        $cnt = 1;
                                        while ($row = mysqli_fetch_array($query_inactive)) {
                                        ?>
                                            <tr>
                                                <th scope="row"><?php echo htmlentities($cnt); ?></th>
                                                <td><?php echo htmlentities($row['username']); ?></td>
                                                <td><?php echo htmlentities($row['email']); ?></td>
                                                <td><?php echo htmlentities($row['role']); ?></td>
                                                <td><?php echo date('M d, Y', strtotime($row['created_at'])); ?></td>
                                                <td>
                                                    <a class="btn btn-primary btn-sm" href="manage-users.php?uid=<?php echo htmlentities($row['user_id']); ?>&action=restore" title="Restore User">
                                                        <i class="ion-arrow-return-right"></i> Restore
                                                    </a>
                                                    &nbsp;
                                                    <a class="btn btn-danger btn-sm" href="manage-users.php?uid=<?php echo htmlentities($row['user_id']); ?>&action=permdel" onclick="return confirm('Do you want to permanently delete this user? This action cannot be undone.')" title="Delete Permanently">
                                                        <i class="fa fa-trash-o"></i> Delete
                                                    </a>
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
        <?php include('includes/footer.php'); ?>
    </div>
<?php } ?>