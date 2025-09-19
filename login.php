<?php
session_name('client_session');
session_start();
include('includes/config.php');

if (isset($_POST['login'])) {
    $uname = $_POST['username'];
    $password = $_POST['password'];

    $sql = mysqli_query($con, "SELECT user_id, username, password_hash, email, role, status FROM USERS WHERE (username = '$uname' OR email = '$uname') AND password_hash = '$password' AND role = 'client' AND status = 'active' ");
    $user = mysqli_fetch_array($sql);

    if ($user) {
        $_SESSION['login'] = $_POST['username'];
        $_SESSION['user_id'] = $user['user_id'];
        echo "<script type='text/javascript'> document.location = 'index.php'; </script>";
    } else {
        echo "<script>alert('Invalid username or password');</script>";
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
    <title>Belleville Dental | Login</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css2?family=Merriweather:wght@400;600;700&family=Merriweather:wght@400;700&display=swap"
        rel="stylesheet">

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

        .login2-container {
            max-width: 500px;
            margin: 0 auto;
            padding: 30px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            margin-top: 50px;
        }

        .login-logo {
            text-align: center;
            margin-bottom: 30px;
        }

        .login-logo img {
            max-height: 80px;
        }

        .form-control {
            padding: 12px 15px;
            border-radius: 6px;
            border: 1px solid #ddd;
            margin-bottom: 15px;
        }

        .btn-login {
            background-color: var(--primary);
            color: white;
            border-radius: 6px;
            padding: 12px;
            font-weight: 600;
            transition: all 0.3s ease;
            border: none;
            width: 100%;
        }

        .btn-login:hover {
            background-color: var(--primary-dark);
            transform: translateY(-2px);
        }

        .login-links {
            text-align: center;
            margin-top: 20px;
        }

        .login-links a {
            color: var(--primary);
            text-decoration: none;
        }

        .login-links a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <?php include('includes/header.php'); ?>

    <div class="container">
        <div class="login2-container">
            <div class="login-logo">
                <img src="images/Belleville Dental logo transparent.png" alt="Belleville Dental">
            </div>

            <form method="post">
                <div class="form-group">
                    <input type="text" class="form-control" name="username" placeholder="Username or Email" required>
                </div>

                <div class="form-group">
                    <input type="password" class="form-control" name="password" placeholder="Password" required>
                </div>



                <button type="submit" name="login" class="btn btn-login">Login</button>

                <div class="login-links">
                    <a href="forgot-password.php">Forgot Password?</a>
                    <p>Don't have an account? <a href="register.php">Register here</a></p>
                </div>
            </form>
        </div>
    </div>

    <?php include('includes/footer.php'); ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>