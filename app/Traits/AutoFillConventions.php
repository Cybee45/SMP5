<?php

namespace App\Traits;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

trait AutoFillConventions
{
    protected static function bootAutoFillConventions(): void
    {
        static::creating(function ($model) {
            $table = $model->getTable();

            // Auto UUID
            if (Schema::hasColumn($table, 'uuid_id') && blank($model->uuid_id)) {
                $model->uuid_id = (string) Str::uuid();
            }

            // Auto urutan (max + 1) & min 1
            if (Schema::hasColumn($table, 'urutan')) {
                if (blank($model->urutan)) {
                    $max = static::max('urutan');
                    $model->urutan = ($max ?? 0) + 1;
                }
                if ((int) $model->urutan < 1) {
                    $model->urutan = 1;
                }
            }
        });

        static::saving(function ($model) {
            $table = $model->getTable();

            if (Schema::hasColumn($table, 'urutan')) {
                if (blank($model->urutan)) {
                    $model->urutan = 1;
                }
                if ((int) $model->urutan < 1) {
                    $model->urutan = 1;
                }
            }
        });
    }
}
