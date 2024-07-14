<?php
    $conn = mysqli_connect("localhost", "root", "", "parkiran-daffa");
    if ($conn -> connect_errno) {
        echo "Failed to connect to MySQL: " . $conn -> connect_error;
        exit();
    }
