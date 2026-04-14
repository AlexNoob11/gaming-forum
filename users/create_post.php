<?php
require 'db.php';

// No need for session_start() here, it's already in db.php!

// GATEKEEPER: Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php?error=unauthorized");
    exit();
}

$username = $_SESSION['username'];
$avatar_seed = $_SESSION['avatar'];
$user_id = $_SESSION['user_id'];

// --- DATABASE LOGIC (PDO VERSION) ---
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 1. Collect Input
    $category = $_POST['category'] ?? '';
    $tags     = $_POST['tags'] ?? '';
    $title    = $_POST['title'] ?? '';
    $content  = $_POST['content'] ?? '';

    // 2. Validate
    if (!empty($title) && !empty($content)) {
        try {
            // 3. Prepare SQL using PDO
            $sql = "INSERT INTO threads (user_id, category, tags, title, content, created_at) 
                    VALUES (:user_id, :category, :tags, :title, :content, NOW())";
            
            $stmt = $pdo->prepare($sql);
            
            // 4. Execute with bound parameters (Safe from SQL Injection)
            $stmt->execute([
                ':user_id'  => $user_id,
                ':category' => $category,
                ':tags'     => $tags,
                ':title'    => $title,
                ':content'  => $content
            ]);

            // Success!
            header("Location: thread.php?success=1");
            exit();

        } catch (PDOException $e) {
            $error_msg = "Database Error: " . $e->getMessage();
        }
    } else {
        $error_msg = "Please fill in all required fields.";
    }
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
                    <span class="heading-font text-xl md:text-2xl font-bold tracking-wider uppercase text-white">Gaming<span class="text-blue-500">Forum</span></span>
                </div>
                
                <div class="hidden lg:flex items-center space-x-6 text-sm font-medium">
                    <a href="dashboard.php" class="hover:text-blue-400 transition">Home</a>
                    <a href="about.php" class="hover:text-blue-400 transition">Guidelines</a>
                    <a href="category.php" class="hover:text-blue-400 transition">Category</a>
                    <a href="create_post.php" class="text-blue-400 border-b-2 border-blue-500 pb-1">Create a post</a>
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
            document.getElementById('mobileMenu').classList.toggle('hidden');
        }

        function filterTopics() {
            let input = document.getElementById('topicSearch').value.toLowerCase();
            let cards = document.querySelectorAll('.category-group .glass');
            
            cards.forEach(card => {
                let title = card.querySelector('a').innerText.toLowerCase();
                let desc = card.querySelector('p').innerText.toLowerCase();
                v
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