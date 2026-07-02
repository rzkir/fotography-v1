@props(['active' => 'workspace'])

<aside class="w-72 glass rounded-[2.5rem] flex flex-col p-6 z-40 flex-shrink-0 h-full min-h-0 overflow-hidden">
    <div class="flex items-center gap-3 px-4 py-8 flex-shrink-0">
        <div class="w-10 h-10 glass rounded-2xl flex items-center justify-center">
            <iconify-icon icon="lucide:camera" class="text-2xl"></iconify-icon>
        </div>
        <a href="/" class="text-2xl font-bold tracking-tighter font-['Space_Grotesk']">
            Noir<span class="text-[#f5f2ed]/40">/</span>Studio
        </a>
    </div>

    <nav class="flex-1 min-h-0 overflow-y-auto overflow-x-hidden custom-scroll space-y-2 pr-1">
        <a
            href="/dashboard"
            id="nav-workspace"
            @class([
                'flex items-center gap-4 px-6 py-4 rounded-2xl',
                'active-nav' => $active === 'workspace',
                'glass-hover opacity-60 hover:opacity-100' => $active !== 'workspace',
            ])
        >
            <iconify-icon icon="lucide:grid"></iconify-icon>
            <span @class(['font-medium' => $active === 'workspace'])>Workspace</span>
        </a>
        <a
            href="{{ route('dashboard.portofolio.index') }}"
            id="nav-projects"
            @class([
                'flex items-center gap-4 px-6 py-4 rounded-2xl',
                'active-nav' => $active === 'projects',
                'glass-hover opacity-60 hover:opacity-100' => $active !== 'projects',
            ])
        >
            <iconify-icon icon="lucide:folder-kanban"></iconify-icon>
            <span @class(['font-medium' => $active === 'projects'])>Projects</span>
        </a>
        <a
            href="/works"
            id="nav-gallery"
            @class([
                'flex items-center gap-4 px-6 py-4 rounded-2xl',
                'active-nav' => $active === 'gallery',
                'glass-hover opacity-60 hover:opacity-100' => $active !== 'gallery',
            ])
        >
            <iconify-icon icon="lucide:images"></iconify-icon>
            <span @class(['font-medium' => $active === 'gallery'])>Gallery</span>
        </a>
        <a
            href="#"
            id="nav-messages"
            @class([
                'flex items-center gap-4 px-6 py-4 rounded-2xl',
                'active-nav' => $active === 'messages',
                'glass-hover opacity-60 hover:opacity-100' => $active !== 'messages',
            ])
        >
            <iconify-icon icon="lucide:message-square"></iconify-icon>
            <span @class(['font-medium' => $active === 'messages'])>Messages</span>
        </a>
        <a
            href="#"
            id="nav-team"
            @class([
                'flex items-center gap-4 px-6 py-4 rounded-2xl',
                'active-nav' => $active === 'team',
                'glass-hover opacity-60 hover:opacity-100' => $active !== 'team',
            ])
        >
            <iconify-icon icon="lucide:users"></iconify-icon>
            <span @class(['font-medium' => $active === 'team'])>Team</span>
        </a>
    </nav>

    <div class="mt-auto p-4 flex-shrink-0">
        <div class="p-6 rounded-[2rem] glass border-white/5 relative overflow-hidden group">
            <div class="absolute -top-10 -right-10 w-24 h-24 bg-white/5 rounded-full blur-2xl group-hover:bg-white/10 transition-all"></div>
            <p class="text-xs uppercase tracking-widest text-[#f5f2ed]/40 mb-3">Studio Plan</p>
            <h4 class="font-bold mb-4">Professional</h4>
            <a id="nav-upgrade" href="/contact" class="block text-center py-3 bg-[#f5f2ed] text-[#0d0d0d] rounded-xl text-sm font-bold hover:bg-white transition-colors">
                Upgrade Plan
            </a>
        </div>
    </div>
</aside>
