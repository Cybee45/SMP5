@php
echo "Debug halaman blog dimulai...\n";
@endphp

<x-app-layout title="Debug Blog">
    <div style="background: red; color: white; padding: 20px;">
        <h1>DEBUG: Blog page loading...</h1>
    </div>
    
    @php
    echo "Sebelum include hero component...\n";
    @endphp
    
    @include('components.blog.hero')
    
    @php
    echo "Setelah hero, sebelum berita...\n";
    @endphp
    
    @include('components.blog.berita')
    
    @php
    echo "Selesai include semua component...\n";
    @endphp
    
    <div style="background: green; color: white; padding: 20px;">
        <h1>DEBUG: Blog page loaded successfully!</h1>
    </div>
</x-app-layout>
