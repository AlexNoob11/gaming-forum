<?php
// submit_post.php simulation logic
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = htmlspecialchars($_POST['title']);
    $category = $_POST['category'];
    $content = htmlspecialchars($_POST['content']);
    
    // In a real app, you'd insert into SQL here. 
    // For this simulation, we'll just redirect with a success message.
    header("Location: index.php?status=success&thread=" . urlencode($title));
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Thread | NexusGrid</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&family=Rajdhani:wght@500;700&display=swap');
        body { font-family: 'Inter', sans-serif; background-color: #0f172a; color: #e2e8f0; }
        .heading-font { font-family: 'Rajdhani', sans-serif; }
        .glass { background: rgba(30, 41, 59, 0.7); backdrop-filter: blur(10px); }
        .input-glow:focus { border-color: #3b82f6; box-shadow: 0 0 15px rgba(59, 130, 246, 0.2); outline: none; }
        
        /* Custom Checkbox Style */
        input[type="checkbox"] { accent-color: #3b82f6; }
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
    

    <main class="max-w-4xl mx-auto px-4 py-12">
        
        <div class="mb-10">
            <h1 class="heading-font text-4xl font-bold text-white mb-2 uppercase tracking-tight">Protocol: <span class="text-blue-500">New Discussion</span></h1>
            <p class="text-slate-400">Share your thoughts, ask for advice, or showcase your latest achievement.</p>
        </div>

        <form id="threadForm" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" class="space-y-6">
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label class="block text-xs font-bold uppercase tracking-widest text-slate-500 ml-1">Select Sector</label>
                    <div class="relative">
                        <select name="category" id="category" required class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-3 appearance-none input-glow text-white cursor-pointer">
                            <option value="general">General Gaming</option>
                            <option value="esports">Esports & Tournaments</option>
                            <option value="hardware">Hardware & PC Builds</option>
                            <option value="modding">Development & Mods</option>
                        </select>
                        <i class="fa-solid fa-chevron-down absolute right-4 top-4 text-slate-500 pointer-events-none"></i>
                    </div>
                </div>
                <div class="space-y-2">
                    <label class="block text-xs font-bold uppercase tracking-widest text-slate-500 ml-1">Add Tags (Optional)</label>
                    <input type="text" name="tags" id="tags" placeholder="e.g. Help, Review, News" class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-3 input-glow text-white">
                </div>
            </div>

            <div class="space-y-2">
                <label class="block text-xs font-bold uppercase tracking-widest text-slate-500 ml-1">Thread Title</label>
                <input type="text" name="title" id="title" required maxlength="100" placeholder="Give your topic a clear, catchy name..." 
                       class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-4 text-lg font-semibold input-glow text-white">
            </div>

            <div class="space-y-2">
                <label class="block text-xs font-bold uppercase tracking-widest text-slate-500 ml-1">Transmission Content</label>
                <div class="glass border border-slate-700 rounded-xl overflow-hidden">
                    <div class="flex items-center gap-1 p-2 border-b border-slate-700 bg-slate-800/50">
                        <button type="button" onclick="insertTag('**','**')" class="w-8 h-8 rounded hover:bg-slate-700 text-slate-300 transition" title="Bold"><i class="fa-solid fa-bold"></i></button>
                        <button type="button" onclick="insertTag('*','*')" class="w-8 h-8 rounded hover:bg-slate-700 text-slate-300 transition" title="Italic"><i class="fa-solid fa-italic"></i></button>
                        <button type="button" onclick="insertTag('[', '](url)')" class="w-8 h-8 rounded hover:bg-slate-700 text-slate-300 transition" title="Link"><i class="fa-solid fa-link"></i></button>
                        <button type="button" onclick="insertTag('`','`')" class="w-8 h-8 rounded hover:bg-slate-700 text-slate-300 transition" title="Code"><i class="fa-solid fa-code"></i></button>
                    </div>
                    <textarea name="content" id="content" required rows="12" 
                              class="w-full bg-transparent p-6 focus:outline-none text-slate-200 leading-relaxed resize-none" 
                              placeholder="Type your message here... markdown is supported!"></textarea>
                </div>
            </div>

            <div class="flex items-start gap-3 p-4 bg-blue-500/5 border border-blue-500/20 rounded-xl">
                <input type="checkbox" id="guidelines" required class="mt-1 w-4 h-4 rounded border-slate-700 bg-slate-900 text-blue-600 focus:ring-blue-500">
                <label for="guidelines" class="text-xs text-slate-400 leading-normal cursor-pointer">
                    I have read the <a href="about.php" class="text-blue-400 hover:underline">Community Guidelines</a> and confirm that this post does not contain spam, harassment, or restricted content.
                </label>
            </div>

            <div class="flex flex-col md:flex-row items-center justify-between gap-4 pt-4">
                <button type="button" onclick="discardThread()" class="text-slate-500 hover:text-red-400 transition text-sm font-bold uppercase tracking-widest">
                    <i class="fa-solid fa-trash-can mr-2"></i> Discard
                </button>
                <div class="flex gap-4 w-full md:w-auto">
                    <button type="button" onclick="saveDraft()" class="flex-1 md:flex-none px-8 py-3 bg-slate-800 hover:bg-slate-700 border border-slate-700 rounded-xl font-bold transition">
                        Save Draft
                    </button>
                    <button type="submit" class="flex-1 md:flex-none px-10 py-3 bg-blue-600 hover:bg-blue-500 text-white font-bold rounded-xl transition shadow-lg shadow-blue-900/20">
                        Launch Thread
                    </button>
                </div>
            </div>

        </form>
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
        // --- Persistence Logic ---

        const form = document.getElementById('threadForm');
        const saveStatus = document.getElementById('save-status');

        // Load data from localStorage on page load
        window.onload = () => {
            const savedData = JSON.parse(localStorage.getItem('nexus_draft'));
            if (savedData) {
                document.getElementById('title').value = savedData.title || '';
                document.getElementById('content').value = savedData.content || '';
                document.getElementById('category').value = savedData.category || 'general';
                document.getElementById('tags').value = savedData.tags || '';
                saveStatus.classList.remove('hidden');
                saveStatus.innerText = "Draft Recovered";
            }
        };

        // Auto-save logic
        form.addEventListener('input', () => {
            const draft = {
                title: document.getElementById('title').value,
                content: document.getElementById('content').value,
                category: document.getElementById('category').value,
                tags: document.getElementById('tags').value
            };
            localStorage.setItem('nexus_draft', JSON.stringify(draft));
            
            saveStatus.classList.remove('hidden');
            saveStatus.innerText = "Auto-saving...";
            
            clearTimeout(window.saveTimer);
            window.saveTimer = setTimeout(() => {
                saveStatus.innerText = "Draft Saved";
            }, 1000);
        });

        function saveDraft() {
            alert("Draft saved to your browser's local storage!");
        }

        function discardThread() {
            if (confirm("Are you sure? This will wipe your draft permanently.")) {
                localStorage.removeItem('nexus_draft');
                form.reset();
                saveStatus.classList.add('hidden');
            }
        }

        // Form Submission - Clear storage on success
        form.onsubmit = () => {
            localStorage.removeItem('nexus_draft');
        };

        // --- Helper: Markdown Toolbar ---
        function insertTag(startTag, endTag) {
            const textarea = document.getElementById('content');
            const start = textarea.selectionStart;
            const end = textarea.selectionEnd;
            const text = textarea.value;
            const before = text.substring(0, start);
            const after = text.substring(end, text.length);
            const selected = text.substring(start, end);
            
            textarea.value = before + startTag + selected + endTag + after;
            textarea.focus();
            textarea.selectionEnd = end + startTag.length;
        }
    </script>
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