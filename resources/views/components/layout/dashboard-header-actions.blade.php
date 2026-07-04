<div {{ $attributes->merge(['class' => 'flex items-center gap-3 shrink-0']) }}>
    {{ $slot }}
    <x-layout.profile />
</div>
