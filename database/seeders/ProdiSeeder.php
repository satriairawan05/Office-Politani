<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProdiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Prodi::create([
            'prodi_name' => 'Teknologi Rekayasa Perangkat Lunak',
            'prodi_jenjang' => 'D4',
            'jurusan_id' => 1
        ]);

        \App\Models\Prodi::create([
            'prodi_name' => 'Teknologi Rekayasa Geomatika dan Survey',
            'prodi_jenjang' => 'D3',
            'jurusan_id' => 1
        ]);
    }
}
