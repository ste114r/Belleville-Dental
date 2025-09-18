<?php
// [file name]: register.php
// session_start();
include('includes/config.php');

if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    
    // Check if passwords match
    if ($password !== $confirm_password) {
        echo "<script>alert('Passwords do not match');</script>";
    } else {
        // Check if user already exists
        $check_query = mysqli_query($con, "SELECT user_id FROM USERS WHERE username = '$username' OR email = '$email'");
        
        if (mysqli_num_rows($check_query) > 0) {
            echo "<script>alert('Username or email already exists');</script>";
        } else {
            // Insert new user
            $insert_query = mysqli_query($con, "INSERT INTO USERS (username, password_hash, email, role) VALUES ('$username', '$password', '$email', 'client')");
            
            if ($insert_query) {
                echo "<script>alert('Registration successful. Please login.');</script>";
                echo "<script type='text/javascript'> document.location = 'login.php'; </script>";
            } else {
                echo "<script>alert('Something went wrong. Please try again.');</script>";
            }
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
    <title>Belleville Dental | Register</title>

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
        
        .register-container {
            max-width: 500px;
            margin: 0 auto;
            padding: 30px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            margin-top: 50px;
        }
        
        .register-logo {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .register-logo img {
            max-height: 80px;
        }
        
        .form-control {
            padding: 12px 15px;
            border-radius: 6px;
            border: 1px solid #ddd;
            margin-bottom: 15px;
        }
        
        .btn-register {
            background-color: var(--primary);
            color: white;
            border-radius: 6px;
            padding: 12px;
            font-weight: 600;
            transition: all 0.3s ease;
            border: none;
            width: 100%;
        }
        
        .btn-register:hover {
            background-color: var(--primary-dark);
            transform: translateY(-2px);
        }
        
        .register-links {
            text-align: center;
            margin-top: 20px;
        }
        
        .register-links a {
            color: var(--primary);
            text-decoration: none;
        }
        
        .register-links a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <?php include('includes/header.php'); ?>
    
    <div class="container">
        <div class="register-container">
            <div class="register-logo">
                <img src="images/Belleville Dental logo transparent.png" alt="Belleville Dental">
            </div>
            
            <form method="post">
                <div class="form-group">
                    <input type="text" class="form-control" name="username" placeholder="Username" required>
                </div>
                
                <div class="form-group">
                    <input type="email" class="form-control" name="email" placeholder="Email Address" required>
                </div>
                
                <div class="form-group">
                    <input type="password" class="form-control" name="password" placeholder="Password" required>
                </div>
                
                <div class="form-group">
                    <input type="password" class="form-control" name="confirm_password" placeholder="Confirm Password" required>
                </div>
                
                <button type="submit" name="register" class="btn btn-register">Register</button>
                
                <div class="register-links">
                    <p>Already have an account? <a href="login.php">Login here</a></p>
                </div>
            </form>
        </div>
    </div>
    
    <?php include('includes/footer.php'); ?>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>