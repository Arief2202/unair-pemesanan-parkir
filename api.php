<?php
    include 'koneksi.php';
    header('Content-Type: application/json; charset=utf-8');
    http_response_code(400);
    $r1 = mysqli_fetch_object(mysqli_query($conn, "SELECT * FROM pemesanan WHERE slot = 'r1' AND status > 0 and status < 3"));
    $r2 = mysqli_fetch_object(mysqli_query($conn, "SELECT * FROM pemesanan WHERE slot = 'r2' AND status > 0 and status < 3"));
    $r3 = mysqli_fetch_object(mysqli_query($conn, "SELECT * FROM pemesanan WHERE slot = 'r3' AND status > 0 and status < 3"));
    $l1 = mysqli_fetch_object(mysqli_query($conn, "SELECT * FROM pemesanan WHERE slot = 'l1' AND status > 0 and status < 3"));
    $l2 = mysqli_fetch_object(mysqli_query($conn, "SELECT * FROM pemesanan WHERE slot = 'l2' AND status > 0 and status < 3"));
    $l3 = mysqli_fetch_object(mysqli_query($conn, "SELECT * FROM pemesanan WHERE slot = 'l3' AND status > 0 and status < 3"));

    if(isset($_GET['read'])){
        http_response_code(200);
        echo json_encode([
            // "slots" => [
            //     "r1" => $r1 ? 1 : 0,
            //     "r2" => $r2 ? 1 : 0,
            //     "r3" => $r3 ? 1 : 0,
            //     "l1" => $l1 ? 1 : 0,
            //     "l2" => $l2 ? 1 : 0,
            //     "l3" => $l3 ? 1 : 0,
            // ]
            "slots" => [
                "r1" => $r1 ? (int)$r1->status : 0,
                "r2" => $r2 ? (int)$r2->status : 0,
                "r3" => $r3 ? (int)$r3->status : 0,
                "l1" => $l1 ? (int)$l1->status : 0,
                "l2" => $l2 ? (int)$l2->status : 0,
                "l3" => $l3 ? (int)$l3->status : 0,
            ]
        ]);
    }
    if(isset($_GET['checkin']) && isset($_GET['id_card'])){
        $user = mysqli_fetch_object(mysqli_query($conn, "SELECT * FROM user WHERE id_card = '".$_GET['id_card']."'"));
        $pemesanan = mysqli_fetch_object(mysqli_query($conn, "SELECT * FROM pemesanan WHERE user_id = '".$user->id."' AND status = 1"));
        if($user){
            if($pemesanan){
                $result = mysqli_query($conn, "UPDATE `pemesanan` SET `status` = '2' WHERE `pemesanan`.`id` = ".$pemesanan->id.";");
                if($result){
                    $slots = ["r3", "r2", "r1", "l1", "l2", "l3"];
                    http_response_code(200);
                    header("Content-Type: text/plain");
                    for($a=0; $a<6; $a++){
                        if($pemesanan->slot == $slots[$a]) echo $a+1, die;
                    }
                }
                else{
                    echo json_encode([
                        "status" => "failed",
                        "pesan" => "Checkin failed, database error!",
                        "user" => $user,
                    ]);
                }
            }
            else{
                echo json_encode([
                    "status" => "failed",
                    "pesan" => "Checkin failed, data pemesanan tidak ditemukan!",
                    "user" => $user,
                ]);
            }
        }
        else{
            echo json_encode([
                "status" => "failed",
                "pesan" => "Checkin failed, data user tidak ditemukan!",
            ]);
        }
    }
    if(isset($_GET['checkout']) && isset($_GET['id_card'])){
        $user = mysqli_fetch_object(mysqli_query($conn, "SELECT * FROM user WHERE id_card = '".$_GET['id_card']."'"));
        $pemesanan = mysqli_fetch_object(mysqli_query($conn, "SELECT * FROM pemesanan WHERE user_id = '".$user->id."' AND status = 2"));
        if($user){
            if($pemesanan){
                $result = mysqli_query($conn, "UPDATE `pemesanan` SET `status` = '3' WHERE `pemesanan`.`id` = ".$pemesanan->id.";");
                if($result){
                    http_response_code(200);
                    echo json_encode([
                        "status" => "success",
                        "pesan" => "Checkout berhasil",
                        "user" => $user,
                        "pemesanan" => $pemesanan,
                    ]);
                }
                else{
                    echo json_encode([
                        "status" => "failed",
                        "pesan" => "Checkout failed, database error!",
                        "user" => $user,
                    ]);
                }
            }
            else{
                echo json_encode([
                    "status" => "failed",
                    "pesan" => "Checkout failed, data pemesanan tidak ditemukan!",
                    "user" => $user,
                ]);
            }
        }
        else{
            echo json_encode([
                "status" => "failed",
                "pesan" => "Checkout failed, data user tidak ditemukan!",
            ]);
        }
    }
    if(isset($_GET['update_slot']) && isset($_GET['slot']) && isset($_GET['status'])){
        $slot = $_GET['slot'];
        if($slot != 'l1' && $slot != 'l2' && $slot != 'l3' && $slot != 'r1' && $slot != 'r2' && $slot != 'r3'){
            echo json_encode([
                "status" => "failed",
                "pesan" => "change status failed, incorrect slot",
            ]);die;
        }
        $pemesanan = mysqli_fetch_object(mysqli_query($conn, "SELECT * FROM pemesanan WHERE slot = '".$_GET['slot']."' AND status = 1"));
        if($pemesanan){
            http_response_code(403);
            echo json_encode([
                "status" => "failed",
                "pesan" => "pemesan tempat ini belum melakukan checkin!",
                "alarm" => 1
            ]);
            die;
        }
        $pemesanan = mysqli_fetch_object(mysqli_query($conn, "SELECT * FROM pemesanan WHERE user_id = '0' AND slot = '".$_GET['slot']."'"));
        $result = null;
        if(!$pemesanan){
            $sql = "INSERT INTO `pemesanan` (`id`, `user_id`, `slot`, `status`) VALUES (NULL, '0', '".$_GET['slot']."', '".$_GET['status']."');";
            $result = mysqli_query($conn, $sql);
            $result = mysqli_fetch_object(mysqli_query($conn, "SELECT * FROM pemesanan WHERE user_id = 0 AND slot = '".$_GET['slot']."'"));
        }
        else{
            $result = mysqli_query($conn, "UPDATE `pemesanan` SET `status` = '".$_GET['status']."' WHERE `pemesanan`.`id` = ".$pemesanan->id.";");
            $result = mysqli_fetch_object(mysqli_query($conn, "SELECT * FROM pemesanan WHERE user_id = 0 AND slot = '".$_GET['slot']."'"));
        }
        if($result){
            http_response_code(200);
            echo json_encode([
                "status" => "success",
                "pesan" => "change status berhasil",
                "pemesanan" => $result,
                "alarm" => 0
            ]);
        }
        else{
            echo json_encode([
                "status" => "failed",
                "pesan" => "change status failed, database error",
                "alarm" => 0
            ]);
        }
    }