<?php 
    include 'components/connection.php';
    include 'components/session-init.php';

    // session_start();

    try {
        if(isset($_POST['login'])) {
            $username=$_POST['uname'];
            $password=$_POST['password'];
            $sql ="SELECT UserName,Password FROM `admin` WHERE UserName=:username and Password=:password";
            $query= $conn -> prepare($sql);
            $query-> bindParam(':username', $username, PDO::PARAM_STR);
            $query-> bindParam(':password', $password, PDO::PARAM_STR);
            $query-> execute();
            $results=$query->fetchAll(PDO::FETCH_OBJ);
            if($query->rowCount() > 0){
                $_SESSION['alogin']=$_POST['username'];
                header('Location: dashboard.php');
                exit();
            } else {
                $message[] = 'Incorrect username or password';
            }
        }    
    } catch (PDOException $e) {
        $message[] = 'Connection failed: ' . $e->getMessage();
    }
?>

<!DOCTYPE HTML>
<html>
<head>
<title>Cakery-Admin</title>
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
    <script>
        let messages = <?php echo json_encode($message); ?>;
        if (Array.isArray(messages) && messages.length > 0) {
            messages.forEach(msg => {
                alert(msg);
            });
        }
</script>
<div class="container backg">
  <div class="row box">
    <div class="col-sm-4">
        <h3>Sweet Cakery System | Admin Login</h3>
    </div>
    
    <div class="col-sm-5">   
        <form action="" method="post">     
            <input type="text" placeholder="Username" class="input-field" name="uname" required>
            <input type="password" placeholder="Password" class="input-field" name="password" required>
            <button class="login-button" name="login">Login</button>
        </form>
            <a href="../User/index.php"><button class="register-button" name="back">Back Home</button></a>
    </div>
    
  </div>
</div>
</body>

</html>