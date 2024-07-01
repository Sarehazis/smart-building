<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Device extends Model
{
    use HasFactory, HasApiTokens;

    protected $table = 'device';
    protected $fillable = [
        'nama_device',
        'jenis_device_id',
        'ruangan_id',
        'suhu',
        'status',
        'min_suhu',
        'max_suhu',
        'mac_address',
        'qr_code',
        'url',
    ];

    public function jenis_device()
    {
        return $this->belongsTo(jenisDevice::class);
    }
}
