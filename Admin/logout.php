<?php
    session_start();
    unset($_SESSION['alogin']);
    header('location:index.php');
?>