<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'address', 'website', 'phone']; 

    public function users()
    {
        return $this->belongsToMany(User::class, 'company_role_user')
                    ->withPivot('role_id')
                    ->using(CompanyRoleUser::class)
                    ->withTimestamps();
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'company_role_user')
                    ->withPivot('user_id')
                    ->using(CompanyRoleUser::class)
                    ->withTimestamps();
    }

}
