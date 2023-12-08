<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_SESSION['user'])) {
        unset($_SESSION['user']);
        unset($_SESSION['email']);
        header("Location: index.php");
        echo "Logout success";
        exit();
    } else {
        echo "Not logged in";
        exit();
    }
}
?>