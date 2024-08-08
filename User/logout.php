<?php
    session_start();
    unset($_SESSION['user_login']);
    unset($_SESSION['user_email']);
    unset($_SESSION['user_id']);
    echo "<script>alert('You are Successfully Loged-out');</script>";
    header('location:index.php');
?>