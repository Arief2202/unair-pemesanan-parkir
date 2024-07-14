<?php
    include "koneksi.php";
    session_start();
    if(!isset($_SESSION['id_card'])){
        header('Location: /login.php');
        die;
    }
    unset($_SESSION['id_card']);
    header('Location: /dashboard.php');
?>