<?php
session_start();

if (isset($_POST['sortOption'])) {
    $_SESSION['sortOption'] = $_POST['sortOption'];
}

?>