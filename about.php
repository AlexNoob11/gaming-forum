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
        body { font-family: 'Inter', sans-serif; background-color: #0f172a; color: #e2e8f0; }
        .heading-font { font-family: 'Rajdhani', sans-serif; }
        .glass { background: rgba(30, 41, 59, 0.7); backdrop-filter: blur(10px); }
        .gradient-text { background: linear-gradient(90deg, #3b82f6, #8b5cf6); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
    </style>
</head>
<body class="min-h-screen">
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

    <main class="max-w-4xl mx-auto px-6 py-16">
        
        <header class="text-center mb-16">
            <h1 class="heading-font text-5xl font-bold mb-4 uppercase italic">The Gaming <span class="gradient-text">Forum</span></h1>
            <p class="text-slate-400 text-lg">Founded in 2024, NexusGrid is a sanctuary for competitive spirits and hardware enthusiasts.</p>
        </header>

        <div class="space-y-12">
            
            <section class="glass p-8 rounded-2xl border border-slate-700">
                <h2 class="heading-font text-2xl font-bold mb-4 text-white flex items-center gap-3">
                    <i class="fa-solid fa-bullseye text-blue-500"></i> Our Mission
                </h2>
                <p class="text-slate-300 leading-relaxed">
                    NexusGrid was built to bridge the gap between casual players and the pro circuit. We believe gaming is more than a hobby—it's a culture of continuous improvement, technical mastery, and shared strategy. Our goal is to provide the fastest, cleanest platform for the exchange of digital knowledge.
                </p>
            </section>

            <section>
                <h2 class="heading-font text-2xl font-bold mb-6 text-white text-center uppercase tracking-widest">Community Guidelines</h2>
                <div class="grid md:grid-cols-2 gap-4">
                    
                    <div class="bg-slate-800/40 p-6 rounded-xl border border-slate-700 hover:border-blue-500 transition">
                        <div class="text-blue-500 mb-3"><i class="fa-solid fa-hand-fist text-xl"></i></div>
                        <h3 class="font-bold mb-2">GG, No Toxicity</h3>
                        <p class="text-sm text-slate-400">Respect your rivals. Trash talk is part of the game; harassment is not. Keep it competitive, keep it civil.</p>
                    </div>

                    <div class="bg-slate-800/40 p-6 rounded-xl border border-slate-700 hover:border-blue-500 transition">
                        <div class="text-blue-500 mb-3"><i class="fa-solid fa-shield-halved text-xl"></i></div>
                        <h3 class="font-bold mb-2">No Exploits/Cheats</h3>
                        <p class="text-sm text-slate-400">Discussion of game-breaking exploits or the distribution of cheating software results in an instant perma-ban.</p>
                    </div>

                    <div class="bg-slate-800/40 p-6 rounded-xl border border-slate-700 hover:border-blue-500 transition">
                        <div class="text-blue-500 mb-3"><i class="fa-solid fa-folder-open text-xl"></i></div>
                        <h3 class="font-bold mb-2">Correct Categorization</h3>
                        <p class="text-sm text-slate-400">Post hardware questions in the Hardware hub. Keep off-topic content in the 'Lounge' section to keep the grid clean.</p>
                    </div>

                    <div class="bg-slate-800/40 p-6 rounded-xl border border-slate-700 hover:border-blue-500 transition">
                        <div class="text-blue-500 mb-3"><i class="fa-solid fa-eye text-xl"></i></div>
                        <h3 class="font-bold mb-2">No Spoilers</h3>
                        <p class="text-sm text-slate-400">Use the spoiler tag for any plot-sensitive discussion of new releases within 30 days of launch.</p>
                    </div>

                </div>
            </section>

            <div class="border-l-4 border-blue-500 bg-blue-500/5 p-6 italic text-slate-400">
                "Our moderators are volunteers who love the game as much as you do. Treat them with respect and they will ensure the community remains a top-tier environment for everyone." 
                <span class="block mt-2 font-bold text-slate-300">— The Admin Team</span>
            </div>

        </div>
    </main>

    <footer class="border-t border-slate-800 py-10 text-center text-slate-500 text-sm">
        <p>&copy; 2025 Gaming Forum. All rights reserved.</p>
    </footer>
    <div id="loginModal" class="hidden fixed inset-0 z-[200] flex items-center justify-center p-4">
        <div class="absolute inset-0 bg-slate-950/90 backdrop-blur-sm" onclick="toggleModal('loginModal')"></div>
        <form action="auth.php" method="POST" class="relative glass border border-slate-700 p-6 md:p-8 rounded-3xl w-full max-w-sm">
            <h2 class="heading-font text-xl font-bold text-white mb-6 uppercase">User Login</h2>
            <div class="space-y-4">
                <input type="email" name="email" placeholder="Email" required class="w-full bg-slate-900 border border-slate-700 p-3 rounded-xl outline-none focus:border-blue-500 text-white text-sm">
                <input type="password" name="password" placeholder="Password" required class="w-full bg-slate-900 border border-slate-700 p-3 rounded-xl outline-none focus:border-blue-500 text-white text-sm">
                <button type="submit" name="login" class="w-full bg-blue-600 py-3 rounded-xl font-bold text-white uppercase text-xs tracking-widest hover:bg-blue-500 transition">Authorize</button>
            </div>
        </form>
    </div>

    <script>
        function toggleMenu() {
            const menu = document.getElementById('mobileMenu');
            menu.classList.toggle('hidden');
        }

        function toggleModal(id) {
            const modal = document.getElementById(id);
            modal.classList.toggle('hidden');
        }

        function filterTopics() {
            let input = document.getElementById('topicSearch').value.toLowerCase();
            let cards = document.querySelectorAll('.category-group .glass');
            
            cards.forEach(card => {
                let title = card.querySelector('a').innerText.toLowerCase();
                let desc = card.querySelector('p').innerText.toLowerCase();
                
                if (title.includes(input) || desc.includes(input)) {
                    card.classList.remove('hidden');
                    card.classList.add('flex');
                } else {
                    card.classList.remove('flex');
                    card.classList.add('hidden');
                }
            });
        }
    </script>
    

</body>
</html>