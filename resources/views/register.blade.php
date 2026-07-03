<x-layout.public title="Noir/Studio - Register" :with-scripts="false">
    <div class="min-h-screen relative overflow-hidden bg-[#0d0d0d] flex items-center justify-center">
        <div class="diagonal-line"></div>

        <main class="relative z-10 w-full container px-12">
            <div class="text-center mb-16">
                <h1 class="text-6xl font-display font-black uppercase tracking-tighter mb-4">Join Us</h1>
                <p class="font-serif italic text-zinc-400">Create your account for exclusive access</p>
            </div>

            @if ($errors->any())
                <div class="mb-8 p-4 border border-red-500/30 bg-red-500/10 rounded-xl text-center space-y-1">
                    @foreach ($errors->all() as $error)
                        <p class="text-sm text-red-400">{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="/register" class="space-y-12">
                @csrf
                <div class="space-y-8">
                    <div>
                        <label class="block text-[10px] font-bold uppercase tracking-widest text-zinc-500 mb-2">Full Name</label>
                        <input type="text" name="name" required class="custom-input" placeholder="Jane Doe">
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold uppercase tracking-widest text-zinc-500 mb-2">Email</label>
                        <input type="email" name="email" required class="custom-input" placeholder="your@email.com">
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold uppercase tracking-widest text-zinc-500 mb-2">Password</label>
                        <input type="password" name="password" required class="custom-input" placeholder="••••••••">
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold uppercase tracking-widest text-zinc-500 mb-2">Confirm Password</label>
                        <input type="password" name="password_confirmation" required class="custom-input" placeholder="••••••••">
                    </div>
                </div>
                <button type="submit" class="w-full py-4 border border-zinc-800 text-[10px] font-bold uppercase tracking-[0.4em] hover:bg-white hover:text-black transition-all duration-500">Create Account</button>
            </form>

            <div class="mt-12 text-center">
                <a href="/login" class="text-zinc-400 hover:text-white transition-colors text-xs font-bold uppercase tracking-widest">Already have an account? Sign In</a>
            </div>
        </main>

        <x-layout.footer />
    </div>
</x-layout.public>