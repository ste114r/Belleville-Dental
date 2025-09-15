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

        h1, h2, h3, h4, h5, h6 {
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
            height: 95%;
            background: white;
            margin-bottom: 25px;
            overflow: hidden;
            border: 1px solid rgba(0,0,0,0.08);
        }

        .product-card:hover {
            transform: translateY(-5px);
        }

        .product-image {
            height: 210px;
            object-fit: cover;
        }

        .category-badge {
            background-color: var(--primary);
            color: white;
            font-size: 0.8rem;
            padding: 4px 10px;
            border-radius: 4px;
            display: inline-block;
            margin-bottom: 10px;
        }

        .card-body-inner {
            padding: 20px 20px;
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

        .sidebar-card {
            border: none;
            border-radius: 8px;
            background: white;
            margin-bottom: 25px;
            overflow: hidden;
            border: 1px solid rgba(0,0,0,0.08);
        }
        
        .sidebar-header {
            background-color: var(--light-blue);
            padding: 12px 15px;
            border-bottom: 1px solid rgba(0,0,0,0.08);
        }
        
        .category-list {
            padding: 0;
            margin: 0;
        }
        
        .category-list li {
            padding: 8px 15px;
            border-bottom: 1px solid rgba(0,0,0,0.05);
            list-style: none;
        }
        
        .category-list li:last-child {
            border-bottom: none;
        }
        
        .category-list a {
            color: var(--dark);
            text-decoration: none;
            transition: all 0.2s ease;
            display: block;
        }
        
        .category-list a:hover {
            color: var(--primary);
            padding-left: 5px;
        }

        .btn-primary {
            background: var(--primary);
            border: none;
            border-radius: 4px;
            padding: 8px 20px;
            font-weight: 500;
            transition: all 0.2s ease;
            font-size: 0.9rem;
        }

        .btn-primary:hover {
            background: var(--primary-dark);
        }

        .pagination .page-link {
            border: none;
            color: var(--primary);
            border-radius: 4px;
            margin: 0 3px;
        }
        
        .pagination .page-item.active .page-link {
            background-color: var(--primary);
            border-color: var(--primary);
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
        <div class="row" style="margin-top: 4%">
            <!-- Categories Column -->
            <div class="col-md-2 mt-4">
                <div class="sidebar-card">
                    <div class="sidebar-header">
                        <h5 class="mb-0">Categories</h5>
                    </div>
                    <div class="card-body p-0">
                        <ul class="category-list">
                            <?php $query = mysqli_query($con, "select pcategory_id,name from PRODUCT_CATEGORIES WHERE is_active = 1");
                            while ($row = mysqli_fetch_array($query)) {
                            ?>
                                <li>
                                    <a href="category.php?catid=<?php echo htmlentities($row['pcategory_id']) ?>"><?php echo htmlentities($row['name']); ?></a>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Main Content Column -->
            <div class="col-md-7">
                <h4 class="section-title">Our <span>Recommendations</span></h4>

                <div class="row">
                    <?php
                    if (isset($_GET['pageno'])) {
                        $pageno = $_GET['pageno'];
                    } else {
                        $pageno = 1;
                    }
                    $no_of_records_per_page = 8;
                    $offset = ($pageno - 1) * $no_of_records_per_page;

                    $total_pages_sql = "SELECT COUNT(*) FROM PRODUCTS";
                    $result = mysqli_query($con, $total_pages_sql);
                    if (!$result) {
                        echo "SQL Error: " . mysqli_error($conn);
                    }

                    $total_rows = mysqli_fetch_array($result)[0];
                    $total_pages = ceil($total_rows / $no_of_records_per_page);

                    $query = mysqli_query($con, "
                        SELECT 
                            PRODUCTS.product_id AS pid,
                            PRODUCTS.name AS posttitle,
                            PRODUCTS.image_url AS PostImage,
                            PRODUCT_CATEGORIES.name AS category,
                            PRODUCT_CATEGORIES.pcategory_id AS cid,
                            PRODUCTS.description AS postdetails,
                            PRODUCTS.created_at AS postingdate,
                            PRODUCTS.slug AS url
                        FROM PRODUCTS
                        LEFT JOIN PRODUCT_CATEGORIES 
                            ON PRODUCT_CATEGORIES.pcategory_id = PRODUCTS.pcategory_id
                        WHERE PRODUCTS.is_active = 1
                        ORDER BY PRODUCTS.product_id DESC
                        LIMIT $offset, $no_of_records_per_page
                        ");
                    while ($row = mysqli_fetch_array($query)) {
                    ?>
                        <div class="col-md-5">
                            <div class="product-card">
                                <img class="product-image w-100" src="images/<?php echo htmlentities($row['PostImage']); ?>" alt="<?php echo htmlentities($row['posttitle']); ?>">
                                <div class="card-body">
                                    <div class="card-body-inner">
                                        <span class="category-badge"><?php echo htmlentities($row['category']); ?></span>
                                        <a href="product-details.php?nid=<?php echo htmlentities($row['pid']) ?>" class="text-decoration-none text-dark">
                                            <h5 class="card-title mt-2"><?php echo htmlentities($row['posttitle']); ?></h5>
                                        </a>
                                        <div class="text-center mt-3">
                                            <a href="product-details.php?nid=<?php echo htmlentities($row['pid']) ?>" class="btn btn-primary">Learn More</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                    
                    <!-- Pagination -->
                    <div class="col-md-12">
                        <ul class="pagination justify-content-center mb-4">
                            <li class="page-item <?php if ($pageno <= 1) { echo 'disabled'; } ?>">
                                <a href="<?php if ($pageno <= 1) { echo '#'; } else { echo "?pageno=" . ($pageno - 1); } ?>" class="page-link">Prev</a>
                            </li>
                            <li class="page-item <?php if ($pageno >= $total_pages) { echo 'disabled'; } ?>">
                                <a href="<?php if ($pageno >= $total_pages) { echo '#'; } else { echo "?pageno=" . ($pageno + 1); } ?> " class="page-link">Next</a>
                            </li>
                        </ul>
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
                    <p>We select products with proven effectiveness based on scientific research and clinical studies.</p>
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
            <p class="mb-3">Our dental professionals can provide personalized recommendations based on your specific needs.</p>
            <a href="contact-us.php" class="btn btn-primary">Contact Us for Advice</a>
        </div>
    </div>

    <?php include('includes/footer.php'); ?>

    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>

</html>