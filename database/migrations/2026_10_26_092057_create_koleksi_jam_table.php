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
        Schema::create('koleksi_jam', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 255);
            $table->string('brand', 100);
            $table->unsignedBigInteger('harga');
            $table->integer('tahun_rilis');
            $table->string('tipe_gerakan', 50); // Automatic, Manual, Quartz
            $table->string('material', 100);
            $table->enum('status', ['tersedia', 'terjual'])->default('tersedia');
            $table->string('foto', 500);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('koleksi_jam');
    }
};
