<?php
session_name('client_session');
session_start();
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
            left: 50%;
            transform: translateX(-50%);
            width: 60px;
            height: 3px;
            background: var(--primary);
        }

        .product-filters {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 40px;
        }

        .filter-btn {
            background-color: #fff;
            color: var(--dark);
            border: 1px solid #ddd;
            padding: 8px 20px;
            border-radius: 8px;
            text-decoration: none;
            transition: all 0.3s ease;
            font-weight: 500;
        }

        .filter-btn:hover,
        .filter-btn.active {
            background-color: var(--primary);
            color: #fff;
            border-color: var(--primary);
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
        }

        .product-card {
            border: 1px solid #e9ecef;
            border-radius: 8px;
            transition: all 0.3s ease;
            background: white;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
        }

        .product-image-wrapper {
            height: 220px;
            overflow: hidden;
        }

        .product-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .product-card-body {
            padding: 20px;
            display: flex;
            flex-direction: column;
            flex-grow: 1;
        }

        .category-badge {
            background-color: var(--primary);
            color: white;
            font-size: 0.8rem;
            padding: 4px 10px;
            border-radius: 4px;
            margin-bottom: 10px;
            display: inline-block;
            width: auto;
            max-width: max-content;
            margin-left: auto;
            margin-right: auto;
        }

        .product-card-body .card-title {
            font-size: 1.1rem;
            margin-bottom: 15px;
            flex-grow: 1;
            text-align: center;
        }

        .product-card-body .mt-auto {
            text-align: center;
        }

        .btn-primary {
            background: var(--primary);
            border: none;
            border-radius: 4px;
            padding: 8px 20px;
            font-weight: 600;
            transition: all 0.2s ease;
            font-size: 0.9rem;
            letter-spacing: 0.5px;
            display: inline-block;
        }

        .btn-primary:hover {
            background: var(--primary-dark);
        }

        .pagination .page-link {
            border: none;
            color: var(--primary);
            border-radius: 4px;
            margin: 0 3px;
            transition: all 0.2s ease;
        }

        .pagination .page-item.active .page-link {
            background-color: var(--primary);
            border-color: var(--primary);
            color: #fff;
        }

        .pagination .page-link:hover {
            background-color: var(--light-blue);
        }

        .criteria-section {
            background: var(--primary);
            padding: 40px 40px;
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
        <div class="row justify-content-center" style="margin-top: 4%;">
            <div class="col-lg-10">

                <?php
                $catid = 0;
                if (isset($_GET['catid']) && is_numeric($_GET['catid'])) {
                    $catid = (int) $_GET['catid'];
                }
                ?>

                <div class="text-center">
                    <h4 class="section-title">Browse by <span>Category</span></h4>
                </div>
                <div class="product-filters">
                    <a href="product.php" class="filter-btn <?php if ($catid == 0)
                        echo 'active'; ?>">All Products</a>
                    <?php
                    $query = mysqli_query($con, "select pcategory_id, name from PRODUCT_CATEGORIES WHERE is_active = 1");
                    while ($row = mysqli_fetch_array($query)) {
                        $isActive = ($catid == $row['pcategory_id']) ? 'active' : '';
                        ?>
                        <a href="product.php?catid=<?php echo htmlentities($row['pcategory_id']) ?>"
                            class="filter-btn <?php echo $isActive; ?>"><?php echo htmlentities($row['name']); ?></a>
                    <?php } ?>
                </div>

                <div class="row">
                    <?php
                    if (isset($_GET['pageno'])) {
                        $pageno = $_GET['pageno'];
                    } else {
                        $pageno = 1;
                    }
                    $no_of_records_per_page = 9;
                    $offset = ($pageno - 1) * $no_of_records_per_page;

                    // Using prepared statements for security
                    $params = [];
                    $types = '';

                    $whereClause = "WHERE p.is_active = 1";
                    if ($catid > 0) {
                        $whereClause .= " AND p.pcategory_id = ?";
                        $params[] = $catid;
                        $types .= 'i';
                    }
                    
                    // Total pages calculation
                    $total_pages_sql = "SELECT COUNT(*) FROM PRODUCTS p $whereClause";
                    $stmt_total = mysqli_prepare($con, $total_pages_sql);
                    if ($catid > 0) {
                        mysqli_stmt_bind_param($stmt_total, $types, ...$params);
                    }
                    mysqli_stmt_execute($stmt_total);
                    $result = mysqli_stmt_get_result($stmt_total);
                    $total_rows = mysqli_fetch_array($result)[0];
                    $total_pages = ceil($total_rows / $no_of_records_per_page);

                    // Product fetching query
                    $product_query_sql = "
                        SELECT 
                            p.product_id AS pid,
                            p.name AS posttitle,
                            p.image_url AS PostImage,
                            pc.name AS category
                        FROM PRODUCTS p
                        LEFT JOIN PRODUCT_CATEGORIES pc 
                            ON pc.pcategory_id = p.pcategory_id
                        $whereClause
                        ORDER BY p.product_id DESC
                        LIMIT ?, ?
                    ";
                    $stmt_products = mysqli_prepare($con, $product_query_sql);
                    
                    // Add limit and offset to params
                    $params[] = $offset;
                    $params[] = $no_of_records_per_page;
                    $types .= 'ii';

                    mysqli_stmt_bind_param($stmt_products, $types, ...$params);
                    mysqli_stmt_execute($stmt_products);
                    $product_query = mysqli_stmt_get_result($stmt_products);

                    $postcount = mysqli_num_rows($product_query);
                    if ($postcount == 0) {
                        echo "<div class='col-12'><p class='text-center fs-5 mt-4'>No products found in this category.</p></div>";
                    } else {
                        while ($row = mysqli_fetch_array($product_query)) {
                            ?>
                            <div class="col-lg-4 col-md-6 mb-4">
                                <div class="product-card">
                                    <div class="product-image-wrapper">
                                        <img class="product-image" src="admin/productimages/<?php echo htmlentities($row['PostImage']); ?>"
                                            alt="<?php echo htmlentities($row['posttitle']); ?>">
                                    </div>
                                    <div class="product-card-body">
                                        <span class="category-badge"><?php echo htmlentities($row['category']); ?></span>
                                        <a class="text-decoration-none text-dark">
                                            <h5 class="card-title"><?php echo htmlentities($row['posttitle']); ?></h5>
                                        </a>
                                        <div class="mt-auto">
                                            <a href="product-details.php?pid=<?php echo htmlentities($row['pid']) ?>"
                                                class="btn btn-primary">Learn More</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php }
                    } ?>
                </div>

                <?php if ($total_pages > 1): ?>
                    <div class="col-md-12 mt-4">
                        <ul class="pagination justify-content-center">
                            <?php
                            $paginationUrl = "?";
                            if ($catid > 0) {
                                $paginationUrl .= "catid=$catid&";
                            }
                            ?>
                            <li class="page-item <?php if ($pageno <= 1) {
                                echo 'disabled';
                            } ?>">
                                <a href="<?php if ($pageno <= 1) {
                                    echo '#';
                                } else {
                                    echo $paginationUrl . "pageno=" . ($pageno - 1);
                                } ?>" class="page-link">Prev</a>
                            </li>

                            <?php for ($i = 1; $i <= $total_pages; $i++) { ?>
                                <li class="page-item <?php if ($pageno == $i) {
                                    echo 'active';
                                } ?>">
                                    <a href="<?php echo $paginationUrl . "pageno=" . $i; ?>"
                                        class="page-link"><?php echo $i; ?></a>
                                </li>
                            <?php } ?>

                            <li class="page-item <?php if ($pageno >= $total_pages) {
                                echo 'disabled';
                            } ?>">
                                <a href="<?php if ($pageno >= $total_pages) {
                                    echo '#';
                                } else {
                                    echo $paginationUrl . "pageno=" . ($pageno + 1);
                                } ?> " class="page-link">Next</a>
                            </li>
                        </ul>
                    </div>
                <?php endif; ?>
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