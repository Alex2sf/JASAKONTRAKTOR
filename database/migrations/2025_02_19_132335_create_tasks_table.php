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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Relasi ke tabel users
            $table->string('lokasi_proyek'); // Lokasi proyek
            $table->decimal('estimasi_anggaran', 15, 2)->nullable(); // Estimasi anggaran (opsional)
            $table->date('tanggal_mulai'); // Tanggal mulai proyek
            $table->integer('durasi_proyek')->nullable(); // Durasi proyek (opsional)
            $table->string('image')->nullable(); // Upload gambar (opsional)
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
