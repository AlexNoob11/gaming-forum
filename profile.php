<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile | NexusGrid</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&family=Rajdhani:wght@500;700&display=swap');
        body { font-family: 'Inter', sans-serif; background-color: #0f172a; color: #e2e8f0; }
        .heading-font { font-family: 'Rajdhani', sans-serif; }
        .glass { background: rgba(30, 41, 59, 0.7); backdrop-filter: blur(10px); }
        .profile-banner { 
            background: linear-gradient(to bottom, rgba(15, 23, 42, 0.3), #0f172a), 
                        url('https://images.unsplash.com/photo-1542751371-adc38448a05e?auto=format&fit=crop&w=1200&q=80');
            background-size: cover;
            background-position: center;
        }
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

    <div class="profile-banner h-64 w-full"></div>
    
    <main class="max-w-7xl mx-auto px-4 -mt-24 pb-20">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            
            <div class="lg:col-span-1">
                <div class="glass p-6 rounded-2xl border border-slate-700 text-center relative">
                    <div class="relative inline-block">
                        <img src="https://api.dicebear.com/7.x/avataaars/svg?seed=Felix" 
                             alt="Avatar" class="w-32 h-32 rounded-2xl border-4 border-slate-900 bg-slate-800 shadow-2xl mb-4">
                        <div class="absolute bottom-6 right-0 w-5 h-5 bg-green-500 border-4 border-slate-900 rounded-full" title="Online"></div>
                    </div>
                    
                    <h1 class="heading-font text-2xl font-bold text-white">CyberGhost_99</h1>
                    <p class="text-blue-400 text-sm font-semibold uppercase tracking-widest mb-4">Elite Vanguard</p>
                    
                    <div class="flex justify-center gap-4 mb-6">
                        <a href="#" class="text-slate-400 hover:text-white transition"><i class="fa-brands fa-discord"></i></a>
                        <a href="#" class="text-slate-400 hover:text-white transition"><i class="fa-brands fa-twitch"></i></a>
                        <a href="#" class="text-slate-400 hover:text-white transition"><i class="fa-brands fa-steam"></i></a>
                    </div>

                    <button class="w-full py-2 bg-blue-600 hover:bg-blue-500 rounded-lg font-bold transition mb-3">Follow</button>
                    <button class="w-full py-2 bg-slate-800 border border-slate-700 hover:bg-slate-700 rounded-lg font-bold transition">Message</button>
                    
                    <div class="mt-8 pt-8 border-t border-slate-800 text-left space-y-4">
                        <div class="flex justify-between text-sm">
                            <span class="text-slate-500">Joined</span>
                            <span class="text-slate-300">Oct 2023</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-slate-500">Reputation</span>
                            <span class="text-green-400">+1,420</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-3 space-y-6">
                
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div class="glass p-4 rounded-xl border border-slate-700 text-center">
                        <span class="block text-2xl font-bold heading-font text-white">152</span>
                        <span class="text-xs uppercase text-slate-500 tracking-tighter">Posts</span>
                    </div>
                    <div class="glass p-4 rounded-xl border border-slate-700 text-center">
                        <span class="block text-2xl font-bold heading-font text-white">843</span>
                        <span class="text-xs uppercase text-slate-500 tracking-tighter">Replies</span>
                    </div>
                    <div class="glass p-4 rounded-xl border border-slate-700 text-center">
                        <span class="block text-2xl font-bold heading-font text-white">12</span>
                        <span class="text-xs uppercase text-slate-500 tracking-tighter">Awards</span>
                    </div>
                    <div class="glass p-4 rounded-xl border border-slate-700 text-center">
                        <span class="block text-2xl font-bold heading-font text-white">2.1k</span>
                        <span class="text-xs uppercase text-slate-500 tracking-tighter">Followers</span>
                    </div>
                </div>

                <div class="glass rounded-2xl border border-slate-700 overflow-hidden">
                    <div class="flex border-b border-slate-700 bg-slate-800/50">
                        <button class="px-6 py-4 text-sm font-bold border-b-2 border-blue-500 text-white">Recent Activity</button>
                        <button class="px-6 py-4 text-sm font-bold text-slate-500 hover:text-slate-300 transition">Hardware Builds</button>
                        <button class="px-6 py-4 text-sm font-bold text-slate-500 hover:text-slate-300 transition">Badges</button>
                    </div>

                    <div class="p-6 space-y-6">
                        <div class="flex gap-4">
                            <div class="mt-1 text-blue-500"><i class="fa-solid fa-comment-dots"></i></div>
                            <div>
                                <p class="text-slate-300 text-sm">
                                    Replied to <a href="#" class="text-blue-400 hover:underline">"Best GPU for 1440p gaming in 2024?"</a>
                                </p>
                                <p class="text-slate-500 text-xs mt-1 italic">"I'd personally wait for the Super series refresh next month before..."</p>
                                <span class="text-[10px] text-slate-600 mt-2 block">2 hours ago</span>
                            </div>
                        </div>

                        <div class="flex gap-4 border-t border-slate-800 pt-6">
                            <div class="mt-1 text-green-500"><i class="fa-solid fa-plus"></i></div>
                            <div>
                                <p class="text-slate-300 text-sm">
                                    Started a new thread in <a href="#" class="text-green-400 hover:underline">Showcase</a>
                                </p>
                                <p class="font-semibold text-white mt-1">My Minimalist White-Out Build [4090 / 7800X3D]</p>
                                <span class="text-[10px] text-slate-600 mt-2 block">Yesterday at 11:30 PM</span>
                            </div>
                        </div>

                        <div class="pt-6">
                            <h3 class="heading-font text-sm font-bold text-slate-500 uppercase mb-4 tracking-widest">Unlocked Badges</h3>
                            <div class="flex flex-wrap gap-3">
                                <div class="w-12 h-12 rounded-lg bg-yellow-500/10 border border-yellow-500/30 flex items-center justify-center text-yellow-500" title="1 Year Anniversary">
                                    <i class="fa-solid fa-cake-candles"></i>
                                </div>
                                <div class="w-12 h-12 rounded-lg bg-blue-500/10 border border-blue-500/30 flex items-center justify-center text-blue-400" title="Top Contributor">
                                    <i class="fa-solid fa-medal"></i>
                                </div>
                                <div class="w-12 h-12 rounded-lg bg-red-500/10 border border-red-500/30 flex items-center justify-center text-red-500" title="Bug Hunter">
                                    <i class="fa-solid fa-bug"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </main>
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