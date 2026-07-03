<x-layout.dashboard title="Change Password" active="profile-password">
    <x-slot:header>
        <x-layout.page-header title="Change Password" :back="route('dashboard.profile.index')">
            <x-slot:subtitle>Update your account security</x-slot:subtitle>
        </x-layout.page-header>
    </x-slot:header>

    <div class="max-w-[900px] mx-auto space-y-8">
        <div class="card-photography p-10 rounded-[3rem] bg-linear-to-br from-indigo-500/5 to-transparent">
            <h2 class="text-2xl font-display font-black mb-8 border-b border-white/5 pb-4">Change Password</h2>

            <form method="POST" action="{{ route('dashboard.profile.password.update') }}" class="space-y-6">
                @csrf

                <x-ui.field
                    label="Current Password"
                    name="current_password"
                    type="password"
                    required
                    autocomplete="current-password"
                />

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <x-ui.field
                        label="New Password"
                        name="password"
                        type="password"
                        required
                        autocomplete="new-password"
                    />
                    <x-ui.field
                        label="Confirm New Password"
                        name="password_confirmation"
                        type="password"
                        required
                        autocomplete="new-password"
                    />
                </div>

                <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4">
                    <div class="flex items-center gap-2">
                        <iconify-icon icon="lucide:shield-check" class="text-emerald-500 text-xl"></iconify-icon>
                        <span class="text-xs text-zinc-500 font-bold uppercase tracking-tighter">
                            Use at least 8 characters
                        </span>
                    </div>

                    <button
                        type="submit"
                        class="px-8 py-4 bg-white/10 text-white rounded-3xl text-xs font-black tracking-widest hover:bg-white hover:text-black transition-all"
                    >
                        UPDATE PASSWORD
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-layout.dashboard>
