<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JenisSuratSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\JenisSurat::create([
            'js_name' => 'Surat Abdi Masyarakat'
        ]);

        \App\Models\JenisSurat::create([
            'js_name' => 'Surat Dispen'
        ]);

        \App\Models\JenisSurat::create([
            'js_name' => 'Surat Ijin Cuti'
        ]);

        \App\Models\JenisSurat::create([
            'js_name' => 'Surat Keterangan'
        ]);

        \App\Models\JenisSurat::create([
            'js_name' => 'Surat Keterangan Aktif Kuliah'
        ]);

        \App\Models\JenisSurat::create([
            'js_name' => 'Surat Merdeka'
        ]);

        \App\Models\JenisSurat::create([
            'js_name' => 'Surat Permohonan Orientasi Profesi'
        ]);

        \App\Models\JenisSurat::create([
            'js_name' => 'Surat Peminjaman'
        ]);

        \App\Models\JenisSurat::create([
            'js_name' => 'Surat Pengantar PKL'
        ]);

        \App\Models\JenisSurat::create([
            'js_name' => 'Surat Pengunduran Diri'
        ]);

        \App\Models\JenisSurat::create([
            'js_name' => 'Surat Permohonan Lokasi Penelitian'
        ]);

        \App\Models\JenisSurat::create([
            'js_name' => 'Surat Permohonan Praktek Lapangan'
        ]);

        \App\Models\JenisSurat::create([
            'js_name' => 'Surat Supervisi Magang Industri'
        ]);
    }
}
