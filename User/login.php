<?php 
    include 'components/session-init.php';
    include 'components/connection.php';
    // session_start();

    if(isset($_SESSION['user_id'])){
        $user_id = $_SESSION['user_id'];
    }
    else{
        $user_id = '';
    }
    //register user
    try{
        if(isset($_POST['submit'])) {
            $email=$_POST['email'];
            $password=md5($_POST['password']);
    
            $select_user = $conn->prepare("SELECT * FROM `users` WHERE email = :email AND password = :password");
            $select_user->bindParam(':email',$email);
            $select_user->bindParam(':password',$password);
            // $row = $select_user->fetch(PDO::FETCH_ASSOC);
            $select_user->execute();
    
            if($select_user->rowCount() > 0) {
                $row = $select_user->fetch(PDO::FETCH_ASSOC);
                $_SESSION['user_login']=true;
                $_SESSION['user_id'] = $row['user_id'];
                $_SESSION['user_email']=$_POST['email'];
                echo "<script>alert('Successfulyy Login');</script>";
                header("location:index.php"); 
            }
            else{
                echo "<script>alert('Invalid Details');</script>";
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
                <p style="font-size: 52px;">Login Form</p>
                <h5 class=""> <a href="login.php">Login</a>  
                    <span> |</span> <a href="index.php"> Home</a></h5>
            </div>
        </div>

        <!-- registration form -->
        <div class="rgr">
                <h2>Login Form!!!</h2>
                <p style="font-size: 20px;">Fill below details.</p>
        </div>
        <section>
            
            <div class="container box2">
                <div class="row box">
                    <div class="col-md-7">
                        <form action="" method="post">
                            <div class="row">
                                <div class="col-sm-8 form-group">
                                    <!-- <label for="email">Email</label> -->
                                    <input type="email" class="form-control" name="email" id="email" placeholder="Email address" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-8 form-group">
                                    <!-- <label for="pass">Password</label> -->
                                    <input type="Password" name="password" class="form-control" id="pass" placeholder="Password" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-2 form-group">
                                    <button class="btn float-left custom-btn" name="submit">Submit</button>
                                </div>
                            </div>
                        </form>
                        <div class="row">
                            <div class="col form-group">
                                <p>don't have an account?</p>
                                <a href="signup.php"><button class="btn float-left custom-btn" name="rgst">Register Now</button></a>
                            </div>
                        </div>
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
        </section>
        
        <!-- footer -->
        <?php include 'components/footer.php'?>
    </body>

</html>