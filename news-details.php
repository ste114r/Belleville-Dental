<?php
session_name('client_session');
session_start();
include('includes/config.php');

$postid = intval($_GET['nid']);
$sql = "SELECT view_counter FROM ARTICLES WHERE article_id = '$postid'";
$result = $con->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $visits = $row["view_counter"];
        $sql = "UPDATE ARTICLES SET view_counter = $visits+1 WHERE article_id ='$postid'";
        $con->query($sql);
    }
} else {
    echo "no results";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Belleville Dental | Article Page</title>
    <link rel="shortcut icon" href="images/Belleville Dental logo transparent.png" type="image/x-icon">
    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="css/modern-business.css" rel="stylesheet">
    <link rel="stylesheet" href="css/icons.css">
    <!-- Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&family=Merriweather:wght@400;700&display=swap"
        rel="stylesheet">
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

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-family: 'Merriweather', serif;
            color: var(--dark);
        }

        .article-container {
            padding: 0;
        }

        .article-hero {
            padding: 30px 0 20px;
            text-align: center;
            background-color: var(--light-blue);
            margin-bottom: 20px;
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

        .article-title {
            font-size: 2.2rem;
            margin: 15px 0;
            color: var(--primary);
            line-height: 1.3;
            max-width: 800px;
            margin-left: auto;
            margin-right: auto;
        }

        .article-meta {
            color: var(--gray);
            font-size: 0.9rem;
            margin-bottom: 10px;
        }

        .article-meta i {
            margin-right: 5px;
            color: var(--dark);
        }

        .article-image {
            border-radius: 8px;
            margin: 25px 0;
            border: 1px solid rgba(0, 0, 0, 0.08);
        }

        .share-buttons {
            background: var(--secondary);
            padding: 12px 15px;
            border-radius: 8px;
            margin-bottom: 25px;
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
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: white;
            color: var(--primary);
            margin-right: 8px;
            text-decoration: none;
            font-size: 0.9rem;
            transition: all 0.2s ease;
            border: 1px solid rgba(0, 0, 0, 0.1);
        }

        .share-buttons a:hover {
            background: var(--primary);
            color: white;
        }

        .view-counter {
            margin-left: auto;
            display: flex;
            align-items: center;
            color: var(--gray);
            font-size: 0.85rem;
        }

        .view-counter i {
            margin-right: 6px;
            color: var(--primary);
        }

        .article-content {
            /* font-size: 1.05rem; */
            /* color: #555; */
            line-height: 1.7;
            max-width: 800px;
            margin: 0 auto;
        }

        .article-content p {
            margin-bottom: 1.5rem;
        }

        .article-content h2,
        .article-content h3 {
            margin-top: 2rem;
            margin-bottom: 1rem;
            /* color: var(--primary-dark); */
            padding-bottom: 8px;
            border-bottom: 1px solid rgba(11, 126, 200, 0.2);
        }

        .recommended-products {
            padding: 30px 0;
            margin-top: 40px;
            background-color: var(--light-blue);
            border-radius: 8px;
            text-align: center;
            border: 1px solid rgba(11, 126, 200, 0.2);
        }

        .section-title {
            margin-bottom: 30px;
            padding-bottom: 10px;
            text-align: center;
            position: relative;
        }

        .section-title:after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 60px;
            height: 3px;
            background: var(--primary);
        }

        .product-card {
            border: none;
            border-radius: 8px;
            transition: all 0.2s ease;
            height: 100%;
            background: white;
            margin-bottom: 20px;
            overflow: hidden;
            border: 1px solid rgba(0, 0, 0, 0.08);
        }

        .product-card:hover {
            transform: translateY(-5px);
        }

        .product-image {
            height: 180px;
            object-fit: cover;
        }

        .product-card .card-body {
            padding: 15px;
        }

        .product-card .card-title {
            font-size: 1.05rem;
            margin-bottom: 10px;
            color: var(--dark);
        }

        .product-card .card-text {
            font-size: 0.85rem;
            color: var(--gray);
            margin-bottom: 15px;
        }

        .btn-outline-primary {
            border-color: var(--primary);
            color: var(--primary);
            border-radius: 4px;
            padding: 5px 15px;
            font-size: 0.85rem;
            transition: all 0.2s ease;
        }

        .btn-outline-primary:hover {
            background: var(--primary);
            color: white;
        }

        .contact-cta {
            background: var(--light-blue);
            border-radius: 8px;
            padding: 30px;
            margin: 30px 0;
            text-align: center;
            border: 1px solid rgba(11, 126, 200, 0.2);
        }

        .contact-cta h4 {
            color: white;
            margin-bottom: 15px;
            font-size: 1.5rem;
        }

        .contact-cta p {
            margin-bottom: 20px;
            font-size: 1rem;
            opacity: 0.9;
            max-width: 700px;
            margin-left: auto;
            margin-right: auto;
        }

        .btn-primary {
            background: white;
            color: var(--primary);
            border: none;
            border-radius: 4px;
            padding: 8px 20px;
            font-weight: 500;
            transition: all 0.2s ease;
        }

        .btn-primary:hover {
            background: var(--light);
            color: var(--primary-dark);
        }

        @media (max-width: 768px) {
            .article-title {
                font-size: 1.8rem;
            }

            .share-buttons {
                flex-direction: column;
                align-items: flex-start;
            }

            .share-buttons .share-label {
                margin-bottom: 10px;
            }

            .view-counter {
                margin-left: 0;
                margin-top: 15px;
            }
        }
    </style>
