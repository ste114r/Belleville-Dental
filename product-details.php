<?php
session_name('client_session');
session_start();
include('includes/config.php');

// Handle Feedback Submission (Rating and/or Comment)
if (isset($_POST['submit_feedback'])) {
    $alert_messages = []; // Array to hold messages for the alert box.

    // Check if user is logged in
    if (isset($_SESSION['login']) && !empty($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
        $product_id = intval($_POST['product_id']);
        $comment = isset($_POST['comment']) ? trim($_POST['comment']) : '';
        $rating = isset($_POST['rating']) ? intval($_POST['rating']) : 0;

        $form_had_input = false; // Flag to check if the user submitted any data

        // Handle Rating Submission
        if ($rating >= 1 && $rating <= 5) {
            $form_had_input = true;
            // Check if the user has already rated this product
            $stmt_check_rating = mysqli_prepare($con, "SELECT rating_id FROM PRODUCT_RATINGS WHERE user_id = ? AND product_id = ?");
            mysqli_stmt_bind_param($stmt_check_rating, "ii", $user_id, $product_id);
            mysqli_stmt_execute($stmt_check_rating);
            mysqli_stmt_store_result($stmt_check_rating);

            if (mysqli_stmt_num_rows($stmt_check_rating) == 0) {
                // Insert the new rating
                $stmt_rate = mysqli_prepare($con, "INSERT INTO PRODUCT_RATINGS (product_id, user_id, rating) VALUES (?, ?, ?)");
                mysqli_stmt_bind_param($stmt_rate, "iii", $product_id, $user_id, $rating);
                if (mysqli_stmt_execute($stmt_rate)) {
                    $alert_messages[] = "Your rating has been submitted successfully.";
                } else {
                    $alert_messages[] = "Error: Could not submit your rating.";
                }
                mysqli_stmt_close($stmt_rate);
            } else {
                $alert_messages[] = "You have already rated this product.";
            }
            mysqli_stmt_close($stmt_check_rating);
        }

        // Handle Comment Submission
        if (!empty($comment)) {
            $form_had_input = true;
            // Check if user has already commented
            $stmt_check = mysqli_prepare($con, "SELECT comment_id FROM PRODUCT_COMMENTS WHERE user_id = ? AND product_id = ?");
            mysqli_stmt_bind_param($stmt_check, "ii", $user_id, $product_id);
            mysqli_stmt_execute($stmt_check);
            mysqli_stmt_store_result($stmt_check);

            if (mysqli_stmt_num_rows($stmt_check) == 0) {
                // Insert the new comment
                $stmt_insert = mysqli_prepare($con, "INSERT INTO PRODUCT_COMMENTS (product_id, user_id, comment, status) VALUES (?, ?, ?, 'pending')");
                mysqli_stmt_bind_param($stmt_insert, "iis", $product_id, $user_id, $comment);
                if (mysqli_stmt_execute($stmt_insert)) {
                    $alert_messages[] = "Your comment has been submitted and is awaiting approval.";
                } else {
                    $alert_messages[] = "Error: Could not submit your comment.";
                }
                mysqli_stmt_close($stmt_insert);
            } else {
                $alert_messages[] = "You have already submitted a comment for this product.";
            }
            mysqli_stmt_close($stmt_check);
        }
        
        // If the form was submitted but contained no actual data
        if (!$form_had_input && empty($comment) && $rating == 0) {
            $alert_messages[] = "Please provide a rating or a comment to submit.";
        }

    } else {
        $alert_messages[] = "You must be logged in to submit feedback.";
    }

    // After processing, check if there are any messages to display
    if (!empty($alert_messages)) {
        // Combine messages with a newline character for the alert box
        $final_message = implode('\\n', $alert_messages); 
        // Sanitize the message for use in JavaScript
        $sanitized_message = addslashes($final_message);

        // Echo the JavaScript to show the alert and then redirect
        echo "<script>
                alert('{$sanitized_message}');
                window.location.href = '{$_SERVER['REQUEST_URI']}';
              </script>";
        exit(); // Stop script execution to prevent the rest of the page from loading
    } else {
        // Fallback: If form was submitted but no message was generated, just redirect
        header("Location: " . $_SERVER['REQUEST_URI']);
        exit();
    }
}


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
            margin-top: 10px;
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

        /* --- STYLES FOR COMMENT & RATING SECTION --- */
        .comments-section {
            background: white;
            padding: 30px;
            margin-top: 40px;
            border-radius: 12px;
            border: 1px solid rgba(0, 0, 0, 0.08);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        .comment-card {
            background: var(--secondary);
            border: 1px solid #e9ecef;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 15px;
        }

        .comment-author {
            font-weight: 600;
            color: var(--primary-dark);
        }

        .comment-date {
            font-size: 0.85rem;
            color: var(--gray);
        }

        .comment-text {
            color: var(--dark);
            line-height: 1.6;
        }
        
        .no-comments {
            text-align: center;
            padding: 20px;
            color: var(--gray);
            border: 1px dashed var(--gray);
            border-radius: 8px;
            background-color: var(--secondary);
        }

        .guest-comment-lock {
            border: 1px dashed var(--gray);
            border-radius: 8px;
            background-color: var(--secondary);
            padding: 20px;
            text-align: center;
        }
        
        .average-rating-display {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }
        .average-rating-display .stars {
            color: #ffc107;
            margin-right: 10px;
            font-size: 1.2rem;
        }
        .average-rating-display .stars .far {
            color: #ddd;
        }
        .average-rating-display .rating-count {
            color: var(--gray);
            font-size: 0.95rem;
        }
        
        .rating-stars {
            display: inline-block;
        }
        .rating-stars input[type="radio"] {
            display: none;
        }
        .rating-stars > label {
            font-size: 2rem;
            color: #ddd;
            float: right;
            cursor: pointer;
            transition: color 0.2s;
            margin: 0 2px;
        }
        .rating-stars > label:before {
            content: '\f005';
            font-family: 'Font Awesome 6 Free';
            font-weight: 900;
        }
        .rating-stars > input:checked ~ label,
        .rating-stars:not(:checked) > label:hover,
        .rating-stars:not(:checked) > label:hover ~ label {
            color: #ffc107;
        }
        /* New styles for disabled state */
        .rating-stars input[type="radio"]:disabled ~ label {
            cursor: not-allowed;
        }
        .rating-stars input[type="radio"]:disabled:not(:checked) ~ label:hover,
        .rating-stars input[type="radio"]:disabled:not(:checked) ~ label:hover ~ label {
            color: #ddd !important;
        }
        .rating-stars > input:disabled:checked ~ label {
            color: #ffc107 !important;
            opacity: 0.6;
        }
    </style>
</head>

<body>
    <?php include('includes/header.php'); ?>

    <div class="container-fluid product-container">
        <div class="row" style="margin-top: 4%;">
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
                                                JOIN PRODUCT_CATEGORIES pc ON p.pcategory_id = pc.pcategory_id
                                                WHERE p.product_id = ? AND p.is_active = 1");
                mysqli_stmt_bind_param($stmt, "i", $productid);
                mysqli_stmt_execute($stmt);
                $query = mysqli_stmt_get_result($stmt);

                $rowcount = mysqli_num_rows($query);
                if ($rowcount == 0) {
                    echo "<h3>Product not found or is no longer available.</h3>";
                } else {
                    // Get Average Rating
                    // $rating_stmt = mysqli_prepare($con, "SELECT COUNT(rating_id) as rating_count, AVG(rating) as avg_rating FROM PRODUCT_RATINGS WHERE product_id = ?");
                    // mysqli_stmt_bind_param($rating_stmt, "i", $productid);
                    // mysqli_stmt_execute($rating_stmt);
                    // $rating_result = mysqli_stmt_get_result($rating_stmt);
                    // $rating_data = mysqli_fetch_assoc($rating_result);
                    // $avg_rating = round($rating_data['avg_rating'] ?? 0, 1);
                    // $rating_count = $rating_data['rating_count'] ?? 0;
                    // mysqli_stmt_close($rating_stmt);

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
                                <a href="http://www.facebook.com/share.php?u=<?php echo $currenturl; ?>" target="_blank" title="Share on Facebook"><i class="fab fa-facebook-f"></i></a>
                                <a href="https://twitter.com/share?url=<?php echo $currenturl; ?>" target="_blank" title="Share on Twitter"><i class="fab fa-twitter"></i></a>
                                <a href="https://web.whatsapp.com/send?text=<?php echo $currenturl; ?>" target="_blank" title="Share on WhatsApp"><i class="fab fa-whatsapp"></i></a>
                                <a href="http://www.linkedin.com/shareArticle?mini=true&amp;url=<?php echo $currenturl; ?>" target="_blank" title="Share on LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                            </div>

                            <section class="comments-section">
                                <h4 class="section-title text-center">Ratings & Comments</h4>

                                <?php
                                $comment_stmt = mysqli_prepare($con, "SELECT u.username, pc.comment, pc.created_at, pr.rating 
                                                                        FROM PRODUCT_COMMENTS pc
                                                                        JOIN USERS u ON pc.user_id = u.user_id
                                                                        LEFT JOIN PRODUCT_RATINGS pr ON pc.user_id = pr.user_id AND pc.product_id = pr.product_id
                                                                        WHERE pc.product_id = ? AND pc.status = 'approved'
                                                                        ORDER BY pc.created_at DESC");
                                mysqli_stmt_bind_param($comment_stmt, "i", $productid);
                                mysqli_stmt_execute($comment_stmt);
                                $comment_query = mysqli_stmt_get_result($comment_stmt);
                                $comment_count = mysqli_num_rows($comment_query);

                                if ($comment_count > 0) {
                                    while ($comment_row = mysqli_fetch_array($comment_query)) {
                                ?>
                                <div class="comment-card">
                                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                                        <p class="comment-author mb-0"><i class="fas fa-user-circle mr-2"></i><?php echo htmlentities($comment_row['username']); ?></p>
                                        <p class="comment-date mb-0"><?php echo date('F j, Y', strtotime($comment_row['created_at'])); ?></p>
                                    </div>
                                    <?php if (!empty($comment_row['rating'])): ?>
                                        <div class="user-rating mt-2" style="color: #ffc107; font-size: 0.9rem;">
                                            <?php 
                                            for ($i = 1; $i <= 5; $i++) {
                                                echo $i <= $comment_row['rating'] ? '<i class="fas fa-star"></i>' : '<i class="far fa-star" style="color: #ddd;"></i>';
                                            }
                                            ?>
                                        </div>
                                    <?php endif; ?>
                                    <hr class="my-2">
                                    <p class="comment-text mb-0"><?php echo htmlentities($comment_row['comment']); ?></p>
                                </div>
                                <?php
                                    }
                                } else {
                                    echo "<div class='no-comments'><p class='mb-0'>Be the first to leave a comment!</p></div>";
                                }
                                ?>

                                <div class="comment-form-container mt-4 pt-4 border-top">
                                    <h5 class="text-center mb-3">Leave Your Feedback</h5>
                                    
                                    <?php if (isset($_SESSION['login']) && !empty($_SESSION['user_id'])): 
                                        $user_id_check = $_SESSION['user_id'];

                                        // Check if this user has already commented
                                        $check_comment_stmt = mysqli_prepare($con, "SELECT comment_id FROM PRODUCT_COMMENTS WHERE user_id = ? AND product_id = ?");
                                        mysqli_stmt_bind_param($check_comment_stmt, "ii", $user_id_check, $productid);
                                        mysqli_stmt_execute($check_comment_stmt);
                                        $has_commented = mysqli_stmt_get_result($check_comment_stmt)->num_rows > 0;
                                        mysqli_stmt_close($check_comment_stmt);
                                        
                                        // Check for this user's existing rating
                                        $check_rating_stmt = mysqli_prepare($con, "SELECT rating FROM PRODUCT_RATINGS WHERE user_id = ? AND product_id = ?");
                                        mysqli_stmt_bind_param($check_rating_stmt, "ii", $user_id_check, $productid);
                                        mysqli_stmt_execute($check_rating_stmt);
                                        $user_rating_result = mysqli_stmt_get_result($check_rating_stmt);
                                        $user_rating = mysqli_fetch_assoc($user_rating_result)['rating'] ?? 0;
                                        mysqli_stmt_close($check_rating_stmt);
                                    ?>
                                        <form name="feedback" method="post">
                                            <input type="hidden" name="product_id" value="<?php echo $productid; ?>" />
                                            <div class="form-group text-center">
                                                <label class="font-weight-bold d-block">Your Rating</label>
                                                <div class="rating-stars">
                                                    <input type="radio" id="star5" name="rating" value="5" <?php if ($user_rating == 5) echo 'checked'; ?> <?php if ($user_rating > 0) echo 'disabled'; ?> /><label for="star5" title="5 stars"></label>
                                                    <input type="radio" id="star4" name="rating" value="4" <?php if ($user_rating == 4) echo 'checked'; ?> <?php if ($user_rating > 0) echo 'disabled'; ?> /><label for="star4" title="4 stars"></label>
                                                    <input type="radio" id="star3" name="rating" value="3" <?php if ($user_rating == 3) echo 'checked'; ?> <?php if ($user_rating > 0) echo 'disabled'; ?> /><label for="star3" title="3 stars"></label>
                                                    <input type="radio" id="star2" name="rating" value="2" <?php if ($user_rating == 2) echo 'checked'; ?> <?php if ($user_rating > 0) echo 'disabled'; ?> /><label for="star2" title="2 stars"></label>
                                                    <input type="radio" id="star1" name="rating" value="1" <?php if ($user_rating == 1) echo 'checked'; ?> <?php if ($user_rating > 0) echo 'disabled'; ?> /><label for="star1" title="1 star"></label>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="font-weight-bold">Your Comment</label>
                                                <?php if($has_commented): ?>
                                                    <div class="alert alert-light text-center p-2">Your comment is being reviewed or has been posted. You cannot submit another.</div>
                                                    <textarea class="form-control" name="comment" rows="3" disabled></textarea>
                                                <?php else: ?>
                                                    <textarea class="form-control" name="comment" rows="4" placeholder="Share your thoughts on this product... (optional)"></textarea>
                                                <?php endif; ?>
                                            </div>
                                            <div class="text-center">
                                                <?php if($has_commented): ?>
                                                    <button type="submit" class="btn btn-primary" name="submit_feedback" disabled>Submit Feedback</button>
                                                <?php else: ?>
                                                    <button type="submit" class="btn btn-primary" name="submit_feedback">Submit Feedback</button>
                                                <?php endif; ?>
                                            </div>
                                        </form>
                                    <?php else: ?>
                                        <div class="guest-comment-lock">
                                            <p class="mt-2 mb-0">You must be logged in to post a rating or comment. <br>
                                            <a href="login.php" class="btn btn-primary btn-sm mt-2">Login</a> or 
                                            <a href="registration.php" class="btn btn-outline-primary btn-sm mt-2">Register</a>
                                            </p>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </section>

                            <section class="recommended-products">
                                <h4 class="section-title">Related Products</h4>
                                <div class="row">
                                    <?php
                                    if ($category_id_for_related > 0) {
                                        $related_stmt = mysqli_prepare($con, "SELECT product_id, name, description, image_url
                                                                                FROM PRODUCTS
                                                                                WHERE pcategory_id = ? AND product_id != ? AND is_active = 1
                                                                                ORDER BY RAND() LIMIT 3");
                                        mysqli_stmt_bind_param($related_stmt, "ii", $category_id_for_related, $productid);
                                        mysqli_stmt_execute($related_stmt);
                                        $related_query = mysqli_stmt_get_result($related_stmt);

                                        if (mysqli_num_rows($related_query) > 0) {
                                            while ($related_row = mysqli_fetch_array($related_query)) {
                                                ?>
                                                <div class="col-md-4">
                                                    <div class="card product-card">
                                                        <img class="card-img-top" src="admin/productimages/<?php echo htmlentities($related_row['image_url']); ?>" alt="<?php echo htmlentities($related_row['name']); ?>">
                                                        <div class="card-body">
                                                            <h5 class="card-title"><?php echo htmlentities($related_row['name']); ?></h5>
                                                            <p class="card-text"><?php echo strip_tags(substr($related_row['description'], 0, 100)); ?>...</p>
                                                            <a href="product-details.php?pid=<?php echo htmlentities($related_row['product_id']); ?>" class="btn btn-outline-primary">View Details</a>
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

                            <div class="contact-cta">
                                <h4>Have Questions About Dental Products?</h4>
                                <p class="mb-3">Our dental professionals can provide personalized recommendations based on your specific needs.</p>
                                <a href="contact-us.php" class="btn btn-primary">Contact Us for Advice</a>
                            </div>
                        </div>
                        <?php
                    }
                }
                ?>
            </div>

            <?php include('includes/sidebar.php'); ?>
        </div>
    </div>

    <?php include('includes/footer.php'); ?>

    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>

</html>