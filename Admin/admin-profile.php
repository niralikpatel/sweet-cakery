<?php 
include_once 'components/connection.php';
session_start();

// Fetch admin details (assuming there's only one admin)
$sql = "SELECT * FROM `admin` LIMIT 1";
$query = $conn->prepare($sql);
$query->execute();
$result = $query->fetch(PDO::FETCH_OBJ);

if ($result === false) {
    echo "<script>alert('No admin data found.');</script>";
    // Redirect or handle the error as needed
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $name = $_POST['name'];

    // Update admin details
    $update_sql = "UPDATE admin SET UserName = :username, Name = :name WHERE admin_id = :admin_id";
    $update_query = $conn->prepare($update_sql);
    $update_query->bindParam(':username', $username, PDO::PARAM_STR);
    $update_query->bindParam(':name', $name, PDO::PARAM_STR);
    $update_query->bindParam(':admin_id', $result->admin_id, PDO::PARAM_INT); // Using the fetched admin's ID

    if ($update_query->execute()) {
        echo "<script>alert('Profile updated successfully.');</script>";
        // Optionally, refresh the page to reflect updated data
        echo "<script>window.location.href='admin-profile.php';</script>";
    } else {
        echo "<script>alert('Failed to update profile.');</script>";
    }
}
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
<link href='//fonts.googleapis.com/css?family=Roboto:700,500,300,100italic,100,400' rel='stylesheet' type='text/css'/>
<link href='//fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="css/icon-font.min.css" type='text/css' />
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
                    <li class="breadcrumb-item active" aria-current="page">Admin Profile</li>
                </ol>
            </nav>
            <!-- breadcrumb -->

            <div class="main-container">
                <div class="user-container">
					<h2 style="text-align: center;">Profile Details</h2>
					<form method="POST" action="">
                        <table class="table table-bordered">
                            <tr>
                                <th>Username</th>
                                <td><input type="text" name="username" value="<?php echo htmlentities($result->UserName); ?>" class="form-control" ></td>
                            </tr>
                            <tr>
                                <th>Name</th>
                                <td><input type="text" name="name" value="<?php echo htmlentities($result->Name); ?>" class="form-control" ></td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td><?php echo htmlentities($result->Email); ?></td>
                            </tr>
                            <tr>
                                <th>Phone</th>
                                <td><?php echo htmlentities($result->Phone); ?></td>
                            </tr>
                            <tr>
                                <td colspan="2" style="text-align: center;">
                                    <button type="submit" class="btn custom-btn">Update Profile</button>
                                </td>
                            </tr>
                        </table>
                    </form>
                </div>
                
            </div>
        <div>
    </div>        
</body>

</html>
