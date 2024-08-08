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
            $fname=$_POST['fname'];
            $lname=$_POST['lname'];
            $phone=$_POST['phone'];
            $email=$_POST['email'];
            $password=md5($_POST['password']);
            $cpassword=md5($_POST['password']);
    
            $select_user = $conn->prepare("SELECT * FROM `users` WHERE email = :email");
            $select_user->bindParam(':email',$email);
            // $row = $select_user->fetch(PDO::FETCH_ASSOC);
            $select_user->execute();
    
            if($select_user->rowCount() > 0) {
                $message[] = 'email already exist.';
            }
            else{
                if($password != $cpassword){
                    $message[] = 'confirm your password';
                    return;
                }
                else{
                    $sql="INSERT INTO  users(Firstname, Lastname, Phone, Email, Password, CPassword) VALUES(:fname,:lname,:phone,:email,:password,:cpassword)";
                    $query = $conn->prepare($sql);
                    $query->bindParam(':fname',$fname,PDO::PARAM_STR);
                    $query->bindParam(':lname',$lname,PDO::PARAM_STR);
                    $query->bindParam(':phone',$phone,PDO::PARAM_STR);
                    $query->bindParam(':email',$email,PDO::PARAM_STR);
                    $query->bindParam(':password',$password,PDO::PARAM_STR);
                    $query->bindParam(':cpassword',$cpassword,PDO::PARAM_STR);
                    $query->execute();
                    $lastInsertId = $conn->lastInsertId();
                    if($lastInsertId)
                    {
                        echo "<script>alert('You are Scuccessfully registered. Now you can login');</script>";
                        header('location:index.php');
                    }
                    else 
                    {
                        echo "<script>alert('Something went wrong. Please try again.');</script>";
                        header('location:index.php');
                    }
                }
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
                <p style="font-size: 52px;">Registration Form</p>
                <h5 class=""> <a href="signup.php">Register</a>  
                    <span> |</span> <a href="index.php"> Home</a></h5>
            </div>
        </div>

        <!-- registration form -->
        <div class="rgr">
                <h2>Registration Form!!!</h2>
                <p style="font-size: 20px;">Fill below details.</p>
            </div>
        <section>
            
            <div class="container box2">
                <div class="row box">
                    <div class="col-md-7">
                        <form action="" method="post">
                            <div class="row">
                                <div class="col-sm-6 form-group">
                                    <!-- <label for="name-f">First Name</label> -->
                                    <input type="text" class="form-control" name="fname" id="name-f" placeholder="First Name" required>
                                </div>
                                <div class="col-sm-6 form-group">
                                    <!-- <label for="name-l">Last name</label> -->
                                    <input type="text" class="form-control" name="lname" id="name-l" placeholder="Last Name" required>
                                </div>
                                <div class="col-sm-6 form-group">
                                    <!-- <label for="tel">Phone</label> -->
                                    <input type="tel" name="phone" class="form-control" id="tel" placeholder="Mobile Number" required>
                                </div>
                                <div class="col-sm-6 form-group">
                                    <!-- <label for="email">Email</label> -->
                                    <input type="email" class="form-control" name="email" id="email" placeholder="Email address" required>
                                </div>
                                
                                <div class="col-sm-6 form-group">
                                    <!-- <label for="pass">Password</label> -->
                                    <input type="Password" name="password" class="form-control" id="pass" placeholder="Password" required>
                                </div>
                                <div class="col-sm-6 form-group">
                                    <!-- <label for="pass2">Confirm Password</label> -->
                                    <input type="Password" name="cpassword" class="form-control" id="pass2" placeholder="Repeat password" required>
                                </div>
                                <!-- <div class="col-sm-12">
                                    <input type="checkbox" class="form-check d-inline" id="chb" required><label for="chb" class="form-check-label">&nbsp;I accept all terms and conditions.
                                    </label>
                                </div> -->
                                <div class="col-sm-2 form-group">
                                    <button class="btn float-left custom-btn" name="submit">Submit</button>
                                </div>
                            </div>
                        </form>
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