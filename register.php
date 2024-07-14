<?php
 include "koneksi.php";
 session_start();
 if(isset($_SESSION['id_card'])){
    header('Location: dashboard.php');
 } 
 if(isset($_POST['name']) && isset($_POST['email']) && isset($_POST['id_card']) && isset($_POST['password']) && isset($_POST['password2'])){
    $name = $_POST['name'];
    $email = $_POST['email'];
    $id_card = $_POST['id_card'];
    $password = $_POST['password'];
    $password2 = $_POST['password2'];
    $resultEmail = mysqli_fetch_object(mysqli_query($conn, "SELECT * FROM user WHERE email = '".$_POST['email']."'"));
    $resultIDCard = mysqli_fetch_object(mysqli_query($conn, "SELECT * FROM user WHERE id_card = '".$_POST['id_card']."'"));

    if($password != $password2) echo "<script>alert('password and confirm password not same!');</script>";
    else if($resultEmail) echo "<script>alert('this email alraedy registred!');</script>";
    else if($resultIDCard) echo "<script>alert('this ID Card alraedy registred!');</script>";
    else{
        $sql = "INSERT INTO `user` (`id`, `name`, `email`, `id_card`, `password`) VALUES (NULL, '".$_POST['name']."', '".$_POST['email']."', '".$_POST['id_card']."', '".password_hash($_POST['password'], PASSWORD_DEFAULT)."');";
        $result = mysqli_query($conn, $sql);
        if($result){
            $_SESSION['id_card'] = $id_card;
            header('Location: dashboard.php');
        }
    }
 }
?>

<!doctype html>
<html lang="en" data-bs-theme="dark">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Smart Parking | Register</title>
    <link href="/bootstrap-5.3.3/bootstrap.min.css" rel="stylesheet">
  </head>
  <body>
    <div class="container d-flex align-items-center justify-content-center" style="height:100vh;">
        <div class="card" style="overflow:hidden; border-radius:15px; width:500px;">
            <div class="p-5">
                <form method="POST" action="">
                    <h1>Register</h1>
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="<?=$_POST['name'] ?? '' ?>">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?=$_POST['email'] ?? '' ?>">
                    </div>
                    <div class="mb-3">
                        <label for="id_card" class="form-label">ID Card</label>
                        <input type="text" class="form-control" id="id_card" name="id_card" value="<?=$_POST['id_card'] ?? '' ?>">
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password">
                    </div>
                    <div class="mb-3">
                        <label for="password2" class="form-label">Confirm Password</label>
                        <input type="password" class="form-control" id="password2" name="password2">
                    </div>
                    <p>have an account ? <a href="/login.php">Login</a></p>
                    <button type="submit" class="btn btn-primary w-100 mt-2">Register</button>
                </form>
            </div>
        </div>
    </div>
    <script src="/bootstrap-5.3.3/bootstrap.bundle.min.js"></script>
  </body>
</html>