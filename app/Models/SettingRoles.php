<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class SettingRoles extends Model
{
    use HasFactory, HasApiTokens;

    protected $table = 'settings_roles';
    protected $fillable = ['users_id', 'roles_id'];


    public function User()
    {
        return $this->belongsTo(User::class);
    }

    public function Device()
    {
        return $this->belongsTo(Device::class);
    }

    public function Roles()
    {
        return $this->belongsTo(Roles::class);
    }
}
