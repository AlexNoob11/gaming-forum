<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 1. Capture Data
    $new_id = time(); // Use timestamp as a unique ID
    $title = htmlspecialchars($_POST['title']);
    $category_slug = $_POST['category'];
    $content = htmlspecialchars($_POST['content']);
    
    // Map slugs to display names
    $categories = [
        "general" => "General Gaming",
        "esports" => "Esports & Tournaments",
        "hardware" => "Hardware & PC Builds",
        "modding" => "Development & Mods"
    ];

    // 2. Structure the new thread object
    $new_thread = [
        "title" => $title,
        "category_name" => $categories[$category_slug] ?? "General",
        "category_slug" => $category_slug,
        "author" => "Guest_User", // Simulation default
        "author_role" => "New Member",
        "author_avatar" => "Guest" . rand(1, 99),
        "upvotes" => 0,
        "content" => $content,
        "stats" => ["Status" => "Just Launched", "Origin" => "Web Terminal"]
    ];

    // 3. Store in Session
    if (!isset($_SESSION['custom_threads'])) {
        $_SESSION['custom_threads'] = [];
    }
    $_SESSION['custom_threads'][$new_id] = $new_thread;

    // 4. Redirect to thread.php to see the result
    header("Location: thread.php?status=success");
    exit();
}
?>