<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kontraktor_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id'); // Relasi ke tabel users
            $table->string('foto_profile')->nullable(); // Foto profil
            $table->string('nama_depan'); // Nama depan
            $table->string('nama_belakang'); // Nama belakang
            $table->string('nomor_telepon'); // Nomor telepon
            $table->string('email')->unique(); // Email
            $table->text('alamat'); // Alamat lengkap
            $table->string('nama_perusahaan'); // Nama perusahaan
            $table->string('nomor_npwp')->nullable(); // Nomor NPWP (opsional)
            $table->string('bidang_usaha'); // Bidang usaha
            $table->string('dokumen_pendukung')->nullable(); // Dokumen pendukung (opsional)
            $table->string('portofolio')->nullable(); // Portofolio (foto)
            $table->timestamps();

            // Foreign key ke tabel users
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kontraktor_profiles');
    }
};
