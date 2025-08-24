<x-filament-widgets::widget>
    <x-filament::section>
        <x-slot name="heading">
            Aksi Cepat
        </x-slot>
        
        <x-slot name="description">
            Akses cepat untuk mengelola konten sekolah
        </x-slot>

        <div class="space-y-6">
            @foreach($actions as $category => $categoryActions)
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                        {{ $category }}
                    </h3>
                    
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
                        @foreach($categoryActions as $action)
                            @if(!isset($action['permission']) || $user->can($action['permission']))
                                <a href="{{ $action['url'] }}" 
                                   class="group relative overflow-hidden rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-4 hover:shadow-lg transition-all duration-200 hover:border-{{ $action['color'] }}-300 dark:hover:border-{{ $action['color'] }}-600">
                                    
                                    <div class="flex items-start space-x-3">
                                        <!-- Icon -->
                                        <div class="flex-shrink-0">
                                            <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-{{ $action['color'] }}-100 dark:bg-{{ $action['color'] }}-900/30 group-hover:scale-105 transition-transform duration-200">
                                                <x-dynamic-component 
                                                    :component="$action['icon']" 
                                                    class="w-5 h-5 text-{{ $action['color'] }}-600 dark:text-{{ $action['color'] }}-400" 
                                                />
                                            </div>
                                        </div>
                                        
                                        <!-- Content -->
                                        <div class="flex-1 min-w-0">
                                            <h4 class="text-sm font-semibold text-gray-900 dark:text-white mb-1 group-hover:text-{{ $action['color'] }}-600 dark:group-hover:text-{{ $action['color'] }}-400 transition-colors duration-200">
                                                {{ $action['title'] }}
                                            </h4>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                                {{ $action['description'] }}
                                            </p>
                                        </div>
                                        
                                        <!-- Arrow Icon -->
                                        <div class="flex-shrink-0">
                                            <svg class="w-4 h-4 text-gray-400 group-hover:text-{{ $action['color'] }}-600 dark:group-hover:text-{{ $action['color'] }}-400 transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                            </svg>
                                        </div>
                                    </div>
                                </a>
                            @endif
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </x-filament::section>
</x-filament-widgets::widget>