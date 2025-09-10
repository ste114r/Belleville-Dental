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
    <title>Belleville Dental | Products</title>

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

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-family: 'Merriweather', serif;
            color: var(--dark);
        }

        .products-hero {
            padding: 50px 0 30px;
            text-align: center;
            background-color: var(--light-blue);
            margin-bottom: 30px;
            margin-top: 25px;
            border-bottom: 1px solid rgba(11, 126, 200, 0.1);
        }

        .product-card {
            border: none;
            border-radius: 8px;
            transition: all 0.2s ease;
            height: 100%;
            background: white;
            margin-bottom: 25px;
            overflow: hidden;
            border: 1px solid rgba(0, 0, 0, 0.08);
        }

        .product-card:hover {
            transform: translateY(-5px);
        }

        .product-image {
            height: 250px;
            object-fit: cover;
            background-color: var(--light-blue);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .product-image img {
            max-height: 100%;
            max-width: 100%;
            object-fit: contain;
        }

        .product-category {
            font-size: 0.85rem;
            color: var(--gray);
            margin-bottom: 5px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .btn-primary {
            background: var(--primary);
            border: none;
            border-radius: 4px;
            padding: 8px 20px;
            font-weight: 500;
            transition: all 0.2s ease;
        }

        .btn-primary:hover {
            background: var(--primary-dark);
        }

        .section-title {
            position: relative;
            display: inline-block;
            margin-bottom: 25px;
            padding-bottom: 10px;
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

        .benefit-item {
            margin-bottom: 8px;
            position: relative;
            padding-left: 25px;
            color: var(--gray);
        }

        .benefit-item:before {
            content: "✓";
            color: var(--primary);
            position: absolute;
            left: 0;
            font-weight: bold;
        }

        .breadcrumb {
            background: var(--light-blue);
            border-radius: 4px;
            padding: 8px 15px;
            margin-bottom: 25px;
        }

        .criteria-section {
            background: var(--primary);
            padding: 40px 0;
            margin: 30px 0;
            color: white;
        }

        .criteria-section h3,
        .criteria-section h5 {
            color: white;
        }

        .benefit-icon {
            font-size: 2rem;
            color: var(--primary);
            margin-bottom: 15px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 60px;
            height: 60px;
            background: white;
            border-radius: 50%;
        }

        .criteria-section .benefit-icon {
            color: var(--primary);
        }

        .consultation-cta {
            background: var(--light-blue);
            border-radius: 8px;
            padding: 30px;
            margin: 30px 0;
            text-align: center;
            border: 1px solid rgba(11, 126, 200, 0.2);
        }
    </style>
</head>

<body>
    <?php include('includes/header.php'); ?>

    <div class="products-hero">
        <div class="container-fluid">
            <h1 class="display-4 text-primary">Recommended Dental Products</h1>
            <p class="lead">Professional recommendations for optimal oral health</p>
        </div>
    </div>

    <div class="container-fluid">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="index.php">Home</a>
            </li>
            <li class="breadcrumb-item active">Products</li>
        </ol>

        <div class="row mb-4">
            <div class="col-lg-12 text-center">
                <p class="lead" style="max-width: 800px; margin: 0 auto;">We recommend these dental care products to
                    help you maintain optimal oral hygiene. Each product is selected based on its effectiveness and
                    dental professional recommendations.</p>
            </div>
        </div>

        <h2 class="text-center mb-4 section-title">Our Recommendations</h2>
        <div class="row justify-content-center">
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card product-card">
                    <div class="product-image">
                        <img src="images/01.png" alt="Soft Bristle Toothbrush">
                    </div>
                    <div class="card-body">
                        <div class="product-category">TOOTHBRUSH</div>
                        <h5 class="card-title">Soft Bristle Toothbrush</h5>
                        <p class="card-text">Gentle on gums while effectively removing plaque. Recommended for daily use
                            by dental professionals.</p>

                        <div class="text-center mt-3">
                            <a href="#" class="btn btn-primary">Learn More</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card product-card">
                    <div class="product-image">
                        <img src="images/01.png" alt="Soft Bristle Toothbrush">
                    </div>
                    <div class="card-body">
                        <div class="product-category">TOOTHBRUSH</div>
                        <h5 class="card-title">Soft Bristle Toothbrush</h5>
                        <p class="card-text">Gentle on gums while effectively removing plaque. Recommended for daily use
                            by dental professionals.</p>

                        <div class="text-center mt-3">
                            <a href="#" class="btn btn-primary">Learn More</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card product-card">
                    <div class="product-image">
                        <img src="images/03.png" alt="Antibacterial Mouthwash">
                    </div>
                    <div class="card-body">
                        <div class="product-category">MOUTHWASH</div>
                        <h5 class="card-title">Antibacterial Mouthwash</h5>
                        <p class="card-text">Helps reduce plaque bacteria and freshens breath. Use daily as part of your
                            oral hygiene routine.</p>

                        <div class="text-center mt-3">
                            <a href="#" class="btn btn-primary">Learn More</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="criteria-section">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h3 class="mb-4">Our Product Selection Criteria</h3>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 text-center mb-4">
                    <div class="benefit-icon">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <h5>Dentist Recommended</h5>
                    <p>All products we recommend are approved by dental professionals for optimal oral health.</p>
                </div>
                <div class="col-md-4 text-center mb-4">
                    <div class="benefit-icon">
                        <i class="fas fa-flask"></i>
                    </div>
                    <h5>Evidence-Based</h5>
                    <p>We select products with proven effectiveness based on scientific research and clinical studies.
                    </p>
                </div>
                <div class="col-md-4 text-center mb-4">
                    <div class="benefit-icon">
                        <i class="fas fa-award"></i>
                    </div>
                    <h5>Quality Standards</h5>
                    <p>Every product meets high quality and safety standards for dental care products.</p>
                </div>
            </div>
        </div>

        <div class="consultation-cta">
            <h4 class="text-primary">Have Questions About Dental Products?</h4>
            <p class="mb-3">Our dental professionals can provide personalized recommendations based on your specific
                needs.</p>
            <a href="contact-us.php" class="btn btn-primary">Contact Us for Advice</a>
        </div>
    </div>
    <?php include('includes/footer.php'); ?>

    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>

</html>