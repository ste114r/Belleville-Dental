<div class="col-md-3 ">
    <!-- Search Widget -->
    <!-- <h4 class="widget-title mb-5">Don't <span>Miss</span></h4> -->

    <div class="card mb-4 border-0">
        <h5 class="card-header border-0 bg-white">Search</h5>
        <div class="card-body">
            <form name="search" action="search.php" method="post">
                <div class="input-group">
                    <input type="text" name="searchtitle" class="form-control rounded-0" placeholder="Search for..." required>
                    <span class="input-group-btn">
                        <button class="btn btn-secondary rounded-0" type="submit"><i class="fa fa-search"></i></button>
                    </span>
            </form>
        </div>
    </div>
</div>

<!-- <a href="tel:+8801608445456"> -->
    <!-- <img src="images/ads.jpg" class="img-fluid"></a> -->

<!-- Side Widget -->
<div class="card my-4 border-0">
    <h5 class="card-header border-0 bg-white">Recent News</h5>
    <div class="card-body">
        <ul class="mb-0 list-unstyled">
            <?php
            $query = mysqli_query($con, "SELECT ARTICLES.article_id AS pid, ARTICLES.cover_image_url AS PostImage, ARTICLES.title AS posttitle FROM ARTICLES LEFT JOIN ARTICLE_CATEGORIES ON ARTICLE_CATEGORIES.category_id = ARTICLES.category_id WHERE ARTICLES.is_active = 1 LIMIT 8");
            while ($row = mysqli_fetch_array($query)) {

            ?>
                <li class="d-flex mb-2 align-items-center">
                    <img class="mr-2 rounded-circle" src="admin/postimages/<?php echo htmlentities($row['PostImage']); ?>" alt="<?php echo htmlentities($row['posttitle']); ?>" width="50px" height="50px">
                    <a href="news-details.php?nid=<?php echo htmlentities($row['pid']) ?>" class="text-dark font-weight-bold"><?php echo htmlentities($row['posttitle']); ?></a>
                </li>
            <?php } ?>
        </ul>
    </div>
</div>

<!-- Side Widget: Most Popular News (with images) -->
<div class="card my-4 border-0">
    <h5 class="card-header border-0 bg-white">Most Popular News</h5>
    <div class="card-body">
        <ul class="list-unstyled mb-0">
            <?php
            $query1 = mysqli_query($con, "SELECT ARTICLES.article_id AS pid, ARTICLES.cover_image_url AS PostImage, ARTICLES.title AS posttitle FROM ARTICLES LEFT JOIN ARTICLE_CATEGORIES ON ARTICLE_CATEGORIES.category_id=ARTICLES.category_id ORDER BY view_counter DESC LIMIT 10");
            while ($result = mysqli_fetch_array($query1)) {
            ?>
                <li class="d-flex mb-2 align-items-center">
                    <img class="mr-2 rounded" src="admin/postimages/<?php echo htmlentities($result['PostImage']); ?>" alt="<?php echo htmlentities($result['posttitle']); ?>" width="50px" height="50px">
                    <a href="news-details.php?nid=<?php echo htmlentities($result['pid']) ?>" class="text-dark font-weight-bold"><?php echo htmlentities($result['posttitle']); ?></a>
                </li>
            <?php } ?>
        </ul>
    </div>
</div>

<!-- Side Widget: Top Trending Now (titles only) -->
<!-- <div class="card my-4 border-0">
    <h5 class="card-header border-0 bg-white">Top Trending Now</h5>
    <div class="card-body">
        <ul class="mb-0 list-unstyled">
            <?php
            $query = mysqli_query($con, "SELECT ARTICLES.article_id AS pid, ARTICLES.title AS posttitle FROM ARTICLES LEFT JOIN ARTICLE_CATEGORIES ON ARTICLE_CATEGORIES.category_id=ARTICLES.category_id LIMIT 8");
            while ($row = mysqli_fetch_array($query)) {
            ?>
                <li class="mb-2">
                    <a href="news-details.php?nid=<?php echo htmlentities($row['pid']) ?>" class="text-dark font-weight-bold"><?php echo htmlentities($row['posttitle']); ?></a>
                </li>
            <?php } ?>
        </ul>
    </div>
</div> -->

<!-- <a href="tel:+8801608445456"> -->
    <!-- <img src="images/ads.jpg" class="img-fluid"></a> -->

<h5 class="card-header border-0 bg-transparent">Helpful Videos</h5>
<div class="card my-4 border-0">
    <div class="card-body p-2">
        <iframe width="100%" height="180px" class="youtube" src="https://www.youtube.com/embed/BapR9J86ZZw?si=2ybxPLH019aG5Ytn&amp;controls=0" title="Sample Videos / Dummy Videos For Demo Use" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
    </div>
</div>
    
<div class="card my-4 border-0">
    <div class="card-body p-2">
        <iframe width="100%" height="180px" class="youtube" src="https://www.youtube.com/embed/7k3wjTOhYwY?si=oGV6UkQrbdrD9eTL" title="Sample Videos / Dummy Videos For Demo Use" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
    </div>
</div>

<div class="card my-4 border-0">
    <div class="card-body p-2">
        <iframe width="100%" height="180px" class="youtube" src="https://www.youtube.com/embed/4kXrUXDZKuM?si=2OPjXSnNMUw6N8h2" title="Sample Videos / Dummy Videos For Demo Use" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
    </div>
</div>
</div>