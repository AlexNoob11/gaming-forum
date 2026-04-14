<?php
require 'db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['user_id'])) {
    $thread_id = $_POST['thread_id'];
    $content = trim($_POST['content']);
    $user_id = $_SESSION['user_id'];

    if (!empty($content)) {
        $stmt = $pdo->prepare("INSERT INTO replies (thread_id, user_id, content, created_at) VALUES (?, ?, ?, NOW())");
        $stmt->execute([$thread_id, $user_id, $content]);
    }
    
    // Redirect back to the threads page
    header("Location: thread.php"); 
    exit();
}
?>