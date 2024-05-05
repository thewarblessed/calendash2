<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'social_id',
        'email_verified_at',
        'social_type'
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

    // public function hasRole($role) {
    //     $roles = $role[0];
    //     return $this->role === $roles;
    // }
    
    public function hasRole($roles)
    {
        if (is_array($roles)) {
            // Check if the user has any of the specified roles
            foreach ($roles as $role) {
                if ($this->role === $role) {
                    return true;
                }
            }
        } else {
            // Check if the user has the specified role
            return $this->role === $roles;
        }
        
        return false;
    }

    public function student() {
        return $this->hasOne('App\Models\Student', 'user_id');
    }

    public function official() {
        return $this->hasOne('App\Models\Official', 'user_id');
    }
    
    public function prof() {
        return $this->hasOne('App\Models\Prof', 'user_id');
    }

    public function staff() {
        return $this->hasOne('App\Models\Staff', 'user_id');
    }

    public function event() {
        return $this->hasMany('App\Models\Event', 'user_id');
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

}
