<?php
session_name('client_session');
session_start();
error_reporting(0);
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
    <title>Belleville Dental | Search Page</title>
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
        
        .hero-section {
            padding: 50px 0 30px;
            text-align: center;
            background-color: var(--light-blue);
            margin-bottom: 30px;
            border-bottom: 1px solid rgba(11, 126, 200, 0.1);
        }
        
        .article-card {
            border: none;
            border-radius: 8px;
            transition: all 0.2s ease;
            height: 100%;
            background: white;
            margin-bottom: 25px;
            overflow: hidden;
            border: 1px solid rgba(0,0,0,0.08);
        }
        
        .article-card:hover {
            transform: translateY(-5px);
        }
        
        .article-image {
            height: 200px;
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

        .read-more-btn {
            color: var(--primary);
            text-decoration: none;
            font-weight: 600;
            transition: all 0.2s ease;
        }

        .read-more-btn:hover {
            color: var(--primary-dark);
            text-decoration: none;
        }

        .post-date {
            color: var(--gray);
            font-size: 0.9rem;
        }

        .search-info {
            background: var(--light-blue);
            padding: 15px 20px;
            border-radius: 8px;
            margin-bottom: 25px;
            border: 1px solid rgba(11, 126, 200, 0.1);
        }

        .no-results {
            text-align: center;
            padding: 40px 20px;
            background: white;
            border-radius: 8px;
            border: 1px solid rgba(0,0,0,0.08);
        }

        .no-results i {
            font-size: 3rem;
            color: var(--gray);
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <!-- Navigation -->
    <?php include('includes/header.php'); ?>
    
    <?php
    if ($_POST['searchtitle'] != '') {
        $st = $_SESSION['searchtitle'] = $_POST['searchtitle'];
    }
    $searchTerm = isset($_SESSION['searchtitle']) ? $_SESSION['searchtitle'] : '';
    ?>

    <!-- Hero Section -->
    <!-- <div class="hero-section">
        <div class="container-fluid">
            <h1 class="display-4 text-primary">Search Results</h1>
            <p class="lead">Find the dental information you're looking for</p>
        </div>
    </div> -->

    <!-- Page Content -->
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
                            <?php $query = mysqli_query($con, "select category_id,name from ARTICLE_CATEGORIES WHERE is_active = 1");
                            while ($row = mysqli_fetch_array($query)) {
                            ?>
                                <li>
                                    <a href="category.php?catid=<?php echo htmlentities($row['category_id']) ?>"><?php echo htmlentities($row['name']); ?></a>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Main Content Column -->
            <div class="col-md-7">
                <?php if ($searchTerm): ?>
                    <div class="search-info">
                        <i class="fa fa-search me-2"></i>
                        <strong>Search results for:</strong> "<?php echo htmlentities($searchTerm); ?>"
                    </div>
                <?php endif; ?>
                
                <h4 class="section-title">Search <span>Results</span></h4>
                
                <div class="row">
                    <?php
                    if (isset($_GET['pageno'])) {
                        $pageno = $_GET['pageno'];
                    } else {
                        $pageno = 1;
                    }
                    $no_of_records_per_page = 8;
                    $offset = ($pageno - 1) * $no_of_records_per_page;
                    
                    $st = isset($_SESSION['searchtitle']) ? $_SESSION['searchtitle'] : '';
                    $total_pages_sql = "SELECT COUNT(*) FROM ARTICLES WHERE title LIKE '%$st%' AND is_active = 1";
                    $result = mysqli_query($con, $total_pages_sql);
                    $total_rows = mysqli_fetch_array($result)[0];
                    $total_pages = ceil($total_rows / $no_of_records_per_page);

                    $query = mysqli_query($con, "SELECT 
                        ARTICLES.article_id AS pid,
                        ARTICLES.title AS posttitle,
                        ARTICLE_CATEGORIES.name AS category,
                        ARTICLES.content AS postdetails,
                        ARTICLES.created_at AS postingdate,
                        ARTICLES.slug AS url,
                        ARTICLES.cover_image_url
                    FROM 
                        ARTICLES
                    LEFT JOIN 
                        ARTICLE_CATEGORIES ON ARTICLE_CATEGORIES.category_id = ARTICLES.category_id
                    WHERE 
                        ARTICLES.title LIKE '%$st%'
                        AND ARTICLES.is_active = 1
                    ORDER BY ARTICLES.article_id DESC
                    LIMIT 
                        $offset, $no_of_records_per_page;");
                    $rowcount = mysqli_num_rows($query);
                    if ($rowcount == 0) {
                        ?>
                        <div class="col-12">
                            <div class="no-results">
                                <i class="fa fa-search"></i>
                                <h4>No results found</h4>
                                <p class="text-muted">Sorry, we couldn't find any articles matching your search term "<?php echo htmlentities($searchTerm); ?>"</p>
                                <p><small>Try using different keywords or browse our categories.</small></p>
                            </div>
                        </div>
                        <?php
                    } else {
                        while ($row = mysqli_fetch_array($query)) {
                        ?>
                            <div class="col-md-6">
                                <div class="article-card">
                                    <img class="article-image w-100" src="admin/postimages/<?php echo htmlentities($row['cover_image_url']); ?>" alt="<?php echo htmlentities($row['posttitle']); ?>">
                                    <div class="card-body">
                                        <span class="category-badge"><?php echo htmlentities($row['category']); ?></span>
                                        <p class="post-date m-0"><small>Posted on <?php echo htmlentities($row['postingdate']); ?></small></p>
                                        <a href="news-details.php?nid=<?php echo htmlentities($row['pid']) ?>" class="text-decoration-none text-dark">
                                            <h5 class="card-title mt-2"><?php echo htmlentities($row['posttitle']); ?></h5>
                                        </a>
                                        <a href="news-details.php?nid=<?php echo htmlentities($row['pid']) ?>" class="read-more-btn">Read More &rarr;</a>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>

                        <!-- Pagination -->
                        <div class="col-md-12">
                            <ul class="pagination justify-content-center mb-4">
                                <li class="page-item"><a href="?pageno=1" class="page-link">First</a></li>
                                <li class="page-item <?php if ($pageno <= 1) { echo 'disabled'; } ?>">
                                    <a href="<?php if ($pageno <= 1) { echo '#'; } else { echo "?pageno=" . ($pageno - 1); } ?>" class="page-link">Prev</a>
                                </li>
                                <li class="page-item <?php if ($pageno >= $total_pages) { echo 'disabled'; } ?>">
                                    <a href="<?php if ($pageno >= $total_pages) { echo '#'; } else { echo "?pageno=" . ($pageno + 1); } ?>" class="page-link">Next</a>
                                </li>
                                <li class="page-item"><a href="?pageno=<?php echo $total_pages; ?>" class="page-link">Last</a></li>
                            </ul>
                        </div>
                    <?php } ?>
                </div>
            </div>

            <!-- Sidebar Widgets Column -->
            <?php include('includes/sidebar.php'); ?>
        </div>
    </div>

    <!-- Footer -->
    <?php include('includes/footer.php'); ?>

    <script src="js/foot.js"></script>
    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>

</html>