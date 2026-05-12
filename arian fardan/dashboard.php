<?php
session_start();

/* PROTECT PAGE */
if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
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

<!DOCTYPE html>
<html>
<head>
<title>fsociety</title>

<style>

/* GLOBAL */
html, body {
    height: 100%;
    margin: 0;
}

body{
    display: flex;
    flex-direction: column;
    font-family: Arial;
    background:#f4f6f9;
}

/* HEADER */
.header{
    background:#667eea;
    color:white;
    padding:15px 30px;
    display:flex;
    justify-content:space-between;
    align-items:center;
}

/* LAYOUT */
.container{
    display:flex;
    flex:1;
}

/* SIDEBAR */
.sidebar{
    width:120px;
    background:#2d3748;
    color:white;
    padding:20px;
}

.sidebar h3{
    margin-top:0;
}

.sidebar ul{
    list-style:none;
    padding:0;
}

.sidebar li{
    margin:15px 0;
}

.sidebar a{
    color:white;
    text-decoration:none;
}

/* MAIN */
.main{
    flex:1;
    padding:30px;
}

/* CARDS */
.cards{
    display:flex;
    gap:20px;
    flex-wrap:wrap;
}

.card{
    background:white;
    padding:20px;
    border-radius:10px;
    box-shadow:0 3px 10px rgba(0,0,0,0.1);
    width:220px;
}

/* PROFILE */
.profile{
    background:white;
    padding:25px;
    border-radius:10px;
    box-shadow:0 3px 10px rgba(0,0,0,0.1);
    width:350px;
}

/* FOOTER */
.footer{
    background:#eee;
    text-align:center;
    padding:12px;
    margin-top:auto;
}

/* LOGOUT */
.logout{
    color:white;
    text-decoration:none;
    margin-left:15px;
}

</style>

</head>

<body>

<!-- HEADER -->
<div class="header">
    <div>
        <h2>Dredge</h2>
    </div>

    <div>
        Logged in as <b><?php echo htmlspecialchars($user['email']); ?></b>
        <a class="logout" href="logout.php">Logout</a>
    </div>
</div>

<div class="container">

<!-- SIDEBAR -->
<div class="sidebar">
    <h3>Menu</h3>
    <ul>
        <li><a href="dashboard.php">Home</a></li>
        <li><a href="?page=profile">Profile</a></li>
    </ul>
</div>

<!-- MAIN CONTENT -->
<div class="main">

<?php if($page == "home"): ?>

<h1>Dashboard</h1>

<p>Welcome back <b><?php echo htmlspecialchars($user['email']); ?></b></p>

<div class="cards">

    <div class="card">
        <h3>User ID</h3>
        <p><?php echo $user['id']; ?></p>
    </div>

    <div class="card">
        <h3>Email</h3>
        <p><?php echo htmlspecialchars($user['email']); ?></p>
    </div>

    <div class="card">
        <h3>Joined</h3>
        <p><?php echo $user['created_at']; ?></p>
    </div>

</div>

<?php elseif($page == "profile"): ?>

<h1>Profile</h1>

<div class="profile">
    <p><b>User ID:</b> <?php echo $user['id']; ?></p>
    <p><b>Email:</b> <?php echo htmlspecialchars($user['email']); ?></p>
    <p><b>Account Created:</b> <?php echo $user['created_at']; ?></p>
</div>

<?php endif; ?>

</div> <!-- END MAIN -->
</div> <!-- END CONTAINER -->

<!-- FOOTER -->
<footer class="footer">
    <p>© <?php echo date("Y"); ?> My System</p>
</footer>

</body>
</html>