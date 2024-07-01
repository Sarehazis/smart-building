<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Lantai extends Model
{
    use HasFactory,
        HasApiTokens;

    protected $table = 'lantai';
    protected $fillable = [
        'nama',
        'deskripsi',
        'gedung_id',
    ];

    public function ruangan()
    {
        return $this->hasMany(Ruangan::class);
    }
}
