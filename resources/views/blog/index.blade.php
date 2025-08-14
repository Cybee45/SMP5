@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-6">BLOG PAGE TEST</h1>
    
    <div class="bg-blue-100 p-4 mb-6">
        <p>Total Artikel: {{ $artikels->count() }}</p>
        <p>Total Kategori: {{ $kategoris->count() }}</p>
    </div>

    @if($artikels->count() > 0)
        @foreach($artikels as $artikel)
            <div class="bg-white p-4 mb-4 shadow rounded">
                <h2 class="text-xl font-bold">{{ $artikel->title }}</h2>
                <p class="text-gray-600">{{ Str::limit($artikel->content, 150) }}</p>
                <p class="text-sm text-gray-500 mt-2">{{ $artikel->created_at->format('d M Y') }}</p>
            </div>
        @endforeach
    @else
        <p class="text-gray-500">Tidak ada artikel.</p>
    @endif
</div>
@endsection
