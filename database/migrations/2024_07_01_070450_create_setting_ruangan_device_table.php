
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
        Schema::create('setting_ruangan_device', function (Blueprint $table) {
            $table->id();
            $table->foreignId('perusahaan_id')->nullable();
            $table->foreignId('gedung_id')->nullable();
            $table->foreignId('lantai_id')->nullable();
            $table->foreignId('ruangan_id')->nullable();
            $table->foreignId('device_id')->nullable();
            $table->text('deskripsi');
            $table->timestamps();

            $table->foreign('perusahaan_id')->references('id')->on('perusahaan')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('gedung_id')->references('id')->on('gedung')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('lantai_id')->references('id')->on('lantai')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('ruangan_id')->references('id')->on('ruangan')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('device_id')->references('id')->on('device')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('setting_ruangan_device');
    }
};
