<?php 
include 'components/connection.php';
$query = "SELECT * FROM items LIMIT 12"; // Adjust the query based on your table structure and needs
$result = $conn->query($query);
$cakes = $result->fetchAll(PDO::FETCH_ASSOC);
?>


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
        <?php include 'components/banner.php'?>

        
        <div class="index-content">
            <div class="row">
                <div class="col-lg-6">
                    <h2>About us ___</h2>
                    <p class="about-text">We provide you a trustworthy and convenient platform to choose best gift for your family, friends etc. 
                    for every occasion like birthdays, anniversaries, marriage, love, farewell and many more. 
                    We offer wide range of products in various categories like cakes, egg-less cakes, drawing cakes, 3D cakes, photo cakes, 
                    collectibles, chocolates, bouquet, flowers bunch, soft toys, greeting cards, candles, photo frames, handicrafts etc. 
                    We also customize gifts according to customer wish.</p>
                </div>
                <div class="col-lg-6">
                    <div class="img_about mt-3">
                        <img src="../Admin/item-images/bakery1.jpg" alt="" class="img-fluid mx-auto d-block" width="450px">
                    </div>
                </div>
            </div><br><br><br>
            <hr>
            <br><br>
            <div class="row">
            <div class="col">
                <h2>Our Featured Cakes ___</h2>
                <div id="featuredCakesCarousel" class="carousel slide" data-ride="carousel" data-interval="3000">
                    <div class="carousel-inner">
                    <?php
                        $isActive = true; // To set the first item as active
                        $chunks = array_chunk($cakes, 4); // Divide items into chunks of 4
                        foreach ($chunks as $index => $chunk):
                            ?>
                            <div class="carousel-item <?php echo $isActive ? 'active' : ''; ?>">
                                <div class="d-flex justify-content-between">
                                    <?php foreach ($chunk as $cake): ?>
                                        <div class="card card-class">
                                            <img src="../Admin/item-images/<?php echo htmlspecialchars($cake['item_img']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($cake['item_name']); ?>">
                                            <div class="card-body">
                                                <h5 class="card-title"><?php echo htmlspecialchars($cake['item_name']); ?></h5>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                            <?php
                            $isActive = false; // Only the first item should have 'active' class
                        endforeach;
                        ?>
                    </div>
                    <a class="carousel-control-prev" href="#featuredCakesCarousel" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#featuredCakesCarousel" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>
            </div>
        </div>
        <?php include 'components/footer.php'?>
    </body>

</html>