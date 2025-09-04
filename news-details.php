<?php
session_start();
include('includes/config.php');
//Genrating CSRF Token
// if (empty($_SESSION['token'])) {
//     $_SESSION['token'] = bin2hex(random_bytes(32));
// }

// if (isset($_POST['submit'])) {
//     //Verifying CSRF Token
//     if (!empty($_POST['csrftoken'])) {
//         if (hash_equals($_SESSION['token'], $_POST['csrftoken'])) {
//             $name = $_POST['name'];
//             $email = $_POST['email'];
//             $comment = $_POST['comment'];
//             $postid = intval($_GET['nid']);
//             $st1 = '0';
//             $query = mysqli_query($con, "insert into tblcomments(postId,name,email,comment,status) values('$postid','$name','$email','$comment','$st1')");
//             if ($query):
//                 echo "<script>alert('comment successfully submit. Comment will be display after admin review ');</script>";
//                 unset($_SESSION['token']);
//             else :
//                 echo "<script>alert('Something went wrong. Please try again.');</script>";

//             endif;
//         }
//     }
// }

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
</head>

<body>
    <!-- Navigation -->
    <?php include('includes/header.php'); ?>
    <!-- Page Content -->
    <div class="container-fluid">
        <div class="row" style="margin-top: 4%">
            <!-- Blog Entries Column -->
            <div class="col-md-9 mt-5">
                <!-- Blog Post -->
                <?php
                $pid = intval($_GET['nid']);
                $currenturl = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];;
                $query = mysqli_query($con, "select ARTICLES.title as posttitle,ARTICLES.cover_image_url as PostImage,ARTICLE_CATEGORIES.name as category,ARTICLE_CATEGORIES.category_id as cid,ARTICLES.content as postdetails,ARTICLES.created_at as postingdate,ARTICLES.slug as url,ARTICLES.author as postedBy,ARTICLES.updated_at from ARTICLES left join ARTICLE_CATEGORIES on ARTICLE_CATEGORIES.category_id=ARTICLES.category_id where ARTICLES.article_id='$pid'");
                while ($row = mysqli_fetch_array($query)) {
                ?>
                    <div class="card border-0">
                        <div class="card-body">
                            <a class="badge bg-success text-decoration-none link-light" href="category.php?catid=<?php echo htmlentities($row['cid']) ?>" style="color:#fff"><?php echo htmlentities($row['category']); ?></a>
                            <h1 class="card-title"><?php echo htmlentities($row['posttitle']); ?></h1>
                            <!--category-->
                            <p>
                                by <?php echo htmlentities($row['postedBy']); ?> on | <?php echo htmlentities($row['postingdate']); ?>
                                <!-- <?php if ($row['lastUpdatedBy'] != ''): ?>
                                    Last Updated at <?php echo htmlentities($row['UpdationDate']); ?>
                                <?php endif; ?> -->
                            </p>                                    
                        <p><strong>Share:</strong> <a href="http://www.facebook.com/share.php?u=<?php echo $currenturl; ?>" target="_blank">Facebook</a> |
                            <a href="https://twitter.com/share?url=<?php echo $currenturl; ?>" target="_blank">Twitter</a> |
                            <a href="https://web.whatsapp.com/send?text=<?php echo $currenturl; ?>" target="_blank">Whatsapp</a> |
                            <a href="http://www.linkedin.com/shareArticle?mini=true&amp;url=<?php echo $currenturl; ?>" target="_blank">Linkedin</a> <b>Visits:</b> <?php print $visits; ?>
                        </p>
                        <hr>
                        <img class="img-fluid w-100" src="admin/postimages/<?php echo htmlentities($row['PostImage']); ?>" alt="<?php echo htmlentities($row['posttitle']); ?>">
                        <p class="card-text"><?php
                                                $pt = $row['postdetails'];
                                                echo (substr($pt, 0)); ?></p>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <!-- Sidebar Widgets Column -->
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