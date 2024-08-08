<?php 
    include 'components/session-init.php';
    include 'components/connection.php';
    // session_start();

    try {
        if (isset($_POST['submit'])) {
            $user_id = $_SESSION['user_id'];
            $old_password = md5($_POST['old_password']);
            $new_password = md5($_POST['new_password']);
            $confirm_password = md5($_POST['confirm_password']);
    
            $check_password = $conn->prepare("SELECT password FROM `users` WHERE user_id = :user_id");
            $check_password->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $check_password->execute();
            $result = $check_password->fetch(PDO::FETCH_ASSOC);

            if ($result['password'] === $old_password) {
                if ($new_password === $confirm_password) {
                    // Update first name, last name, and password
                    $update_user = $conn->prepare("UPDATE `users` SET Firstname = :fname, Lastname = :lname, password = :new_password WHERE user_id = :user_id");
                    $update_user->bindParam(':fname', $fname);
                    $update_user->bindParam(':lname', $lname);
                    $update_user->bindParam(':new_password', $new_password);
                    $update_user->bindParam(':user_id', $user_id, PDO::PARAM_INT);

                    if ($update_user->execute()) {
                        echo "<script>alert('Profile and password updated successfully!');</script>";
                    } else {
                        echo "<script>alert('Failed to update profile.');</script>";
                    }
                } else {
                    echo "<script>alert('New passwords do not match.');</script>";
                }
            } else {
                echo "<script>alert('Old password is incorrect.');</script>";
            }
        }
    }catch (PDOException $e) {
        $message[] = 'Connection failed: ' . $e->getMessage();
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
        
        <!-- <section class="breadcrumb-section set-bg" data-setbg="img/bread.png">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 text-center text-dark">
                        <div class="breadcrumb__text">
                            <h2>Register Your Self</h2>
                            <div class="breadcrumb__option">
                                <a href="./index.php">Home ></a>
                                <span>Sign Up</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section> -->
        <div class="banner-3">
            <div class="container">
                <p style="font-size: 52px;">Change Password</p>
                <h5 class=""> <a href="change-password.php">Change Password</a>  
                    <span> |</span> <a href="index.php"> Home</a></h5>
            </div>
        </div>

            <!-- main content --><br><br><br><br>
        <div class="profile-content">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <h2>Change Password ___</h2>
                        <h5>Change your password!!!</h5>
                        <div class="row">
                        <div class="col-lg-7">
                                <?php 
                                $user_id = $_SESSION['user_id'];

                                $sql = "SELECT * FROM users WHERE user_id = :user_id";
                                $query = $conn->prepare($sql);
                                $query->bindParam(':user_id', $user_id, PDO::PARAM_INT);
                                $query->execute();
                                $result = $query->fetch(PDO::FETCH_ASSOC);
                                
                                if ($result) {
                                ?>
                                <form action="" method="post">
                                    <div class="row">
                                        <div class="col-sm-9 form-group">
                                            <label for="old_password">Old Password:</label>
                                            <input type="password" class="form-control" name="old_password" id="old_password" required>
                                        </div>
                                        <div class="col-sm-9 form-group">
                                            <label for="new_password">New Password:</label>
                                            <input type="password" class="form-control" name="new_password" id="new_password" required>
                                        </div>
                                        <div class="col-sm-9 form-group">
                                            <label for="confirm_password">Confirm New Password:</label>
                                            <input type="password" class="form-control" name="confirm_password" id="confirm_password" required>
                                        </div>
                                        <div class="col-sm-2 form-group">
                                            <button class="btn float-left custom-btn" name="submit">Submit</button>
                                        </div>
                                    </div>
                                </form>
                                <?php } ?>
                            </div>
                            <div class="col-lg-5">
                                <div class="info-column">
                                    <p><strong>Address:</strong> Reliance Cross Rd, Gandhinagar, Gujarat, India</p>
                                    <p><strong>Phone:</strong> 9876543210</p>
                                    <p><strong>Email:</strong> info@gmail.com</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!-- footer -->
        <?php include 'components/footer.php'?>
    </body>

</html>