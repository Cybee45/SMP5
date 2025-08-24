<?php

namespace App\Filament\Widgets;

use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;

// ====== SESUAIKAN MODEL & KOLOM DENGAN PROYEKMU ======
use App\Models\Artikel;       // kolom: judul, status, tanggal_publikasi (fallback created_at)
use App\Models\MediaGaleri;   // kolom: thumbnail / image_path, tanggal (fallback created_at)
use App\Models\MediaVideo;    // kolom: judul, embed_url / youtube_id, created_at
// =====================================================

class RecentActivityTable extends BaseWidget
{
    // TableWidget: heading STATIC
    protected static ?string $heading = 'Aktivitas Terbaru';

    /**
     * Tab aktif saat ini (harus cocok dengan key di getTableContentTabs()).
     */
    public ?string $activeTab = 'artikel';

    /**
     * Query default; akan diganti sesuai tab aktif.
     */
    protected function getTableQuery(): Builder
    {
        return match ($this->activeTab) {
            'galeri' => MediaGaleri::query()->latest(),
            'video'  => MediaVideo::query()->latest(),
            default  => Artikel::query()->latest(),
        };
    }

    /**
     * Kolom tabel juga mengikuti tab aktif.
     */
    protected function getTableColumns(): array
    {
        return match ($this->activeTab) {
            // ===== GALERI =====
            'galeri' => [
                Tables\Columns\ImageColumn::make('thumbnail')
                    ->label('Thumbnail')
                    ->getStateUsing(fn ($record) => $record->thumbnail ?? $record->image_path ?? null)
                    ->circular()
                    ->width(44)
                    ->height(44),

                Tables\Columns\TextColumn::make('tanggal')
                    ->label('Tanggal Upload')
                    ->date('d M Y')
                    ->sortable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->since()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ],

            // ===== VIDEO =====
            'video' => [
                Tables\Columns\TextColumn::make('judul')
                    ->label('Judul')
                    ->limit(50)
                    ->searchable()
                    ->wrap(),

                Tables\Columns\TextColumn::make('embed')
                    ->label('Embed / YouTube ID')
                    ->getStateUsing(fn ($record) => $record->youtube_id ?? $record->embed_url ?? '-')
                    ->limit(50)
                    ->copyable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Ditambahkan')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(),
            ],

            // ===== ARTIKEL (default) =====
            default => [
                Tables\Columns\TextColumn::make('judul')
                    ->label('Judul')
                    ->limit(60)
                    ->searchable()
                    ->wrap(),

                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(function ($state) {
                        $s = strtolower((string) $state);
                        return match ($s) {
                            'draft', 'draf' => 'Draft',
                            'publish', 'published', 'terbit' => 'Publish',
                            default => ucfirst($s ?: 'Unknown'),
                        };
                    })
                    ->color(function ($state) {
                        $s = strtolower((string) $state);
                        return match ($s) {
                            'draft', 'draf' => 'gray',
                            'publish', 'published', 'terbit' => 'success',
                            default => 'warning',
                        };
                    })
                    ->toggleable(),

                Tables\Columns\TextColumn::make('tanggal_publikasi')
                    ->label('Tanggal Publish')
                    ->date('d M Y')
                    ->getStateUsing(fn ($record) => $record->tanggal_publikasi ?? $record->created_at)
                    ->sortable()
                    ->toggleable(),
            ],
        };
    }

    /**
     * Tabs konten: Artikel | Galeri | Video
     */
    protected function getTableContentTabs(): array
    {
        return [
            'artikel' => Tables\Components\Tabs\Tab::make('Artikel')->icon('heroicon-o-newspaper'),
            'galeri'  => Tables\Components\Tabs\Tab::make('Galeri')->icon('heroicon-o-photo'),
            'video'   => Tables\Components\Tabs\Tab::make('Video')->icon('heroicon-o-video-camera'),
        ];
    }

    // ===== Override yang diminta PUBLIC oleh base class =====

    public function getDefaultTableRecordsPerPageSelectOption(): int
    {
        return 10;
    }

    public function getTableRecordsPerPageSelectOptions(): array
    {
        return [10, 25, 50];
    }

    public function getTableEmptyStateHeading(): ?string
    {
        return 'Belum ada data.';
    }

    public function getTableActions(): array
    {
        return [];
    }

    public function getTableBulkActions(): array
    {
        return [];
    }
}
