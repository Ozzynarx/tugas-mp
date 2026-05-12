<?php
require "config.php";

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO users (email, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $email, $password);

    if ($stmt->execute()) {
        $message = "Account created! You can now log in.";
    } else {
        $message = "Email already exists.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <style>
        body {
            margin: 0;
            height: 100vh;
            font-family: Arial, sans-serif;

            background: url("images/reze.jpg") no-repeat center center fixed;
            background-size: cover;

            display: flex;
            justify-content: center;
            align-items: center;
        }

        .container {
            background: rgba(255, 255, 255, 0.5); /* MORE TRANSPARENT */
            backdrop-filter: blur(14px) saturate(160%);
            -webkit-backdrop-filter: blur(14px) saturate(160%);
            border: 1px solid rgba(255, 255, 255, 0.3);

            padding: 40px;
            width: 320px;
            border-radius: 12px;
            box-shadow: 0 8px 30px rgba(0,0,0,0.25);
            text-align: center;
        }

        h2 {
            margin-bottom: 20px;
        }

        input {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 14px;
        }

        button {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 6px;
            background: #667eea;
            color: white;
            font-size: 15px;
            cursor: pointer;
        }

        button:hover {
            background: #5a67d8;
        }

        p {
            margin-top: 15px;
            color: #333;
            font-size: 14px;
        }

        a {
            display: block;
            margin-top: 10px;
            text-decoration: none;
            color: #5a67d8;
            font-size: 14px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Register</h2>

    <form method="POST">
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Register</button>
    </form>

    <p><?= htmlspecialchars($message) ?></p>
    <a href="login.php">Go to Login</a>
</div>

</body>
</html>
