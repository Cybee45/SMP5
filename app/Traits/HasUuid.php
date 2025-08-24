<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;
use Ramsey\Uuid\Uuid;

/**
 * HasUuid (robust)
 *
 * Fitur:
 * - Auto-generate UUID ke kolom yang benar: 'uuid_id' atau 'uuid'
 * - Bisa dimatikan untuk route model binding via $routeKeyUsesUuid = false
 * - Aman kalau tabel TIDAK punya kolom UUID: tidak melakukan apa-apa
 *
 * Cara pakai di Model:
 *   use HasUuid;
 *   protected string $uuidColumn = 'uuid_id'; // opsional (override)
 *   protected bool   $routeKeyUsesUuid = false; // opsional (default: true)
 */
trait HasUuid
{
    /**
     * Default nama kolom UUID bila tidak ditentukan & tidak terdeteksi dari schema.
     */
    protected string $defaultUuidColumn = 'uuid_id';

    /**
     * Control apakah route key pakai UUID atau tidak.
     * Override di model jika perlu: protected bool $routeKeyUsesUuid = false;
     */
    protected bool $routeKeyUsesUuid = true;

    /**
     * Boot the trait.
     */
    protected static function bootHasUuid(): void
    {
        static::creating(function (Model $model) {
            $col = $model->getUuidColumnOrNull();

            // Jika tabel tidak punya kolom UUID sama sekali: skip
            if ($col === null) {
                return;
            }

            // Isi UUID jika kosong
            if (empty($model->{$col})) {
                $model->{$col} = Uuid::uuid4()->toString();
            }
        });
    }

    /**
     * Ambil nama kolom UUID yang dipakai model:
     * 1) Hormati properti $uuidColumn di model (jika valid di schema)
     * 2) Deteksi otomatis 'uuid_id' lalu 'uuid'
     * 3) Jika tidak ada kolom UUID sama sekali -> kembalikan null
     */
    public function getUuidColumnOrNull(): ?string
    {
        $table = $this->getTable();

        // Jika model mendeklarasikan $uuidColumn, validasi dulu ke schema
        if (property_exists($this, 'uuidColumn') && !empty($this->uuidColumn)) {
            if (Schema::hasColumn($table, $this->uuidColumn)) {
                return $this->uuidColumn;
            }
        }

        // Auto-detect
        if (Schema::hasColumn($table, 'uuid_id')) {
            return 'uuid_id';
        }
        if (Schema::hasColumn($table, 'uuid')) {
            return 'uuid';
        }

        // Tidak ada kolom UUID
        return null;
    }

    /**
     * Backward-compat: method lama (dipanggil kode lama).
     * Tetap kembalikan nama kolom yang valid; jika tidak ada, default ke $defaultUuidColumn.
     * NOTE: bedanya dengan getUuidColumnOrNull(), ini tidak mengembalikan null.
     */
    public function getUuidColumn(): string
    {
        return $this->getUuidColumnOrNull() ?? $this->defaultUuidColumn;
    }

    /**
     * Route key: pakai UUID kalau $routeKeyUsesUuid = true dan kolomnya ada.
     * Kalau tidak, pakai 'id' (supaya aman untuk Filament).
     * Model boleh override method ini untuk memaksa perilaku lain.
     */
    public function getRouteKeyName(): string
    {
        if (($this->routeKeyUsesUuid ?? true) === true) {
            $col = $this->getUuidColumnOrNull();
            if ($col !== null) {
                return $col;
            }
        }
        return 'id';
    }

    /**
     * Resolve binding berdasarkan getRouteKeyName().
     * Jika pakai UUID: filter by UUID column.
     * Jika pakai 'id': fallback ke default behavior Eloquent.
     */
    public function resolveRouteBinding($value, $field = null)
    {
        $key = $field ?? $this->getRouteKeyName();

        // Jika pakai id, biarkan Eloquent handle default-nya
        if ($key === 'id') {
            return $this->where($key, $value)->first();
        }

        // Jika pakai UUID
        return $this->where($key, $value)->first();
    }

    /**
     * Helper finder by UUID (akan pilih kolom yang benar).
     */
    public static function findByUuid(string $uuid): ?static
    {
        $instance = new static;
        $col = $instance->getUuidColumnOrNull();

        if ($col === null) {
            return null;
        }

        return static::where($col, $uuid)->first();
    }
}
