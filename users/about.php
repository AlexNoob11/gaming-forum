<?php
require 'db.php';
// Check if logged in to customize the nav
$is_logged_in = isset($_SESSION['user_id']);
$username = $is_logged_in ? htmlspecialchars($_SESSION['username']) : '';
$avatar_seed = $is_logged_in ? htmlspecialchars($_SESSION['avatar']) : '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About & Guidelines | NexusGrid</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&family=Rajdhani:wght@500;700&display=swap');
        
        body { font-family: 'Inter', sans-serif; background-color: #0f172a; color: #e2e8f0; overflow-x: hidden; }
        .heading-font { font-family: 'Rajdhani', sans-serif; }
        .glass { background: rgba(30, 41, 59, 0.7); backdrop-filter: blur(10px); }
        .gradient-text { background: linear-gradient(90deg, #3b82f6, #8b5cf6); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
        
        .rule-card:hover { transform: translateY(-5px); border-color: #3b82f6; box-shadow: 0 10px 30px -15px rgba(59, 130, 246, 0.5); }
        .rule-card { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
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
                    <a href="about.php" class="text-blue-400 border-b-2 border-blue-500 pb-1">Guidelines</a>
                    <a href="category.php" class="hover:text-blue-400 transition">Category</a>
                    <a href="create_post.php" class="hover:text-blue-400 transition">Create a post</a>
                    <a href="thread.php" class="hover:text-blue-400 transition">Threads</a>
                    <a href="profile.php" class="block text-slate-300">Profile</a>
                </div>

                <div class="flex items-center gap-4">
                    <div class="hidden md:flex items-center gap-3 bg-slate-800/50 p-1 pr-4 rounded-full border border-slate-700">
                        <img src="https://api.dicebear.com/7.x/avataaars/svg?seed=<?php echo $avatar_seed; ?>" class="w-8 h-8 rounded-full">
                        <span class="text-sm font-bold text-white"><?php echo $username; ?></span>
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
                <img src="https://api.dicebear.com/7.x/avataaars/svg?seed=<?php echo $avatar_seed; ?>" class="w-10 h-10 rounded-full">
                <div>
                    <p class="text-sm font-bold text-white"><?php echo $username; ?></p>
                    <a href="auth.php?logout=1" class="text-xs text-red-400">Sign Out</a>
                </div>
            </div>
            <a href="dashboard.php" class="block text-blue-400 font-bold">Home</a>
            <a href="about.php" class="block text-slate-300">Guidelines</a>
            <a href="category.php" class="block text-slate-300">Category</a>
            <a href="create_post.php" class="block text-slate-300">Create Post</a>
            <a href="thread.php" class="block text-slate-300">Threads</a>
            <a href="profile.php" class="block text-slate-300">Profile</a>
        </div>
    </nav>

    <main class="max-w-4xl mx-auto px-6 py-12 md:py-20">
        
        <header class="text-center mb-16">
            <div class="inline-block px-3 py-1 mb-4 text-[10px] font-bold tracking-widest text-blue-400 uppercase bg-blue-500/10 border border-blue-500/20 rounded-full">
                Operation Manual
            </div>
            <h1 class="heading-font text-5xl md:text-6xl font-bold mb-4 uppercase italic tracking-tighter">Nexus <span class="gradient-text">Protocols</span></h1>
            <p class="text-slate-400 text-lg max-w-2xl mx-auto leading-relaxed">Established in 2024, NexusGrid is a high-bandwidth sanctuary for competitive spirits and hardware enthusiasts.</p>
        </header>

        <div class="space-y-16">
            
            <section class="glass p-8 md:p-10 rounded-3xl border border-slate-700/50 relative overflow-hidden group">
                <div class="absolute -right-8 -top-8 text-blue-500/5 text-9xl rotate-12 group-hover:text-blue-500/10 transition-colors">
                    <i class="fa-solid fa-rocket"></i>
                </div>
                <h2 class="heading-font text-2xl md:text-3xl font-bold mb-6 text-white flex items-center gap-3">
                    <i class="fa-solid fa-bullseye text-blue-500"></i> Our Mission
                </h2>
                <p class="text-slate-300 leading-relaxed text-base md:text-lg relative z-10">
                    NexusGrid was built to bridge the gap between casual players and the pro circuit. We believe gaming is more than a hobby—it's a culture of continuous improvement, technical mastery, and shared strategy. Our goal is to provide the fastest, cleanest platform for the exchange of digital knowledge.
                </p>
            </section>

            <section>
                <h2 class="heading-font text-xl font-bold mb-8 text-slate-500 uppercase tracking-[0.3em] text-center">Community Standards</h2>
                <div class="grid md:grid-cols-2 gap-6">
                    
                    <div class="rule-card bg-slate-800/40 p-8 rounded-2xl border border-slate-700/50">
                        <div class="bg-blue-500/10 w-12 h-12 rounded-xl flex items-center justify-center text-blue-500 mb-6">
                            <i class="fa-solid fa-hand-fist text-2xl"></i>
                        </div>
                        <h3 class="font-bold text-xl mb-3 text-white italic">GG, No Toxicity</h3>
                        <p class="text-sm text-slate-400 leading-relaxed">Respect your rivals. Trash talk is part of the game; harassment is not. Keep it competitive, keep it civil. Bigotry and hate speech result in immediate uplink termination.</p>
                    </div>

                    <div class="rule-card bg-slate-800/40 p-8 rounded-2xl border border-slate-700/50">
                        <div class="bg-red-500/10 w-12 h-12 rounded-xl flex items-center justify-center text-red-500 mb-6">
                            <i class="fa-solid fa-shield-halved text-2xl"></i>
                        </div>
                        <h3 class="font-bold text-xl mb-3 text-white italic">Anti-Cheat Policy</h3>
                        <p class="text-sm text-slate-400 leading-relaxed">Discussion of game-breaking exploits or the distribution of malicious cheating software results in an instant perma-ban. We play fair or we don't play at all.</p>
                    </div>

                    <div class="rule-card bg-slate-800/40 p-8 rounded-2xl border border-slate-700/50">
                        <div class="bg-purple-500/10 w-12 h-12 rounded-xl flex items-center justify-center text-purple-500 mb-6">
                            <i class="fa-solid fa-folder-open text-2xl"></i>
                        </div>
                        <h3 class="font-bold text-xl mb-3 text-white italic">The Right Grid</h3>
                        <p class="text-sm text-slate-400 leading-relaxed">Post hardware questions in the Hardware hub. Keep off-topic content in the 'Lounge'. Correct categorization keeps the data stream optimized for everyone.</p>
                    </div>

                    <div class="rule-card bg-slate-800/40 p-8 rounded-2xl border border-slate-700/50">
                        <div class="bg-yellow-500/10 w-12 h-12 rounded-xl flex items-center justify-center text-yellow-500 mb-6">
                            <i class="fa-solid fa-eye text-2xl"></i>
                        </div>
                        <h3 class="font-bold text-xl mb-3 text-white italic">Spoiler Protocol</h3>
                        <p class="text-sm text-slate-400 leading-relaxed">Use spoiler tags for any plot-sensitive discussion of new releases within 30 days of launch. Don't ruin the campaign for fellow pilots.</p>
                    </div>

                </div>
            </section>

            <div class="relative">
                <div class="absolute inset-0 bg-blue-500/5 blur-3xl rounded-full"></div>
                <div class="relative border-l-4 border-blue-500 bg-slate-800/50 p-8 rounded-r-2xl italic text-slate-300 text-lg shadow-xl">
                    "Our moderators are volunteers who love the game as much as you do. Treat them with respect and they will ensure the community remains a top-tier environment for everyone." 
                    <span class="block mt-4 font-bold text-blue-400 not-italic uppercase tracking-widest text-sm">— The Admin Team</span>
                </div>
            </div>

        </div>
    </main>

    <footer class="border-t border-slate-800 py-12 text-center text-slate-500 text-xs tracking-widest uppercase px-4">
        <p class="mb-4">&copy; 2026 NexusGrid. All systems operational.</p>
        <div class="flex justify-center gap-6">
            <a href="#" class="hover:text-blue-500 transition">Twitter</a>
            <a href="#" class="hover:text-blue-500 transition">Discord</a>
            <a href="about.php" class="text-white">Guidelines</a>
        </div>
    </footer>

    <script>
        function toggleMenu() {
            const menu = document.getElementById('mobileMenu');
            menu.classList.toggle('hidden');
        }
    </script>

</body>
</html>