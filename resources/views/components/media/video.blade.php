@php
    // Ambil data video aktif dari database
    $mediaVideo = \App\Models\MediaVideo::active()->ordered()->first();
    
    // Data fallback jika belum ada di database
    $videoData = $mediaVideo ? [
        'judul' => $mediaVideo->judul,
        'deskripsi' => $mediaVideo->deskripsi,
        'embed_url' => $mediaVideo->embed_url,
        'thumbnail_url' => $mediaVideo->thumbnail_url,
    ] : [
        'judul' => 'Selamat Datang di SMP 5 Sangatta Utara',
        'deskripsi' => 'Tempat di mana setiap langkah adalah proses menuju masa depan. Di sini, kami tidak hanya mengajarkan ilmu, tapi juga membentuk karakter, menggali potensi, dan menanamkan nilai-nilai kehidupan. Kami hadirkan semangat belajar, kerja keras, dan prestasi dalam setiap momen.',
        'embed_url' => 'https://www.youtube.com/embed/yNAFtADhzss?si=NTCpKtzCea3uN6FB',
        'thumbnail_url' => null,
    ];
@endphp

<section class="py-16 md:py-24 relative overflow-hidden">
    <!-- Gradasi atas agar menyatu dengan section hero -->
    <div class="absolute top-0 left-0 w-full h-24 md:h-32 z-10 pointer-events-none bg-gradient-to-b from-white via-white/80 to-transparent"></div>
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16 items-center">

            <!-- Kolom Video -->
            <div id="video-container" class="relative rounded-2xl overflow-hidden shadow-2xl">
                <!-- Embedded YouTube Video -->
                <iframe 
                    width="560" 
                    height="315" 
                    src="{{ $videoData['embed_url'] }}" 
                    title="{{ $videoData['judul'] }}" 
                    frameborder="0" 
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                    referrerpolicy="strict-origin-when-cross-origin" 
                    allowfullscreen
                    class="w-full h-auto aspect-video">
                </iframe>
            </div>

            <!-- Kolom Teks -->
            <div class="text-center lg:text-left">
                <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900 tracking-tight">
                    {{ $videoData['judul'] }}
                </h2>
                <div class="mt-6 text-lg text-gray-600 leading-relaxed">
                    {!! nl2br(e($videoData['deskripsi'])) !!}
                </div>
                <p class="mt-4 text-lg text-gray-600 leading-relaxed font-semibold">
                    Bersama, kita tumbuh. Bersama, kita wujudkan impian.
                </p>
            </div>

        </div>
    </div>
</section>