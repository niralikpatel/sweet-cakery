<?php 
include 'components/session-init.php';
include 'components/connection.php';

try {
    if (isset($_POST['submit'])) {
        if (!isset($_SESSION['user_id'])) {
            echo "<script>alert('You need to log in to add items to the cart');</script>";
            header("Refresh:0; url=login.php"); // Redirect to login page
        }
        $item_id = $_POST['item_id'];
        $user_id = $_SESSION['user_id']; // Assuming user_id is stored in session

        $insert_query = $conn->prepare("INSERT INTO cart (user_id, item_id) VALUES (:user_id, :item_id)");
        $insert_query->bindParam(':user_id', $user_id);
        $insert_query->bindParam(':item_id', $item_id);
        $insert_query->execute();

        $message[] = 'Item added to cart successfully!';
    }
} catch (PDOException $e) {
    $message[] = ' ' . $e->getMessage();
}
?>
<script>
    let messages = <?php echo json_encode($message); ?>;
    if (Array.isArray(messages) && messages.length > 0) {
        messages.forEach(msg => {
            alert(msg);
        });
    }
</script>
<!DOCTYPE HTML>
<html>
<head>
    <title>Cakery</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <link href="css/css/bootstrap.css" rel='stylesheet' type='text/css' />
    <link href="css/style.css" rel='stylesheet' type="text/css"/>
    <link href='//fonts.googleapis.com/css?family=Open+Sans:400,700,600' rel='stylesheet' type='text/css'>
    <link href='//fonts.googleapis.com/css?family=Roboto+Condensed:400,700,300' rel='stylesheet' type='text/css'>
    <link href='//fonts.googleapis.com/css?family=Oswald' rel='stylesheet' type='text/css'>
    <link href="css/font-awesome.css" rel="stylesheet">

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    
    <script src="css/js/script.js"></script>
    <!-- Custom Theme files -->
    <script src="css/js/bootstrap.min.js"></script>
    <!-- icon -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
</head>
<body>
    <?php include 'components/header.php' ?>
    <?php include 'components/navbar.php' ?>
    
    <div class="banner-3">
        <div class="container">
            <p style="font-size: 52px;">Our Cakes</p>
            <h5><a href="items.php">Cakes</a><span> |</span> <a href="index.php"> Home</a></h5>
        </div>
    </div>

    <!-- Main content -->
    <br><br><br><br>
    
    <div class="row row-cols-3 item-content">
    <div class="row">
        <div class="col">
            <div class="row">
                <div class="col">
                    <h2>Our Cakes ___</h2>
                </div>
            </div><br>
            <div class="row">
                <div class="col">
                <form action="search-results.php" method="GET" class="form-inline mb-3">
    <select name="category_id" class="form-control mr-sm-2">
        <option value="">Select Category</option>
        <?php 
        $categories_query = $conn->prepare("SELECT * FROM category");
        $categories_query->execute();
        $categories = $categories_query->fetchAll(PDO::FETCH_OBJ);

        foreach ($categories as $category) {
            echo '<option value="' . htmlentities($category->category_id) . '">' . htmlentities($category->cat_name) . '</option>';
        }
        ?>
    </select>
    <button type="submit" class="btn custom-btn" name="search-btn">Search</button>
</form>

                    <br>
                    <p class="cake-info">We provide you a trustworthy and convenient platform to choose best gife for your family, firneds, etc.
                                Your online destination for delicious, handcrafted cakes baked with love. 
                                Whether it's a birthday, anniversary, or any celebration, our wide range of cakes are freshly made to sweeten your special moments.</p>
                </div>
            </div>
        </div>
    </div>
        <?php 
        // Pagination logic
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $items_per_page = 8;
        $offset = ($page - 1) * $items_per_page;

        // Fetch the total number of items
        $total_items_query = $conn->prepare("SELECT COUNT(*) FROM items");
        $total_items_query->execute();
        $total_items = $total_items_query->fetchColumn();
        $total_pages = ceil($total_items / $items_per_page);

        // Fetch items for the current page
        $sql = "SELECT * FROM items LIMIT :limit OFFSET :offset";
        $query = $conn->prepare($sql);
        $query->bindParam(':limit', $items_per_page, PDO::PARAM_INT);
        $query->bindParam(':offset', $offset, PDO::PARAM_INT);
        $query->execute();
        $results = $query->fetchAll(PDO::FETCH_OBJ);

        if ($query->rowCount() > 0) {
            foreach ($results as $result) { ?>
                <div class="col-lg-3 col-md-4 col-sm-6 mix">
                    <div class="card">
                        <img src="../Admin/item-images/<?php echo htmlentities($result->item_img); ?>" class="card-img-top" alt="Current Image">
                        <div class="price-tag"><?php echo htmlentities($result->price); ?> <span>/-</span></div>
                        <div class="card-body">
                            <h5 class="card-title text-center"><a href="item-details.php?item_id=<?php echo htmlentities($result->item_id); ?>"><?php echo htmlentities($result->item_name); ?></a></h5>
                            <form method="POST" action="">
                                <input type="hidden" name="item_id" value="<?php echo htmlentities($result->item_id); ?>">
                                <button class="btn mb-2 custom-btn add-to-cart-btn" name="submit" type="submit">Add to Cart</button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php }
        } ?>
    </div>

    <!-- Pagination -->
    <div class="pagination">
        <?php if ($page > 1) { ?>
            <a href="?page=<?php echo $page - 1; ?>">&laquo; Previous</a>
        <?php } ?>

        <?php for ($i = 1; $i <= $total_pages; $i++) { ?>
            <a href="?page=<?php echo $i; ?>" <?php if ($i == $page) echo 'class="active"'; ?>><?php echo $i; ?></a>
        <?php } ?>

        <?php if ($page < $total_pages) { ?>
            <a href="?page=<?php echo $page + 1; ?>">Next &raquo;</a>
        <?php } ?>
    </div>

    <!-- footer -->
    <?php include 'components/footer.php' ?>
</body>
</html>
