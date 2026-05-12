
<?php
session_start();
require "config.php";

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['email'] = $user['email'];

        header("Location: dashboard.php");
        exit();
    } else {
        $error = "Invalid email or password";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login</title>

<style>
body{
    margin:0;
    font-family:Arial, sans-serif;
    height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
    background:url('images/fruit.png') no-repeat center center/cover;
    position:relative;
}

body::before{
    content:"";
    position:absolute;
    top:0;
    left:0;
    width:100%;
    height:100%;
    background:rgba(0,0,0,0.1);
    z-index:0;
}

.login-container{
    position:relative;
    z-index:1;
    background:rgba(255,255,255,0.4);
    backdrop-filter:blur(10px);
    -webkit-backdrop-filter:blur(10px);
    padding:40px;
    border-radius:12px;
    box-shadow:0 8px 25px rgba(0,0,0,0.2);
    width:320px;
    text-align:center;
    color:#333;
}

.login-container img{
    width:100px;
    margin-bottom:20px;
}

.login-container h2{
    margin-bottom:20px;
}

.login-container input{
    width:100%;
    padding:12px;
    margin:10px 0;
    border-radius:6px;
    border:1px solid #ccc;
    box-sizing:border-box;
    background:rgba(255,255,255,0.3);
}

.login-container button{
    width:100%;
    padding:12px;
    margin-top:15px;
    border:none;
    border-radius:6px;
    background:#6b73ff;
    color:white;
    font-size:16px;
    cursor:pointer;
}

.login-container button:hover{
    background:#4e5cff;
}

.register-link{
    display:block;
    margin-top:15px;
    color:#6b73ff;
    text-decoration:none;
}

.register-link:hover{
    text-decoration:underline;
}

.error{
    color:#ff6b6b;
    margin-bottom:10px;
}
</style>

</head>

<body>

<div class="login-container">

<img src="images/smkcbnobg.png" alt="Logo">

<h2>Login</h2>

<?php if($error): ?>
<div class="error"><?= $error ?></div>
<?php endif; ?>

<form method="POST">

<input type="email" name="email" placeholder="Email" required>

<input type="password" name="password" placeholder="Password" required>

<button type="submit">Login</button>

</form>

<a class="register-link" href="register.php">Register</a>

</div>

</body>
</html>

