<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Dashboard</title>
<link rel="stylesheet" href="css/dashboard.css">
</head>

<body>

<header class="header">
    <h2>My Dashboard</h2>

    <div class="user-info">
        Logged in as: <b><?php echo $_SESSION['email']; ?></b>
        <a href="logout.php">Logout</a>
    </div>
</header>

<div class="container"></div>