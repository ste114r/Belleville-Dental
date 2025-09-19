<?php
include('includes/config.php');
session_name('client_session');
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Sitemap for Belleville Dental, providing an overview of the website structure.">
    <meta name="author" content="">
    <link rel="shortcut icon" href="images/Belleville Dental logo transparent.png" type="image/x-icon">
    <title>Belleville Dental | Sitemap</title>

    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/modern-business.css" rel="stylesheet">
    <link rel="stylesheet" href="css/icons.css">
    <link
        href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&family=Merriweather:wght@400;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --primary: #0B7EC8;
            --primary-dark: #064A8A;
            --secondary: #f8f9fa;
            --dark: #343a40;
            --light: #f8f9fa;
            --gray: #6c757d;
            --light-blue: #F0F8FF;
        }

        body {
            font-family: 'Nunito', sans-serif;
            color: #444;
            background-color: #fff;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-family: 'Merriweather', serif;
            color: var(--dark);
        }

        .sitemap-hero {
            padding: 50px 0 30px;
            text-align: center;
            background-color: var(--light-blue);
            margin-bottom: 30px;
            margin-top: 25px;
            border-bottom: 1px solid rgba(11, 126, 200, 0.1);
        }

        .sitemap-container {
            background: white;
            padding: 40px;
            border-radius: 8px;
            border: 1px solid rgba(0, 0, 0, 0.08);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        .sitemap-tree {
            list-style: none;
            padding-left: 0;
        }
        
        .sitemap-tree a, .sitemap-tree span {
            font-size: 1.1rem;
            color: var(--dark);
            text-decoration: none;
            transition: color 0.2s ease-in-out;
            font-weight: 600;
        }
        
        .sitemap-tree span {
            color: #343a40; /* Make non-link headers slightly different if needed */
        }
        
        .sitemap-tree a:hover {
            color: var(--primary);
            text-decoration: underline;
        }

        .sitemap-tree > li {
            padding: 10px 0;
            border-bottom: 1px solid #f0f0f0;
        }
        .sitemap-tree > li:last-child {
            border-bottom: none;
        }

        .sitemap-tree ul {
            list-style: none;
            padding-left: 30px;
            margin-top: 10px;
        }

        .sitemap-tree ul li {
            position: relative;
            padding: 5px 0 5px 20px;
        }
        
        .sitemap-tree ul li::before {
            content: '—';
            position: absolute;
            left: 0;
            top: 5px;
            color: var(--gray);
        }

        .sitemap-tree ul a {
            font-size: 1rem;
            font-weight: 400;
        }
    </style>
</head>

<body>
    <?php include('includes/header.php'); ?>

    <div class="sitemap-hero">
        <div class="container-fluid">
            <h1 class="display-4 text-primary">Sitemap</h1>
            <p class="lead">Navigate through our website using the links below.</p>
        </div>
    </div>

    <div class="container my-5">
        <div class="sitemap-container">
            <ul class="sitemap-tree">
                <li><a href="index.php"><i class="fas fa-home me-2 text-primary"></i>Home</a></li>

                <li><a href="index.php"><i class="fas fa-newspaper me-2 text-primary"></i>Articles</a>
                    <ul>
                        <?php 
                        $query_articles = mysqli_query($con, "SELECT category_id, name FROM ARTICLE_CATEGORIES WHERE is_active = 1 ORDER BY name ASC");
                        while ($row = mysqli_fetch_array($query_articles)) { ?>
                            <li><a href="category.php?catid=<?php echo htmlentities($row['category_id']); ?>"><?php echo htmlentities($row['name']); ?></a></li>
                        <?php } ?>
                    </ul>
                </li>

                <li><a href="product.php"><i class="fas fa-shopping-basket me-2 text-primary"></i>Recommended Products</a>
                    <ul>
                        <?php 
                        $query_products = mysqli_query($con, "SELECT pcategory_id, name FROM PRODUCT_CATEGORIES WHERE is_active = 1 ORDER BY name ASC");
                        while ($row = mysqli_fetch_array($query_products)) { ?>
                            <li><a href="product.php?catid=<?php echo htmlentities($row['pcategory_id']); ?>"><?php echo htmlentities($row['name']); ?></a></li>
                        <?php } ?>
                    </ul>
                </li>

                <li><a href="about-us.php"><i class="fas fa-info-circle me-2 text-primary"></i>About Us</a></li>
                <li><a href="contact-us.php"><i class="fas fa-envelope me-2 text-primary"></i>Contact Us</a></li>

                <li><span><i class="fas fa-user me-2 text-primary"></i>User Account</span>
                    <ul>
                        <?php if (isset($_SESSION['login'])): ?>
                            <li><a href="profile.php">My Profile</a></li>
                            <li><a href="logout.php">Logout</a></li>
                        <?php else: ?>
                            <li><a href="login.php">Login</a></li>
                            <li><a href="register.php">Register</a></li>
                            <li><a href="forgot-password.php">Forgot Password</a></li>
                        <?php endif; ?>
                    </ul>
                </li>
            </ul>
        </div>
    </div>

    <?php include('includes/footer.php'); ?>

    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>

</html>