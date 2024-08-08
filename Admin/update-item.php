<?php 
    include 'components/connection.php';
    session_start();
    ini_set('post_max_size', '6M');
ini_set('upload_max_filesize', '10M');
    //add category
    try{
         // Fetch the item ID from the URL
    $item_id = intval($_GET['item_id']); 

    if (isset($_POST['submit'])) {
        $iname = $_POST['item_name'];
        $des = $_POST['item_des'];
        $quantity = $_POST['quantity'];
        $weight = $_POST['weight'];
        $price = $_POST['price'];
        $category_id = $_POST['category_id'];
        $img = $_FILES["item_img"]["name"];
        
        // Initialize the SQL update statement
        $sql = "UPDATE `items` SET `item_name` = :iname, `item_des` = :des, `quantity` = :quantity, `weight` = :weight, `price` = :price, `category_id` = :category_id";
        
        // Check if an image file was uploaded
        if (!empty($img)) {
            $imgPath = "item-images/" . $img;
            move_uploaded_file($_FILES["item_img"]["tmp_name"], $imgPath);
            $sql .= ", `item_img` = :img";
        }
        
        $sql .= " WHERE `item_id` = :item_id";
        
        // Prepare and execute the SQL update statement
        $query = $conn->prepare($sql);
        $query->bindParam(':iname', $iname, PDO::PARAM_STR);
        $query->bindParam(':des', $des, PDO::PARAM_STR);
        $query->bindParam(':quantity', $quantity, PDO::PARAM_INT);
        $query->bindParam(':weight', $weight, PDO::PARAM_STR);
        $query->bindParam(':price', $price, PDO::PARAM_INT);
        $query->bindParam(':category_id', $category_id, PDO::PARAM_INT);
        $query->bindParam(':item_id', $item_id, PDO::PARAM_INT);

        // Bind the image parameter if an image was uploaded
        if (!empty($img)) {
            $query->bindParam(':img', $img, PDO::PARAM_STR);
        }

        $query->execute();
        $affectedRows = $query->rowCount();

        if ($affectedRows > 0) {
            echo "<script>alert('Item Updated.');</script>";
            echo "<script>window.location.href='view-items.php'</script>";
        } else {
            echo "<script>alert('No changes made or something went wrong.');</script>";
        }
    }

    // Fetch the current data for the item
    $sql = "SELECT * FROM `items` WHERE item_id = :item_id";
    $query = $conn->prepare($sql);
    $query->bindParam(':item_id', $item_id, PDO::PARAM_INT);
    $query->execute();
    $result = $query->fetch(PDO::FETCH_OBJ);

}catch (PDOException $e) {
        $message[] = 'Error: ' . $e->getMessage();
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
                    <li class="breadcrumb-item active" aria-current="page">Update Items</li>
                </ol>
            </nav>
            <!-- breadcrumb -->

            <div class="main-container">
                <div class="row cat-box">
                <h2 style="text-align: center;">Update Item</h3><br>
                    <div class="col">
                    <?php 
                    $sql = "SELECT * FROM `items` WHERE item_id = :item_id";
                    $query = $conn->prepare($sql);
                    $query->bindParam(':item_id', $item_id, PDO::PARAM_INT);
                    $query->execute();
                    $result = $query->fetch(PDO::FETCH_OBJ);

                    if ($result) { ?>
                        <form action="" method="post" enctype="multipart/form-data">
                        <div class="row">
                                <div class="col-sm-3 form-group">
                                    <label for="item_name">Item name:</label>
                                </div>
                                <div class="col-sm-8 form-group">
                                    <input type="text" class="form-control" name="item_name" placeholder="Item Name" id="item_name" value="<?php echo htmlentities($result->item_name); ?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-3 form-group">
                                    <label for="item_des">Description:</label>
                                </div>
                                <div class="col-sm-8 form-group">
                                    <textarea rows="5" cols="50" class="form-control" name="item_des" placeholder="Description.." id="item_des"><?php echo htmlentities($result->item_des); ?></textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-3 form-group">
                                    <label for="item_img">Image:</label>
                                </div>
                                <div class="col-sm-8 form-group">
                                    <input type="file" class="" name="item_img" id="item_img">
                                    <?php if ($result->item_img) { ?>
                                        <img src="item-images/<?php echo htmlentities($result->item_img); ?>" alt="Current Image" style="max-width: 150px; margin-top: 10px;">
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-3 form-group">
                                    <label for="quantity">Quantity:</label>
                                </div>
                                <div class="col-sm-8 form-group">
                                    <input type="number" class="form-control" name="quantity" placeholder="" id="quantity" value="<?php echo htmlentities($result->quantity); ?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-3 form-group">
                                    <label for="weight">Weight:</label>
                                </div>
                                <div class="col-sm-8 form-group">
                                    <select class="form-control" name="weight">
                                        <option value="" disabled>Select weight</option>
                                        <option value="w1" <?php if ($result->weight === 'w1') echo 'selected'; ?>>500 gm</option>
                                        <option value="w2" <?php if ($result->weight === 'w2') echo 'selected'; ?>>1 kg</option>
                                        <option value="w3" <?php if ($result->weight === 'w3') echo 'selected'; ?>>1.5 kg</option>
                                        <option value="w4" <?php if ($result->weight === 'w4') echo 'selected'; ?>>2 kg</option>
                                        <option value="w5" <?php if ($result->weight === 'w5') echo 'selected'; ?>>2.5 kg</option>
                                        <option value="w6" <?php if ($result->weight === 'w6') echo 'selected'; ?>>3 kg</option>
                                        <option value="w7" <?php if ($result->weight === 'w7') echo 'selected'; ?>>4 kg</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-3 form-group">
                                    <label for="price">Price:</label>
                                </div>
                                <div class="col-sm-8 form-group">
                                    <input type="number" class="form-control" name="price" placeholder="" id="price" value="<?php echo htmlentities($result->price); ?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-3 form-group">
                                    <label for="category_id">Category:</label>
                                </div>
                                <div class="col-sm-8 form-group">
                                    <select class="form-control" name="category_id">
                                        <option value="" disabled>Select category</option>
                                        <?php 
                                        $sql = "SELECT * FROM category";
                                        $query = $conn->prepare($sql);
                                        $query->execute();
                                        $categories = $query->fetchAll(PDO::FETCH_OBJ);
                                        foreach ($categories as $category) { ?>	
                                            <option value="<?php echo htmlentities($category->category_id); ?>" <?php if ($result->category_id == $category->category_id) echo 'selected'; ?>> 
                                                <?php echo htmlentities($category->cat_name); ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-8 form-group">
                                    <button class="btn float-left custom-btn" name="submit">Update</button>
                                </div>
                            </div>
                        </form>
                        <?php } else { ?>
                        <p>Item not found.</p>
                    <?php } ?>
                    </div>
                </div>
                <div class='pagination-container'>
				<nav>
				  <ul class="pagination">
				   <!--	Here the JS Function Will Add the Rows -->
				  </ul>
				</nav>
			</div>
            </div>
        </div>            
    </div>        
</body>

</html>
