<?php
// Set the correct session name for clients
session_name('client_session');
session_start();
include('includes/config.php');

$msg = "";
$error = "";

// 1. Authentication Check: Ensure the user is logged in. If not, redirect to the login page.
if (!isset($_SESSION['login']) || empty($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// 2. Handle Form Submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $current_password = $_POST['currentpassword'];
    $new_password = $_POST['newpassword'];
    $confirm_password = $_POST['confirmpassword'];
    $user_id = $_SESSION['user_id'];

    // 3. Server-Side Validation
    if ($new_password !== $confirm_password) {
        $error = "New Password and Confirm Password do not match!";
    } else {
        // 4. Verify Current Password using a standard SQL query
        $query = mysqli_query($con, "SELECT password_hash FROM USERS WHERE user_id='$user_id'");
        $user = mysqli_fetch_assoc($query);

        // Note: Comparing plain text passwords is not secure. This matches the existing system's logic.
        // For a production environment, you should use password_hash() and password_verify().
        if ($user && password_verify($current_password, $user['password_hash'])) {

            // 5. Update Password in the Database using a standard SQL query
            $hashed_new_password = password_hash($new_password, PASSWORD_DEFAULT);
            $update_query = mysqli_query($con, "UPDATE USERS SET password_hash = '$hashed_new_password' WHERE user_id = '$user_id'");
            
            if ($update_query) {
                $msg = "Password changed successfully!";
            } else {
                $error = "Something went wrong. Please try again.";
            }

        } else {
            $error = "Your current password is incorrect. Please try again.";
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Change your account password.">
    <meta name="author" content="">
    <link rel="shortcut icon" href="images/Belleville Dental logo transparent.png" type="image/x-icon">
    <title>Belleville Dental | Change Password</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=Merriweather:wght@400;600;700&family=Merriweather:wght@400;700&display=swap"
        rel="stylesheet">

    <style>
        :root {
            --primary: #0B7EC8;
            --primary-dark: #064A8A;
            --secondary: #f8f9fa;
            --dark: #343a40;
            --light: #f8f9fa;
        }

        body {
            font-family: 'Merriweather', sans-serif;
            background-color: #fff;
            padding-top: 80px;
        }

        .password-container {
            max-width: 500px;
            margin: 0 auto;
            padding: 30px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            margin-top: 50px;
        }

        .password-logo {
            text-align: center;
            margin-bottom: 20px;
        }

        .password-logo img {
            max-height: 80px;
        }

        .form-control {
            padding: 12px 15px;
            border-radius: 6px;
            border: 1px solid #ddd;
            margin-bottom: 15px;
        }

        .btn-submit {
            background-color: var(--primary);
            color: white;
            border-radius: 6px;
            padding: 12px;
            font-weight: 600;
            transition: all 0.3s ease;
            border: none;
            width: 100%;
        }

        .btn-submit:hover {
            background-color: var(--primary-dark);
            transform: translateY(-2px);
        }

        .form-links {
            text-align: center;
            margin-top: 20px;
        }

        .form-links a {
            color: var(--primary);
            text-decoration: none;
        }

        .form-links a:hover {
            text-decoration: underline;
        }
    </style>

    <script type="text/javascript">
        // Client-side validation to check if new passwords match
        function checkpass() {
            if (document.changepassword.newpassword.value !== document.changepassword.confirmpassword.value) {
                alert('New Password and Confirm Password fields do not match');
                document.changepassword.confirmpassword.focus();
                return false;
            }
            return true;
        }
    </script>
</head>

<body>
    <?php include('includes/header.php'); ?>

    <div class="container">
        <div class="password-container">
            <div class="password-logo">
                <img src="images/Belleville Dental logo transparent.png" alt="Belleville Dental">
                <h4 class="mt-3">Change Your Password</h4>
            </div>

            <?php if ($msg): ?>
                <div class="alert alert-success" role="alert">
                    <?php echo htmlentities($msg); ?>
                </div>
            <?php endif; ?>
            <?php if ($error): ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo htmlentities($error); ?>
                </div>
            <?php endif; ?>

            <form method="post" name="changepassword" onsubmit="return checkpass();">
                <div class="form-group">
                    <label for="currentpassword">Current Password</label>
                    <input type="password" class="form-control" id="currentpassword" name="currentpassword"
                        placeholder="Enter your current password" required>
                </div>

                <div class="form-group">
                    <label for="newpassword">New Password</label>
                    <input type="password" class="form-control" id="newpassword" name="newpassword"
                        placeholder="Enter your new password" required>
                </div>

                <div class="form-group">
                    <label for="confirmpassword">Confirm New Password</label>
                    <input type="password" class="form-control" id="confirmpassword" name="confirmpassword"
                        placeholder="Confirm your new password" required>
                </div>

                <button type="submit" name="submit" class="btn btn-submit">Change Password</button>

                <div class="form-links">
                    <a href="profile.php"><i class="fas fa-arrow-left"></i> Back to Profile</a>
                </div>
            </form>
        </div>
    </div>

    <?php include('includes/footer.php'); ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>