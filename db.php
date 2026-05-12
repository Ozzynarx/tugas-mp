<?php
session_start();

/* PROTECT PAGE */
if(!isset($_SESSION['user_id'])){
    header("Location: main/login.php");
    exit();
}

/* DATABASE CONNECTION */
$conn = new mysqli("localhost","root","","login_system");

if($conn->connect_error){
    die("Connection failed");
}

/* GET USER DATA */
$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare("SELECT * FROM users WHERE id=?");
$stmt->bind_param("i",$user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

/* PAGE ROUTER */
$page = $_GET['page'] ?? "home";
?>