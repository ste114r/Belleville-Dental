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
    <meta name="description" content="Image gallery for Belleville Dental, showcasing images from our articles.">
    <meta name="author" content="">
    <link rel="shortcut icon" href="images/Belleville Dental logo transparent.png" type="image/x-icon">
    <title>Belleville Dental | Gallery</title>

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

        .gallery-hero {
            padding: 50px 0 30px;
            text-align: center;
            background-color: var(--light-blue);
            margin-bottom: 30px;
            margin-top: 25px;
            border-bottom: 1px solid rgba(11, 126, 200, 0.1);
        }
        
        /* Minimal Card Style for Gallery Item */
        .gallery-card {
            border: 1px solid #e9ecef;
            border-radius: 8px;
            transition: all 0.3s ease;
            background: white;
            overflow: hidden;
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .gallery-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
        }

        .gallery-image {
            width: 100%;
            height: 220px;
            object-fit: cover;
        }

        .gallery-card .card-body {
            padding: 15px;
            text-align: center;
            flex-grow: 1; /* Allows title to push to the bottom if needed */
        }
        
        .gallery-card .card-title {
            font-size: 0.95rem;
            margin-bottom: 0;
        }
        
        .gallery-card .card-title a {
            color: var(--dark);
            text-decoration: none;
        }

        .gallery-card .card-title a:hover {
            color: var(--primary);
        }

        .no-results {
            text-align: center;
            padding: 40px;
            background-color: var(--secondary);
            border: 1px dashed var(--gray);
            border-radius: 8px;
            color: var(--gray);
        }

        /* Pagination Styles */
        .pagination .page-link {
            border: none;
            color: var(--primary);
            border-radius: 4px;
            margin: 0 3px;
        }

        .pagination .page-item.active .page-link {
            background-color: var(--primary);
            border-color: var(--primary);
            color: #fff;
        }
    </style>
</head>

<body>
    <?php include('includes/header.php'); ?>

    <div class="gallery-hero">
        <div class="container-fluid">
            <h1 class="display-4 text-primary">Image Gallery</h1>
            <p class="lead">A collection of images from our dental health articles.</p>
        </div>
    </div>

    <div class="container my-5">
        <div class="row">
            <?php
            $pageno = isset($_GET['pageno']) ? (int)$_GET['pageno'] : 1;
            $no_of_records_per_page = 12;
            $offset = ($pageno - 1) * $no_of_records_per_page;

            $total_pages_sql = "SELECT COUNT(*) FROM ARTICLES WHERE is_active = 1 AND cover_image_url IS NOT NULL";
            $result = mysqli_query($con, $total_pages_sql);
            $total_rows = mysqli_fetch_array($result)[0];
            $total_pages = ceil($total_rows / $no_of_records_per_page);

            $stmt = mysqli_prepare($con, "SELECT article_id, title, cover_image_url FROM ARTICLES WHERE is_active = 1 AND cover_image_url IS NOT NULL ORDER BY created_at DESC LIMIT ?, ?");
            mysqli_stmt_bind_param($stmt, "ii", $offset, $no_of_records_per_page);
            mysqli_stmt_execute($stmt);
            $query = mysqli_stmt_get_result($stmt);

            if (mysqli_num_rows($query) == 0) {
                echo "<div class='col-12'><div class='no-results'><p class='mb-0'>No images found in the gallery yet.</p></div></div>";
            } else {
                while ($row = mysqli_fetch_array($query)) {
            ?>
                    <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                        <div class="gallery-card">
                            <a href="news-details.php?nid=<?php echo htmlentities($row['article_id']); ?>">
                                <img class="gallery-image" src="admin/postimages/<?php echo htmlentities($row['cover_image_url']); ?>" alt="<?php echo htmlentities($row['title']); ?>">
                            </a>
                            <div class="card-body">
                                <h6 class="card-title">
                                    <a href="news-details.php?nid=<?php echo htmlentities($row['article_id']); ?>">
                                        <?php echo htmlentities($row['title']); ?>
                                    </a>
                                </h6>
                            </div>
                        </div>
                    </div>
            <?php 
                }
            } 
            mysqli_stmt_close($stmt);
            ?>
        </div>

        <?php if ($total_pages > 1): ?>
            <div class="row">
                <div class="col-md-12 mt-4">
                    <ul class="pagination justify-content-center">
                        <li class="page-item <?php if ($pageno <= 1) echo 'disabled'; ?>">
                            <a href="<?php if ($pageno <= 1) echo '#'; else echo "?pageno=".($pageno - 1); ?>" class="page-link">Prev</a>
                        </li>
                        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                            <li class="page-item <?php if ($pageno == $i) echo 'active'; ?>">
                                <a href="?pageno=<?php echo $i; ?>" class="page-link"><?php echo $i; ?></a>
                            </li>
                        <?php endfor; ?>
                        <li class="page-item <?php if ($pageno >= $total_pages) echo 'disabled'; ?>">
                            <a href="<?php if ($pageno >= $total_pages) echo '#'; else echo "?pageno=".($pageno + 1); ?>" class="page-link">Next</a>
                        </li>
                    </ul>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <?php include('includes/footer.php'); ?>

    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>

</html>