<?php 
    include 'components/connection.php';
    session_start();
    
    //add category
    try{
        if(isset($_POST['submit'])) {
            $cat_name=$_POST['cat_name'];
    
            $select_cat = $conn->prepare("SELECT * FROM `category` WHERE cat_name = :cat_name");
            $select_cat->bindParam(':cat_name',$cat_name);
            $select_cat->execute();
    
            if($select_cat->rowCount() > 0) {
                $message[] = 'category already exist.';
            }
            else{
                $sql="INSERT INTO category(cat_name) VALUES(:cat_name)";
                $query = $conn->prepare($sql);
                $query->bindParam(':cat_name',$cat_name,PDO::PARAM_STR);
                $query->execute();
                $lastInsertId = $conn->lastInsertId();
                if($lastInsertId)
                {
                    echo "<script>alert('Category Added.');</script>";
                    // header('location:index.php');
                }
                else 
                {
                    echo "<script>alert('Something went wrong. Please try again.');</script>";
                    // header('location:index.php');
                }
            }
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
                    <li class="breadcrumb-item active" aria-current="page">Add Category</li>
                </ol>
            </nav>
            <!-- breadcrumb -->

            <div class="main-container">
                <div class="row cat-box">
                <h3>Add Category</h3><br>
                    <div class="col">
                        <form action="" method="post">
                            <div class="row">
                                <div class="col-sm-8 form-group">
                                    <!-- <label for="email">Email address:</label> -->
                                    <input type="text" class="form-control" name="cat_name" placeholder="Add Category" id="cat_name">
                                </div>
                            </div> <br>
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
<!-- <div class="row cat-box">
                    <div class="col">
                        <form action="" method="post">
                            <div class="row-sm-10">
                                <div class="col form-group">
                                    <label for="email">Email</label>
                                    <input type="text" name="cat_name" id="cat_name" placeholder="Category name" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col form-group">
                                    <button class="btn float-left custom-btn" name="add">Add</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div> -->