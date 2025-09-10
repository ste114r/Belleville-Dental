<?php
include('includes/config.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="images/Belleville Dental logo transparent.png" type="image/x-icon">
    <title>Belleville Dental | About Us</title>

    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/modern-business.css" rel="stylesheet">
    <link rel="stylesheet" href="css/icons.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&family=Merriweather:wght@400;700&display=swap" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
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
            font-family: 'Nunito', sans-serif;
            color: #444;
            line-height: 1.6;
            background-color: #fff;
        }
        
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Merriweather', serif;
            color: var(--dark);
        }
        
        .about-hero {
            padding: 50px 0 30px;
            text-align: center;
            background-color: var(--light-blue);
            margin-bottom: 30px;
            margin-top: 25px;
            border-bottom: 1px solid rgba(11, 126, 200, 0.1);
        }
        
        .mission-vision {
            background: var(--primary);
            padding: 40px 0;
            border-radius: 8px;
            margin: 30px 0;
            color: white;
        }
        
        .value-card {
            border: none;
            border-radius: 8px;
            transition: all 0.2s ease;
            height: 100%;
            background: white;
            margin-bottom: 20px;
            overflow: hidden;
            border: 1px solid rgba(0,0,0,0.08);
        }
        
        .value-icon {
            font-size: 2rem;
            margin-bottom: 15px;
            color: var(--primary);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: var(--light-blue);
        }
        
        .mission-vision .value-icon {
            background: rgba(255, 255, 255, 0.2);
            color: white;
        }
        
        .section-title {
            margin-bottom: 25px;
            padding-bottom: 10px;
            position: relative;
            display: inline-block;
        }
        
        .section-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 60px;
            height: 3px;
            background: var(--primary);
        }
        
        .text-primary {
            color: var(--primary) !important;
        }
        
        .lead {
            font-size: 1.1rem;
            color: var(--gray);
        }
        
        .breadcrumb {
            background: var(--light-blue);
            border-radius: 4px;
            padding: 8px 15px;
            margin-bottom: 25px;
        }
    </style>
</head>

<body>
    <!-- Navigation -->
    <?php include('includes/header.php'); ?>
    
    <!-- Hero Section -->
    <div class="about-hero">
        <div class="container-fluid">
            <h1 class="display-4 text-primary">About Belleville Dental</h1>
            <p class="lead">Your trusted partner in oral health education and care</p>
        </div>
    </div>
    
    <!-- Page Content -->
    <div class="container-fluid">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="index.php">Home</a>
            </li>
            <li class="breadcrumb-item active">About Us</li>
        </ol>

        <!-- Intro Content -->
        <div class="row mb-4">
            <div class="col-lg-6">
                <div class="p-4" style="background: var(--light-blue); border-radius: 8px; height: 100%;">
                    <div class="text-center">
                        <i class="fas fa-tooth" style="font-size: 4rem; color: var(--primary);"></i>
                        <h3 class="mt-3 text-primary">Our Dental Mission</h3>
                    </div>
                    <p class="mt-4">Welcome to Belleville Dental, your trusted partner in oral health education and care! We are dedicated to promoting healthy smiles and empowering our community with the knowledge needed to maintain optimal dental wellness.</p>
                    <p>At the core of our educational efforts is the belief that informed individuals make better choices for their oral health. From daily brushing and flossing techniques to understanding the importance of regular dental check-ups, we cover a wide range of topics to ensure you have the tools to care for your smile.</p>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="p-4" style="background: white; border-radius: 8px; border: 1px solid rgba(0,0,0,0.08); height: 100%;">
                    <div class="text-center">
                        <i class="fas fa-smile" style="font-size: 4rem; color: var(--primary);"></i>
                        <h3 class="mt-3 text-primary">Our Commitment</h3>
                    </div>
                    <p class="mt-4">Thank you for choosing Belleville Dental as your trusted resource for oral health! We're committed to providing accurate, up-to-date information to help you make informed decisions about your dental care.</p>
                    <p>Our team of dental professionals works tirelessly to create educational content that is both engaging and informative. We believe that prevention is the best medicine, and we're here to guide you on your journey to optimal oral health.</p>
                </div>
            </div>
        </div>
        
        <!-- Mission & Vision Section -->
        <div class="mission-vision">
            <div class="row">
                <div class="col-md-6 mb-4">
                    <div class="card h-100 value-card" style="background: rgba(255, 255, 255, 0.1);">
                        <div class="card-body text-center p-4">
                            <div class="value-icon">
                                <i class="fas fa-bullseye"></i>
                            </div>
                            <h3 class="card-title text-white">Our Mission</h3>
                            <p class="card-text" style="color: white;">To provide the highest standard of dental education and services, empowering our community with knowledge to maintain lifelong oral health.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-4">
                    <div class="card h-100 value-card" style="background: rgba(255, 255, 255, 0.1);">
                        <div class="card-body text-center p-4">
                            <div class="value-icon">
                                <i class="fas fa-eye"></i>
                            </div>
                            <h3 class="card-title text-white">Our Vision</h3>
                            <p class="card-text" style="color: white;">To be the leading resource for dental care education, helping individuals make informed decisions about their oral health.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Values Section -->
        <h2 class="text-center mb-4 section-title">Our Values</h2>
        <div class="row mb-4">
            <div class="col-md-3 col-sm-6 mb-4">
                <div class="card h-100 value-card">
                    <div class="card-body text-center p-4">
                        <div class="value-icon">
                            <i class="fas fa-heart"></i>
                        </div>
                        <h4 class="text-primary">Compassionate Care</h4>
                        <p>We treat every patient with empathy, understanding, and personalized attention.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 mb-4">
                <div class="card h-100 value-card">
                    <div class="card-body text-center p-4">
                        <div class="value-icon">
                            <i class="fas fa-graduation-cap"></i>
                        </div>
                        <h4 class="text-primary">Patient Education</h4>
                        <p>We believe informed patients make better decisions about their oral health.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 mb-4">
                <div class="card h-100 value-card">
                    <div class="card-body text-center p-4">
                        <div class="value-icon">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <h4 class="text-primary">Preventive Focus</h4>
                        <p>We emphasize prevention to help you maintain optimal oral health long-term.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 mb-4">
                <div class="card h-100 value-card">
                    <div class="card-body text-center p-4">
                        <div class="value-icon">
                            <i class="fas fa-star"></i>
                        </div>
                        <h4 class="text-primary">Commitment to Excellence</h4>
                        <p>We continuously strive to provide the highest quality dental education and resources.</p>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- /.container-fluid -->

    <!-- Footer -->
    <?php include('includes/footer.php'); ?>

    <script src="js/foot.js"></script>
    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>

</html>