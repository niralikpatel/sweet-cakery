<?php 
    include 'components/session-init.php';
    include 'components/connection.php';

    try {
        // Check if user is logged in
        if (!isset($_SESSION['user_id'])) {
            echo "<script>alert('You need to log in to view your orders.');</script>";
            echo "<script>window.location.href='login.php';</script>";
            exit;
        }

        $user_id = $_SESSION['user_id'];

        // Fetch orders for the logged-in user
        $sql = "SELECT * FROM orders WHERE user_id = :user_id ORDER BY order_date DESC";
        $query = $conn->prepare($sql);
        $query->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $query->execute();
        $orders = $query->fetchAll(PDO::FETCH_OBJ);
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
                <p style="font-size: 52px;">My Order</p>
                <h5 class=""> <a href="orders.php">My order</a>  
                    <span> |</span> <a href="index.php"> Home</a></h5>
            </div>
        </div>

        <!-- main content --><br><br><br><br>
        <div>
            <div class="cart-content">
                <table>
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Order date and time</th>
                            <th>Order status</th>
                            <th>View details</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if (count($orders) > 0): ?>
                            <?php foreach ($orders as $order): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($order->order_id); ?></td>
                                    <td><?php echo htmlspecialchars($order->order_date); ?></td>
                                    <td><?php echo htmlspecialchars($order->order_status); ?></td>
                                    <td><a href="order-details.php?order_id=<?php echo htmlspecialchars($order->order_id); ?>" class="btn btn-info">View Details</a></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4">No orders found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- footer -->
        <?php include 'components/footer.php'?>
    </body>

</html>