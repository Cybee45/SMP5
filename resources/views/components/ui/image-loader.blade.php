@props([
    'src',
    'alt' => '',
    'class' => 'rounded-lg w-full h-auto',
    'placeholder' => '',
    'errorPlaceholder' => ''
])

<div 
    class="relative {{ $class }}" 
    x-data="imageLoader('{{ $src }}', '{{ $placeholder }}', '{{ $errorPlaceholder }}')"
    x-init="init()"
>
    <!-- Loading Skeleton -->
    <div 
        x-show="loading" 
        x-cloak
        class="absolute inset-0 bg-gray-200 animate-pulse rounded-lg flex items-center justify-center"
    >
        <div class="flex flex-col items-center space-y-2">
            <svg class="animate-spin h-8 w-8 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.37 0 0 5.37 0 12h4zm2 5.29A7.96 7.96 0 014 12H0c0 3.04 1.13 5.82 3 7.94l3-2.65z"/>
            </svg>
            <span class="text-xs text-gray-400">Memuat...</span>
        </div>
    </div>
    
    <!-- Actual Image -->
    <img 
        x-show="!loading && !error"
        x-cloak
        x-ref="image"
        :src="imageSrc"
        alt="{{ $alt }}"
        class="block {{ $class }}"
    >
    
    <!-- Error State -->
    <div 
        x-show="error" 
        x-cloak
        class="absolute inset-0 bg-gray-100 rounded-lg flex items-center justify-center"
    >
        <div class="flex flex-col items-center space-y-2 text-gray-400">
            <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                      d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
            <span class="text-xs">Gagal memuat gambar</span>
        </div>
    </div>
</div>

<script>
function imageLoader(src, placeholder, errorPlaceholder) {
    return {
        loading: true,
        error: false,
        imageSrc: placeholder || src,
        
        init() {
            this.loadImage();
        },
        
        loadImage() {
            const img = new Image();
            
            img.onload = () => {
                this.loading = false;
                this.error = false;
                this.imageSrc = src;
                this.$refs.image.style.display = 'block';
            };
            
            img.onerror = () => {
                this.loading = false;
                this.error = true;
                
                if (errorPlaceholder) {
                    this.imageSrc = errorPlaceholder;
                    const fallbackImg = new Image();
                    fallbackImg.onload = () => {
                        this.error = false;
                        this.$refs.image.style.display = 'block';
                    };
                    fallbackImg.src = errorPlaceholder;
                }
            };
            
            // Delay kecil supaya skeleton sempat muncul
            setTimeout(() => { img.src = src; }, 100);
        }
    }
}
</script>
