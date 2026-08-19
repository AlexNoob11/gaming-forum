<?php
session_start();
require 'db.php';

// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$stmt = $pdo->prepare("SELECT username, email, avatar, created_at FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch();

if (!$user) {
    die("User not found.");
}

// Define variables to fix the "Undefined variable" errors
$username = $user['username'];
$avatar_seed = $user['avatar'];
$email = $user['email'];

// Format the date
$member_since = date("M Y", strtotime($user['created_at']));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile | NexusGrid</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&family=Rajdhani:wght@500;700&display=swap');
        body { font-family: 'Inter', sans-serif; background-color: #0f172a; color: #e2e8f0; }
        .heading-font { font-family: 'Rajdhani', sans-serif; }
        .glass { background: rgba(30, 41, 59, 0.7); backdrop-filter: blur(10px); }
        .profile-card { background: linear-gradient(145deg, rgba(30, 41, 59, 0.9), rgba(15, 23, 42, 0.9)); border: 1px solid rgba(59, 130, 246, 0.2); }
        .stat-card { background: rgba(15, 23, 42, 0.5); border: 1px solid rgba(255, 255, 255, 0.05); }
    </style>
</head>
<body class="min-h-screen">

    <nav class="glass sticky top-0 z-50 border-b border-slate-700">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center gap-2">
                    <i class="fa-solid fa-ghost text-blue-500 text-2xl"></i>
                    <span class="heading-font text-xl md:text-2xl font-bold tracking-wider uppercase text-white">Gaming<span class="text-blue-500">Forum</span></span>
                </div>
                
                <div class="hidden lg:flex items-center space-x-6 text-sm font-medium">
                    <a href="dashboard.php" class="hover:text-blue-400 transition">Home</a>
                    <a href="about.php" class="hover:text-blue-400 transition">Guidelines</a>
                    <a href="category.php" class="hover:text-blue-400 transition">Category</a>
                    <a href="create_post.php" class="hover:text-blue-400 transition">Create a post</a>
                    <a href="thread.php" class="hover:text-blue-400 transition">Threads</a>
                    <a href="profile.php" class="text-blue-400 border-b-2 border-blue-500 pb-1">Profile</a>
                </div>

                <div class="flex items-center gap-4">
                    <div class="hidden md:flex items-center gap-3 bg-slate-800/50 p-1 pr-4 rounded-full border border-slate-700">
                        <img src="https://api.dicebear.com/7.x/avataaars/svg?seed=<?php echo htmlspecialchars($avatar_seed); ?>" class="w-8 h-8 rounded-full">
                        <span class="text-sm font-bold text-white"><?php echo htmlspecialchars($username); ?></span>
                        <a href="auth.php?logout=1" class="text-[10px] text-red-400 ml-2 hover:text-red-300 font-bold uppercase">Exit</a>
                    </div>
                    
                    <button onclick="toggleMenu()" class="lg:hidden text-slate-300 p-2 text-xl">
                        <i class="fa-solid fa-bars-staggered"></i>
                    </button>
                </div>
            </div>
        </div>

        <div id="mobileMenu" class="hidden lg:hidden border-t border-slate-700 bg-slate-900/95 p-4 space-y-4">
            <div class="flex items-center gap-3 p-2 bg-slate-800/50 rounded-xl mb-4">
                <img src="https://api.dicebear.com/7.x/avataaars/svg?seed=<?php echo htmlspecialchars($avatar_seed); ?>" class="w-10 h-10 rounded-full">
                <div>
                    <p class="text-sm font-bold text-white"><?php echo htmlspecialchars($username); ?></p>
                    <a href="auth.php?logout=1" class="text-xs text-red-400">Sign Out</a>
                </div>
            </div>
            <a href="dashboard.php" class="block text-slate-300">Home</a>
            <a href="about.php" class="block text-slate-300">Guidelines</a>
            <a href="category.php" class="block text-slate-300">Category</a>
            <a href="create_post.php" class="block text-slate-300">Create Post</a>
            <a href="thread.php" class="block text-slate-300">Threads</a>
            <a href="profile.php" class="block text-blue-400 font-bold">Profile</a>
        </div>
    </nav>

    <main class="max-w-5xl mx-auto px-6 py-12">
        <div class="profile-card rounded-3xl overflow-hidden shadow-2xl">
            <div class="h-32 bg-gradient-to-r from-blue-600 to-purple-600 opacity-50"></div>
            
            <div class="px-8 pb-8">
                <div class="relative flex flex-col md:flex-row items-center md:items-end -mt-16 gap-6">
                    <div class="relative">
                        <img src="https://api.dicebear.com/7.x/avataaars/svg?seed=<?php echo htmlspecialchars($avatar_seed); ?>" 
                             class="w-32 h-32 rounded-2xl bg-slate-800 border-4 border-slate-900 shadow-xl object-cover">
                        <div class="absolute bottom-2 right-2 w-6 h-6 bg-green-500 border-4 border-slate-900 rounded-full shadow-lg"></div>
                    </div>

                    <div class="flex-1 text-center md:text-left">
                        <h1 class="heading-font text-4xl font-bold text-white tracking-tight"><?php echo htmlspecialchars($username); ?></h1>
                        <p class="text-slate-400 flex items-center justify-center md:justify-start gap-2">
                            <i class="fa-regular fa-envelope text-blue-500"></i> <?php echo htmlspecialchars($email); ?>
                        </p>
                    </div>

                    <div class="flex gap-3">
                        <button class="px-6 py-2 bg-blue-600 hover:bg-blue-500 text-white rounded-xl font-bold transition shadow-lg shadow-blue-900/40">
                            Edit Profile
                        </button>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-12">
                    <div class="stat-card p-6 rounded-2xl">
                        <p class="text-xs font-bold uppercase tracking-widest text-slate-500 mb-1">Rank</p>
                        <p class="text-xl font-bold text-white uppercase heading-font">Elite Voyager</p>
                    </div>
                    <div class="stat-card p-6 rounded-2xl">
                        <p class="text-xs font-bold uppercase tracking-widest text-slate-500 mb-1">Member Since</p>
                        <p class="text-xl font-bold text-white heading-font"><?php echo $member_since; ?></p>
                    </div>
                    <div class="stat-card p-6 rounded-2xl">
                        <p class="text-xs font-bold uppercase tracking-widest text-slate-500 mb-1">Status</p>
                        <p class="text-xl font-bold text-green-400 heading-font uppercase">Online</p>
                    </div>
                </div>

                <div class="mt-8 grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <div class="lg:col-span-2 space-y-6">
                        <div class="bg-slate-800/30 p-6 rounded-2xl border border-slate-700/50">
                            <h3 class="heading-font text-xl font-bold text-white mb-4 uppercase tracking-wider">About Me</h3>
                            <p class="text-slate-400 leading-relaxed">
                                Welcome to my digital grid. I'm a passionate gamer and a proud member of the NexusGrid community. 
                                Always looking for the next quest and the best threads.
                            </p>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <h3 class="heading-font text-xl font-bold text-white uppercase tracking-wider">Inventory</h3>
                        <div class="flex flex-wrap gap-2">
                            <span class="px-3 py-1 bg-slate-800 rounded-lg text-xs font-bold text-blue-400 border border-blue-500/30">FPS PRO</span>
                            <span class="px-3 py-1 bg-slate-800 rounded-lg text-xs font-bold text-purple-400 border border-purple-500/30">RPG LOVER</span>
                            <span class="px-3 py-1 bg-slate-800 rounded-lg text-xs font-bold text-orange-400 border border-orange-500/30">BETA TESTER</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script>
        function toggleMenu() {
            const menu = document.getElementById('mobileMenu');
            menu.classList.toggle('hidden');
        }
    </script>
</body>
</html>
