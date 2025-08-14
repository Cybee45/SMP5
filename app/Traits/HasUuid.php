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
            if (empty($model->uuid_id)) {
                $model->uuid_id = Uuid::uuid4()->toString();
            }
        });
    }

    /**
     * Get UUID column name
     */
    public function getUuidColumn(): string
    {
        return 'uuid_id';
    }

    /**
     * Find model by UUID
     */
    public static function findByUuid(string $uuid): ?static
    {
        return static::where('uuid_id', $uuid)->first();
    }

    /**
     * Get the route key for the model (using UUID for URLs)
     */
    public function getRouteKeyName(): string
    {
        return 'uuid_id';
    }

    /**
     * Resolve route model binding using UUID
     */
    public function resolveRouteBinding($value, $field = null)
    {
        return $this->where('uuid_id', $value)->first();
    }
}
