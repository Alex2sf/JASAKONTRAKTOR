<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('kontraktor_files', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kontraktor_profile_id')->constrained('kontraktor_profiles')->onDelete('cascade');
            $table->string('file_path'); // Path file
            $table->string('file_type'); // Jenis file (dokumen_pendukung atau portofolio)
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('kontraktor_files');
    }
};
