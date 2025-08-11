<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

trait HasUuid
{
    /**
     * Boot the trait.
     */
    protected static function bootHasUuid(): void
    {
        static::creating(function (Model $model) {
            if (empty($model->uuid)) {
                $model->uuid = Uuid::uuid4()->toString();
            }
        });
    }

    /**
     * Get UUID column name
     */
    public function getUuidColumn(): string
    {
        return 'uuid';
    }

    /**
     * Find model by UUID
     */
    public static function findByUuid(string $uuid): ?static
    {
        return static::where('uuid', $uuid)->first();
    }

    /**
     * HYBRID APPROACH: Admin menggunakan ID, Public menggunakan UUID
     * Get the route key for the model
     */
    public function getRouteKeyName(): string
    {
        // Jika request dari admin panel, gunakan ID untuk performa
        if (request()->is('admin/*') || request()->is('filament/*')) {
            return 'id';
        }
        
        // Untuk public routes dan API, gunakan UUID untuk keamanan
        return 'uuid';
    }

    /**
     * Resolve route model binding
     */
    public function resolveRouteBinding($value, $field = null)
    {
        // Jika dari admin panel, cari berdasarkan ID
        if (request()->is('admin/*') || request()->is('filament/*')) {
            return $this->where('id', $value)->first();
        }
        
        // Untuk public/API, cari berdasarkan UUID
        return $this->where('uuid', $value)->first();
    }

    /**
     * Get public URL with UUID
     */
    public function getPublicUrl(): string
    {
        return url('/' . str_replace('_', '-', $this->getTable()) . '/' . $this->uuid);
    }

    /**
     * Get admin URL with ID
     */
    public function getAdminUrl(): string
    {
        return url('/admin/' . str_replace('_', '-', $this->getTable()) . '/' . $this->id);
    }
}
