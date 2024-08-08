<?php
    // session_start();
    include 'components/session-init.php';
    
?>

<div class="nvbr">
    <div class="nvbr-nv">
        <ul class="nv-ul">
            <li class="nav-li logo"> <a href=""><img src="../Admin/item-images/logo2.jpeg" alt=""><span></span></a></li>
            <li class="nav-li"> <a href="index.php">Home</a></li> 
            <li class="nav-li"> <a href="items.php">Our Cakes</a></li>
            <!-- <li class="nav-li">
                <a href="#">Category</a>
                <ul class="dropdown">
                    <li><a href="category1.php">Category 1</a></li>
                    <li><a href="category2.php">Category 2</a></li>
                    <li><a href="category3.php">Category 3</a></li>
                </ul>
            </li> -->
            <li class="nav-li"> <a href="cart.php">Cart</a></li>
            <li class="nav-li"> <a href="about.php">About Us</a></li>
            <li class="nav-li">
                <?php
                if (isset($_SESSION['user_id'])) {
                    echo '<a href="#">My Account</a>';
                    echo '<ul class="dropdown">';
                    echo '<li><a href="profile.php">Profile</a></li>';
                    echo '<li><a href="change-password.php">Change Password</a></li>';
                    echo '<li><a href="logout.php">Logout</a></li>';
                    echo '</ul>';
                } else {
                    echo '<a href="signup.php">SignUp</a> <span> / </span> <a href="login.php">SignIn</a>';
                }
                ?>
            </li>
            <li class="nav-li"> <a href="orders.php">My Orders</a></li>
            <li class="nav-li"> <a href="contact.php">Contact Us</a></li>   
        </ul>
    </div>
</div>