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
    if(isset($_POST['cancel'])){
        $sql = "UPDATE `pemesanan` SET `status` = '4' WHERE `pemesanan`.`id` = ".$_POST['cancel'].";";
        $query = mysqli_query($conn, $sql);
        if($query) echo "<script>alert('Pesanan berhasil dibatalkan!'); window.location.href = \"/history.php\";</script>";
    }
?>
<!doctype html>
<html lang="en" data-bs-theme="dark">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Smart Parking | History</title>
    <link href="/bootstrap-5.3.3/bootstrap.min.css" rel="stylesheet">
    <link href="/datatables/dataTables.css" rel="stylesheet">
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
            <a class="nav-link active" aria-current="page" href="/history.php">History</a>
            <a class="nav-link" href="/pemesanan.php">Pemesanan</a>
            <a class="nav-link" href="/logout.php">Logout</a>
        </div>
        </div>
    </div>
    </nav>

    <div class="container mt-5">
        <div class="card p-3">
            <table id="myTable" class="display">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Slot</th>
                        <th>Status</th>
                        <th>Waktu Pemesanan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $sql = "SELECT * FROM pemesanan WHERE user_id = $user->id ORDER BY timestamp DESC";
                        $query = mysqli_query($conn, $sql);
                        $idx = 0;
                        while($data = mysqli_fetch_object($query)){
                        $idx++;
                    ?>
                    <tr>
                        <td><?=$idx?></td>
                        <td><?=$data->slot?></td>
                        <?php
                            if($data->status == 1) echo "<td><button class='btn btn-warning disabled'>Menunggu Checkin</button></td>";
                            else if($data->status == 2) echo "<td><button class='btn btn-secondary disabled'>Telah Checkin</button></td>";
                            else if($data->status == 3) echo "<td><button class='btn btn-success disabled'>Transaksi Berhasil</button></td>";
                            else if($data->status == 4) echo "<td><button class='btn btn-danger disabled'>Dibatalkan</button></td>";
                            else echo "<td><button class='btn btn-secondary disabled'>Invalid Status</button></td>";
                        ?>                        
                        <td><?=$data->timestamp?></td>
                        
                        <?php
                            if($data->status == 1) echo "<td><form method='post' action=''><button type='submit' name='cancel' value='$data->id' class='btn btn-danger'>Batalkan Pesanan</button></td></form>";
                            else if($data->status == 2) echo "<td> </td>";
                            else if($data->status == 3) echo "<td> </td>";
                            else if($data->status == 4) echo "<td> </td>";
                            else echo "<td> </td>";
                        ?>    
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
    
    <script src="/bootstrap-5.3.3/bootstrap.bundle.min.js"></script>
    <script src="/jquery-3.7.1/jquery-3.7.1.min.js"></script>
    <script src="/datatables/dataTables.js"></script>
    <script type="text/javascript">
        $(document).ready( function () {
            $('#myTable').DataTable();
        } );
    </script>
  </body>
</html>