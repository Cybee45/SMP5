<?php

namespace Database\Seeders;

use App\Models\Kontak;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class KontakSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Hapus data lama
        Kontak::truncate();

        // Buat data kontak
        Kontak::create([
            'uuid_id' => Str::uuid(),
            'section_title' => 'Hubungi & Kunjungi Kami',
            'section_description' => 'Punya pertanyaan atau ingin datang langsung? Informasi lengkapnya ada di bawah ini.',
            'email_title' => 'Email Pertanyaan',
            'email_description' => 'Untuk pertanyaan umum, pendaftaran, atau informasi lainnya.',
            'email_address' => 'info@smpn5sangatta.sch.id',
            'phone_title' => 'Telepon & WhatsApp',
            'phone_description' => 'Hubungi kami di jam kerja (08:00 - 17:00 WITA).',
            'phone_number' => '+62 832-8907-4832',
            'location_title' => 'Kunjungi Sekolah Kami',
            'location_address' => 'SMP Negeri 5 Sangatta Utara, Jl. Poros Kabo, Swarga Bara, Kec. Sangatta Utara, Kabupaten Kutai Timur, Kalimantan Timur.',
            'map_embed' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d5148.134314454969!2d117.53354207598979!3d0.4869592637395554!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x320a359185a0ccdd%3A0xd75f2288aa912a2e!2sSMP%20NEGERI%205%20SANGATTA%20UTARA!5e1!3m2!1sen!2sid!4v1754648855319!5m2!1sen!2sid',
            'urutan' => 1,
            'aktif' => true,
        ]);
    }
}
