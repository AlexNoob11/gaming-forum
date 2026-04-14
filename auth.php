<?php
require 'db.php';

// SIGN UP LOGIC
if (isset($_POST['signup'])) {
    $user = $_POST['username'];
    $email = $_POST['email'];
    $pass = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $seed = bin2hex(random_bytes(5)); // Random avatar seed

    $stmt = $pdo->prepare("INSERT INTO users (username, email, password, avatar_seed) VALUES (?, ?, ?, ?)");
    
    if ($stmt->execute([$user, $email, $pass, $seed])) {
        header("Location: index.php?status=registered");
    }
}

// LOGIN LOGIC
if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $pass = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($pass, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['avatar'] = $user['avatar_seed'];
        header("Location: users/dashboard.php?status=loggedin");
    } else {
        header("Location: index.php?error=invalid_credentials");
    }
}

// LOGOUT LOGIC
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: index.php");
}
?>