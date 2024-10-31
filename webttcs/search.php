<?php

include "connect.php";


if (isset($_POST['query'])) {
    $inpText = $_POST['query'];
    $sql = "SELECT name, id FROM product WHERE name LIKE '%$inpText%' LIMIT 4";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        
        while ($row = mysqli_fetch_assoc($result)) {
            $id = $row['id'];
            echo "<a href='shop-detail.php?id=" . $id . "' class='list-group-item list-group-item-action border-1'>" . $row['name'] . "</a>";
        }
        
    } else {
        echo "<p class='list-group-item border-1'>No Record</p>";
    }
}
?>