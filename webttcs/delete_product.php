<?php
        include "connect.php";
        
        $this_id = $_GET['this_id'];

        $sql = " DELETE FROM product WHERE id='$this_id' ";
        $result = mysqli_query($conn, $sql);

        header('location: admin.php');
    ?>