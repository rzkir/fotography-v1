@props([
    'title' => 'Dashboard',
    'active' => 'workspace',
    'contentClass' => 'pr-2',
])

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&family=Space+Grotesk:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg-color: #0d0d0d;
            --accent-color: #f5f2ed;
        }
        html {
            height: 100%;
            overflow: hidden;
        }
        body {
            font-family: 'Outfit', sans-serif;
            background-color: var(--bg-color);
            color: var(--accent-color);
            height: 100dvh;
            overflow: hidden;
            margin: 0;
        }
        .glass {
            background: rgba(245, 242, 237, 0.03);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(245, 242, 237, 0.08);
        }
        .glass-hover:hover {
            background: rgba(245, 242, 237, 0.06);
            border: 1px solid rgba(245, 242, 237, 0.15);
            transition: all 0.3s ease;
        }
        .mesh-bg {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            background:
                radial-gradient(circle at 15% 15%, rgba(245, 242, 237, 0.04) 0%, transparent 45%),
                radial-gradient(circle at 85% 85%, rgba(245, 242, 237, 0.04) 0%, transparent 45%);
        }
        .active-nav {
            background: rgba(245, 242, 237, 0.1);
            border: 1px solid rgba(245, 242, 237, 0.2);
        }
        .card-gradient {
            background: linear-gradient(135deg, rgba(245, 242, 237, 0.05) 0%, rgba(245, 242, 237, 0) 100%);
        }
        .input-field {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(245, 242, 237, 0.1);
            border-radius: 1.25rem;
            padding: 1rem 1.25rem;
            font-size: 0.875rem;
            color: #f5f2ed;
            outline: none;
            transition: all 0.3s ease;
            width: 100%;
        }
        .input-field:focus {
            border-color: rgba(245, 242, 237, 0.3);
            background: rgba(255, 255, 255, 0.08);
        }
        .input-field::placeholder {
            color: rgba(245, 242, 237, 0.3);
        }
        select.input-field option {
            background: #0d0d0d;
            color: #f5f2ed;
        }
        .custom-scroll {
            scrollbar-width: thin;
            scrollbar-color: rgba(245, 242, 237, 0.28) transparent;
            scrollbar-gutter: stable;
        }
        .custom-scroll::-webkit-scrollbar {
            width: 5px;
        }
        .custom-scroll::-webkit-scrollbar-track {
            background: transparent;
            margin: 12px 0;
        }
        .custom-scroll::-webkit-scrollbar-thumb {
            background: rgba(245, 242, 237, 0.1);
            border-radius: 999px;
            border: 1px solid rgba(245, 242, 237, 0.06);
        }
        .custom-scroll::-webkit-scrollbar-thumb:hover {
            background: rgba(245, 242, 237, 0.28);
        }
    </style>
    <title>Noir/Studio - {{ $title }}</title>
</head>
<body>
    <div class="mesh-bg"></div>

    <div class="flex h-full p-4 gap-4 overflow-hidden">
        <x-layout.sidebar :active="$active" />

        <main class="flex-1 flex flex-col gap-4 min-h-0 min-w-0 overflow-hidden">
            @isset($header)
                {{ $header }}
            @else
                <header class="h-24 glass rounded-[2rem] flex items-center justify-between px-6 lg:px-10 flex-shrink-0 min-w-0 gap-4">
                    <div class="flex items-center gap-4 min-w-0">
                        <div class="w-12 h-12 rounded-full overflow-hidden border border-[#f5f2ed]/20 flex-shrink-0">
                            <img src="https://api.dicebear.com/7.x/shapes/svg?seed={{ rawurlencode(auth()->user()->name) }}" alt="{{ auth()->user()->name }}">
                        </div>
                        <div class="min-w-0">
                            <h2 class="text-lg font-bold leading-tight truncate">Morning, {{ explode(' ', auth()->user()->name)[0] }}</h2>
                            <p class="text-xs text-[#f5f2ed]/40 hidden sm:block truncate">Manage your portfolio and commissions</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3 lg:gap-4 flex-shrink-0">
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="w-12 h-12 flex items-center justify-center glass rounded-2xl glass-hover" title="Sign out">
                                <iconify-icon icon="lucide:log-out"></iconify-icon>
                            </button>
                        </form>
                    </div>
                </header>
            @endisset

            <div class="flex-1 min-h-0 overflow-y-auto overflow-x-hidden custom-scroll pb-4 {{ $contentClass ?? 'pr-2' }}">
                @if (session('success'))
                    <div class="mb-4 px-6 py-4 glass rounded-2xl border-emerald-500/20 text-emerald-300 text-sm">
                        {{ session('success') }}
                    </div>
                @endif

                {{ $slot }}
            </div>
        </main>
    </div>
</body>
</html>
