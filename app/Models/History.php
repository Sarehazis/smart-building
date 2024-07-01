<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class History extends Model
{
    use HasFactory, HasApiTokens;

    protected $table = 'history';
    protected $fillable = [
        'status',
        'deskripsi',
    ];
}
