<?php 
    include 'components/session-init.php';
    include 'components/connection.php';

    // Initialize message array
    $message = array();

    if (isset($_POST['submit'])) {
        $name = trim($_POST['name']);
        $email = trim($_POST['email']);
        $messageContent = trim($_POST['msg']);
        
        if (empty($name) || empty($email) || empty($messageContent)) {
            $message[] = 'All fields are required.';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $message[] = 'Invalid email format.';
        } else {
            try {
                $sql = "INSERT INTO inquiries (name, email, message) VALUES (:name, :email, :message)";
                $query = $conn->prepare($sql);
                $query->bindParam(':name', $name);
                $query->bindParam(':email', $email);
                $query->bindParam(':message', $messageContent);
                $query->execute();
                
                $message[] = 'Your inquiry has been submitted successfully.';
            } catch (PDOException $e) {
                $message[] = 'Error: ' . $e->getMessage();
            }
        }
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
        
        <div class="banner-3">
            <div class="container">
                <p style="font-size: 52px;">Contact Us</p>
                <h5 class=""> <a href="contact.php">Contact us</a>  
                    <span> |</span> <a href="index.php"> Home</a></h5>
            </div>
        </div>

        <!-- main content --><br><br><br>
        <div class="contact-content">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <h2>Get In Touch</h2>
                        <p class="contact">Do you have anything in your mind to let us know or inquire about product? 
                            Kindly don't delay to contact us by means of our contact form.</p>
                        <div class="row">
                            <div class="col-lg-7">
                                <form action="" method="post">
                                    <div class="row">
                                        <div class="col-md-6 form-group">
                                            <input type="text" class="form-control" name="name" id="name" placeholder="Your name" required>
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <input type="email" class="form-control" name="email" id="email" placeholder="Email address" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <textarea class="form-control" id="msg" name="msg" placeholder="Write your message" rows="4" required></textarea>
                                    </div>
                                    <button class="btn float-left custom-btn" name="submit">Submit</button>
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
                </div>
            </div>

        </div>
        <!-- footer -->
        <?php include 'components/footer.php'?>
    </body>

</html>