</head>

<body>
    <!-- Navigation -->
    <?php include('includes/header.php'); ?>

    <!-- Page Content -->
    <div class="container-fluid article-container">
        <div class="row" style="margin-top: 4%;">
            <!-- Main Content Column -->
            <div class="col-md-9">
                <?php
                $pid = intval($_GET['nid']);
                $currenturl = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
                $query = mysqli_query($con, "select ARTICLES.title as posttitle,ARTICLES.cover_image_url as PostImage,ARTICLE_CATEGORIES.name as category,ARTICLE_CATEGORIES.category_id as cid,ARTICLES.content as postdetails,ARTICLES.created_at as postingdate,ARTICLES.slug as url,ARTICLES.author as postedBy,ARTICLES.updated_at from ARTICLES left join ARTICLE_CATEGORIES on ARTICLE_CATEGORIES.category_id=ARTICLES.category_id where ARTICLES.article_id='$pid'");
                while ($row = mysqli_fetch_array($query)) {
                    ?>
                    <div class="article-hero">
                        <span class="category-badge"><?php echo htmlentities($row['category']); ?></span>
                        <h1 class="article-title"><?php echo htmlentities($row['posttitle']); ?></h1>
                        <p class="article-meta">
                            <i class="fas fa-user-md"></i> by <?php echo htmlentities($row['postedBy']); ?>
                            <i class="fas fa-calendar-alt ml-3"></i> <?php echo htmlentities($row['postingdate']); ?>
                        </p>
                    </div>

                    <div class="share-buttons">
                        <span class="share-label">Share this article:</span>
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
                        <span class="view-counter">
                            <i class="fas fa-eye"></i> <?php print $visits + 1; ?> views
                        </span>
                    </div>

                    <img class="img-fluid article-image"
                        src="admin/postimages/<?php echo htmlentities($row['PostImage']); ?>"
                        alt="<?php echo htmlentities($row['posttitle']); ?>">

                    <div class="article-content">
                        <?php
                        $pt = $row['postdetails'];
                        echo (substr($pt, 0));
                        ?>
                    </div>

                    <!-- Recommended Products -->
                    <section class="recommended-products">
                        <h4 class="section-title">Recommended Products</h4>
                        <div class="row">
                            <?php
                            // Prepare the query to fetch recommended products based on the current article's category.
                            // This version uses standard spaces to prevent SQL syntax errors.
                            $recommendation_query_sql = "
                                SELECT DISTINCT
                                    p.product_id,
                                    p.name,
                                    p.image_url,
                                    p.description,
                                    m.relevance_score
                                FROM PRODUCTS p
                                JOIN ARTICLE_PRODUCT_CATEGORY_MAPPING m
                                    ON p.pcategory_id = m.product_category_id
                                JOIN ARTICLES a
                                    ON a.category_id = m.article_category_id
                                WHERE a.article_id = ?
                                AND p.is_active = 1
                                ORDER BY m.relevance_score DESC, RAND()
                                LIMIT 3
                            ";

                            $stmt = mysqli_prepare($con, $recommendation_query_sql);

                            // Check if the prepare statement was successful before binding parameters
                            if ($stmt) {
                                mysqli_stmt_bind_param($stmt, "i", $pid); // $pid is the current article ID
                                mysqli_stmt_execute($stmt);
                                $recommendation_query = mysqli_stmt_get_result($stmt);

                                if (mysqli_num_rows($recommendation_query) > 0) {
                                    while ($rec_row = mysqli_fetch_array($recommendation_query)) {
                                ?>
                                        <div class="col-md-4">
                                            <div class="card product-card">
                                                <img src="admin/productimages/<?php echo htmlentities($rec_row['image_url']); ?>" class="card-img-top" alt="<?php echo htmlentities($rec_row['name']); ?>">
                                                <div class="card-body">
                                                    <h5 class="card-title"><?php echo htmlentities($rec_row['name']); ?></h5>
                                                    <p class="card-text"><?php echo strip_tags(substr($rec_row['description'], 0, 80)); ?>...</p>
                                                    <a href="product-details.php?pid=<?php echo htmlentities($rec_row['product_id']); ?>" class="btn btn-outline-primary">View Details</a>
                                                </div>
                                            </div>
                                        </div>
                                <?php
                                    }
                                } else {
                                    echo "<div class='col-12'><p>No recommended products found for this article.</p></div>";
                                }
                                mysqli_stmt_close($stmt);
                            } else {
                                // Optional: Output an error if the query preparation failed for debugging
                                echo "<div class='col-12'><p>Error: Could not prepare the product recommendation query.</p></div>";
                            }
                            ?>
                        </div>
                    </section>

                    <!-- Contact Us Section -->
                    <div class="contact-cta">
                        <h4 class="text-primary">Have Questions About Dental Products?</h4>
                        <p class="mb-3">Our dental professionals can provide personalized recommendations based on your
                            specific
                            needs.</p>
                        <a href="contact-us.php" class="btn btn-primary">Contact Us for Advice</a>
                    </div>
                <?php } ?>
            </div>

            <!-- Sidebar Column -->
            <?php include('includes/sidebar.php'); ?>
        </div>
    </div>

    <?php include('includes/footer.php'); ?>

    <script src="js/foot.js"></script>
    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>

</html>