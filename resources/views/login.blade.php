<x-layout.public title="Noir/Studio - Login" :with-scripts="false">
    <div class="min-h-screen relative overflow-hidden bg-[#0d0d0d] flex flex-col">
        <div class="diagonal-line"></div>

        <main class="relative z-10 flex flex-1 items-center justify-center px-6 md:px-12 py-16 w-full">
            <div class="w-full max-w-md mx-auto">
                <div class="text-center mb-16">
                    <h1 class="text-5xl md:text-6xl font-display font-black uppercase tracking-tighter mb-4">Welcome Back</h1>
                    <p class="font-serif italic text-zinc-400">Access your exclusive portfolio archive</p>
                </div>

                @if ($errors->any())
                    <div class="mb-8 p-4 border border-red-500/30 bg-red-500/10 rounded-xl text-center space-y-1">
                        @foreach ($errors->all() as $error)
                            <p class="text-sm text-red-400">{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" class="space-y-12">
                    @csrf
                    <div class="space-y-8">
                        <div>
                            <label for="email" class="block text-[10px] font-bold uppercase tracking-widest text-zinc-500 mb-2">Email</label>
                            <input
                                type="email"
                                id="email"
                                name="email"
                                value="{{ old('email') }}"
                                required
                                autocomplete="email"
                                class="custom-input w-full"
                                placeholder="your@email.com"
                            >
                        </div>
                        <div>
                            <label for="password" class="block text-[10px] font-bold uppercase tracking-widest text-zinc-500 mb-2">Password</label>
                            <input
                                type="password"
                                id="password"
                                name="password"
                                required
                                autocomplete="current-password"
                                class="custom-input w-full"
                                placeholder="••••••••"
                            >
                        </div>
                        <x-ui.checkbox />
                    </div>
                    <button type="submit" class="w-full py-4 border border-zinc-800 text-[10px] font-bold uppercase tracking-[0.4em] hover:bg-white hover:text-black transition-all duration-500">
                        Sign In
                    </button>
                </form>

                <div class="mt-12 text-center">
                    <a href="/register" class="text-zinc-400 hover:text-white transition-colors text-xs font-bold uppercase tracking-widest">
                        Create Account
                    </a>
                </div>
            </div>
        </main>

        <footer class="relative z-10 py-6 text-center border-t border-zinc-900/80">
            <p class="text-[10px] font-bold text-zinc-700 uppercase tracking-[0.3em]">© Noir Studio</p>
        </footer>
    </div>
</x-layout.public>
