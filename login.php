<?php
 include "koneksi.php";
 session_start();
 if(isset($_SESSION['id_card'])){
    header('Location: dashboard.php');
 } 
 if(isset($_POST['id_card']) && isset($_POST['password'])){
    $resultIDCard = mysqli_fetch_object(mysqli_query($conn, "SELECT * FROM user WHERE id_card = '".$_POST['id_card']."'"));
    if(!$resultIDCard) echo "<script>alert('Wrong id card or password!');</script>";
    else{
        if(password_verify($_POST['password'], $resultIDCard->password)){
            $_SESSION['id_card'] = $_POST['id_card'];
            header('Location: dashboard.php');
        }
        else echo "<script>alert('Wrong id card or password!');</script>";
    }

 }
?>
<!doctype html>
<html lang="en" data-bs-theme="dark">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Smart Parking | Login</title>
    <link href="/bootstrap-5.3.3/bootstrap.min.css" rel="stylesheet">
  </head>
  <body>
    <div class="container d-flex align-items-center justify-content-center" style="height:100vh;">
        <div class="card" style="overflow:hidden; border-radius:15px; width:500px;">
            <div class="p-5">
                <form method="POST" action="">
                    <h1>Login</h1>
                    <div class="mb-3">
                        <label for="id_card" class="form-label">ID Card</label>
                        <input type="text" class="form-control" id="id_card" name="id_card" value="<?=$_POST['id_card'] ?? '' ?>">
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password">
                    </div>
                    <p>did'nt have an account ? <a href="/register.php">Register</a></p>
                    <button type="submit" class="btn btn-primary w-100 mt-2">Login</button>
                </form>
            </div>
        </div>
    </div>
    <script src="/bootstrap-5.3.3/bootstrap.bundle.min.js"></script>
  </body>
</html>