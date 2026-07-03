<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@1,300;1,600&family=Epilogue:wght@700;900&family=Outfit:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        @import url('https://api.fontshare.com/v2/css?f[]=cabinet-grotesk@800,900&f[]=satoshi@400,700&display=swap');
        :root {
            --bg-color: #0d0d0d;
            --accent-color: #f5f2ed;
        }
        body {
            background-color: var(--bg-color);
            color: var(--accent-color);
            font-family: 'Satoshi', sans-serif;
            overflow-x: hidden;
        }
        .font-display {
            font-family: 'Cabinet Grotesk', sans-serif;
        }
        .font-serif {
            font-family: 'Cormorant Garamond', serif;
        }
        .diagonal-line {
            position: absolute;
            width: 150%;
            height: 1px;
            background: rgba(245, 242, 237, 0.05);
            transform: rotate(-15deg);
            top: 50%;
            left: -25%;
            z-index: 0;
            pointer-events: none;
        }
        .custom-input {
            background: transparent;
            border-bottom: 1px solid #27272a;
            padding: 1rem 0;
            width: 100%;
            outline: none;
            transition: border-color 0.3s ease;
            color: var(--accent-color);
        }
        .custom-input:focus {
            border-color: #f5f2ed;
        }
    </style>
    <title>Noir/Studio - Login</title>
</head>
<body>
    <div class="min-h-screen relative overflow-hidden bg-[#0d0d0d] flex items-center justify-center">
        <div class="diagonal-line"></div>
        <main class="relative z-10 w-full container px-12">
            <div class="text-center mb-16">
                <h1 class="text-6xl font-display font-black uppercase tracking-tighter mb-4">Welcome Back</h1>
                <p class="font-serif italic text-zinc-400">Access your exclusive portfolio archive</p>
            </div>

            <form method="POST" action="/login" class="space-y-12">
                @csrf
                <div class="space-y-8">
                    <div>
                        <label class="block text-[10px] font-bold uppercase tracking-widest text-zinc-500 mb-2">Email</label>
                        <input type="email" name="email" required class="custom-input" placeholder="your@email.com">
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold uppercase tracking-widest text-zinc-500 mb-2">Password</label>
                        <input type="password" name="password" required class="custom-input" placeholder="••••••••">
                    </div>
                    <x-ui.checkbox />
                </div>
                <button type="submit" class="w-full py-4 border border-zinc-800 text-[10px] font-bold uppercase tracking-[0.4em] hover:bg-white hover:text-black transition-all duration-500">Sign In</button>
            </form>

            <div class="mt-12 text-center">
                <a href="/register" class="text-zinc-400 hover:text-white transition-colors text-xs font-bold uppercase tracking-widest">Create Account</a>
            </div>
        </main>

        <x-layout.footer />
    </div>
</body>
</html>