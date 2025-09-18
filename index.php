<?php
session_start();
include('includes/config.php');

// Initialize the catid variable for articles.
$catid = 0;
if (isset($_GET['catid']) && is_numeric($_GET['catid'])) {
    $catid = intval($_GET['catid']);
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
    <title>Belleville Dental | Home Page</title>
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

        .products-hero,
        .hero-section {
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
            left: 0;
            width: 60px;
            height: 3px;
            background: var(--primary);
        }

        /* Article card styling from 2nd CSS */
        .article-card {
            border: 1px solid #e9ecef;
            border-radius: 8px;
            transition: all 0.3s ease;
            background: white;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            height: 100%;
            text-align: center;
        }

        .article-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
        }

        .article-image {
            width: 100%;
            height: 220px;
            object-fit: cover;
        }

        .join-article-image {
            width: 100%;
            height: 400px;
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
            display: inline-block;
            /* prevents flex from stretching it */
            width: auto;
            /* shrink to fit content */
            max-width: max-content;
            /* ensures it only wraps text length */
        }

        .card-body-inner {
            padding: 20px 20px;
            display: flex;
            flex-direction: column;
            flex-grow: 1;
            align-items: center;
        }

        /* Sidebar + category restored from 1st CSS */
        .sidebar-card {
            border: none;
            border-radius: 8px;
            background: white;
            margin-bottom: 25px;
            overflow: hidden;
            border: 1px solid rgba(0, 0, 0, 0.08);
        }

        .sidebar-header {
            background-color: var(--light-blue);
            padding: 12px 15px;
            border-bottom: 1px solid rgba(0, 0, 0, 0.08);
        }

        .category-list {
            padding: 0;
            margin: 0;
        }

        .category-list li {
            padding: 8px 15px;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
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

        /* Pagination */
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
    </style>


</head>

<body>
    <?php include('includes/header.php'); ?>

    <div class="hero-section">
        <div class="container-fluid">
            <h1 class="display-4 text-primary">Belleville Dental Education</h1>
            <p class="lead">Your trusted resource for dental health information</p>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row" style="margin-top: 4%">
            <div class="col-md-2 mt-4">
                <div class="sidebar-card">
                    <div class="sidebar-header">
                        <h5 class="mb-0">Categories</h5>
                    </div>
                    <div class="card-body p-0">
                        <ul class="category-list">
                            <?php $query = mysqli_query($con, "select category_id,name from ARTICLE_CATEGORIES WHERE is_active = 1");
                            while ($row = mysqli_fetch_array($query)) {
                                ?>
                                <li>
                                    <a
                                        href="category.php?catid=<?php echo htmlentities($row['category_id']) ?>"><?php echo htmlentities($row['name']); ?></a>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-md-7">
                <h4 class="section-title">Today <span>Highlight</span></h4>

                <div class="row">
                    <?php
                    if (isset($_GET['pageno'])) {
                        $pageno = $_GET['pageno'];
                    } else {
                        $pageno = 1;
                    }
                    $no_of_records_per_page = 8;
                    $offset = ($pageno - 1) * $no_of_records_per_page;

                    // Updated query to count records with optional catid filter
                    if ($catid > 0) {
                        $total_pages_sql = "SELECT COUNT(*) FROM ARTICLES WHERE category_id = $catid";
                    } else {
                        $total_pages_sql = "SELECT COUNT(*) FROM ARTICLES";
                    }

                    $result = mysqli_query($con, $total_pages_sql);
                    if (!$result) {
                        echo "SQL Error: " . mysqli_error($con);
                    }

                    $total_rows = mysqli_fetch_array($result)[0];
                    $total_pages = ceil($total_rows / $no_of_records_per_page);

                    // Updated query to fetch articles with optional catid filter
                    $query_select = "
                        SELECT 
                            ARTICLES.article_id AS pid,
                            ARTICLES.title AS posttitle,
                            ARTICLES.cover_image_url AS PostImage,
                            ARTICLE_CATEGORIES.name AS category,
                            ARTICLE_CATEGORIES.category_id AS cid,
                            ARTICLES.content AS postdetails,
                            ARTICLES.created_at AS postingdate,
                            ARTICLES.slug AS url
                        FROM ARTICLES
                        LEFT JOIN ARTICLE_CATEGORIES 
                            ON ARTICLE_CATEGORIES.category_id = ARTICLES.category_id
                        WHERE ARTICLES.is_active = 1
                    ";

                    if ($catid > 0) {
                        $query_select .= " AND ARTICLES.category_id = $catid";
                    }

                    $query_select .= " ORDER BY ARTICLES.article_id DESC
                        LIMIT $offset, $no_of_records_per_page
                    ";

                    $query = mysqli_query($con, $query_select);
                    while ($row = mysqli_fetch_array($query)) {
                        ?>
                        <div class="col-md-6 mb-4">
                            <div class="article-card">
                                <img class="article-image"
                                    src="admin/postimages/<?php echo htmlentities($row['PostImage']); ?>"
                                    alt="<?php echo htmlentities($row['posttitle']); ?>">
                                <div class="card-body">
                                    <div class="card-body-inner">
                                        <span class="category-badge"><?php echo htmlentities($row['category']); ?></span>
                                        <p class="m-0"><small> Posted on
                                                <?php echo htmlentities($row['postingdate']); ?></small></p>
                                        <a href="news-details.php?nid=<?php echo htmlentities($row['pid']) ?>"
                                            class="text-decoration-none text-dark">
                                            <h5 class="card-title mt-2"><?php echo htmlentities($row['posttitle']); ?></h5>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>

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

                    <div class="col-md-12">
                        <div class="article-card text-center">
                            <img class="join-article-image w-100" src="./images/join-us.png" alt="Join Us">
                            <div class="card-body">
                                <div class="card-body-inner">
                                    <a href="login.php" class="text-decoration-none text-dark">
                                        <h5 class="card-title">Join Us!</h5>
                                    </a>
                                    <p class="card-text">Become part of our dental health community</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <?php include('includes/sidebar.php'); ?>
        </div>
    </div>

    <?php include('includes/footer.php'); ?>

    <script src="js/foot.js"></script>
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>

</html>