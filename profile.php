<?php
session_name('client_session');
session_start();
include('includes/config.php');

// 1. Check if the user is logged in. If not, redirect to the login page.
if (!isset($_SESSION['login']) || empty($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// 2. Get the logged-in user's ID from the session.
$user_id = $_SESSION['user_id'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="User profile page to view comments and ratings.">
    <meta name="author" content="">
    <link rel="shortcut icon" href="images/Belleville Dental logo transparent.png" type="image/x-icon">
    <title>Belleville Dental | My Profile</title>

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

        .profile-hero {
            padding: 50px 0 30px;
            text-align: center;
            background-color: var(--light-blue);
            margin-bottom: 30px;
            margin-top: 25px;
            border-bottom: 1px solid rgba(11, 126, 200, 0.1);
        }

        .section-heading {
            margin-bottom: 2rem;
            padding-bottom: 10px;
            border-bottom: 2px solid var(--primary);
            display: inline-block;
        }

        .feedback-card {
            background: white;
            border: 1px solid #e9ecef;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            transition: all 0.2s ease-in-out;
        }

        .feedback-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.08);
        }

        .feedback-card .card-header {
            background-color: var(--secondary);
            font-weight: 600;
            border-bottom: 1px solid #e9ecef;
        }

        .feedback-card .card-header a,
        .feedback-card .card-body a {
            color: var(--primary-dark);
            text-decoration: none;
        }

        .feedback-card .card-header a:hover,
        .feedback-card .card-body a:hover {
            text-decoration: underline;
        }

        .feedback-card .card-text {
            color: #555;
            font-style: italic;
        }

        .badge.bg-warning {
            color: var(--dark) !important;
        }

        .rating-card-body {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        /* .rating-product-image {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 6px;
            border: 1px solid #ddd;
        } */

        .rating-details h5 {
            margin-bottom: 5px;
            font-size: 1.1rem;
        }

        .rating-details h5 a {
            color: var(--dark);
            text-decoration: none;
        }

        .rating-details h5 a:hover {
            color: var(--primary);
        }

        .stars {
            color: #ffc107;
            font-size: 1.2rem;
        }

        .stars .far {
            color: #ddd;
        }

        .no-feedback {
            text-align: center;
            padding: 30px;
            background-color: var(--secondary);
            border: 1px dashed var(--gray);
            border-radius: 8px;
            color: var(--gray);
        }
    </style>
</head>

<body>
    <?php include('includes/header.php'); ?>

    <div class="profile-hero">
        <div class="container">
            <h1 class="display-4 text-primary">User Profile</h1>
            <p class="lead">View your submitted product feedback and favorite articles below.</p>
        </div>
    </div>

    <div class="container my-5">
        <div class="row">
            <div class="col-lg-6">
                <h2 class="section-heading">Comments</h2>
                <?php
                // 3. Fetch all comments for the current user using a prepared statement.
                $stmt_comments = mysqli_prepare($con, "SELECT pc.comment, pc.created_at, pc.status, p.name as ProductName, p.product_id FROM PRODUCT_COMMENTS pc JOIN PRODUCTS p ON pc.product_id = p.product_id WHERE pc.user_id = ? ORDER BY pc.created_at DESC");
                mysqli_stmt_bind_param($stmt_comments, "i", $user_id);
                mysqli_stmt_execute($stmt_comments);
                $comments_result = mysqli_stmt_get_result($stmt_comments);
                $comment_count = mysqli_num_rows($comments_result);

                if ($comment_count > 0) {
                    while ($row = mysqli_fetch_assoc($comments_result)) {
                        ?>
                        <div class="feedback-card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <span>For: <a
                                        href="product-details.php?pid=<?php echo $row['product_id']; ?>"><?php echo htmlentities($row['ProductName']); ?></a></span>
                                <small class="text-muted"><?php echo date('M j, Y', strtotime($row['created_at'])); ?></small>
                            </div>
                            <div class="card-body">
                                <p class="card-text">"<?php echo htmlentities($row['comment']); ?>"</p>
                                <?php if ($row['status'] == 'pending'): ?>
                                    <span class="badge bg-warning">Pending Approval</span>
                                <?php else: ?>
                                    <span class="badge bg-success">Approved</span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php
                    }
                } else {
                    echo "<div class='no-feedback'><p class='mb-0'>You haven't submitted any comments yet.</p></div>";
                }
                mysqli_stmt_close($stmt_comments);
                ?>
            </div>

            <div class="col-lg-6">
                <h2 class="section-heading">Product Ratings</h2>
                <?php
                // 4. Fetch all ratings for the current user using a prepared statement.
                $stmt_ratings = mysqli_prepare($con, "SELECT pr.rating, pr.created_at, p.name as ProductName, p.product_id, p.image_url FROM PRODUCT_RATINGS pr JOIN PRODUCTS p ON pr.product_id = p.product_id WHERE pr.user_id = ? ORDER BY pr.created_at DESC");
                mysqli_stmt_bind_param($stmt_ratings, "i", $user_id);
                mysqli_stmt_execute($stmt_ratings);
                $ratings_result = mysqli_stmt_get_result($stmt_ratings);
                $rating_count = mysqli_num_rows($ratings_result);

                if ($rating_count > 0) {
                    while ($row = mysqli_fetch_assoc($ratings_result)) {
                        ?>
                        <div class="feedback-card">
                            <div class="card-body rating-card-body">
                                <!-- <img src="admin/productimages/<?php echo htmlentities($row['image_url']); ?>"
                                    alt="<?php echo htmlentities($row['ProductName']); ?>" class="rating-product-image"> -->
                                <div class="rating-details w-100">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <h5><a
                                                href="product-details.php?pid=<?php echo $row['product_id']; ?>"><?php echo htmlentities($row['ProductName']); ?></a>
                                        </h5>
                                        <small
                                            class="text-muted flex-shrink-0 ms-2"><?php echo date('M j, Y', strtotime($row['created_at'])); ?></small>
                                    </div>
                                    <div class="stars">
                                        <?php
                                        for ($i = 1; $i <= 5; $i++) {
                                            echo $i <= $row['rating'] ? '<i class="fas fa-star"></i>' : '<i class="far fa-star"></i>';
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                } else {
                    echo "<div class='no-feedback'><p class='mb-0'>You haven't rated any products yet.</p></div>";
                }
                mysqli_stmt_close($stmt_ratings);
                ?>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-12">
                <h2 class="section-heading">Favorited Articles</h2>
                <?php
                // 5. Fetch all favorited articles for the current user.
                $stmt_favorites = mysqli_prepare($con, "SELECT a.article_id, a.title, ufa.created_at FROM USER_FAVORITE_ARTICLES ufa JOIN ARTICLES a ON ufa.article_id = a.article_id WHERE ufa.user_id = ? ORDER BY ufa.created_at DESC");
                mysqli_stmt_bind_param($stmt_favorites, "i", $user_id);
                mysqli_stmt_execute($stmt_favorites);
                $favorites_result = mysqli_stmt_get_result($stmt_favorites);
                $favorite_count = mysqli_num_rows($favorites_result);

                if ($favorite_count > 0) {
                    while ($row = mysqli_fetch_assoc($favorites_result)) {
                        ?>
                        <div class="feedback-card">
                            <div class="card-body d-flex justify-content-between align-items-center">
                                <h5 class="mb-0"><a
                                        href="news-details.php?nid=<?php echo $row['article_id']; ?>"><?php echo htmlentities($row['title']); ?></a>
                                </h5>
                                <small class="text-muted flex-shrink-0 ms-3">
                                    <i class="fas fa-heart text-danger me-1"></i>Favorited on
                                    <?php echo date('M j, Y', strtotime($row['created_at'])); ?>
                                </small>
                            </div>
                        </div>
                        <?php
                    }
                } else {
                    echo "<div class='no-feedback'><p class='mb-0'>You haven't added any articles to your favorites yet.</p></div>";
                }
                mysqli_stmt_close($stmt_favorites);
                ?>
            </div>
        </div>

        <div class="mt-3">
            <a href="change-password.php" class="btn btn-sm btn-outline-primary">
                <i class="fas fa-key me-2"></i>Change Password
            </a>
        </div>


    </div>

    <?php include('includes/footer.php'); ?>

    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>

</html>