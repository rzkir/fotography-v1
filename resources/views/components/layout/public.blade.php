@props([
    'title' => 'Noir/Studio',
    'withScripts' => true,
])

<!DOCTYPE html>
<html lang="id" class="noir-site">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@1,300;1,600&family=Epilogue:wght@700;900&family=Outfit:wght@300;400;600&display=swap" rel="stylesheet">
    <title>{{ $title }}</title>
    @if ($withScripts)
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        @vite(['resources/css/app.css'])
    @endif
    @stack('head')
</head>
<body {{ $attributes->merge(['class' => 'noir-site']) }}>
    {{ $slot }}
    @stack('scripts')
</body>
</html>
