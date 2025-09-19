<div class="col-md-3">
    <!-- Search Widget -->
    <div class="sidebar-card mb-4">
        <div class="sidebar-header">
            <h5 class="mb-0">Search Articles</h5>
        </div>
        <div class="card-body">
            <form name="search" action="search.php" method="post">
                <div class="input-group">
                    <input type="text" name="searchtitle" class="form-control" placeholder="Search for..." required>
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit"><i class="fa fa-search"></i></button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Recent News Widget -->
    <div class="sidebar-card mb-4">
        <div class="sidebar-header">
            <h5 class="mb-0">Recent Articles</h5>
        </div>
        <div class="card-body">
            <ul class="list-unstyled mb-0">
                <?php
                $query = mysqli_query($con, "SELECT ARTICLES.article_id AS pid, ARTICLES.cover_image_url AS PostImage, ARTICLES.title AS posttitle FROM ARTICLES LEFT JOIN ARTICLE_CATEGORIES ON ARTICLE_CATEGORIES.category_id = ARTICLES.category_id WHERE ARTICLES.is_active = 1 ORDER BY ARTICLES.created_at DESC LIMIT 5");
                while ($row = mysqli_fetch_array($query)) {
                    ?>
                    <li class="media mb-3">
                        <img class="mr-3 rounded" src="images/<?php echo htmlentities($row['PostImage']); ?>"
                            alt="<?php echo htmlentities($row['posttitle']); ?>" width="50" height="50">
                        <div class="media-body">
                            <a href="news-details.php?nid=<?php echo htmlentities($row['pid']) ?>"
                                class="text-dark small"><?php echo htmlentities(substr($row['posttitle'], 0, 40)); ?>...</a>
                        </div>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </div>

    <!-- Most Popular News Widget -->
    <div class="sidebar-card mb-4">
        <div class="sidebar-header">
            <h5 class="mb-0">Most Popular</h5>
        </div>
        <div class="card-body">
            <ul class="list-unstyled mb-0">
                <?php
                $query1 = mysqli_query($con, "SELECT ARTICLES.article_id AS pid, ARTICLES.cover_image_url AS PostImage, ARTICLES.title AS posttitle FROM ARTICLES LEFT JOIN ARTICLE_CATEGORIES ON ARTICLE_CATEGORIES.category_id=ARTICLES.category_id ORDER BY view_counter DESC LIMIT 5");
                while ($result = mysqli_fetch_array($query1)) {
                    ?>
                    <li class="media mb-3">
                        <img class="mr-3 rounded" src="images/<?php echo htmlentities($result['PostImage']); ?>"
                            alt="<?php echo htmlentities($result['posttitle']); ?>" width="50" height="50">
                        <div class="media-body">
                            <a href="news-details.php?nid=<?php echo htmlentities($result['pid']) ?>"
                                class="text-dark small"><?php echo htmlentities(substr($result['posttitle'], 0, 40)); ?>...</a>
                        </div>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </div>

    <!-- Helpful Videos Widget -->
    <div class="sidebar-card mb-4">
        <div class="sidebar-header">
            <h5 class="mb-0">Helpful Videos</h5>
        </div>
        <div class="card-body p-0">
            <div class="p-3">
                <div class="embed-responsive embed-responsive-16by9">
                    <iframe class="embed-responsive-item rounded"
                        src="https://www.youtube.com/embed/BapR9J86ZZw?si=2ybxPLH019aG5Ytn&amp;controls=0"
                        title="Sample Videos / Dummy Videos For Demo Use" frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                        allowfullscreen></iframe>
                </div>
            </div>
            <div class="p-3 border-top">
                <div class="embed-responsive embed-responsive-16by9">
                    <iframe class="embed-responsive-item rounded"
                        src="https://www.youtube.com/embed/7k3wjTOhYwY?si=oGV6UkQrbdrD9eTL"
                        title="Sample Videos / Dummy Videos For Demo Use" frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                        allowfullscreen></iframe>
                </div>
            </div>
            <div class="p-3 border-top">
                <div class="embed-responsive embed-responsive-16by9">
                    <iframe class="embed-responsive-item rounded"
                        src="https://www.youtube.com/embed/4kXrUXDZKuM?si=2OPjXSnNMUw6N8h2"
                        title="Sample Videos / Dummy Videos For Demo Use" frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                        allowfullscreen></iframe>
                </div>
            </div>
        </div>
    </div>
</div>


<style>
    .sidebar-card {
        font-family: 'Merriweather', serif;
        border: none;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        margin-bottom: 30px;
    }

    .sidebar-header {
        background-color: #f8f9fa;
        border-top-left-radius: 10px;
        border-top-right-radius: 10px;
        padding: 15px 20px;
        border-bottom: 1px solid #eee;
    }

    .sidebar-card .card-body {
        padding: 20px;
    }

    .sidebar-card a {
        text-decoration: none !important;
        color: #333;
        transition: color 0.3s;
    }

    .sidebar-card a:hover {
        text-decoration: none !important;
        color: #17a2b8;
    }

    .sidebar-card .media {
        align-items: center;
    }

    .sidebar-card .media img {
        object-fit: cover;
    }

    .embed-responsive-16by9 {
        position: relative;
        padding-bottom: 56.25%;
        /* 16:9 aspect ratio */
        height: 0;
        overflow: hidden;
    }

    .embed-responsive-16by9 iframe {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        border: 0;
    }
</style>