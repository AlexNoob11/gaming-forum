<?php
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php?error=unauthorized");
    exit();
}

$username = $_SESSION['username'];
$avatar_seed = $_SESSION['avatar'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nexus | Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&family=Rajdhani:wght@500;700&display=swap');
        
        body { font-family: 'Inter', sans-serif; background-color: #0f172a; color: #e2e8f0; overflow-x: hidden; }
        .heading-font { font-family: 'Rajdhani', sans-serif; }
        .glass { background: rgba(30, 41, 59, 0.7); backdrop-filter: blur(10px); }
        .card-hover:hover { transform: translateY(-3px); transition: all 0.3s ease; background: rgba(51, 65, 85, 0.5); }
        
        @keyframes slideIn {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
        .animate-slide-in { animation: slideIn 0.5s ease-out forwards; }
    </style>
</head>
<body class="min-h-screen">

    <?php if(isset($_GET['status']) && $_GET['status'] == 'success'): ?>
    <div id="toast" class="fixed top-5 right-5 left-5 md:left-auto z-[100] glass border border-green-500/50 p-4 rounded-xl flex items-center justify-between gap-3 animate-slide-in">
        <div class="flex items-center gap-3">
            <div class="bg-green-500/20 p-2 rounded-lg text-green-400">
                <i class="fa-solid fa-circle-check"></i>
            </div>
            <div>
                <p class="text-sm font-bold text-white">Transmission Received!</p>
                <p class="text-xs text-slate-400">Thread launched successfully.</p>
            </div>
        </div>
        <button onclick="this.parentElement.remove()" class="text-slate-500 hover:text-white">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </div>
    <script>setTimeout(() => document.getElementById('toast')?.remove(), 5000);</script>
    <?php endif; ?>

    <nav class="glass sticky top-0 z-50 border-b border-slate-700">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center gap-2">
                    <i class="fa-solid fa-ghost text-blue-500 text-2xl"></i>
                    <span class="heading-font text-xl md:text-2xl font-bold tracking-wider uppercase text-white">Gaming<span class="text-blue-500">Forum</span></span>
                </div>
                
                <div class="hidden lg:flex items-center space-x-6 text-sm font-medium">
                    <a href="dashboard.php" class="text-blue-400 border-b-2 border-blue-500 pb-1">Home</a>
                    <a href="about.php" class="hover:text-blue-400 transition">Guidelines</a>
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

    <header class="relative py-16 px-4 overflow-hidden">
        <div class="absolute top-0 left-1/2 -translate-x-1/2 w-full h-full bg-[radial-gradient(circle_at_center,_var(--tw-gradient-stops))] from-blue-900/20 via-transparent to-transparent -z-10"></div>
        <div class="max-w-7xl mx-auto text-center">
            <h1 class="heading-font text-5xl md:text-6xl font-bold mb-4 uppercase">Level Up Your <span class="text-blue-500 underline decoration-double">Strategy</span></h1>
            <p class="text-slate-400 max-w-2xl mx-auto mb-10">Join the premier hub for competitive gaming, hardware builds, and esports discussions.</p>
            
            <div class="max-w-xl mx-auto mb-8 relative">
                <div class="flex items-center bg-slate-800/50 border border-slate-700 p-1 rounded-2xl focus-within:border-blue-500 transition-all shadow-2xl">
                    <input type="text" id="topicSearch" onkeyup="filterTopics()" placeholder="Quick filter categories..." 
                           class="flex-1 bg-transparent border-none py-3 px-6 outline-none text-white placeholder:text-slate-500">
                    <button class="bg-blue-600 hover:bg-blue-500 text-white px-6 py-3 rounded-xl font-bold transition flex items-center gap-2">
                        <i class="fa-solid fa-filter text-xs"></i>
                        <span>Filter</span>
                    </button>
                </div>
            </div>

            <a href="create_post.php" class="inline-flex items-center gap-2 text-sm font-bold text-slate-400 hover:text-blue-500 transition group">
                <i class="fa-solid fa-plus group-hover:rotate-90 transition-transform"></i>
                Can't find a topic? Start a New Thread
            </a>
        </div>
    </header>
<main class="max-w-7xl mx-auto px-4 pb-20">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <div class="lg:col-span-2 space-y-10">
            
            <section class="category-group">
                <div class="flex items-center justify-between mb-6 px-2">
                    <div class="flex items-center gap-3">
                        <div class="h-8 w-1 bg-blue-500 rounded-full animate-pulse"></div>
                        <h2 class="heading-font text-2xl font-bold uppercase tracking-wider text-white">The Main Arena</h2>
                    </div>
                    <span class="text-[10px] bg-blue-500/20 text-blue-400 px-2 py-1 rounded-md font-mono border border-blue-500/30">NEW_SERVER_ONLINE</span>
                </div>

                <div class="space-y-4" id="categoryList">
                    <div class="glass p-5 rounded-2xl border border-slate-700/50 card-hover flex flex-col sm:flex-row sm:items-center justify-between gap-6 opacity-90">
                        <div class="flex items-start gap-5">
                            <div class="bg-gradient-to-br from-blue-500/20 to-blue-600/5 p-4 rounded-2xl text-blue-400">
                                <i class="fa-solid fa-trophy text-2xl"></i>
                            </div>
                            <div>
                                <a href="category.php?cat=esports" class="font-bold text-xl text-white hover:text-blue-400 transition decoration-blue-500/30 underline-offset-4 hover:underline">Esports & Tournaments</a>
                                <p class="text-sm text-slate-400 mt-1 leading-relaxed">Discuss pro league results, roster shuffles, and upcoming majors.</p>
                                <div class="flex gap-3 mt-3">
                                    <span class="text-[10px] bg-slate-800 text-slate-500 px-2 py-0.5 rounded uppercase font-bold border border-slate-700 italic">No threads yet</span>
                                </div>
                            </div>
                        </div>
                        <div class="sm:border-l border-slate-800 sm:pl-8 flex flex-col items-center">
                            <a href="create_post.php" class="bg-blue-600/10 hover:bg-blue-600/20 text-blue-400 text-[10px] font-bold py-2 px-4 rounded-full border border-blue-500/30 transition uppercase tracking-widest whitespace-nowrap">
                                <i class="fa-solid fa-plus mr-1"></i> Be the First
                            </a>
                        </div>
                    </div>

                    <div class="glass p-5 rounded-2xl border border-slate-700/50 card-hover flex flex-col sm:flex-row sm:items-center justify-between gap-6 opacity-90">
                        <div class="flex items-start gap-5">
                            <div class="bg-gradient-to-br from-purple-500/20 to-purple-600/5 p-4 rounded-2xl text-purple-400">
                                <i class="fa-solid fa-microchip text-2xl"></i>
                            </div>
                            <div>
                                <a href="category.php?cat=hardware" class="font-bold text-xl text-white hover:text-purple-400 transition underline-offset-4 hover:underline">Battle Stations</a>
                                <p class="text-sm text-slate-400 mt-1 leading-relaxed">Showcase your rig, discuss GPU drops, or ask for build advice.</p>
                                <div class="flex gap-3 mt-3">
                                    <span class="text-[10px] bg-slate-800 text-slate-500 px-2 py-0.5 rounded uppercase font-bold border border-slate-700 italic">Queue is empty</span>
                                </div>
                            </div>
                        </div>
                        <div class="sm:border-l border-slate-800 sm:pl-8 flex flex-col items-center">
                            <a href="create_post.php" class="bg-purple-600/10 hover:bg-purple-600/20 text-purple-400 text-[10px] font-bold py-2 px-4 rounded-full border border-purple-500/30 transition uppercase tracking-widest whitespace-nowrap">
                                <i class="fa-solid fa-plus mr-1"></i> Drop a Spec
                            </a>
                        </div>
                    </div>
                </div>
            </section>

            <section class="category-group">
                <div class="flex items-center gap-3 mb-6 px-2">
                    <div class="h-8 w-1 bg-green-500 rounded-full"></div>
                    <h2 class="heading-font text-2xl font-bold uppercase tracking-wider text-white">Creative Forge</h2>
                </div>
                
                <div class="glass p-5 rounded-2xl border border-slate-700/50 card-hover flex flex-col sm:flex-row sm:items-center justify-between gap-6 opacity-90">
                    <div class="flex items-start gap-5">
                        <div class="bg-gradient-to-br from-green-500/20 to-green-600/5 p-4 rounded-2xl text-green-400">
                            <i class="fa-solid fa-code-branch text-2xl"></i>
                        </div>
                        <div>
                            <a href="category.php?cat=modding" class="font-bold text-xl text-white hover:text-green-400 transition underline-offset-4 hover:underline">Modding & Dev</a>
                            <p class="text-sm text-slate-400 mt-1 leading-relaxed">The place for custom scripts, skin packs, and game development talk.</p>
                            <div class="flex gap-3 mt-3">
                                <span class="text-[10px] bg-slate-800 text-slate-500 px-2 py-0.5 rounded uppercase font-bold border border-slate-700 italic">Awaiting source code...</span>
                            </div>
                        </div>
                    </div>
                    <div class="sm:border-l border-slate-800 sm:pl-8 flex flex-col items-center">
                        <a href="create_post.php" class="bg-green-600/10 hover:bg-green-600/20 text-green-400 text-[10px] font-bold py-2 px-4 rounded-full border border-green-500/30 transition uppercase tracking-widest whitespace-nowrap">
                            <i class="fa-solid fa-terminal mr-1"></i> Start Modding
                        </a>
                    </div>
                </div>
            </section>
        </div>

        <aside class="space-y-6">
            <div class="glass p-6 rounded-3xl border border-slate-700/50 bg-gradient-to-b from-slate-800/40 to-transparent">
                <h3 class="heading-font font-bold mb-5 flex items-center gap-2 text-white italic">
                    <i class="fa-solid fa-satellite-dish text-blue-400"></i> SYSTEM READY
                </h3>
                <div class="space-y-5">
                    <div class="flex justify-between items-end">
                        <span class="text-xs text-slate-400 uppercase font-bold tracking-widest">Growth Phase</span>
                        <span class="text-blue-400 font-mono font-bold text-sm uppercase italic underline decoration-blue-500/20">Alpha V1.0</span>
                    </div>
                    <div class="w-full bg-slate-900 rounded-full h-2 overflow-hidden border border-slate-700">
                        <div class="bg-gradient-to-r from-blue-600 to-cyan-400 h-full rounded-full" style="width: 5%"></div>
                    </div>
                    <div class="grid grid-cols-2 gap-4 pt-2">
                        <div class="bg-slate-900/30 p-3 rounded-xl border border-slate-800/50 text-center">
                            <span class="block text-[10px] text-slate-500 uppercase">Threads</span>
                            <span class="text-sm font-bold text-slate-400 font-mono">0000</span>
                        </div>
                        <div class="bg-slate-900/30 p-3 rounded-xl border border-slate-800/50 text-center">
                            <span class="block text-[10px] text-slate-500 uppercase">Posts</span>
                            <span class="text-sm font-bold text-slate-400 font-mono">0000</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="glass p-6 rounded-3xl border border-slate-700/50 relative overflow-hidden group">
                <div class="absolute inset-0 bg-blue-500/5 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                <h3 class="heading-font font-bold mb-4 uppercase tracking-wider text-sm text-slate-400 flex justify-between">
                    <span>Transmission Feed</span>
                    <i class="fa-solid fa-wifi text-[10px] animate-pulse text-blue-500"></i>
                </h3>
                <div class="text-center py-8">
                    <div class="text-slate-600 text-3xl mb-3"><i class="fa-solid fa-inbox"></i></div>
                    <p class="text-xs text-slate-500 uppercase tracking-tighter">Scanning for new activity...</p>
                    <p class="text-[10px] text-slate-600 mt-2">The grid is currently silent.</p>
                </div>
            </div>
        </aside>

    </div>
</main>

    <footer class="border-t border-slate-800 py-10 text-center text-slate-500 text-sm">
        <p>&copy; 2024 NexusGrid Forum. Built for the gamers.</p>
        <div class="flex justify-center gap-6 mt-4">
            <a href="#" class="hover:text-white transition">Twitter</a>
            <a href="#" class="hover:text-white transition">Discord</a>
            <a href="about.php" class="hover:text-white transition">Community Guidelines</a>
        </div>
    </footer>

    <script>
        function toggleMenu() {
            document.getElementById('mobileMenu').classList.toggle('hidden');
        }

        function filterTopics() {
            let input = document.getElementById('topicSearch').value.toLowerCase();
            let cards = document.querySelectorAll('.category-group .glass');
            
            cards.forEach(card => {
                let title = card.querySelector('a').innerText.toLowerCase();
                let desc = card.querySelector('p').innerText.toLowerCase();
                
                if (title.includes(input) || desc.includes(input)) {
                    card.style.display = "flex";
                } else {
                    card.style.display = "none";
                }
            });
        }
    </script>
</body>
</html>
