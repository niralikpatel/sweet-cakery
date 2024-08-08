<?php 
    include_once 'components/connection.php';
    session_start();
    
?>

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
                    <li class="breadcrumb-item active"><a href="#">Home</a></li>
                    <!-- <li class="breadcrumb-item active" aria-current="page">Library</li> -->
                </ol>
            </nav>
            <!-- breadcrumb -->

            <div class="main-container">
                <div class="card-content">    
                    <div class="cards">
                        <div class="card">
                            <h3>Total Category</h3>
                            <p>
                            <?php $sql = "SELECT category_id from category";
                                $query = $conn -> prepare($sql);
                                $query->execute();
                                $results=$query->fetchAll(PDO::FETCH_OBJ);
                                $cnt=$query->rowCount();?>
                                <h3> <?php echo htmlentities($cnt);?> </h3>
                            </p>
                            <p>Total Category</p>
                        </div>
                        <div class="card">
                            <h3>Total Items</h3>
                            <?php $sql = "SELECT item_id from items";
                                $query = $conn -> prepare($sql);
                                $query->execute();
                                $results=$query->fetchAll(PDO::FETCH_OBJ);
                                $cnt=$query->rowCount();?>
                                <h3> <?php echo htmlentities($cnt);?> </h3>
                            </p>
                            <p>Total Items</p>
                        </div>
                        <div class="card">
                            <h3>Total Users</h3>
                            <?php $sql = "SELECT user_id from users";
                                $query = $conn -> prepare($sql);
                                $query->execute();
                                $results=$query->fetchAll(PDO::FETCH_OBJ);
                                $cnt=$query->rowCount();?>
                                <h3> <?php echo htmlentities($cnt);?> </h3>
                            </p>
                            <p>Total Users</p>
                        </div>
                        <div class="card">
                            <h3>Total Orders</h3>
                            <?php $sql = "SELECT order_id from orders";
                                $query = $conn -> prepare($sql);
                                $query->execute();
                                $results=$query->fetchAll(PDO::FETCH_OBJ);
                                $cnt=$query->rowCount();?>
                                <h3> <?php echo htmlentities($cnt);?> </h3>
                            </p>
                            <p>Total Orders</p>
                        </div>
                        <div class="card">
                            <h3>Active Orders</h3>
                            <?php $sql = "SELECT order_id from orders WHERE order_status='Pending' ";
                                $query = $conn -> prepare($sql);
                                $query->execute();
                                $results=$query->fetchAll(PDO::FETCH_OBJ);
                                $cnt=$query->rowCount();?>
                                <h3> <?php echo htmlentities($cnt);?> </h3>
                            </p>
                            <p>Active Orderss</p>
                        </div>
                        <div class="card">
                            <h3>Completed Orders</h3>
                            <?php $sql = "SELECT order_id from orders WHERE order_status='completed' ";
                                $query = $conn -> prepare($sql);
                                $query->execute();
                                $results=$query->fetchAll(PDO::FETCH_OBJ);
                                $cnt=$query->rowCount();?>
                                <h3> <?php echo htmlentities($cnt);?> </h3>
                            </p>
                            <p>Completed Orders</p>
                        </div>
                    </div>
                </div>
            </div>
        <div>
    </div>        
</body>

</html>
<!-- <table>
              <thead>
                <tr>
                  <th>Nom</th>
                  <th>Email</th>
                  <th>Téléphone</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>John Doe</td>
                  <td>john@example.com</td>
                  <td>555-1234</td>
                  <td>
                    <a href="#">Modifier</a>
                    <a href="#">Supprimer</a>
                  </td>
                </tr>
                <tr>
                  <td>Jane Smith</td>
                  <td>jane@example.com</td>
                  <td>555-5678</td>
                  <td>
                    <a href="#">Modifier</a>
                    <a href="#">Supprimer</a>
                  </td>
                </tr>
                <tr>
                  <td>Bob Johnson</td>
                  <td>bob@example.com</td>
                  <td>555-9012</td>
                  <td>
                    <a href="#">Modifier</a>
                    <a href="#">Supprimer</a>
                  </td>
                </tr>
              </tbody>
            </table> -->