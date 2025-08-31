<?php

namespace App\Support;

use Filament\Forms\Components\TextInput;
use Illuminate\Support\Facades\DB;

class OrderField
{
    /**
     * Buat field "urutan" dengan batas realistis.
     *
     * @param string $table   Nama tabel untuk cek kolom 'urutan' & default MAX+1
     * @param string|null $label  Label field (default: 'Urutan')
     * @param int $maxCap     Batas maksimum praktis (default 9999)
     * @param int $minCap     Batas minimum praktis (default 1)
     */
    public static function make(string $table, ?string $label = 'Urutan', int $maxCap = 100, int $minCap = 1): TextInput
    {
        // Cek tipe kolom "urutan" di DB (kalau ada)
        $info = DB::selectOne("
            SELECT DATA_TYPE, COLUMN_TYPE
            FROM INFORMATION_SCHEMA.COLUMNS
            WHERE TABLE_SCHEMA = DATABASE()
              AND TABLE_NAME = ?
              AND COLUMN_NAME = 'urutan'
            LIMIT 1
        ", [$table]);

        $type     = strtolower($info->DATA_TYPE ?? 'int');
        $unsigned = isset($info->COLUMN_TYPE) && str_contains(strtolower($info->COLUMN_TYPE), 'unsigned');

        [$dbMin, $dbMax] = self::boundsFor($type, $unsigned);

        // Normalisasi batas dari tipe DB → lalu "diakal-akalin" dengan cap praktis
        $min = max($minCap, $dbMin < 1 ? 1 : $dbMin);
        $max = min($maxCap, $dbMax);

        // Default value = MAX(urutan)+1 tapi tetap tidak boleh melewati $max
        $next = (int) (DB::table($table)->max('urutan') ?? 0) + 1;
        if ($next < $min) {
            $next = $min;
        } elseif ($next > $max) {
            $next = $max;
        }

        return TextInput::make('urutan')
            ->label($label)
            ->numeric()
            ->inputMode('numeric')
            ->minValue($min)
            ->maxValue($max)
            ->default($next)
            ->required()
            ->rule('integer')
            ->rule("between:$min,$max")
            ->validationMessages([
                'between'  => "Nilai urutan di luar batas. Masukkan antara $min s/d $max.",
                'integer'  => 'Urutan harus berupa angka bulat.',
                'required' => 'Kolom urutan wajib diisi.',
            ])
            ->helperText("Masukkan angka $min s/d $max");
    }

    /**
     * Batas teoritis berdasarkan tipe kolom MySQL.
     */
    private static function boundsFor(string $type, bool $unsigned): array
    {
        $bounds = [
            'tinyint'   => $unsigned ? [0, 255] : [-128, 127],
            'smallint'  => $unsigned ? [0, 65535] : [-32768, 32767],
            'mediumint' => $unsigned ? [0, 16777215] : [-8388608, 8388607],
            'int'       => $unsigned ? [0, 4294967295] : [-2147483648, 2147483647],
            'bigint'    => $unsigned ? [0, 18446744073709551615] : [-9223372036854775808, 9223372036854775807],
        ];

        return $bounds[$type] ?? $bounds['int'];
    }
}
