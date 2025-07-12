<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory;

    protected $primaryKey = 'id_user';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $hidden = ['password', 'remember_token'];
    protected $guarded = [''];

    public function vendor()
    {
        return $this->hasOne(Vendor::class, 'id_user');
    }
}
