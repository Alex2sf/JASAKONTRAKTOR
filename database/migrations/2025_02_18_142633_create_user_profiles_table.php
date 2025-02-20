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
        Schema::create('user_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Relasi ke tabel users
            $table->string('nama_lengkap'); // Nama lengkap
            $table->text('alamat_lengkap'); // Alamat lengkap
            $table->string('nomor_telepon'); // Nomor telepon
            $table->string('email'); // Alamat email
            $table->string('foto_profil')->nullable(); // Upload gambar (opsional)
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_profiles');
    }
};
