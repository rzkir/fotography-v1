<div class="flex items-center">
    <input type="checkbox" id="{{ $id ?? 'remember' }}" name="{{ $name ?? 'remember' }}" value="1" {{ $checked ?? false ? 'checked' : '' }} class="w-4 h-4 bg-zinc-900 border border-zinc-700 rounded-sm focus:ring-0 focus:ring-offset-0">
    <label for="{{ $id ?? 'remember' }}" class="ml-3 text-xs font-bold uppercase tracking-widest text-zinc-400 cursor-pointer">{{ $label ?? 'Remember me' }}</label>
</div>