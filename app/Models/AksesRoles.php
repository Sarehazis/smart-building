<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class AksesRoles extends Model
{
    use HasFactory, HasApiTokens;

    protected $table = 'akses_roles';
    protected $fillable = [
        'roles_id',
        'ruangan_id'
    ];

    public function Roles()
    {
        return $this->hasMany(Roles::class);
    }

    // public function Device()
    // {
    //     return $this->belongsTo(Device::class);
    // }

    public function Ruangan()
    {
        return $this->belongsTo(Ruangan::class);
    }
}
