<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gallery Debug - SMP 5 Sangatta Utara</title>
    
    <!-- Tailwind CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Alpine.js -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <style>
        .aspect-w-16 { position: relative; padding-bottom: 56.25%; }
        .aspect-h-9 { position: relative; }
        .aspect-w-16 > * { position: absolute; top: 0; right: 0; bottom: 0; left: 0; width: 100%; height: 100%; }
    </style>
</head>
<body class="bg-gray-100">

    <div class="container mx-auto py-8">
        <h1 class="text-4xl font-bold text-center mb-8">Gallery Debug Test</h1>
        
        @include('components.media.gallery-debug')
    </div>

</body>
</html>
