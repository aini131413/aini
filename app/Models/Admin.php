<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;
class Admin extends Authenticatable
{
    public $fillable=[
        "name",
        "email",
        "password",
    ];
    use HasRoles;
    protected $guard_name = 'admin';

    public function role()
    {
        return $this->belongsTo(Role::class,"name");
    }


}
