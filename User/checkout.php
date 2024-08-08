<?php 
    include 'components/session-init.php';
    include 'components/connection.php';
    
    try {
        if (!isset($_SESSION['user_id'])) {
            echo "<script>alert('You need to log in to place an order.');</script>";
            exit;
        }

        if (isset($_POST['place_order'])) {
            $conn->beginTransaction(); // Start transaction

            // Insert order details into the orders table
            $user_id = $_SESSION['user_id'];
            $total_amount = 0;
            $order_status = "Pending";
            $payment_mode = $_POST['mode'];

            $sql = "SELECT SUM(items.price) AS total FROM cart 
                    JOIN items ON cart.item_id = items.item_id 
                    WHERE cart.user_id = :user_id";
            $query = $conn->prepare($sql);
            $query->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $query->execute();
            $result = $query->fetch(PDO::FETCH_ASSOC);
            if ($result) {
                $total_amount = $result['total'];
            }

            $sql = "INSERT INTO orders (user_id, total_amount, order_status, payment_mode) 
                    VALUES (:user_id, :total_amount, :order_status, :payment_mode)";
            $query = $conn->prepare($sql);
            $query->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $query->bindParam(':total_amount', $total_amount, PDO::PARAM_STR);
            $query->bindParam(':order_status', $order_status, PDO::PARAM_STR);
            $query->bindParam(':payment_mode', $payment_mode, PDO::PARAM_STR);
            $query->execute();

            $order_id = $conn->lastInsertId(); // Get the last inserted order_id

            // Insert billing details into the billing table
            $first_name = $_POST['f_name'];
            $email = $_POST['email'];
            $phone_number = $_POST['phonenumber'];
            $delivery_date = $_POST['delivery_date'];
            $address = $_POST['address'];
            $city = $_POST['city'];
            $state = $_POST['state'];
            $pincode = $_POST['pincode'];
            $message_on_cake = $_POST['message'];

            $sql = "INSERT INTO billing (order_id, first_name, email, phone_number, delivery_date, address, city, state, pincode, message_on_cake) 
                    VALUES (:order_id, :first_name, :email, :phone_number, :delivery_date, :address, :city, :state, :pincode, :message_on_cake)";
            $query = $conn->prepare($sql);
            $query->bindParam(':order_id', $order_id, PDO::PARAM_INT);
            $query->bindParam(':first_name', $first_name, PDO::PARAM_STR);
            $query->bindParam(':email', $email, PDO::PARAM_STR);
            $query->bindParam(':phone_number', $phone_number, PDO::PARAM_STR);
            $query->bindParam(':delivery_date', $delivery_date, PDO::PARAM_STR);
            $query->bindParam(':address', $address, PDO::PARAM_STR);
            $query->bindParam(':city', $city, PDO::PARAM_STR);
            $query->bindParam(':state', $state, PDO::PARAM_STR);
            $query->bindParam(':pincode', $pincode, PDO::PARAM_STR);
            $query->bindParam(':message_on_cake', $message_on_cake, PDO::PARAM_STR);
            $query->execute();

            // Insert order items into the order_items table
            $sql = "SELECT cart.item_id, items.price, items.weight, COUNT(*) AS quantity
                    FROM cart 
                    JOIN items ON cart.item_id = items.item_id 
                    WHERE cart.user_id = :user_id 
                    GROUP BY cart.item_id";
            $query = $conn->prepare($sql);
            $query->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $query->execute();
            $cart_items = $query->fetchAll(PDO::FETCH_OBJ);

            foreach ($cart_items as $item) {
                $sql = "INSERT INTO order_items (order_id, item_id, quantity, price, weight) 
                        VALUES (:order_id, :item_id, :quantity, :price, :weight)";
                $query = $conn->prepare($sql);
                $query->bindParam(':order_id', $order_id, PDO::PARAM_INT);
                $query->bindParam(':item_id', $item->item_id, PDO::PARAM_INT);
                $query->bindParam(':quantity', $item->quantity, PDO::PARAM_INT);
                $query->bindParam(':price', $item->price, PDO::PARAM_STR);
                $query->bindParam(':weight', $item->weight, PDO::PARAM_STR);
                $query->execute();
            }

            // Clear the cart after the order is placed
            $sql = "DELETE FROM cart WHERE user_id = :user_id";
            $query = $conn->prepare($sql);
            $query->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $query->execute();

            // Commit the transaction
            if($conn->commit()){
                echo "<script>alert('Order Placed successfully.');</script>";
                header("Location: last.php"); // Redirect to the last.php page
                exit;   
            }
        }
    } catch (PDOException $e) {
        $conn->rollBack(); // Rollback the transaction on error
        $message[] = ' ' . $e->getMessage();
    }
?>

