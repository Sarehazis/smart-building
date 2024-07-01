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
}
