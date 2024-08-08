<?php 
    include 'components/session-init.php';
    include 'components/connection.php';
    // session_start();

    try{
        if(isset($_POST['submit'])) {
            if(!isset($_SESSION['user_id'])){
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
    }catch (PDOException $e) {
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

    <!-- <script type="applijewelleryion/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script> -->
    
    <link href="css/css/bootstrap.css" rel='stylesheet' type='text/css' />
    <link href="css/style.css" rel='stylesheet' type="text/css"/>
    <link href='//fonts.googleapis.com/css?family=Open+Sans:400,700,600' rel='stylesheet' type='text/css'>
    <link href='//fonts.googleapis.com/css?family=Roboto+Condensed:400,700,300' rel='stylesheet' type='text/css'>
    <link href='//fonts.googleapis.com/css?family=Oswald' rel='stylesheet' type='text/css'>
    <link href="css/font-awesome.css" rel="stylesheet">

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    
    <script src="css/js/script.js"></script>
    <!-- Custom Theme files -->
    <!-- <script src="css/js/jquery-1.12.0.min.js"></script> -->
    <script src="css/js/bootstrap.min.js"></script>
    <!--animate-->
    <!-- <link href="css/animate.css" rel="stylesheet" type="text/css" media="all"> -->
    <!-- <script src="js/wow.min.js"></script> -->
        <!-- <script>
            new WOW().init();
        </script> -->
    <!--//end-animate-->
    <!-- icon -->
     <!-- Option 1: Include in HTML -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    </head>
    <body>
        <?php include 'components/header.php'?>
        <?php include 'components/navbar.php'?>
        
        <div class="banner-3">
            <div class="container">
                <p style="font-size: 52px;">Our Cakes</p>
                <h5 class=""> <a href="items.php">Cakes</a>  
                    <span> |</span> <a href="index.php"> Home</a></h5>
            </div>
        </div>

        <!-- main content --><br><br><br><br>

        <div class="row row-cols-3 item-content">
        <?php 
                $item_id=intval($_GET['item_id']);
                $sql = "SELECT items.*, category.cat_name 
                FROM items 
                JOIN category ON items.category_id = category.category_id 
                WHERE items.item_id = :item_id";
                $query = $conn->prepare($sql);
                $query->bindParam(':item_id', $item_id, PDO::PARAM_INT);
                $query->execute();
                $results = $query->fetchAll(PDO::FETCH_OBJ);
                $cnt = 1;
                        if($query->rowCount() > 0){
                        foreach($results as $result)
                        {				?>
                        <?php if ($result->item_img) { ?>
            <div class="col-md-4">
                <img src="../Admin/item-images/<?php echo htmlentities($result->item_img); ?>"  class="card-img-top"  alt="Current Image" style="">
                <?php } ?>	
            </div>

            <div class="col-md-6 product-info">
                <h2><a href="item-details.php"><?php echo htmlentities($result->item_name); ?></a></h2>
                <div class="detail-item">
                    <span class="label">Type of Cake:</span>
                    <p class="detail-item-itext"><?php echo htmlentities($result->cat_name); ?></p>
                </div>
                <div class="detail-item">
                    <span class="label">Price:</span>
                    <p class="detail-item-itext"><?php echo htmlentities($result->price); ?> <span>/-</span></p>
                </div>
                <div class="detail-item">
                    <span class="label">Weight:</span>
                    <p class="detail-item-itext"><?php echo htmlentities($result->weight); ?></p>
                </div>
                <div class="detail-item">
                    <span class="label">Product details:</span>
                    <p class="detail-item-itext"><?php echo htmlentities($result->item_des); ?></p>
                </div>
                <form method="POST" action="">
                    <input type="hidden" name="item_id" value="<?php echo htmlentities($result->item_id); ?>">
                    <button class="btn mb-2 custom-btn" name="submit">Add to Cart</button>
                </form>
            </div>
        </div>
            <?php } }?>
        </div>
        <!-- footer -->
        <?php include 'components/footer.php'?>
    </body>

</html>