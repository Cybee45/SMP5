<!DOCTYPE html>
<html>
<head>
    <title>Blog Debug</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-8">
    <div class="max-w-4xl mx-auto">
        <h1 class="text-3xl font-bold mb-6">Blog Debug Page</h1>
        
        <div class="bg-white p-6 rounded shadow mb-6">
            <h2 class="text-xl font-semibold mb-4">Debug Info:</h2>
            <p><strong>Artikel Count:</strong> {{ isset($artikels) ? $artikels->count() : 'Variable not set' }}</p>
            <p><strong>Kategori Count:</strong> {{ isset($kategoris) ? $kategoris->count() : 'Variable not set' }}</p>
            <p><strong>Current Time:</strong> {{ now() }}</p>
        </div>

        @if(isset($artikels) && $artikels->count() > 0)
            <div class="bg-white p-6 rounded shadow">
                <h2 class="text-xl font-semibold mb-4">Articles Data:</h2>
                @foreach($artikels as $artikel)
                    <div class="border-b pb-4 mb-4">
                        <h3 class="font-semibold">{{ $artikel->judul }}</h3>
                        <p class="text-sm text-gray-600">Status: {{ $artikel->status }} | Aktif: {{ $artikel->aktif ? 'Yes' : 'No' }}</p>
                        <p class="text-sm text-gray-600">Created: {{ $artikel->created_at }}</p>
                        <p class="text-sm">{{ Str::limit(strip_tags($artikel->konten), 100) }}</p>
                    </div>
                @endforeach
            </div>
        @else
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                <strong>No articles found or variable not passed to view!</strong>
            </div>
        @endif
    </div>
</body>
</html>
