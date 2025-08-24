<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;

trait AutoOrder
{
    /**
     * Kolom urutan (default: 'urutan').
     */
    protected function getOrderColumn(): string
    {
        // Model boleh override dengan: protected string $orderColumn = 'posisi';
        return property_exists($this, 'orderColumn') && !empty($this->orderColumn)
            ? $this->orderColumn
            : 'urutan';
    }

    /**
     * Kolom pengelompokan urutan (opsional).
     * Contoh di model: protected array $orderGroupColumns = ['section_akreditasi_id'];
     */
    protected function getOrderGroupColumns(): array
    {
        return property_exists($this, 'orderGroupColumns') && is_array($this->orderGroupColumns)
            ? $this->orderGroupColumns
            : [];
    }

    /**
     * Boot: isi urutan otomatis saat create jika kosong.
     */
    protected static function bootAutoOrder(): void
    {
        static::creating(function (Model $model) {
            /** @var self $model */
            $orderCol   = $model->getOrderColumn();

            // Kalau sudah diisi manual di form, jangan di-override
            if (!empty($model->{$orderCol})) {
                return;
            }

            // Build query untuk hitung max berdasarkan group (jika ada)
            $q = $model::query();
            foreach ($model->getOrderGroupColumns() as $col) {
                if (!is_null($model->{$col})) {
                    $q->where($col, $model->{$col});
                } else {
                    $q->whereNull($col);
                }
            }

            $max = (int) $q->max($orderCol);
            $model->{$orderCol} = $max + 1;
        });
    }
}
