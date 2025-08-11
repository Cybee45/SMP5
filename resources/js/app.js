import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

        //JAVA SCRIPT UNTUK VIDEO WELCOME di HALAMAN MEDIA
        
        // Fungsionalitas untuk tombol play kustom
        const videoContainer = document.getElementById('video-container');
        const video = document.getElementById('welcome-video');
        const playButtonOverlay = document.getElementById('play-button-overlay');

        videoContainer.addEventListener('click', () => {
            if (video.paused) {
                const playPromise = video.play();

                if (playPromise !== undefined) {
                    playPromise.then(() => {
                        // Video berhasil diputar
                        playButtonOverlay.style.display = 'none'; // Sembunyikan overlay
                        video.setAttribute('controls', 'true'); // Tampilkan kontrol video default
                    }).catch(error => {
                        // Tangani error jika video gagal dimuat atau diputar
                        console.error("Gagal memutar video:", error);
                        playButtonOverlay.innerHTML = `
                            <div class="text-center text-white bg-red-900 bg-opacity-80 p-4 rounded-lg">
                                <p class="font-bold">Gagal Memuat Video</p>
                                <p class="text-sm mt-1">Pastikan URL video valid dan dapat diakses.</p>
                            </div>
                        `;
                        playButtonOverlay.style.display = 'flex'; // Pastikan overlay error terlihat
                    });
                }
            }
        });
        
        // Jika video di-pause menggunakan kontrol default, tampilkan lagi overlay
        video.addEventListener('pause', () => {
            if (!video.ended) {
                 playButtonOverlay.style.display = 'flex';
                 video.removeAttribute('controls');
            }
        });
        
        // Ketika video selesai, tampilkan lagi overlay
         video.addEventListener('ended', () => {
            playButtonOverlay.style.display = 'flex';
            video.removeAttribute('controls');
        });
