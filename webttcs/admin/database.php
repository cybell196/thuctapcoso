<?php
    include "connect.php";
    
    $sql = "CREATE TABLE account (
        id INT(3) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        email VARCHAR(100) NOT NULL,
        matkhau VARCHAR(30) NOT NULL
    )";

    if($conn -> query($sql) == TRUE) {
        echo "<br> tao bang thanh cong";
    }else{
        echo "<br> tao bang that bai";
    }
?>