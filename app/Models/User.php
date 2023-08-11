<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_active',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function companiesWithRole()
    {
        return $this->belongsToMany(Company::class, 'company_role_user')
                    ->withPivot('role_id')
                    ->using(CompanyRoleUser::class)
                    ->withTimestamps();
    }

    public function rolesInCompany()
    {
        return $this->belongsToMany(Role::class, 'company_role_user')
                    ->withPivot('company_id')
                    ->using(CompanyRoleUser::class)
                    ->withTimestamps();
    }

}
