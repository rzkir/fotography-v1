@php
    $user = auth()->user();
@endphp

<div class="relative" data-dashboard-profile>
    <button
        type="button"
        data-dashboard-profile-toggle
        class="flex items-center gap-3 p-2 rounded-2xl bg-white/5 border border-white/5 hover:bg-white/10 hover:border-white/10 transition-all"
        aria-expanded="false"
        aria-haspopup="true"
        aria-controls="dashboard-profile-menu"
    >
        <img
            src="https://api.dicebear.com/7.x/shapes/svg?seed={{ rawurlencode($user->name) }}"
            class="w-10 h-10 rounded-xl object-cover shrink-0"
            alt="{{ $user->name }}"
        >
        <div class="hidden lg:flex flex-col items-start overflow-hidden max-w-[140px]">
            <span class="text-sm font-bold whitespace-nowrap truncate">{{ $user->name }}</span>
            <span class="text-[10px] text-zinc-500 font-bold uppercase tracking-wider">Pro Photographer</span>
        </div>
        <iconify-icon icon="lucide:chevron-down" class="hidden lg:block text-zinc-500 text-sm shrink-0" data-dashboard-profile-chevron></iconify-icon>
    </button>

    <div
        id="dashboard-profile-menu"
        data-dashboard-profile-menu
        class="hidden absolute right-0 top-[calc(100%+0.75rem)] w-56 rounded-2xl border border-white/10 bg-[#181818] shadow-2xl overflow-hidden z-50"
        role="menu"
    >
        <div class="px-4 py-3 border-b border-white/5 lg:hidden">
            <p class="text-sm font-bold truncate">{{ $user->name }}</p>
            <p class="text-[10px] text-zinc-500 font-bold uppercase tracking-wider mt-0.5">Pro Photographer</p>
        </div>

        <div class="p-2">
            <a
                href="{{ route('dashboard.profile.index') }}"
                role="menuitem"
                class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-zinc-300 hover:text-white hover:bg-white/5 transition-all"
            >
                <iconify-icon icon="lucide:settings" class="text-lg text-zinc-500"></iconify-icon>
                Settings
            </a>

            <form method="POST" action="{{ route('logout') }}" role="none">
                @csrf
                <button
                    type="submit"
                    role="menuitem"
                    class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-red-400 hover:text-red-300 hover:bg-red-500/10 transition-all"
                >
                    <iconify-icon icon="lucide:log-out" class="text-lg"></iconify-icon>
                    Logout
                </button>
            </form>
        </div>
    </div>
</div>
