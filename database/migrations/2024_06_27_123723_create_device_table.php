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
        Schema::create('device', function (Blueprint $table) {
            $table->id();
            $table->string('nama_device');
            $table->string('qr_code')->nullable();
            $table->string('url')->nullable();
            $table->foreignId('jenis_device_id');
            $table->foreignId('ruangan_id')->nullable();
            $table->float('suhu')->nullable()->default(0);
            $table->boolean('status')->default(false);
            $table->float('min_suhu')->nullable();
            $table->float('max_suhu')->nullable();
            $table->integer('watt')->default(0);
            $table->string('mac_address');
            $table->timestamps();

            $table->foreign('ruangan_id')->references('id')->on('ruangan')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('jenis_device_id')->references('id')->on('jenis_device')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('device');
    }
};
