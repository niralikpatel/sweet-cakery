<?php 
    include 'components/connection.php';
    session_start();
    ini_set('post_max_size', '6M');
ini_set('upload_max_filesize', '10M');
    //add category
    try{
        if(isset($_POST['submit'])) {
            $iname=$_POST['item_name'];
            $des=$_POST['item_des'];
            $img=$_FILES["item_img"]["name"];
            // $img = $_FILES["item_img"]["name"];
            // $tempname = $_FILES["uploadfile"]["tmp_name"];
            // $folder = "./item-images/" . $img;
            $quantity=$_POST['quantity'];
            $weight=$_POST['weight'];
            $price=$_POST['price'];
            $category_id=$_POST['category_id'];
            // move_uploaded_file($tempname, $folder);
            move_uploaded_file($_FILES["item_img"]["tmp_name"],"item-images/".$_FILES["item_img"]["name"]);
             
            if ($_FILES['item_img']['error'] === UPLOAD_ERR_OK) {
                move_uploaded_file($_FILES['item_img']['tmp_name'], "item-images/" . $_FILES['item_img']['name']);
            } else {
                echo "<script>alert('Error uploading file.');</script>";
                exit;
            }
            // $select_cat = $conn->prepare("SELECT * FROM `category` WHERE cat_name = :cat_name");
            // $select_cat->bindParam(':cat_name',$cat_name);
            // $select_cat->execute();
    
            // if($select_cat->rowCount() > 0) {
            //     $message[] = 'item already exist.';
            // }
            //else{
                $sql = "INSERT INTO `items` (`item_name`, `item_des`, `item_img`, `quantity`, `weight`, `price`, `category_id`) VALUES (:iname, :des, :img, :quantity, :weight, :price, :category_id)";
                $query = $conn->prepare($sql);
                $query->bindParam(':iname', $iname, PDO::PARAM_STR);
                $query->bindParam(':des', $des, PDO::PARAM_STR);
                $query->bindParam(':img', $img, PDO::PARAM_STR);
                $query->bindParam(':quantity', $quantity, PDO::PARAM_INT);
                $query->bindParam(':weight', $weight, PDO::PARAM_STR);
                $query->bindParam(':price', $price, PDO::PARAM_INT);
                $query->bindParam(':category_id', $category_id, PDO::PARAM_INT);
                $query->execute();
                $lastInsertId = $conn->lastInsertId();
                if($lastInsertId)
                {
                    echo "<script>alert('Item Added.');</script>";
                    // header('location:index.php');
                }
                else 
                {
                    echo "<script>alert('Something went wrong. Please try again.');</script>";
                    // header('location:index.php');
                }
            //}
        }
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
                    <li class="breadcrumb-item active" aria-current="page">Add Items</li>
                </ol>
            </nav>
            <!-- breadcrumb -->

            <div class="main-container">
                <div class="row cat-box">
                <h2 style="text-align: center;">Add Items</h3><br>
                    <div class="col">
                        <form action="" method="post" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-sm-3 form-group">
                                    <label for="text">Item name:</label>
                                    <!-- <input type="text" class="form-control" name="cat_name" placeholder="Add Category" id="cat_name"> -->
                                </div>
                                <div class="col-sm-8 form-group">
                                    <!-- <label for="email">Email address:</label> -->
                                    <input type="text" class="form-control" name="item_name" placeholder="Item Name" id="item_name">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-3 form-group">
                                    <label for="text">Description:</label>
                                </div>
                                <div class="col-sm-8 form-group">
                                    <textarea rows="5" cols="50" type="text" class="form-control" name="item_des" placeholder="Description.." id="item_des"></textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-3 form-group">
                                    <label for="image">Image:</label>
                                </div>
                                <div class="col-sm-8 form-group">
                                    <input type="file" class="" name="item_img" id="item_img">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-3 form-group">
                                    <label for="text">Quantity:</label>
                                </div>
                                <div class="col-sm-8 form-group">
                                    <input type="number" class="form-control" name="quantity" placeholder="" id="quantity">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-3 form-group">
                                    <label for="text">Weight:</label>
                                </div>
                                <div class="col-sm-8 form-group">
                                    <select class="form-control" type="text" id="" name="weight">
                                        <option value="Y" selected>Choose weight</option>
                                        <option value="200 gm">200 gm</option>
                                        <option value="500 gm">500 gm</option>
                                        <option value="1 kg">1 kg</option>
                                        <option value="1.5 kg">1.5 kg</option>
                                        <option value="2 kg">2 kg</option>
                                        <option value="2.5 kg">2.5 kg</option>
                                        <option value="3 kg">3 kg</option>
                                        <option value="4 kg">4 kg</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-3 form-group">
                                    <label for="text">Price:</label>
                                </div>
                                <div class="col-sm-8 form-group">
                                    <input type="number" class="form-control" name="price" placeholder="" id="price">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-3 form-group">
                                    <label for="text">Category:</label>
                                </div>
                                <div class="col-sm-8 form-group">
                                    <select class="form-control" type="text" id="" name="category_id">
                                        <option value="Y" selected>Select</option>
                                        <?php $sql = "SELECT * from category";
                                        $query = $conn -> prepare($sql);
                                        $query->execute();
                                        $results=$query->fetchAll(PDO::FETCH_OBJ);
                                        $cnt=1;
                                        if($query->rowCount() > 0){
                                        foreach($results as $result){?>	
                                            <option value="<?php echo htmlentities($result->category_id); ?>"> 
                                            <?php echo htmlentities($result->cat_name);?>
                                            </option>
                                        <?php } }?>
                                    </select>
                                    <!-- <input type="number" class="form-control" name="cat_id" placeholder="" id="cat_id"> -->
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-8 form-group">
                                    <button class="btn float-left custom-btn" name="submit">Add</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>            
    </div>        
</body>

</html>
