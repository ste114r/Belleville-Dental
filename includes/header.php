<?php
// [file name]: includes/header.php
// session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Belleville Dental</title>
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
        }
        
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Merriweather', serif;
            color: var(--dark);
        }
        
        .navbar {
            padding: 0.75rem 0;
            background: white;
            border-bottom: 1px solid rgba(11, 126, 200, 0.1);
            box-shadow: 0 2px 4px rgba(0,0,0,0.04);
        }
        
        .navbar .logo {
            max-height: 55px;
            transition: all 0.2s ease;
        }
        
        .navbar .logo:hover {
            transform: scale(1.02);
        }
        
        .navbar-nav .nav-link {
            color: var(--dark) !important;
            padding: 0.6rem 1.2rem;
            font-weight: 600;
            transition: all 0.3s ease;
            position: relative;
            border-radius: 6px;
        }
        
        .navbar-nav .nav-link:hover {
            color: var(--primary) !important;
            background-color: var(--light-blue);
            transform: translateY(-1px);
        }
        
        .navbar-nav .nav-link.active {
            color: var(--primary) !important;
            background-color: var(--light-blue);
        }
        
        .navbar-nav .nav-link i {
            font-size: 0.9rem;
            margin-right: 0.4rem;
        }
        
        .translate-box {
            padding-left: 1rem;
        }
        
        .navbar-toggler {
            border: none;
            padding: 0.4rem 0.6rem;
            border-radius: 6px;
        }
        
        .navbar-toggler:focus {
            box-shadow: none;
        }
        
        .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='%23064A8A' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='m4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
        }
        
        .btn-login {
            background-color: var(--primary);
            color: white;
            border-radius: 6px;
            padding: 0.5rem 1.2rem;
            font-weight: 600;
            transition: all 0.3s ease;
            border: none;
            text-decoration: none;
            display: inline-block;
        }
        
        .btn-login:hover {
            background-color: var(--primary-dark);
            transform: translateY(-1px);
            color: white;
        }
        
        .user-menu {
            display: flex;
            align-items: center;
        }
        
        .user-welcome {
            margin-right: 15px;
            color: var(--dark);
            font-weight: 600;
        }
        
        @media (max-width: 991px) {
            .navbar-nav .nav-link {
                padding: 0.8rem 0;
                margin: 0.2rem 0;
            }
            
            .translate-box {
                padding-left: 0;
                margin-top: 1rem;
                text-align: center;
            }
            
            .navbar-collapse {
                margin-top: 1rem;
                padding-top: 1rem;
                border-top: 1px solid rgba(11, 126, 200, 0.1);
            }
            
            .user-menu {
                margin-top: 1rem;
                justify-content: center;
                width: 100%;
            }
            
            .user-welcome {
                margin-right: 0;
                margin-bottom: 10px;
                text-align: center;
            }
        }
        
        @media (max-width: 576px) {
            .navbar {
                padding: 0.5rem 0;
            }
            
            .navbar .logo {
                max-height: 45px;
            }
        }
    </style>
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white fixed-top">
        <div class="container-fluid d-flex align-items-center justify-content-between">
            
            <!-- Logo -->
            <a class="navbar-brand d-flex align-items-center" href="index.php">
                <img src="images/Belleville Dental logo transparent.png" height="55" class="me-2 logo" alt="Belleville Dental">
            </a>

            <!-- Mobile Toggler -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive"
                aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Centered Nav -->
            <div class="collapse navbar-collapse justify-content-center" id="navbarResponsive">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php"><i class="fa fa-home"></i>Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="product.php"><i class="fa fa-newspaper"></i>Product</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="about-us.php"><i class="fa fa-info-circle"></i>About Us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="contact-us.php"><i class="fa fa-phone"></i>Contact Us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="gallery.php"><i class="fa fa-picture-o"></i>Gallery</a>
                    </li>
                </ul>
            </div>

            <!-- Right side items -->
            <div class="d-flex align-items-center">
                <?php if(isset($_SESSION['login']) && $_SESSION['login'] != "") { ?>
                    <!-- User is logged in -->
                    <div class="user-menu">
                        <span class="user-welcome d-none d-md-block">Welcome, <?php echo $_SESSION['login']; ?></span>
                        <a href="logout.php" class="btn btn-login">
                            <i class="fa fa-sign-out"></i>Logout
                        </a>
                    </div>
                <?php } else { ?>
                    <!-- User is not logged in -->
                    <div class="login-container me-3">
                        <a href="login.php" class="btn btn-login">
                            <i class="fa fa-user"></i>Login
                        </a>
                    </div>
                <?php } ?>

                <!-- Translate Widget -->
                <div class="translate-box d-none d-lg-block">
                    <div id="google_translate_element"></div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>