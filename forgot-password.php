<?php
session_name('client_session');
session_start();
include('includes/config.php');

if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['newpassword'];
    $confirm_password = $_POST['confirmpassword'];
    
    // Check if passwords match
    if ($password !== $confirm_password) {
        echo "<script>alert('New Password and Confirm Password field does not match');</script>";
    } else {
        // Check if user exists
        $query = mysqli_query($con, "SELECT user_id FROM USERS WHERE email='$email' AND username='$username'");
        $ret = mysqli_num_rows($query);
        
        if ($ret) {
            // Update password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $query1 = mysqli_query($con, "UPDATE USERS SET password_hash='$hashed_password' WHERE email='$email' AND username='$username'");

            if ($query1) {
                echo "<script>alert('Password successfully changed');</script>";
                header('Location: login.php'); // Server side
                exit();
            } else {
                echo "<script>alert('Something went wrong. Please try again.');</script>";
            }
        } else {
            echo "<script>alert('Invalid Details. Please try again.');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="images/Belleville Dental logo transparent.png" type="image/x-icon">
    <title>Belleville Dental | Forgot Password</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:wght@400;600;700&family=Merriweather:wght@400;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary: #0B7EC8;
            --primary-dark: #064A8A;
            --secondary: #f8f9fa;
            --accent: #ff6b6b;
            --dark: #343a40;
            --light: #f8f9fa;
            --gray: #6c757d;
            --light-blue: #F0F8FF;
        }
        
        body {
            font-family: 'Merriweather', sans-serif;
            color: #444;
            line-height: 1.6;
            background-color: #fff;
            padding-top: 80px;
        }
        
        .password-container {
            max-width: 500px;
            margin: 0 auto;
            padding: 30px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            margin-top: 50px;
        }
        
        .password-logo {
            text-align: center;
            margin-bottom: 30px;
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
        
        .btn-reset {
            background-color: var(--primary);
            color: white;
            border-radius: 6px;
            padding: 12px;
            font-weight: 600;
            transition: all 0.3s ease;
            border: none;
            width: 100%;
        }
        
        .btn-reset:hover {
            background-color: var(--primary-dark);
            transform: translateY(-2px);
        }
        
        .password-links {
            text-align: center;
            margin-top: 20px;
        }
        
        .password-links a {
            color: var(--primary);
            text-decoration: none;
        }
        
        .password-links a:hover {
            text-decoration: underline;
        }
        
        .instructions {
            background-color: var(--light-blue);
            padding: 15px;
            border-radius: 6px;
            margin-bottom: 20px;
            font-size: 0.9rem;
        }
    </style>
    
    <script type="text/javascript">
        function checkpass() {
            if (document.changepassword.newpassword.value != document.changepassword.confirmpassword.value) {
                alert('New Password and Confirm Password field does not match');
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
            </div>
            
            <!-- <div class="instructions">
                <p><strong>Reset your password</strong></p>
                <p>Please enter your username, email address, and your new password.</p>
            </div> -->
            
            <form method="post" name="changepassword" onsubmit="return checkpass()">
                <div class="form-group">
                    <input type="text" class="form-control" name="username" placeholder="Username" required autocomplete="off">
                </div>
                
                <div class="form-group">
                    <input type="email" class="form-control" name="email" placeholder="Email Address" required autocomplete="off">
                </div>
                
                <div class="form-group">
                    <input type="password" class="form-control" name="newpassword" placeholder="New Password" required>
                </div>
                
                <div class="form-group">
                    <input type="password" class="form-control" name="confirmpassword" placeholder="Confirm Password" required>
                </div>
                
                <button type="submit" name="submit" class="btn btn-reset">Reset Password</button>
                
                <div class="password-links">
                    <a href="login.php"><i class="fas fa-arrow-left"></i> Back to Login</a>
                </div>
            </form>
        </div>
    </div>
    
    <?php include('includes/footer.php'); ?>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>