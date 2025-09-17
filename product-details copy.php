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
        }

        body {
            font-family: 'Nunito', sans-serif;
            color: #495057;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-family: 'Merriweather', serif;
            color: var(--primary-dark);
        }

        .btn-primary {
            background-color: var(--primary);
            border-color: var(--primary);
        }

        .btn-primary:hover {
            background-color: var(--primary-dark);
            border-color: var(--primary-dark);
        }

        .product-image {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .product-content p {
            line-height: 1.8;
            margin-bottom: 1.5rem;
        }

        .buy-now-btn {
            background-color: #28a745;
            border-color: #28a745;
            color: white;
            padding: 12px 30px;
            font-size: 1.2rem;
            border-radius: 50px;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .buy-now-btn:hover {
            background-color: #218838;
            border-color: #1e7e34;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }
    </style>
</head>

<body>
    <?php include('includes/header.php'); ?>
    <div class="container-fluid">
        <div class="row" style="margin-top: 4%">
            <div class="col-md-8">
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
                    while ($row = mysqli_fetch_array($query)) {
                        $category_id_for_related = $row['pcategory_id'];
                        ?>
                        <div class="mb-4">
                            <h1 class="mt-4 mb-3"><?php echo htmlentities($row['ProductName']); ?></h1>
                            <p class="lead">
                                Category: <?php echo htmlentities($row['CategoryName']); ?>
                            </p>
                        </div>
                        <img class="img-fluid rounded product-image" src="images/<?php echo htmlentities($row['ProductImage']); ?>"
                            alt="<?php echo htmlentities($row['ProductName']); ?>">
                        <hr>
                        <div class="product-content">
                            <?php echo $row['ProductDescription']; ?>
                        </div>
                        <div class="text-center my-4">
                            <a href="<?php echo htmlentities($row['BuyUrl']); ?>" class="btn buy-now-btn" target="_blank">
                                <i class="fas fa-shopping-cart mr-2"></i> Buy Now
                            </a>
                        </div>
                        <?php
                    }
                }
                ?>

                <section class="mb-5">
                    <h3 class="my-4">Related Products</h3>
                    <div class="row">
                        <?php
                        // Check if we found a product and have a category ID before running this query
                        if ($rowcount > 0 && $category_id_for_related > 0) {
                            // Use a prepared statement for the related products query too
                            $related_stmt = mysqli_prepare($con, "SELECT product_id, name, description, image_url
                                                                  FROM PRODUCTS
                                                                  WHERE pcategory_id = ?
                                                                  AND product_id != ?
                                                                  AND is_active = 1
                                                                  ORDER BY RAND()
                                                                  LIMIT 4");
                            mysqli_stmt_bind_param($related_stmt, "ii", $category_id_for_related, $productid);
                            mysqli_stmt_execute($related_stmt);
                            $related_query = mysqli_stmt_get_result($related_stmt);
                            
                            $related_count = mysqli_num_rows($related_query);
                            if ($related_count > 0) {
                                while ($row = mysqli_fetch_array($related_query)) {
                                    ?>
                                    <div class="col-md-6 col-lg-3 mb-4">
                                        <div class="card h-100 shadow-sm">
                                            <img class="card-img-top" src="images/<?php echo htmlentities($row['image_url']); ?>"
                                                alt="<?php echo htmlentities($row['name']); ?>">
                                            <div class="card-body d-flex flex-column">
                                                <h5 class="card-title"><?php echo htmlentities($row['name']); ?></h5>
                                                <p class="card-text text-truncate"><?php echo strip_tags($row['description']); ?></p>
                                                <a href="product-details.php?pid=<?php echo htmlentities($row['product_id']); ?>"
                                                    class="btn btn-outline-primary mt-auto">View Details</a>
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
                <hr>
                <div class="contact-cta text-center py-5 my-4 bg-light rounded">
                    <h4 class="text-primary">Have Questions About Dental Products?</h4>
                    <p class="mb-3">Our dental professionals can provide personalized recommendations based on your
                        specific needs.</p>
                    <a href="contact-us.php" class="btn btn-primary">Contact Us for Advice</a>
                </div>
            </div>
            <?php include('includes/sidebar.php'); ?>
        </div>
    </div>
    <?php include('includes/footer.php'); ?>
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>

</html>