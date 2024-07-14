<?php
    include "koneksi.php";
    session_start();
    if(!isset($_SESSION['id_card'])){
        header('Location: /login.php');
        die;
    }
    if(isset($_POST['logout'])){
        unset($_SESSION['id_card']);
        header('Location: /dashboard.php');
    }
    
    $user = mysqli_fetch_object(mysqli_query($conn, "SELECT * FROM user WHERE id_card = '".$_SESSION['id_card']."'"));
    if(!$user){
        unset($_SESSION['id_card']);
        echo "<script>alert('Login Failed, please relogin!'); window.location.href = \"/login.php\";</script>";
        die;
    }
?>
<!doctype html>
<html lang="en" data-bs-theme="dark">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Smart Parking | Dashboard</title>
    <link href="/bootstrap-5.3.3/bootstrap.min.css" rel="stylesheet">
  </head>
  <body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary bg-dark text-dark">
    <div class="container">
        <a class="navbar-brand" href="#">Smart Parking</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
        <div class="navbar-nav ms-auto">
            <a class="nav-link active" aria-current="page" href="/dashboard.php">Dashboard</a>
            <a class="nav-link" href="/history.php">History</a>
            <a class="nav-link" href="/pemesanan.php">Pemesanan</a>
            <a class="nav-link" href="/logout.php">Logout</a>
        </div>
        </div>
    </div>
    </nav>
    <div class="container d-flex align-items-center justify-content-center" style="height:90vh;">
        <div class="card" style="overflow:hidden; border-radius:15px; width:500px;">
            <div class="p-5">
                <div class="row mb-3">
                    <a href="/history.php" class="btn btn-primary">History Pemesanan</a>
                </div>
                <div class="row">
                    <a href="/pemesanan.php" class="btn btn-primary">Pemesanan</a>
                </div>
            </div>
        </div>
    </div>
    <script src="/bootstrap-5.3.3/bootstrap.bundle.min.js"></script>
  </body>
</html>