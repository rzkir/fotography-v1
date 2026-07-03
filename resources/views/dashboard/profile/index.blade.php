<x-layout.dashboard title="Profile Settings" active="profile">
    <x-slot:header>
        <x-layout.page-header title="Profile Settings" :back="route('dashboard.index')">
            <x-slot:subtitle>Manage your studio account</x-slot:subtitle>
            <x-slot:actions>
                <span class="text-xs font-black bg-zinc-900 text-zinc-400 px-3 py-1.5 rounded-lg border border-white/5 uppercase tracking-tighter">
                    CTRL + B Toggle
                </span>
            </x-slot:actions>
        </x-layout.page-header>
    </x-slot:header>

    <div class="space-y-10">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
            <div class="lg:col-span-4 space-y-6">
                <div class="card-photography p-8 rounded-[2.5rem] flex flex-col items-center text-center">
                    <div class="relative mb-6">
                        <div class="w-32 h-32 rounded-4xl p-1 bg-linear-to-tr from-[#ff6b35] to-[#fb7185]">
                            <img
                                src="https://api.dicebear.com/7.x/shapes/svg?seed={{ rawurlencode($user->name) }}"
                                class="w-full h-full rounded-[1.8rem] object-cover bg-[#0d0d0d]"
                                alt="{{ $user->name }}"
                            >
                        </div>
                        <button type="button" class="absolute -bottom-2 -right-2 w-10 h-10 bg-white text-black rounded-xl flex items-center justify-center shadow-lg hover:scale-110 transition-transform">
                            <iconify-icon icon="lucide:camera-plus"></iconify-icon>
                        </button>
                    </div>

                    <h2 class="text-2xl font-display font-black">{{ $user->name }}</h2>
                    <p class="text-zinc-500 font-medium mb-6 text-sm">Pro Photographer</p>

                    <div class="w-full grid grid-cols-2 gap-4">
                        <div class="p-4 bg-white/5 rounded-2xl border border-white/5">
                            <p class="text-[10px] font-black text-zinc-500 uppercase tracking-widest mb-1">Level</p>
                            <p class="text-lg font-display font-bold">PRO</p>
                        </div>
                        <div class="p-4 bg-white/5 rounded-2xl border border-white/5">
                            <p class="text-[10px] font-black text-zinc-500 uppercase tracking-widest mb-1">Storage</p>
                            <p class="text-lg font-display font-bold">Unlimited</p>
                        </div>
                    </div>

                    <button type="button" class="w-full mt-6 py-4 rounded-3xl border border-white/10 hover:bg-white/5 transition-all text-xs font-black tracking-widest">
                        EDIT PUBLIC PROFILE
                    </button>
                </div>

                <div class="card-photography p-8 rounded-[2.5rem] bg-linear-to-br from-red-500/5 to-transparent border-red-500/20">
                    <h3 class="text-xl font-display font-black mb-4 flex items-center gap-2">
                        <iconify-icon icon="lucide:alert-triangle" class="text-red-500"></iconify-icon>
                        Danger Zone
                    </h3>
                    <p class="text-zinc-500 text-sm mb-6">
                        Deleting your account is permanent. This will erase all your portfolios, cloud assets, and active invoices.
                    </p>
                    <button type="button" class="w-full py-4 rounded-3xl bg-red-500/10 text-red-500 hover:bg-red-500 hover:text-white transition-all text-xs font-black tracking-widest">
                        DELETE ACCOUNT
                    </button>
                </div>
            </div>

            <div class="lg:col-span-8 space-y-10">
                <div class="card-photography p-10 rounded-[3rem]">
                    <h2 class="text-2xl font-display font-black mb-8 border-b border-white/5 pb-4">Personal Information</h2>

                    <form method="POST" action="{{ route('dashboard.profile.update') }}" class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        @csrf

                        <x-ui.field label="Full Name" name="name" :value="$user->name" required />
                        <x-ui.field label="Email Address" name="email" type="email" :value="$user->email" required />
                        <x-ui.field label="Phone Number" name="phone" placeholder="+62..." />

                        <x-ui.field
                            label="Country/Region"
                            name="country"
                            as="select"
                            :options="[
                                ['value' => 'ID', 'label' => 'Indonesia'],
                                ['value' => 'SG', 'label' => 'Singapore'],
                                ['value' => 'UK', 'label' => 'United Kingdom'],
                            ]"
                            value="ID"
                        />

                        <div class="md:col-span-2">
                            <x-ui.field
                                label="Professional Bio"
                                name="bio"
                                as="textarea"
                                rows="5"
                                placeholder="Tell the world what you shoot…"
                            />
                        </div>

                        <div class="md:col-span-2 flex justify-end">
                            <button
                                type="submit"
                                class="px-8 py-4 bg-white text-black rounded-3xl text-xs font-black tracking-widest hover:bg-[#ff6b35] hover:text-white transition-all"
                            >
                                UPDATE INFORMATION
                            </button>
                        </div>
                    </form>
                </div>

                <div class="card-photography p-10 rounded-[3rem] bg-linear-to-br from-indigo-500/5 to-transparent">
                    <h2 class="text-2xl font-display font-black mb-8 border-b border-white/5 pb-4">Change Password</h2>

                    <div class="flex items-center justify-between gap-6">
                        <div class="flex items-center gap-3">
                            <iconify-icon icon="lucide:shield-check" class="text-emerald-500 text-2xl"></iconify-icon>
                            <div class="space-y-1">
                                <p class="text-sm font-black">Password & Security</p>
                                <p class="text-xs text-zinc-500 font-bold uppercase tracking-tighter">
                                    Keep your account secure
                                </p>
                            </div>
                        </div>

                        <a
                            href="{{ route('dashboard.profile.password.edit') }}"
                            class="px-8 py-4 bg-white/10 text-white rounded-3xl text-xs font-black tracking-widest hover:bg-white hover:text-black transition-all"
                        >
                            UPDATE PASSWORD
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-photography p-10 rounded-[3rem]">
            <div class="flex justify-between items-center mb-10">
                <div class="space-y-1">
                    <h2 class="text-2xl font-display font-black">Active Sessions</h2>
                    <p class="text-zinc-500 text-sm">Current and recent login sessions across devices</p>
                </div>
                <button type="button" class="px-6 py-3 bg-white/5 border border-white/10 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-white/10">
                    REVOKE ALL SESSIONS
                </button>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead class="border-b border-white/5 text-[10px] font-black text-zinc-500 uppercase tracking-[0.2em]">
                        <tr>
                            <th class="px-6 py-4">User ID / Session</th>
                            <th class="px-6 py-4">IP Address</th>
                            <th class="px-6 py-4">User Agent / Browser</th>
                            <th class="px-6 py-4">Last Activity</th>
                            <th class="px-6 py-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                        @forelse ($sessions as $session)
                            @php
                                $isCurrent = $session->id === $currentSessionId;
                            @endphp
                            <tr class="table-row-hover transition-colors">
                                <td class="px-6 py-6">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-xl {{ $isCurrent ? 'bg-teal-500/10' : 'bg-white/5' }} flex items-center justify-center">
                                            <iconify-icon icon="{{ $isCurrent ? 'lucide:monitor' : 'lucide:terminal' }}" class="{{ $isCurrent ? 'text-teal-400' : 'text-zinc-400' }}"></iconify-icon>
                                        </div>
                                        <div>
                                            <p class="text-sm font-black">{{ str($session->id)->limit(16) }}</p>
                                            <p class="text-[10px] text-zinc-500 font-bold">{{ $isCurrent ? 'Current Session' : 'Session' }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-6 font-mono text-xs text-zinc-400">{{ $session->ip_address ?? '-' }}</td>
                                <td class="px-6 py-6">
                                    <div class="max-w-xs truncate text-[10px] font-bold text-zinc-400">{{ $session->user_agent ?? '-' }}</div>
                                </td>
                                <td class="px-6 py-6 text-xs font-black tracking-tighter">{{ $session->last_activity }}</td>
                                <td class="px-6 py-6 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <button type="button" class="p-2 text-zinc-500 hover:text-white">
                                            <iconify-icon icon="lucide:copy"></iconify-icon>
                                        </button>
                                        <button type="button" class="p-2 text-zinc-500 hover:text-red-500" @disabled($isCurrent)>
                                            <iconify-icon icon="lucide:trash-2"></iconify-icon>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-10 text-center text-sm text-zinc-500">
                                    No sessions found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-layout.dashboard>
