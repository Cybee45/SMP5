<x-filament-widgets::widget>
    <x-filament::section>
        <x-slot name="heading">
            Panduan CMS Sekolah
        </x-slot>
        
        <x-slot name="description">
            Petunjuk penggunaan sistem manajemen konten untuk website sekolah
        </x-slot>

        <div class="space-y-6">
            @foreach($guides as $category => $items)
                <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-3">
                        {{ $category }}
                    </h3>
                    
                    <div class="grid gap-3">
                        @foreach($items as $title => $description)
                            <div class="flex items-start space-x-3">
                                <div class="flex-shrink-0">
                                    <div class="w-2 h-2 bg-primary-500 rounded-full mt-2"></div>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm font-medium text-gray-900 dark:text-white">
                                        {{ $title }}
                                    </p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">
                                        {{ $description }}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
            
            <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
                <div class="flex items-center space-x-2">
                    <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                    </svg>
                    <h4 class="text-sm font-medium text-blue-900 dark:text-blue-100">
                        Tips Penggunaan
                    </h4>
                </div>
                <ul class="mt-2 text-xs text-blue-800 dark:text-blue-200 space-y-1">
                    <li>• Gunakan gambar berkualitas tinggi untuk konten visual</li>
                    <li>• Pastikan semua konten sudah diaktifkan sebelum publikasi</li>
                    <li>• Backup data secara berkala</li>
                    <li>• Hubungi administrator jika mengalami kendala</li>
                </ul>
            </div>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
