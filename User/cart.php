<?php 
    include 'components/session-init.php';
    include 'components/connection.php';
    // session_start();

    try{
        if (!isset($_SESSION['user_id'])) {
            echo "<script>alert('You need to log in to view the cart.');</script>";
        }
        
        if (isset($_POST['delete_cart_id'])) {
            $delete_cart_id = $_POST['delete_cart_id'];
            $user_id = $_SESSION['user_id'];

            // Debugging output
            // echo "Cart ID: " . htmlspecialchars($delete_cart_id) . "<br>";
            // echo "User ID: " . htmlspecialchars($user_id) . "<br>";
            // echo "<script>console.log('Deleting cart_id: $delete_cart_id for user_id: $user_id');</script>";

            // SQL to delete the item from the cart
            $sql = "DELETE FROM `cart` WHERE cart_id = :cart_id AND user_id = :user_id";
            $query = $conn->prepare($sql);
            $query->bindParam(':cart_id', $delete_cart_id, PDO::PARAM_INT);
            $query->bindParam(':user_id', $user_id, PDO::PARAM_INT);

            if ($query->execute()) {
                echo "<script>alert('Item deleted successfully!');</script>";
                echo "<script>window.location.href='cart.php';</script>"; // Refresh the cart page
            } else {
                echo "<script>alert('Failed to delete item!');</script>";
            }
        }

        // Weight mapping array
        // $weight_mapping = [
        //     'w1' => '500 gm',
        //     'w2' => '1 kg',
        //     'w3' => '1.5 kg',
        //     'w4' => '2 kg',
        //     'w5' => '2.5 kg',
        //     'w6' => '3 kg',
        //     'w7' => '4 kg'
        // ];
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
                <p style="font-size: 52px;">Cart</p>
                <h5 class=""> <a href="cart.php">cart</a>  
                    <span> |</span> <a href="index.php"> Home</a></h5>
            </div>
        </div>

        <!-- main content --><br><br><br><br>
        <div>
            <div class="cart-content">
                <div class="back-btn">
                <a href="items.php"><button class="btn custom-btn" name=""><i class="bi bi-arrow-return-left"></i> <span></span>continue shopping</button></a>    

                </div>
                <table>
                    <thead>
                        <tr>
                            <th>Preview</th>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Weight</th>
                            <!-- <th>Total</th> -->
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php 
                    $user_id = $_SESSION['user_id'];
                    if ($user_id != '') {
                        $sql = "SELECT cart.cart_id, items.item_img, items.item_name, items.price, items.weight 
                                FROM cart 
                                JOIN items ON cart.item_id = items.item_id 
                                WHERE cart.user_id = :user_id";
                        $query = $conn->prepare($sql);
                        $query->bindParam(':user_id', $user_id, PDO::PARAM_INT);
                        $query->execute();
                        $results = $query->fetchAll(PDO::FETCH_OBJ);
                        $sum = 0;
                        if ($query->rowCount() > 0) {
                            foreach ($results as $result) { ?>
                                <tr>
                                    <td><img src="../Admin/item-images/<?php echo htmlentities($result->item_img); ?>" alt="Item Image" style="width: 100px;"></td>
                                    <td><?php echo htmlentities($result->item_name); ?></td>
                                    <td><?php echo htmlentities($result->price); ?></td>
                                    <!-- <td><?php echo isset($weight_mapping[$result->weight]) ? $weight_mapping[$result->weight] : 'Unknown'; ?></td> -->
                                    <td><?php echo htmlentities($result->weight); ?></td>
                                    <td>
                                        <!-- Delete button form -->
                                        <form method="POST" action="">
                                            <input type="hidden" name="delete_cart_id" value="<?php echo $result->cart_id; ?>">
                                            <button type="submit" class="btn btn-danger"><i class="bi bi-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                                
                            <?php $sum = $sum + ($result->price);} 
                        } else {
                            echo '<tr><td colspan="5">No items in the cart.</td></tr>';
                        }
                    }
                    ?>
                    </tbody>
                </table>
            </div>
            <div class="cart-checkout">
                <table>
                    <thead>
                        <tr>
                            <th><h5>Cart Total</h5></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                Total <span id="final"><?php 
                                    if(isset($sum)){
                                    echo "Rs. ".$sum ;
                                    }else{ echo 00;}
                                    ?></span>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <a href="checkout.php" class="btn custom-btn">PROCEED TO CHECKOUT</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- footer -->
        <?php include 'components/footer.php'?>
    </body>

</html>