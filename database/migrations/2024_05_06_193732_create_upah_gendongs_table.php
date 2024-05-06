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
        Schema::create('upah_gendongs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vehicle_id')->constrained()->onDelete('cascade');
            $table->integer('nominal');
            $table->float('tonase_min')->default(0);
            $table->string('nama_driver');
            $table->date('tanggal_masuk_driver');
            $table->string('nama_pengurus');
            $table->date('tanggal_masuk_pengurus');
            $table->string('no_rek');
            $table->string('bank');
            $table->string('nama_rek');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('upah_gendongs');
    }
};
