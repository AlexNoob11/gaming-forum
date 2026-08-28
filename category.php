<?php
require 'db.php';

// REMOVED GATEKEEPER: Page is now public.
// Check if logged in for UI personalization
$is_logged_in = isset($_SESSION['user_id']);
$username = $is_logged_in ? htmlspecialchars($_SESSION['username']) : 'Guest';
$avatar_seed = $is_logged_in ? htmlspecialchars($_SESSION['avatar']) : 'default';

// Categories Definition
$categories = [
    [
        'title' => 'General Gaming',
        'icon' => 'fa-gamepad',
        'desc' => 'Mainstream discussions, reviews, and latest releases across all platforms.',
        'color' => 'blue',
        'tag' => 'GENERAL'
    ],
    [
        'title' => 'Esports & Tournaments',
        'icon' => 'fa-trophy',
        'desc' => 'Competitive play, professional league tracking, and local tournament brackets.',
        'color' => 'purple',
        'tag' => 'COMPETITIVE'
    ],
    [
        'title' => 'Hardware & PC Builds',
        'icon' => 'fa-microchip',
        'desc' => 'Rig showcases, troubleshooting, and overclocking the latest silicon.',
        'color' => 'emerald',
        'tag' => 'HARDWARE'
    ],
    [
        'title' => 'Development & Mods',
        'icon' => 'fa-code-branch',
        'desc' => 'Game design, engine tweaks, and community-made modifications.',
        'color' => 'amber',
        'tag' => 'SOURCE'
    ]
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sectors | NexusGrid</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&family=Rajdhani:wght@500;700&display=swap');
        
        body { font-family: 'Inter', sans-serif; background-color: #0f172a; color: #e2e8f0; }
        .heading-font { font-family: 'Rajdhani', sans-serif; }
        .glass { background: rgba(30, 41, 59, 0.7); backdrop-filter: blur(10px); }
        
        .category-card { 
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            border: 1px solid rgba(51, 65, 85, 0.5);
        }
        .category-card:hover { 
            transform: translateY(-8px);
            background: rgba(30, 41, 59, 0.9);
            box-shadow: 0 20px 40px -20px rgba(0, 0, 0, 0.5);
        }
        .icon-box { transition: transform 0.3s ease; }
        .category-card:hover .icon-box { transform: scale(1.1); }
    </style>
</head>
<body class="min-h-screen flex flex-col">
<nav class="glass sticky top-0 z-50 border-b border-slate-700">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <div class="flex items-center gap-2">
                <i class="fa-solid fa-ghost text-blue-500 text-2xl"></i>
                <span class="heading-font text-2xl font-bold tracking-wider uppercase text-white">Gaming<span class="text-blue-500">Forum</span></span>
            </div>
            
            <div class="hidden md:flex items-center space-x-8 text-sm font-medium">
                <a href="index.php" class="text-blue-400 border-b-2 border-blue-500">Home</a>
                <a href="about.php" class="hover:text-blue-400 transition text-slate-300">Guidelines</a>
                <a href="category.php" class="hover:text-blue-400 transition text-slate-300">Category</a>
                <a href="create_post.php" class="hover:text-blue-400 transition text-slate-300">Create Post</a>
                <a href="thread.php" class="hover:text-blue-400 transition text-slate-300">Threads</a>
                <a href="profile.php" class="hover:text-blue-400 transition text-slate-300">Profile</a>
            </div>

            <div class="flex items-center gap-4">
                <?php if(isset($_SESSION['user_id'])): ?>
                    <div class="flex items-center gap-3 bg-slate-800/50 p-1 pr-4 rounded-full border border-slate-700">
                        <img src="https://api.dicebear.com/7.x/avataaars/svg?seed=<?php echo $_SESSION['avatar']; ?>" class="w-8 h-8 rounded-full">
                        <span class="text-sm font-bold text-white hidden sm:block"><?php echo $_SESSION['username']; ?></span>
                        <a href="auth.php?logout=1" class="text-xs text-red-400 ml-2 hover:text-red-300">Logout</a>
                    </div>
                <?php else: ?>
                    <div class="hidden md:flex items-center gap-4">
                        <button onclick="toggleModal('loginModal')" class="text-sm font-semibold text-slate-300 hover:text-blue-400 transition">Login</button>
                        <button onclick="toggleModal('signupModal')" class="px-5 py-2 bg-blue-600 hover:bg-blue-500 text-white text-sm font-bold rounded-full transition shadow-lg shadow-blue-900/20">
                            Sign Up
                        </button>
                    </div>

                    <button onclick="toggleMenu()" class="md:hidden text-slate-300 p-2 text-2xl">
                        <i class="fa-solid fa-bars-staggered"></i>
                    </button>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div id="mobileMenu" class="hidden md:hidden glass border-b border-slate-700 p-4 space-y-4 bg-slate-900/95">
        <div class="flex flex-col space-y-4">
            <a href="index.php" class="block text-blue-400 font-semibold px-2">Home</a>
            <a href="about.php" class="block text-slate-200 hover:text-blue-400 px-2 transition">Guidelines</a>
            <a href="category.php" class="block text-slate-200 hover:text-blue-400 px-2 transition">Category</a>
            <a href="create_post.php" class="block text-slate-200 hover:text-blue-400 px-2 transition">Create a post</a>
            <a href="thread.php" class="block text-slate-200 hover:text-blue-400 px-2 transition">Threads</a>
            <a href="profile.php" class="block text-slate-200 hover:text-blue-400 px-2 transition">Profile</a>
        </div>

        <div class="pt-4 border-t border-slate-700/50 flex flex-col gap-3">
            <button onclick="toggleModal('loginModal')" 
                class="w-full py-3 text-sm font-semibold text-white border border-slate-600 hover:bg-slate-800 rounded-xl transition">
                Login
            </button>
            <button onclick="toggleModal('signupModal')" 
                class="w-full py-3 bg-blue-600 hover:bg-blue-500 text-white text-sm font-bold rounded-xl transition shadow-lg shadow-blue-900/40 text-center">
                Sign Up
            </button>
        </div>
    </div>
</nav>

    <div id="loginModal" class="hidden fixed inset-0 z-[200] flex items-center justify-center p-4">
    <div class="absolute inset-0 bg-slate-950/80 backdrop-blur-sm" onclick="toggleModal('loginModal')"></div>
    <form action="auth.php" method="POST" class="relative glass border border-slate-700 p-8 rounded-3xl w-full max-w-md">
        <h2 class="heading-font text-2xl font-bold text-white mb-6 uppercase">User Login</h2>
        <div class="space-y-4">
            <input type="email" name="email" placeholder="Email Address" required class="w-full bg-slate-900 border border-slate-700 p-3 rounded-xl outline-none focus:border-blue-500 text-white">
            <input type="password" name="password" placeholder="Password" required class="w-full bg-slate-900 border border-slate-700 p-3 rounded-xl outline-none focus:border-blue-500 text-white">
            <button type="submit" name="login" class="w-full bg-blue-600 py-3 rounded-xl font-bold text-white uppercase tracking-widest hover:bg-blue-500 transition">Authorize</button>
        </div>
    </form>
</div>

<div id="signupModal" class="hidden fixed inset-0 z-[200] flex items-center justify-center p-4">
    <div class="absolute inset-0 bg-slate-950/80 backdrop-blur-sm" onclick="toggleModal('signupModal')"></div>
    <form action="auth.php" method="POST" class="relative glass border border-slate-700 p-8 rounded-3xl w-full max-w-md">
        <h2 class="heading-font text-2xl font-bold text-white mb-6 uppercase">Join the Grid</h2>
        <div class="space-y-4">
            <input type="text" name="username" placeholder="Username" required class="w-full bg-slate-900 border border-slate-700 p-3 rounded-xl outline-none focus:border-blue-500 text-white">
            <input type="email" name="email" placeholder="Email Address" required class="w-full bg-slate-900 border border-slate-700 p-3 rounded-xl outline-none focus:border-blue-500 text-white">
            <input type="password" name="password" placeholder="Password" required class="w-full bg-slate-900 border border-slate-700 p-3 rounded-xl outline-none focus:border-blue-500 text-white">
            <button type="submit" name="signup" class="w-full bg-blue-600 py-3 rounded-xl font-bold text-white uppercase tracking-widest hover:bg-blue-500 transition">Initialize Profile</button>
        </div>
    </form>
</div>

    <header class="py-16 px-4">
        <div class="max-w-7xl mx-auto text-center">
            <h1 class="heading-font text-5xl font-black text-white uppercase tracking-tighter mb-4">
                Sector <span class="text-blue-500">Selection</span>
            </h1>
            <p class="text-slate-400 font-mono text-sm uppercase tracking-widest">Select a frequency to filter transmissions</p>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 pb-20 flex-grow">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <?php foreach ($categories as $cat): ?>
                <a href="thread.php?category=<?php echo urlencode($cat['title']); ?>" class="category-card glass p-8 rounded-3xl group relative overflow-hidden">
                    <div class="absolute -right-10 -top-10 w-32 h-32 bg-<?php echo $cat['color']; ?>-500/10 blur-3xl rounded-full"></div>
                    
                    <div class="flex items-start gap-6 relative z-10">
                        <div class="icon-box w-16 h-16 rounded-2xl bg-<?php echo $cat['color']; ?>-500/20 flex items-center justify-center text-<?php echo $cat['color']; ?>-400 text-3xl border border-<?php echo $cat['color']; ?>-500/30">
                            <i class="fa-solid <?php echo $cat['icon']; ?>"></i>
                        </div>
                        
                        <div class="flex-grow">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-[10px] font-black tracking-widest text-<?php echo $cat['color']; ?>-500 uppercase"><?php echo $cat['tag']; ?></span>
                                <i class="fa-solid fa-arrow-right text-slate-700 group-hover:text-white group-hover:translate-x-1 transition"></i>
                            </div>
                            <h3 class="heading-font text-2xl font-bold text-white mb-2 uppercase"><?php echo $cat['title']; ?></h3>
                            <p class="text-slate-400 text-sm leading-relaxed">
                                <?php echo $cat['desc']; ?>
                            </p>
                        </div>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>

        <div class="mt-12 p-8 glass rounded-3xl border border-dashed border-slate-700 text-center">
            <h4 class="text-white font-bold mb-2 uppercase text-sm">Can't find what you're looking for?</h4>
            <a href="thread.php" class="text-blue-400 text-xs font-mono uppercase tracking-widest hover:text-blue-300">View All Transmissions →</a>
        </div>
    </main>

    <footer class="border-t border-slate-800 py-12 text-center text-slate-500 text-xs tracking-widest uppercase px-4">
        <p class="mb-4">&copy; 2026 NexusGrid. All systems operational.</p>
        <div class="flex justify-center gap-6">
            <a href="#" class="hover:text-blue-500 transition">Twitter</a>
            <a href="#" class="hover:text-blue-500 transition">Discord</a>
            <a href="about.php" class="hover:text-white transition">Guidelines</a>
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
