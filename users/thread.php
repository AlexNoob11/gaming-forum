<?php
require 'db.php';

// GATEKEEPER: Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php?error=unauthorized");
    exit();
}

$username = $_SESSION['username'];
$avatar_seed = $_SESSION['avatar'];

/**
 * Helper function to convert DB timestamp to "Time Ago" format
 */
function timeAgo($timestamp) {
    $datetime = new DateTime($timestamp);
    $now = new DateTime();
    $diff = $now->diff($datetime);

    if ($diff->y > 0) return $diff->y . 'Y';
    if ($diff->m > 0) return $diff->m . 'MO';
    if ($diff->d > 0) return $diff->d . 'D';
    if ($diff->h > 0) return $diff->h . 'H';
    if ($diff->i > 0) return $diff->i . 'M';
    return 'NOW';
}

// --- FETCH ALL THREADS ---
try {
    $query = "SELECT t.*, u.username as author_name, u.avatar as author_avatar 
              FROM threads t 
              JOIN users u ON t.user_id = u.id 
              ORDER BY t.created_at DESC";
    
    $stmt = $pdo->query($query);
    $threads = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $thread_count = count($threads);
} catch (PDOException $e) {
    die("Transmission Error: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Browse Threads | NexusGrid</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&family=Rajdhani:wght@500;700&display=swap');
        body { font-family: 'Inter', sans-serif; background-color: #0f172a; color: #e2e8f0; }
        .heading-font { font-family: 'Rajdhani', sans-serif; }
        .glass { background: rgba(30, 41, 59, 0.7); backdrop-filter: blur(10px); }
        .thread-card { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); border-left: 3px solid transparent; }
        .thread-card:hover { 
            border-left-color: #3b82f6; 
            background: rgba(51, 65, 85, 0.4); 
        }
        .upvoted { color: #3b82f6 !important; transform: scale(1.1); }
        .liked { color: #ef4444 !important; transform: scale(1.1); }
        .btn-interact { transition: all 0.2s ease; }
        .reply-item { animation: slideLeft 0.3s ease-out forwards; }
        @keyframes slideLeft {
            from { opacity: 0; transform: translateX(-10px); }
            to { opacity: 1; transform: translateX(0); }
        }
    </style>
</head>
<body class="antialiased pb-20">
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
                    <a href="thread.php" class="text-blue-400 border-b-2 border-blue-500 pb-1">Threads</a>
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


    <header class="bg-slate-900/50 border-b border-slate-800 py-12">
        <div class="max-w-5xl mx-auto px-4">
            <h1 class="heading-font text-4xl font-bold text-white uppercase tracking-tighter">Active <span class="text-blue-500">Transmissions</span></h1>
            <p class="text-slate-500 mt-2 font-mono text-xs uppercase tracking-widest">Sector Status: <?php echo $thread_count; ?> nodes detected.</p>
        </div>
    </header>

    <main class="max-w-5xl mx-auto px-4 mt-10">
        <div class="mb-8 flex flex-col md:flex-row gap-4">
            <div class="relative flex-grow">
                <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-slate-500"></i>
                <input type="text" id="searchInput" placeholder="Scan by title or tag..." class="w-full bg-slate-900/50 border border-slate-700 rounded-xl py-3 pl-12 pr-4 text-sm focus:border-blue-500 outline-none transition text-white">
            </div>
            <a href="create_post.php" class="bg-blue-600 hover:bg-blue-500 text-white px-6 py-3 rounded-xl font-bold text-sm transition text-center uppercase tracking-widest">
                + Create a post
            </a>
        </div>

        <div class="space-y-4" id="threadContainer">
            <?php foreach ($threads as $row): ?>
                <div class="thread-card glass border border-slate-800 p-5 rounded-2xl">
                    <div class="flex items-start gap-6">
                        <div class="flex flex-col items-center gap-4 min-w-[50px] bg-slate-800/30 p-2 rounded-xl">
                            <div class="flex flex-col items-center">
                                <button onclick="handleInteraction(this, 'upvoted')" class="btn-interact text-slate-500 hover:text-blue-500">
                                    <i class="fa-solid fa-circle-chevron-up text-xl"></i>
                                </button>
                                <span class="font-bold text-white text-[11px] mt-1 count">0</span>
                            </div>
                            <div class="flex flex-col items-center">
                                <button onclick="handleInteraction(this, 'liked')" class="btn-interact text-slate-500 hover:text-red-500">
                                    <i class="fa-solid fa-heart text-lg"></i>
                                </button>
                                <span class="font-bold text-white text-[11px] mt-1 count">0</span>
                            </div>
                        </div>
                        
                        <div class="flex-grow">
                            <div class="flex items-center gap-2 mb-2">
                                <span class="text-[9px] bg-blue-500/10 text-blue-400 font-black px-2 py-0.5 rounded uppercase tracking-widest border border-blue-500/20">
                                    <?php echo htmlspecialchars($row['category']); ?>
                                </span>
                                <span class="text-[10px] text-slate-500 font-bold tracking-tighter uppercase">
                                    FROM <span class="text-blue-400"><?php echo htmlspecialchars($row['author_name']); ?></span> • <?php echo timeAgo($row['created_at']); ?> AGO
                                </span>
                            </div>

                            <a href="view_thread.php?id=<?php echo $row['id']; ?>" class="heading-font text-xl font-bold text-white hover:text-blue-400 transition block mb-1 uppercase">
                                <?php echo htmlspecialchars($row['title']); ?>
                            </a>

                            <p class="text-slate-400 text-sm line-clamp-2 mb-4 leading-relaxed">
                                <?php echo htmlspecialchars($row['content']); ?>
                            </p>

                            <div id="replies-list-<?php echo $row['id']; ?>" class="space-y-2 mb-4">
                                <?php
                                $stmtR = $pdo->prepare("SELECT r.*, u.username FROM replies r JOIN users u ON r.user_id = u.id WHERE r.thread_id = ? ORDER BY r.created_at ASC");
                                $stmtR->execute([$row['id']]);
                                while($reply = $stmtR->fetch()):
                                ?>
                                    <div class="p-3 bg-slate-900/40 border-l border-slate-700 rounded-r-lg text-xs">
                                        <span class="text-blue-400 font-bold">@<?php echo htmlspecialchars($reply['username']); ?>:</span>
                                        <span class="text-slate-300 ml-1"><?php echo htmlspecialchars($reply['content']); ?></span>
                                    </div>
                                <?php endwhile; ?>
                            </div>

                            <div class="flex items-center gap-6 border-t border-slate-800/50 pt-4">
                                <button onclick="toggleReply(<?php echo $row['id']; ?>)" class="text-[10px] font-black text-slate-500 hover:text-blue-400 flex items-center gap-2 transition uppercase tracking-widest">
                                    <i class="fa-solid fa-comment-dots"></i> Reply
                                </button>
                            </div>

                            <div id="reply-box-<?php echo $row['id']; ?>" class="hidden mt-4 bg-slate-900/80 p-4 rounded-xl border border-slate-700/50">
                                <form action="save_reply.php" method="POST">
                                    <input type="hidden" name="thread_id" value="<?php echo $row['id']; ?>">
                                    
                                    <textarea name="content" required placeholder="Input transmission data..." 
                                        class="w-full bg-slate-800/50 border border-slate-700 rounded-lg p-3 text-sm text-white focus:border-blue-500 outline-none h-20 mb-2"></textarea>
                                    
                                    <div class="flex justify-end gap-2">
                                        <button type="button" onclick="toggleReply(<?php echo $row['id']; ?>)" class="px-3 py-1 text-[10px] font-bold text-slate-400 uppercase">Abort</button>
                                        <button type="submit" class="px-4 py-1 bg-blue-600 hover:bg-blue-500 text-white text-[10px] font-bold rounded transition uppercase">Transmit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </main>

    <script>
    // 1. Search Filter (SCANNER)
    document.getElementById('searchInput').addEventListener('input', function(e) {
        const term = e.target.value.toLowerCase();
        document.querySelectorAll('.thread-card').forEach(card => {
            const content = card.innerText.toLowerCase();
            card.style.display = content.includes(term) ? 'block' : 'none';
        });
    });

    // 2. Voting
    function handleInteraction(btn, activeClass) {
        const countLabel = btn.parentElement.querySelector('.count');
        let currentCount = parseInt(countLabel.innerText);
        btn.classList.toggle(activeClass);
        countLabel.innerText = btn.classList.contains(activeClass) ? currentCount + 1 : currentCount - 1;
    }

    // 3. Reply Form Toggle
    function toggleReply(id) {
        const box = document.getElementById(`reply-box-${id}`);
        box.classList.toggle('hidden');
        if(!box.classList.contains('hidden')) {
            document.getElementById(`text-${id}`).focus();
        }
    }

</script>
<script>
    // 1. Search Filter (SCANNER) - Keep this
    document.getElementById('searchInput').addEventListener('input', function(e) {
        const term = e.target.value.toLowerCase();
        document.querySelectorAll('.thread-card').forEach(card => {
            const content = card.innerText.toLowerCase();
            card.style.display = content.includes(term) ? 'block' : 'none';
        });
    });

    // 2. Voting - Keep this (unless you want to move voting to PHP too)
    function handleInteraction(btn, activeClass) {
        const countLabel = btn.parentElement.querySelector('.count');
        let currentCount = parseInt(countLabel.innerText);
        btn.classList.toggle(activeClass);
        countLabel.innerText = btn.classList.contains(activeClass) ? currentCount + 1 : currentCount - 1;
    }

    // 3. Reply Form Toggle - Keep this to show/hide the form
    function toggleReply(id) {
        const box = document.getElementById(`reply-box-${id}`);
        box.classList.toggle('hidden');
        if(!box.classList.contains('hidden')) {
            const area = box.querySelector('textarea');
            if(area) area.focus();
        }
    }
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
    
    // REMOVED: submitReply function is no longer needed!
</script>
</body>
</html>