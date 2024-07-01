<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class SettingRuanganDevice extends Model
{
    use HasFactory,
        HasApiTokens;

    protected $table = 'setting_ruangan_device';
    protected $fillable = [
        'perusahaan_id',
        'gedung_id',
        'lantai_id',
        'ruangan_id',
        'device_id',
        'deskripsi'
    ];
}
