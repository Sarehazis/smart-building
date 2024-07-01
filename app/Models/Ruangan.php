<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Ruangan extends Model
{
    use HasFactory,
        HasApiTokens;

    protected $table = 'ruangan';
    protected $fillable = [
        'nama_ruangan',
        'deskripsi',
        'ukuran',
        'perusahaan_id'
    ];

    public function device()
    {
        return $this->hasMany(Device::class);
    }

    public function perusahaan()
    {
        return $this->belongsTo(Perusahaan::class);
    }
}
