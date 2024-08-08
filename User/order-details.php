<?php 
    include 'components/session-init.php';
    include 'components/connection.php';

    try {
        // Check if user is logged in
        if (!isset($_SESSION['user_id'])) {
            echo "<script>alert('You need to log in to view order details.');</script>";
            echo "<script>window.location.href='login.php';</script>";
            exit;
        }

        if (isset($_GET['order_id'])) {
            $order_id = $_GET['order_id'];
            $user_id = $_SESSION['user_id'];

            // Fetch order details
            $sql_order = "SELECT * FROM orders WHERE order_id = :order_id AND user_id = :user_id";
            $query_order = $conn->prepare($sql_order);
            $query_order->bindParam(':order_id', $order_id, PDO::PARAM_INT);
            $query_order->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $query_order->execute();
            $order = $query_order->fetch(PDO::FETCH_OBJ);

            if (!$order) {
                echo "<script>alert('Order not found.');</script>";
                echo "<script>window.location.href='orders.php';</script>";
                exit;
            }

            // Fetch billing details
            $sql_billing = "SELECT * FROM billing WHERE order_id = :order_id";
            $query_billing = $conn->prepare($sql_billing);
            $query_billing->bindParam(':order_id', $order_id, PDO::PARAM_INT);
            $query_billing->execute();
            $billing = $query_billing->fetch(PDO::FETCH_OBJ);

            // Fetch order items
            $sql_items = "SELECT * FROM order_items WHERE order_id = :order_id";
            $query_items = $conn->prepare($sql_items);
            $query_items->bindParam(':order_id', $order_id, PDO::PARAM_INT);
            $query_items->execute();
            $items = $query_items->fetchAll(PDO::FETCH_OBJ);

        } else {
            echo "<script>alert('Invalid request.');</script>";
            echo "<script>window.location.href='orders.php';</script>";
            exit;
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
        <title>Order Details</title>
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
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

        <script src="css/js/script.js"></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    </head>
    <body>
        <?php include 'components/header.php'?>
        <?php include 'components/navbar.php'?>

        <div class="banner-3">
            <div class="container">
                <p style="font-size: 52px;">Order Details</p>
                <h5 class=""> <a href="orders.php">My Orders</a>  
                    <span> |</span> <a href="index.php"> Home</a></h5>
            </div>
        </div>

        <!-- main content --><br><br><br><br>
        <div>
            <div class="order-details">
            <h3>Order Summary</h3>

                <div class="row-sm-6">
                    <div class="col">
                        <div class="row">
                            <span id="summary">Order ID:</span> &nbsp;&nbsp; <?php echo htmlspecialchars($order->order_id); ?>
                        </div>
                        <div class="row">
                            <span id="summary">Order Date:</span> &nbsp;&nbsp;<?php echo htmlspecialchars($order->order_date); ?>
                        </div>
                        <div class="row">
                            <span id="summary">Order Status:</span> &nbsp;&nbsp;<?php echo htmlspecialchars($order->order_status); ?>
                        </div>
                        <div class="row">
                            <span id="summary">Admin remark:</span> &nbsp;&nbsp;<?php echo htmlspecialchars($order->admin_remark); ?>
                        </div>
                        <br>
                        <div class="row">
                        <form method="POST" action="generate-invoice.php" target="_blank">
                            <input type="hidden" name="invoice" value="<?php echo htmlspecialchars($order->order_id); ?>">
                            <button class="btn mb-2 custom-btn" name="submit" type="submit">Generate Invoice</button>
                        </form>
                        </div>
                    </div>
                </div>
                <!-- <h3>Billing Details</h3>
                <table class="table">
                    <tbody>
                        <tr>
                            <th>First Name</th>
                            <td><?php echo htmlspecialchars($billing->first_name); ?></td>
                        </tr>
                        <tr>
                            <th>Last Name</th>
                            <td><?php echo htmlspecialchars($billing->last_name); ?></td>
                        </tr>
                        <tr>
                            <th>Phone Number</th>
                            <td><?php echo htmlspecialchars($billing->phone_number); ?></td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td><?php echo htmlspecialchars($billing->email); ?></td>
                        </tr>
                        <tr>
                            <th>Address</th>
                            <td><?php echo htmlspecialchars($billing->address); ?></td>
                        </tr>
                        <tr>
                            <th>City</th>
                            <td><?php echo htmlspecialchars($billing->city); ?></td>
                        </tr>
                        <tr>
                            <th>State</th>
                            <td><?php echo htmlspecialchars($billing->state); ?></td>
                        </tr>
                        <tr>
                            <th>Pincode</th>
                            <td><?php echo htmlspecialchars($billing->pincode); ?></td>
                        </tr>
                        <tr>
                            <th>Message on Cake</th>
                            <td><?php echo htmlspecialchars($billing->message_on_cake); ?></td>
                        </tr>
                    </tbody>
                </table> -->

                <br><br>
                <h3>Order Item</h3>
                <table class="table order-item">
                    <thead>
                        <tr>
                            <th>Item Name</th>
                            <th>Image</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Weight</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($items) > 0): ?>
                            <?php foreach ($items as $item): ?>
                                
                                <?php
                                    // Fetch item details based on item_id
                                    $sql_item = "SELECT item_name, item_img FROM items WHERE item_id = :item_id";
                                    $query_item = $conn->prepare($sql_item);
                                    $query_item->bindParam(':item_id', $item->item_id, PDO::PARAM_INT);
                                    $query_item->execute();
                                    $item_details = $query_item->fetch(PDO::FETCH_OBJ);
                                ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($item_details->item_name); ?></td>
                                    <td><img src="../Admin/item-images/<?php echo htmlspecialchars($item_details->item_img); ?>" alt="Item Image" style="width: 150px;"></td>
                                    <td><?php echo htmlspecialchars($item->quantity); ?></td>
                                    <td><?php echo htmlspecialchars($item->price); ?></td>
                                    <td><?php echo htmlspecialchars($item->weight); ?></td>
                                </tr>
                            
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4">No items found.</td>
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
