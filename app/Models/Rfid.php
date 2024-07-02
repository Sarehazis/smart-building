<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Rfid extends Model
{
    use HasFactory, HasApiTokens;
    protected $table = 'rfid';
    protected $fillable = [
        'users_id',
        'rfid',
    ];

    public function User()
    {
        return $this->belongsTo(User::class);
    }
}
