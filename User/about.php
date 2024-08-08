<?php 
    include 'components/session-init.php';
    include 'components/connection.php';

    try {
        // Check if user is logged in

        
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
                <p style="font-size: 52px;">About Us</p>
                <h5 class=""> <a href="about.php">About us</a>  
                    <span> |</span> <a href="index.php"> Home</a></h5>
            </div>
        </div>

        <!-- main content --><br><br><br>
        <div class="about-content">
            <div class="row">
                <div class="col">
                    <div class="row">
                        <div class="col">
                            <h2>About Us</h2>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <p class="about">We provide you a trustworthy and convenient platform to choose best gife for your family, firneds, etc.
                                Your online destination for delicious, handcrafted cakes baked with love. 
                                Whether it's a birthday, anniversary, or any celebration, our wide range of cakes are freshly made to sweeten your special moments.</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="img_about mt-3">
                                <img src="../Admin/item-images/douglas.jpg" alt="" class="img-fluid mx-auto d-block">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="img_about mt-3">
                                <img src="../Admin/item-images/image1.jpg" alt="" class="img-fluid mx-auto d-block">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="img_about mt-3">
                                <img src="../Admin/item-images/cupcake2.jpg" alt="" class="img-fluid mx-auto d-block">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!-- footer -->
        <?php include 'components/footer.php'?>
    </body>

</html>