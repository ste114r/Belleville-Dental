<?php
session_start();
include('includes/config.php');

// 1. Check if 'pid' is set and is a valid number. Exit if not.
if (!isset($_GET['pid']) || !is_numeric($_GET['pid'])) {
    // You can redirect to a 404 page or just show an error message.
    echo "<h1>Error: Product not found.</h1><p>No product ID was provided.</p>";
    exit();
}
$productid = intval($_GET['pid']);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Belleville Dental | Product Details</title>
    <link rel="shortcut icon" href="images/Belleville Dental logo transparent.png" type="image/x-icon">
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/modern-business.css" rel="stylesheet">
    <link rel="stylesheet" href="css/icons.css">
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/owl.theme.default.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link
        href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&family=Merriweather:wght@400;700&display=swap"
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

        .product-container {
            padding: 0;
        }

        .product-hero {
            padding: 40px 0;
            background: linear-gradient(135deg, var(--light-blue) 0%, #e6f2ff 100%);
            margin-bottom: 30px;
            border-bottom: 1px solid rgba(11, 126, 200, 0.1);
        }

        .category-badge {
            background-color: var(--primary);
            color: white;
            font-size: 0.8rem;
            padding: 5px 12px;
            border-radius: 4px;
            font-weight: 500;
            display: inline-block;
            margin-bottom: 15px;
        }

        .product-title {
            font-size: 2.5rem;
            margin: 15px 0;
            color: var(--primary-dark);
            line-height: 1.3;
        }

        .product-image-container {
            position: relative;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            background: white;
            padding: 20px;
        }

        .product-image {
            width: 100%;
            border-radius: 8px;
            transition: transform 0.3s ease;
        }

        .product-image:hover {
            transform: scale(1.02);
        }

        .product-details {
            padding: 20px;
        }

        .product-highlights {
            background: white;
            border-radius: 8px;
            padding: 25px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            margin: 25px 0;
        }

        .highlight-item {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
        }

        .highlight-icon {
            background: var(--light-blue);
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            color: var(--primary);
            font-size: 1.2rem;
        }

        .buy-now-btn {
            background-color: #28a745;
            border-color: #28a745;
            color: white;
            padding: 15px 40px;
            font-size: 1.2rem;
            border-radius: 50px;
            transition: transform 0.2s, box-shadow 0.2s;
            display: inline-block;
            margin: 20px 0;
            text-decoration: none;
            font-weight: 600;
            box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3);
        }

        .buy-now-btn:hover {
            background-color: #218838;
            border-color: #1e7e34;
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(40, 167, 69, 0.4);
            color: white;
            text-decoration: none;
        }

        .share-buttons {
            background: var(--secondary);
            padding: 15px;
            border-radius: 8px;
            margin: 25px 0;
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            border: 1px solid rgba(0, 0, 0, 0.05);
        }

        .share-label {
            font-weight: 500;
            margin-right: 15px;
            color: var(--dark);
            font-size: 0.95rem;
        }

        .share-buttons a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: white;
            color: var(--primary);
            margin-right: 10px;
            text-decoration: none;
            font-size: 1rem;
            transition: all 0.2s ease;
            border: 1px solid rgba(0, 0, 0, 0.1);
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
        }

        .share-buttons a:hover {
            background: var(--primary);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .product-content {
            line-height: 1.7;
            padding: 20px 0;
        }

        .product-content p {
            margin-bottom: 1.5rem;
            font-size: 1.05rem;
        }

        .recommended-products {
            padding: 40px 0;
            margin-top: 40px;
            background-color: var(--light-blue);
            border-radius: 12px;
            text-align: center;
            border: 1px solid rgba(11, 126, 200, 0.2);
        }

        .section-title {
            margin-bottom: 30px;
            padding-bottom: 15px;
            text-align: center;
            position: relative;
            color: var(--primary-dark);
        }

        .section-title:after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 4px;
            background: var(--primary);
            border-radius: 2px;
        }

        .product-card {
            border: none;
            border-radius: 12px;
            transition: all 0.3s ease;
            height: 100%;
            background: white;
            margin-bottom: 20px;
            overflow: hidden;
            border: 1px solid rgba(0, 0, 0, 0.08);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        .product-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .product-card .card-img-top {
            height: 200px;
            object-fit: cover;
        }

        .product-card .card-body {
            padding: 20px;
        }

        .product-card .card-title {
            font-size: 1.1rem;
            margin-bottom: 12px;
            color: var(--dark);
            font-weight: 600;
        }

        .product-card .card-text {
            font-size: 0.9rem;
            color: var(--gray);
            margin-bottom: 15px;
            line-height: 1.5;
        }

        .btn-outline-primary {
            border-color: var(--primary);
            color: var(--primary);
            border-radius: 6px;
            padding: 8px 20px;
            font-size: 0.9rem;
            transition: all 0.2s ease;
            font-weight: 500;
        }

        .btn-outline-primary:hover {
            background: var(--primary);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(11, 126, 200, 0.2);
        }

        .contact-cta {
            background: var(--light-blue);
            border-radius: 12px;
            padding: 40px;
            margin: 40px 0;
            text-align: center;
            border: 1px solid rgba(11, 126, 200, 0.2);
        }

        .contact-cta h4 {
            color: var(--primary-dark);
            margin-bottom: 15px;
            font-size: 1.8rem;
            font-weight: 700;
        }

        .contact-cta p {
            margin-bottom: 25px;
            font-size: 1.1rem;
            opacity: 0.9;
            max-width: 700px;
            margin-left: auto;
            margin-right: auto;
            line-height: 1.6;
        }

        .btn-primary {
            background: var(--primary);
            color: white;
            border: none;
            border-radius: 6px;
            padding: 12px 30px;
            font-weight: 600;
            transition: all 0.2s ease;
            font-size: 1.1rem;
            box-shadow: 0 4px 15px rgba(11, 126, 200, 0.3);
        }

        .btn-primary:hover {
            background: var(--primary-dark);
            color: white;
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(11, 126, 200, 0.4);
        }

        @media (max-width: 768px) {
            .product-title {
                font-size: 2rem;
            }

            .share-buttons {
                flex-direction: column;
                align-items: flex-start;
            }

            .share-buttons .share-label {
                margin-bottom: 10px;
            }

            .buy-now-btn {
                padding: 12px 30px;
                font-size: 1.1rem;
            }
        }

        /* Styling for the description dropdown */
        .description-accordion .card {
            border: 1px solid #e9ecef;
            border-radius: 8px;
            box-shadow: none;
        }

        .description-accordion .card-header {
            background-color: #fff;
            border-bottom: 1px solid #e9ecef;
            border-radius: 8px 8px 0 0;
        }

        .description-accordion .btn-link {
            color: var(--dark);
            text-decoration: none;
            font-weight: 600;
            width: 100%;
            text-align: left;
            padding: 1rem 1.25rem;
        }

        .description-accordion .btn-link:hover {
            text-decoration: none;
        }

        .description-accordion .btn-link .fa-chevron-down {
            transition: transform 0.3s ease;
        }

        .description-accordion .btn-link[aria-expanded="true"] .fa-chevron-down {
            transform: rotate(180deg);
        }
    </style>
</head>

<body>
    <?php include('includes/header.php'); ?>

    <div class="container-fluid product-container">
        <div class="row" style="margin-top: 4%;">
            <!-- Main Content Column -->
            <div class="col-md-9">
                <?php
                // 2. Use a prepared statement for security
                $stmt = mysqli_prepare($con, "SELECT p.name as ProductName,
                                                    p.description as ProductDescription,
                                                    p.image_url as ProductImage,
                                                    p.buy_url as BuyUrl,
                                                    pc.name as CategoryName,
                                                    p.pcategory_id -- Fetch category ID for related products query
                                                FROM PRODUCTS p
                                                -- 3. Corrected the JOIN condition here
                                                JOIN PRODUCT_CATEGORIES pc ON p.pcategory_id = pc.pcategory_id
                                                WHERE p.product_id = ? AND p.is_active = 1");
                mysqli_stmt_bind_param($stmt, "i", $productid);
                mysqli_stmt_execute($stmt);
                $query = mysqli_stmt_get_result($stmt);

                $rowcount = mysqli_num_rows($query);
                if ($rowcount == 0) {
                    echo "<h3>Product not found or is no longer available.</h3>";
                } else {
                    // Store category ID for the next query
                    $category_id_for_related = 0;
                    $currenturl = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

                    while ($row = mysqli_fetch_array($query)) {
                        $category_id_for_related = $row['pcategory_id'];
                        ?>
                        <div class="product-hero">
                            <div class="container">
                                <div class="row align-items-center">
                                    <div class="col-md-6">
                                        <span class="category-badge"><?php echo htmlentities($row['CategoryName']); ?></span>
                                        <h1 class="product-title"><?php echo htmlentities($row['ProductName']); ?></h1>
                                        <!-- <div class="product-highlights">
                                            <div class="highlight-item">
                                                <div class="highlight-icon">
                                                    <i class="fas fa-teeth"></i>
                                                </div>
                                                <div>Professional-grade dental care</div>
                                            </div>
                                            <div class="highlight-item">
                                                <div class="highlight-icon">
                                                    <i class="fas fa-shield-alt"></i>
                                                </div>
                                                <div>Clinically proven effectiveness</div>
                                            </div>
                                            <div class="highlight-item">
                                                <div class="highlight-icon">
                                                    <i class="fas fa-thumbs-up"></i>
                                                </div>
                                                <div>Dentist recommended</div>
                                            </div>
                                        </div> -->

                                        <div class="description-accordion" id="descriptionAccordion">
                                            <div class="card">
                                                <div class="card-header p-0" id="headingOne">
                                                    <h5 class="mb-0">
                                                        <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseDescription" aria-expanded="false" aria-controls="collapseDescription">
                                                            Product Description
                                                            <i class="fas fa-chevron-down float-right"></i>
                                                        </button>
                                                    </h5>
                                                </div>
                                                <div id="collapseDescription" class="collapse" aria-labelledby="headingOne" data-parent="#descriptionAccordion">
                                                    <div class="card-body">
                                                        <?php echo $row['ProductDescription']; ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <a href="<?php echo htmlentities($row['BuyUrl']); ?>" class="buy-now-btn"
                                            target="_blank">
                                            <i class="fas fa-shopping-cart mr-2"></i> Buy Now
                                        </a>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="product-image-container">
                                            <img class="product-image"
                                                src="admin/productimages/<?php echo htmlentities($row['ProductImage']); ?>"
                                                alt="<?php echo htmlentities($row['ProductName']); ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="container">
                            <div class="share-buttons">
                                <span class="share-label">Share this product:</span>
                                <a href="http://www.facebook.com/share.php?u=<?php echo $currenturl; ?>" target="_blank"
                                    title="Share on Facebook">
                                    <i class="fab fa-facebook-f"></i>
                                </a>
                                <a href="https://twitter.com/share?url=<?php echo $currenturl; ?>" target="_blank"
                                    title="Share on Twitter">
                                    <i class="fab fa-twitter"></i>
                                </a>
                                <a href="https://web.whatsapp.com/send?text=<?php echo $currenturl; ?>" target="_blank"
                                    title="Share on WhatsApp">
                                    <i class="fab fa-whatsapp"></i>
                                </a>
                                <a href="http://www.linkedin.com/shareArticle?mini=true&amp;url=<?php echo $currenturl; ?>"
                                    target="_blank" title="Share on LinkedIn">
                                    <i class="fab fa-linkedin-in"></i>
                                </a>
                            </div>

                            <!-- Related Products -->
                            <section class="recommended-products">
                                <h4 class="section-title">Related Products</h4>
                                <div class="row">
                                    <?php
                                    // Check if we found a product and have a category ID before running this query
                                    if ($category_id_for_related > 0) {
                                        // Use a prepared statement for the related products query too
                                        $related_stmt = mysqli_prepare($con, "SELECT product_id, name, description, image_url
                                                                                FROM PRODUCTS
                                                                                WHERE pcategory_id = ?
                                                                                AND product_id != ?
                                                                                AND is_active = 1
                                                                                ORDER BY RAND()
                                                                                LIMIT 3");
                                        mysqli_stmt_bind_param($related_stmt, "ii", $category_id_for_related, $productid);
                                        mysqli_stmt_execute($related_stmt);
                                        $related_query = mysqli_stmt_get_result($related_stmt);

                                        $related_count = mysqli_num_rows($related_query);
                                        if ($related_count > 0) {
                                            while ($related_row = mysqli_fetch_array($related_query)) {
                                                ?>
                                                <div class="col-md-4">
                                                    <div class="card product-card">
                                                        <img class="card-img-top"
                                                            src="images/<?php echo htmlentities($related_row['image_url']); ?>"
                                                            alt="<?php echo htmlentities($related_row['name']); ?>">
                                                        <div class="card-body">
                                                            <h5 class="card-title"><?php echo htmlentities($related_row['name']); ?></h5>
                                                            <p class="card-text">
                                                                <?php echo strip_tags(substr($related_row['description'], 0, 100)); ?>...
                                                            </p>
                                                            <a href="product-details.php?pid=<?php echo htmlentities($related_row['product_id']); ?>"
                                                                class="btn btn-outline-primary">View Details</a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php
                                            }
                                        } else {
                                            echo "<div class='col-12'><p>No related products found.</p></div>";
                                        }
                                    }
                                    ?>
                                </div>
                            </section>

                            <!-- Contact Us Section -->
                            <div class="contact-cta">
                                <h4>Have Questions About Dental Products?</h4>
                                <p class="mb-3">Our dental professionals can provide personalized recommendations based on your
                                    specific needs.</p>
                                <a href="contact-us.php" class="btn btn-primary">Contact Us for Advice</a>
                            </div>
                        </div>
                        <?php
                    }
                }
                ?>
            </div>

            <!-- Sidebar Column -->
            <?php include('includes/sidebar.php'); ?>
        </div>
    </div>

    <?php include('includes/footer.php'); ?>

    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>

</html>