<?php 
    include_once 'components/connection.php';
    session_start();
    try {
        if (isset($_GET['order_id'])) {
            $order_id = $_GET['order_id'];

            // Fetch order details
            $sql_order = "SELECT * FROM orders WHERE order_id = :order_id";
            $query_order = $conn->prepare($sql_order);
            $query_order->bindParam(':order_id', $order_id, PDO::PARAM_INT);
            $query_order->execute();
            $order = $query_order->fetch(PDO::FETCH_OBJ);

            if (!$order) {
                // Handle case where the order is not found
                echo "<script>alert('Order not found.');</script>";
                echo "<script>window.location.href='view-orders.php';</script>";
                exit;
            }

            // Handle form submission
            if (isset($_POST['update'])) {
                $order_status = $_POST['order_status'];
                $admin_remark = $_POST['admin_remark'];

                // Update order details
                $sql_update = "UPDATE orders SET order_status = :order_status, admin_remark = :admin_remark WHERE order_id = :order_id";
                $query_update = $conn->prepare($sql_update);
                $query_update->bindParam(':order_status', $order_status, PDO::PARAM_STR);
                $query_update->bindParam(':admin_remark', $admin_remark, PDO::PARAM_STR);
                $query_update->bindParam(':order_id', $order_id, PDO::PARAM_INT);
                $query_update->execute();

                echo "<script>alert('Order updated successfully.');</script>";
                echo "<script>window.location.href='update-order.php?order_id=$order_id';</script>";
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
            echo "<script>window.location.href='view-orders.php';</script>";
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
<title>Cakery</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- Bootstrap Core CSS -->
<link href="css/bootstrap.min.css" rel='stylesheet' type='text/css' />
<!-- Custom CSS -->
<link href="css/style.css" rel='stylesheet' type='text/css' />
<link rel="stylesheet" href="css/morris.css" type="text/css"/>
<!-- Graph CSS -->
<link href="css/font-awesome.css" rel="stylesheet">
<link rel="stylesheet" href="css/jquery-ui.css"> 
<!-- jQuery -->
<!-- <script src="js/jquery-2.1.4.min.js"></script> -->
<!-- //jQuery -->
<link href='//fonts.googleapis.com/css?family=Roboto:700,500,300,100italic,100,400' rel='stylesheet' type='text/css'/>
<link href='//fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
<!-- lined-icons -->
<link rel="stylesheet" href="css/icon-font.min.css" type='text/css' />
<!-- //lined-icons -->
</head> 

<body> 
    <div class="dashboard-container">
        <?php include 'components/sidemenu.php'?>
        <div class="dashboard-container2">
            <?php include 'components/header.php'?>

            <!-- breadcrumb -->
            <nav aria-label="breadcrumb" class="bd">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                    <li class="breadcrumb-item active"><a href="view-orders.php">View Order</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Update order</li>
                </ol>
            </nav>
            <!-- breadcrumb -->

            <div class="update-order-content">
                <div class="row">
                    <div class="col">
                        <div class="row">
                        <h2 style="text-align: center;">Billing Details</h2>
                        <table class="table">
                            <tbody>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone Number</th>
                                    <th>Delivery Date</th>
                                    <th>Address</th>
                                    <th>City</th>
                                    <th>State</th>
                                    <th>Pincode</th>
                                    <th>Message on Cake</th>
                                </tr>

                                <tr>
                                    <td><?php echo htmlspecialchars($billing->first_name); ?></td>
                                    <td><?php echo htmlspecialchars($billing->email); ?></td>
                                    <td><?php echo htmlspecialchars($billing->phone_number); ?></td>
                                    <td><?php echo htmlspecialchars($billing->delivery_date); ?></td>
                                    <td><?php echo htmlspecialchars($billing->address); ?></td>
                                    <td><?php echo htmlspecialchars($billing->city); ?></td>
                                    <td><?php echo htmlspecialchars($billing->state); ?></td>
                                    <td><?php echo htmlspecialchars($billing->pincode); ?></td>
                                    <td><?php echo htmlspecialchars($billing->message_on_cake); ?></td>
                                </tr>
                            </tbody>
                        </table>
                        </div>
                        
                        <div class="row">
                            <h2 style="text-align:center;">Order Item</h2>
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
                        <div class="row">
                            <h2 style="text-align:center;">Update Order</h2>
                            <table class="table order-item">
                                <thead>
                                    <tr>
                                        <th>Order status</th>
                                        <th>Admin remark</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <form action="" method="post">
                                    <tr> 
                                        <td>
                                            <select class="form-control" name="order_status">
                                                <option value="Pending" <?php echo $order->order_status == 'Pending' ? 'selected' : ''; ?>>Pending</option>
                                                <option value="Processing" <?php echo $order->order_status == 'Processing' ? 'selected' : ''; ?>>Processing</option>
                                                <option value="Completed" <?php echo $order->order_status == 'Completed' ? 'selected' : ''; ?>>Completed</option>
                                                <option value="Cancelled" <?php echo $order->order_status == 'Cancelled' ? 'selected' : ''; ?>>Cancelled</option>
                                            </select>
                                        </td>
                                        <td>
                                            <textarea class="form-control" name="admin_remark"><?php echo htmlspecialchars($order->admin_remark); ?></textarea>
                                        </td>
                                        <td colspan="2" style="text-align: center;">
                                            <button type="submit" class="btn btn-primary" name="update">Update Order</button>
                                        </td>
                                    </tr>
                                    </form>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        <div>
    </div>        
</body>

</html>
