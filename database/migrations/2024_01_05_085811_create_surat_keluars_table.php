<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('surat_keluars', function (Blueprint $table) {
            $table->increments('sk_id');
            $table->foreignId('js_id')->nullable();
            $table->foreignId('prodi_id')->nullable();
            $table->string('sk_nomor')->nullable();
            $table->string('sk_lampiran')->nullable();
            $table->string('sk_perihal')->nullable();
            $table->string('sk_tujuan')->nullable();
            $table->string('sk_tempat')->nullable();
            $table->longText('sk_deskripsi')->nullable();
            $table->string('sk_tembusan')->nullable();
            $table->date('sk_tgl')->nullable();
            $table->integer('sk_step')->default(1)->nullable();
            $table->string('sk_status')->nullable();
            // $table->string('sk_verifikasi')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat_keluars');
    }
};
