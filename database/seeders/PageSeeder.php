<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Surat Keluar
        \App\Models\Page::create([
            'page_name' => 'Surat Keluar',
            'action' => 'Create',
        ]);

        \App\Models\Page::create([
            'page_name' => 'Surat Keluar',
            'action' => 'Read',
        ]);

        \App\Models\Page::create([
            'page_name' => 'Surat Keluar',
            'action' => 'Update',
        ]);

        \App\Models\Page::create([
            'page_name' => 'Surat Keluar',
            'action' => 'Delete',
        ]);

        \App\Models\Page::create([
            'page_name' => 'Surat Keluar',
            'action' => 'Verifikasi',
        ]);

        // Archive
        \App\Models\Page::create([
            'page_name' => 'Archive',
            'action' => 'Read',
        ]);

        // Signature
        \App\Models\Page::create([
            'page_name' => 'Signature',
            'action' => 'Create',
        ]);

        \App\Models\Page::create([
            'page_name' => 'Signature',
            'action' => 'Read',
        ]);

        \App\Models\Page::create([
            'page_name' => 'Signature',
            'action' => 'Update',
        ]);

        \App\Models\Page::create([
            'page_name' => 'Signature',
            'action' => 'Delete',
        ]);

        // Verifikasi
        \App\Models\Page::create([
            'page_name' => 'Verifikasi',
            'action' => 'Create',
        ]);

        \App\Models\Page::create([
            'page_name' => 'Verifikasi',
            'action' => 'Read',
        ]);

        \App\Models\Page::create([
            'page_name' => 'Verifikasi',
            'action' => 'Update',
        ]);

        \App\Models\Page::create([
            'page_name' => 'Verifikasi',
            'action' => 'Delete',
        ]);

        // Jurusan
        \App\Models\Page::create([
            'page_name' => 'Jurusan',
            'action' => 'Create',
        ]);

        \App\Models\Page::create([
            'page_name' => 'Jurusan',
            'action' => 'Read',
        ]);

        \App\Models\Page::create([
            'page_name' => 'Jurusan',
            'action' => 'Update',
        ]);

        \App\Models\Page::create([
            'page_name' => 'Jurusan',
            'action' => 'Delete',
        ]);

        // Prodi
        \App\Models\Page::create([
            'page_name' => 'Program Studi',
            'action' => 'Create',
        ]);

        \App\Models\Page::create([
            'page_name' => 'Program Studi',
            'action' => 'Read',
        ]);

        \App\Models\Page::create([
            'page_name' => 'Program Studi',
            'action' => 'Update',
        ]);

        \App\Models\Page::create([
            'page_name' => 'Program Studi',
            'action' => 'Delete',
        ]);

        // Jenis Surat
        \App\Models\Page::create([
            'page_name' => 'Jenis Surat',
            'action' => 'Create',
        ]);

        \App\Models\Page::create([
            'page_name' => 'Jenis Surat',
            'action' => 'Read',
        ]);

        \App\Models\Page::create([
            'page_name' => 'Jenis Surat',
            'action' => 'Update',
        ]);

        \App\Models\Page::create([
            'page_name' => 'Jenis Surat',
            'action' => 'Delete',
        ]);

        // Account
        \App\Models\Page::create([
            'page_name' => 'User',
            'action' => 'Create',
        ]);

        \App\Models\Page::create([
            'page_name' => 'User',
            'action' => 'Read',
        ]);

        \App\Models\Page::create([
            'page_name' => 'User',
            'action' => 'Update',
        ]);

        \App\Models\Page::create([
            'page_name' => 'User',
            'action' => 'Delete',
        ]);
    }
}
