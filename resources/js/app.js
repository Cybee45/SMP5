import './bootstrap';
import Alpine from 'alpinejs';

window.Alpine = Alpine;
Alpine.start();

/* ===============================
   VIDEO WELCOME — SAFE INITIALIZE
   =============================== */
(() => {
  // Jalankan setelah DOM siap (type="module" memang defer, tapi kita tetap aman)
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initVideoWelcome);
  } else {
    initVideoWelcome();
  }

  function initVideoWelcome() {
    const videoContainer = document.getElementById('video-container');
    const video = document.getElementById('welcome-video');
    const playButtonOverlay = document.getElementById('play-button-overlay');

    // Jika elemen tidak ada (halaman lain), JANGAN lakukan apa-apa
    if (!videoContainer || !video || !playButtonOverlay) return;

    // Klik area video untuk play/pause
    videoContainer.addEventListener('click', () => {
      if (video.paused) {
        const playPromise = video.play();

        if (playPromise && typeof playPromise.then === 'function') {
          playPromise
            .then(() => {
              // Berhasil play
              playButtonOverlay.style.display = 'none';
              video.setAttribute('controls', 'true');
            })
            .catch((error) => {
              console.error('Gagal memutar video:', error);
              playButtonOverlay.innerHTML = `
                <div class="text-center text-white bg-red-900 bg-opacity-80 p-4 rounded-lg">
                  <p class="font-bold">Gagal Memuat Video</p>
                  <p class="text-sm mt-1">Pastikan URL video valid dan dapat diakses.</p>
                </div>
              `;
              playButtonOverlay.style.display = 'flex';
            });
        }
      }
    });

    // Jika dipause (bukan ended), tampilkan overlay lagi
    video.addEventListener('pause', () => {
      if (!video.ended) {
        playButtonOverlay.style.display = 'flex';
        video.removeAttribute('controls');
      }
    });

    // Jika selesai, tampilkan overlay lagi
    video.addEventListener('ended', () => {
      playButtonOverlay.style.display = 'flex';
      video.removeAttribute('controls');
    });
  }
})();