<?php 
    // include 'components/session-init.php';
    // include 'components/connection.php';
    // // session_start();

    // try{
    //     if (!isset($_SESSION['user_id'])) {
    //         echo "<script>alert('You need to log in to view the cart.');</script>";
    //     }
        
    //     if (isset($_POST['place_order'])) {
    //         header("Location: last.php");
    //         exit;
    //     }
    // }catch (PDOException $e) {
    //     $message[] = ' ' . $e->getMessage();
    // }
    
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
                <p style="font-size: 52px;">Checkout</p>
                <h5 class=""> <a href="checkout.php">Checkout</a>  
                    <span> |</span> <a href="index.php"> Home</a></h5>
            </div>
        </div>

        <!-- main content --><br><br><br><br>
        <div>
        <form action="" method="POST">
            <div class="row checkout-content">
                <div class="col-6">
                    <div class="bill-content">
                        <div class="row head-form">
                            <h2>Billing Details ___</h2>
                        </div>
						<div class="row">
							<div class="col-md-6 form-group  ">
                                    <label for="">Name</label>
                                    <span class="text-danger" id="fname"></span>
									<input type="text" class="form-control first_name" id="first" name="f_name" placeholder="Enter  your first name" required/>
									<span class="placeholder text-danger" data-placeholder="First name" ></span>
							</div>

                            <div class="col-md-6 form-group  ">
                                <label for="">Email</label>
                                <span class="text-danger" id="email"></span>  
									<input type="text" class="form-control email" id="email" name="email" placeholder="Enter your email" required/>
									<span class="placeholder" data-placeholder="Email Address"></span>
							</div>
							
							<div class="col-md-6 form-group  ">
                                    <label for="">Phone Number</label>
                                    <span class="text-danger" id="mobile"></span>
									<input type="text" class="form-control mobile" id="number" name="phonenumber" placeholder="Enter  your phone number" required/>
                                    <span class="placeholder" data-placeholder="Phone Number"></span>   
							</div>

                            <div class="col-md-6 form-group">
                                <label for="">Delivery Date</label>
                                <span class="text-danger" id="delivery_date"></span>
                                <input type="date" class="form-control delivery_date" id="delivery_date" name="delivery_date" required/>
                                <span class="placeholder" data-placeholder="Delivery Date"></span>
                            </div>

                            <div class="col-12 form-group  ">
                                <label for="">Address</label>
                                <span class="text-danger" id="address"></span>
                                <input type="text" class="form-control address" id="add1" name="address" placeholder="Enter your address" required/>
                                <span class="placeholder" data-placeholder="Address line 01"></span>
                            </div>
						
                            <div class="col-md-12 form-group  ">
                                <label for="">City</label>
                                <span class="text-danger" id="city"></span>
                                <input type="text" class="form-control city" id="city" name="city" placeholder="Enter your city" required/>
                                <span class="placeholder" data-placeholder="Town/City"></span>
                            </div>

                            <div class="col-md-12 form-group  ">
                                <label for="">State</label>
                                <span class="text-danger" id="state"></span>
                                <input type="text" class="form-control state" id="city" name="state" placeholder="Enter your state" required/>
                                <span class="placeholder" data-placeholder="state"></span>
                            </div>

                            <div class="col-md-12 form-group">
                                <label for="">Pincode</label>
                                <span class="text-danger" id="pincode"></span>
                                <input type="text" class="form-control" id="zip" name="pincode" placeholder="Enter your pincode" required/>
                                <span class="placeholder" data-placeholder="pincode"></span>
                            </div>
                            <div class="col-md-12 form-group">
                                <label for="">Message on cake</label>
                                <span class="text-danger" id="message"></span>
                                <input type="text" class="form-control" id="message" name="message" placeholder="Enter message.." required/>
                                <span class="placeholder" data-placeholder="pincode"></span>
                            </div>
						</div>
                    </div>
                </div>
                <div class="col-5">
                    <div class="checkout-content">
                        <div class="row head-form">
                            <h2>Your Order ___</h2>
                        </div>
                        <div class="row checkout2">
                            <div class="col">
                                <div class="row">
                                    <div class="col-6">
                                        <label for="">PRODUCT</label>
                                    </div>
                                    <div class="col-6 lft">
                                        <label for="">TOTAL</label>
                                    </div>
                                </div>
                                
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
                                <div class="row">
                                    <div class="col-6">
                                        <?php echo htmlentities($result->item_name); ?>
                                    </div>
                                    <div class="col-6 lft">
                                        <?php echo htmlentities($result->price); ?>
                                    </div>
                                    <?php $sum = $sum + ($result->price);?>
                                </div>
                                
                                <?php }?>
                                <br>
                                <div class="row">
                                    <div class="col-6">
                                        <label for="">Shipping and handling</label>
                                    </div>
                                    <div class="col-6 lft">
                                        <label for="">Free shipping</label>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-6">
                                        <label for="">TOTAL</label>
                                    </div>
                                    <div class="col-6 lft">
                                        <label for="">Rs.</label>
                                        <?php echo htmlentities($sum); ?>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col">
                                        <label for="payment">
                                        <input type="radio" name="mode" id="payment" value="COD" required>
                                        Cash on Delivery(COD)
                                            <span class="checkmark"></span>
                                        </label>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col">
                                        <button type="submit" class="btn custom-btn" name="place_order">Place Order</button>    
                                    </div>
                                </div>
                            </div>
                            <?php  } }?>
                        </div>
                    </div>
                </div>
            </div>
            </form>
            <div class="cart-content">
                <div class="back-btn">
                <a href="items.php"><button class="btn custom-btn" name=""><i class="bi bi-arrow-return-left"></i> <span></span>continue shopping</button></a>    
                </div>
            </div>
        </div>
        <!-- footer -->
        <?php include 'components/footer.php'?>
    </body>

</html>