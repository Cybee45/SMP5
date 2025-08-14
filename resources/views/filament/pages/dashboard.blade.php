<x-filament-panels::page>
    @if($this->hasInfolist())
        {{ $this->infolist }}
    @else
        <div class="space-y-6">
            <div class="bg-gradient-to-r from-blue-500 to-blue-700 rounded-lg p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-2xl font-bold">{{ $this->getHeading() }}</h2>
                        <p class="text-blue-100 mt-1">{{ $this->getSubheading() }}</p>
                    </div>
                    <div class="hidden sm:block">
                        <svg class="w-16 h-16 text-blue-200" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                </div>
            </div>

            @if($this->getWidgets())
                <x-filament-widgets::widgets
                    :widgets="$this->getWidgets()"
                    :columns="$this->getColumns()"
                />
            @endif
        </div>
    @endif
</x-filament-panels::page>
