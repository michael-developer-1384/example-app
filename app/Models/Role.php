<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description'];

    public function users()
    {
        return $this->belongsToMany(User::class, 'company_role_user')
                    ->withPivot('company_id')
                    ->using(CompanyRoleUser::class)
                    ->withTimestamps();
    }

    public function companies()
    {
        return $this->belongsToMany(Company::class, 'company_role_user')
                    ->withPivot('user_id')
                    ->using(CompanyRoleUser::class)
                    ->withTimestamps();
    }

}
