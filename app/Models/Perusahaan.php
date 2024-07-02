<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Perusahaan extends Model
{
    use HasFactory, HasApiTokens;

    protected $table = 'perusahaan';
    protected $fillable = [
        'nama',
        'deskripsi',
        'lokasi',
        'image',
        'kwh',
        'harga_kwh'
    ];

    public function ruangan()
    {
        return $this->hasMany(Ruangan::class);
    }

    public function gedung()
    {
        return $this->hasMany(Gedung::class);
    }
}
