@php
    use App\Models\MediaVideo;
    use Illuminate\Support\Facades\Storage;
    use Illuminate\Support\Str;

    $mediaVideo = MediaVideo::active()->ordered()->first();

    $extractId = function (?string $url): ?string {
        if (!$url) return null;
        $patterns = [
            '/youtu\.be\/([a-zA-Z0-9_-]{11})/',
            '/[?&]v=([a-zA-Z0-9_-]{11})/',
            '/embed\/([a-zA-Z0-9_-]{11})/',
            '/shorts\/([a-zA-Z0-9_-]{11})/',
        ];
        foreach ($patterns as $p) if (preg_match($p, $url, $m)) return $m[1];
        return preg_match('/^[a-zA-Z0-9_-]{11}$/', $url) ? $url : null;
    };

    if ($mediaVideo) {
        $ytId = $mediaVideo->youtube_id ?: $extractId($mediaVideo->youtube_url);
        $embedUrl = $ytId
            ? 'https://www.youtube-nocookie.com/embed/'.$ytId.'?rel=0&modestbranding=1'
            : 'https://www.youtube.com/embed/yNAFtADhzss?si=NTCpKtzCea3uN6FB';

        $thumb = !empty($mediaVideo->thumbnail)
            ? (Str::startsWith($mediaVideo->thumbnail, ['http://','https://'])
                ? $mediaVideo->thumbnail
                : (function($path){ try { return Storage::url($path); } catch (\Throwable $e) { return asset('storage/'.$path); } })($mediaVideo->thumbnail))
            : ($ytId ? 'https://i.ytimg.com/vi/'.$ytId.'/hqdefault.jpg' : null);

        $videoData = [
            'judul'         => $mediaVideo->judul,
            'deskripsi'     => $mediaVideo->deskripsi,
            'embed_url'     => $embedUrl,
            'thumbnail_url' => $thumb,
        ];
    } else {
        $videoData = [
            'judul'         => 'Selamat Datang di SMP 5 Sangatta Utara',
            'deskripsi'     => 'Tempat di mana setiap langkah adalah proses menuju masa depan. Di sini, kami tidak hanya mengajarkan ilmu, tapi juga membentuk karakter, menggali potensi, dan menanamkan nilai-nilai kehidupan.',
            'embed_url'     => 'https://www.youtube.com/embed/yNAFtADhzss?si=NTCpKtzCea3uN6FB',
            'thumbnail_url' => null,
        ];
    }
@endphp

<section class="py-16 md:py-24 relative overflow-hidden">
  <!-- Gradasi blur atas -->
  <div class="absolute top-0 left-1/2 -translate-x-1/2 z-0 w-[90%] h-40 
              bg-gradient-radial from-indigo-200/30 via-transparent to-transparent 
              blur-3xl rounded-full pointer-events-none"></div>

  <div class="container mx-auto px-4">
    <div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-5 gap-12 lg:gap-16 items-center">

      <!-- Kolom Video: fade-in -->
      <div id="video-container"
           class="relative rounded-2xl overflow-hidden shadow-2xl lg:col-span-3
                  motion-safe:animate-[fade-in_800ms_ease-out_both]">
        <div class="relative w-full aspect-video bg-gray-200">
          <iframe
              src="{{ $videoData['embed_url'] }}"
              title="{{ $videoData['judul'] }}"
              class="absolute inset-0 w-full h-full"
              style="border:0;"
              allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
              referrerpolicy="strict-origin-when-cross-origin"
              allowfullscreen
              loading="lazy"></iframe>
        </div>
      </div>

      <!-- Kolom Teks: slide-up + delay -->
      <div class="text-center lg:text-left lg:col-span-2
                  motion-safe:animate-[slide-up_800ms_ease-out_both] 
                  motion-safe:[animation-delay:160ms]">
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