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
     * Get the route key for the model (using UUID for URLs)
     */
    public function getRouteKeyName(): string
    {
        return 'uuid';
    }

    /**
     * Resolve route model binding using UUID
     */
    public function resolveRouteBinding($value, $field = null)
    {
        return $this->where('uuid', $value)->first();
    }
}
