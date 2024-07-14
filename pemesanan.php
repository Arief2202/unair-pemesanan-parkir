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
    
    $sqlPemesanan = "SELECT * FROM pemesanan WHERE user_id = ".$user->id." AND status > 0 and status < 3";
    $sqlPemesanan = mysqli_query($conn, $sqlPemesanan);
    if($sqlPemesanan->num_rows > 0){        
        echo "<script>alert('Anda memiliki pemesanan aktif!'); window.location.href = \"/history.php\";</script>";
        die;
    }
    if(isset($_POST['slot'])){
        $sql = "INSERT INTO `pemesanan` (`id`, `user_id`, `slot`, `status`) VALUES (NULL, '$user->id', '".$_POST['slot']."', '1');";
        $query = mysqli_query($conn, $sql);
        if($query){
            echo "<script>alert('Pemesanan Berhasil!'); window.location.href = \"/history.php\";</script>";
        }
    }
?>
<!doctype html>
<html lang="en" data-bs-theme="dark">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Smart Parking | Pemesanan</title>
    <link href="/bootstrap-5.3.3/bootstrap.min.css" rel="stylesheet">
  </head>
  <body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary bg-dark text-dark">
    <div class="container">
        <a class="navbar-brand" href="/dashboard.php">Smart Parking</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
        <div class="navbar-nav ms-auto">
            <a class="nav-link" href="/dashboard.php">Dashboard</a>
            <a class="nav-link" href="/history.php">History</a>
            <a class="nav-link active" aria-current="page" href="/pemesanan.php">Pemesanan</a>
            <a class="nav-link" href="/logout.php">Logout</a>
        </div>
        </div>
    </div>
    </nav>

    <?php
        $r1 = mysqli_fetch_object(mysqli_query($conn, "SELECT * FROM pemesanan WHERE slot = 'r1' AND status > 0 and status < 3"));
        $r2 = mysqli_fetch_object(mysqli_query($conn, "SELECT * FROM pemesanan WHERE slot = 'r2' AND status > 0 and status < 3"));
        $r3 = mysqli_fetch_object(mysqli_query($conn, "SELECT * FROM pemesanan WHERE slot = 'r3' AND status > 0 and status < 3"));
        $l1 = mysqli_fetch_object(mysqli_query($conn, "SELECT * FROM pemesanan WHERE slot = 'l1' AND status > 0 and status < 3"));
        $l2 = mysqli_fetch_object(mysqli_query($conn, "SELECT * FROM pemesanan WHERE slot = 'l2' AND status > 0 and status < 3"));
        $l3 = mysqli_fetch_object(mysqli_query($conn, "SELECT * FROM pemesanan WHERE slot = 'l3' AND status > 0 and status < 3"));
    ?>

    <div class="container mt-5">
        <div class="card p-5">         
            <form method="POST" action="">
                
            <div class="d-md-block d-none">

                <div class="row mb-4">
                    <div class="col-md-6 d-flex justify-content-end">
                        <button type="submit" name="slot" value="l1" class="btn <?php if(!$l1){?> btn-outline-success <?php } else { ?> btn-danger disabled<?php } ?>" style="height:100px; font-size:50px; width:300px;">
                            L1
                        </button>
                    </div>
                    <div class="col-md-6">
                        <button type="submit" name="slot" value="r1" class="btn  <?php if(!$r1){?> btn-outline-success <?php } else { ?> btn-danger disabled<?php } ?>" style="height:100px; font-size:50px; width:300px;">
                            R1
                        </button>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-md-6 d-flex justify-content-end">
                        <button type="submit" name="slot" value="l2" class="btn  <?php if(!$l2){?> btn-outline-success <?php } else { ?> btn-danger disabled<?php } ?>" style="height:100px; font-size:50px; width:300px;">
                            L2
                        </button>
                    </div>
                    <div class="col-md-6">
                        <button type="submit" name="slot" value="r2" class="btn  <?php if(!$r2){?> btn-outline-success <?php } else { ?> btn-danger disabled<?php } ?>" style="height:100px; font-size:50px; width:300px;">
                            R2
                        </button>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-md-6 d-flex justify-content-end">
                        <button type="submit" name="slot" value="l3" class="btn  <?php if(!$l3){?> btn-outline-success <?php } else { ?> btn-danger disabled<?php } ?>" style="height:100px; font-size:50px; width:300px;">
                            L3
                        </button>
                    </div>
                    <div class="col-md-6">
                        <button type="submit" name="slot" value="r3" class="btn  <?php if(!$r3){?> btn-outline-success <?php } else { ?> btn-danger disabled<?php } ?>" style="height:100px; font-size:50px; width:300px;">
                            R3
                        </button>
                    </div>
                </div>
            </div>   
            <div class="d-md-none d-block">
                <div class="row mb-4">
                        <div class="col d-flex justify-content-end">
                            <button type="submit" name="slot" value="l1" class="btn <?php if(!$l1){?> btn-outline-success <?php } else { ?> btn-danger disabled<?php } ?>" style="height:100px; font-size:50px; width:100px;">
                                L1
                            </button>
                        </div>
                        <div class="col">
                            <button type="submit" name="slot" value="r1" class="btn  <?php if(!$r1){?> btn-outline-success <?php } else { ?> btn-danger disabled<?php } ?>" style="height:100px; font-size:50px; width:100px;">
                                R1
                            </button>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col d-flex justify-content-end">
                            <button type="submit" name="slot" value="l2" class="btn  <?php if(!$l2){?> btn-outline-success <?php } else { ?> btn-danger disabled<?php } ?>" style="height:100px; font-size:50px; width:100px;">
                                L2
                            </button>
                        </div>
                        <div class="col">
                            <button type="submit" name="slot" value="r2" class="btn  <?php if(!$r2){?> btn-outline-success <?php } else { ?> btn-danger disabled<?php } ?>" style="height:100px; font-size:50px; width:100px;">
                                R2
                            </button>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col d-flex justify-content-end">
                            <button type="submit" name="slot" value="l3" class="btn  <?php if(!$l3){?> btn-outline-success <?php } else { ?> btn-danger disabled<?php } ?>" style="height:100px; font-size:50px; width:100px;">
                                L3
                            </button>
                        </div>
                        <div class="col">
                            <button type="submit" name="slot" value="r3" class="btn  <?php if(!$r3){?> btn-outline-success <?php } else { ?> btn-danger disabled<?php } ?>" style="height:100px; font-size:50px; width:100px;">
                                R3
                            </button>
                        </div>
                    </div>
            </div>
            </form>
        </div>
    </div>
     

    
    <script src="/bootstrap-5.3.3/bootstrap.bundle.min.js"></script>
    <script>

    </script>
  </body>
</html>