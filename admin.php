<?php
require 'config.php';

session_start();

// Periksa apakah sesi "nama" dan "level" telah diatur
if (!isset($_SESSION["level"]) || $_SESSION["level"] !== "admin") {
    // Jika tidak, redirect ke halaman login
    header("Location: index.php");
    exit();
}

// admin
include 'template/header.php';
include 'template/sidebar.php';
if (!empty($_GET['page'])) {
    include 'module/' . $_GET['page'] . '/index.php';
} else {
    include 'template/home.php';
}
include 'template/footer.php';
// end admin
