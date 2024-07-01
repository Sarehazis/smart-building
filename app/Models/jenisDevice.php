<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class jenisDevice extends Model
{
    use HasFactory, HasApiTokens;

    protected $table = 'jenis_device';
    protected $fillable = [
        'nama_jenis',
        'deskripsi',
        'category_device_id',
    ];
}
