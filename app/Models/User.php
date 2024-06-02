<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
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
        'firstname', 'lastname', 'email', 'numero', 'photo_url', 'is_active', 'password'
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
   
    public function structure()
  {
     return $this->hasMany(Structure::class, 'responsible_id');
  }
   
    public function scopeResponsibles($query)
  {
     return $query->whereHas('roles', function ($query) {
     $query->where('name', 'Responsable_de_la_structure_de_rattachement');
     });
  }
   
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_role');
    }
    /**
     * list permissions for this user
    */
    public function getPermissionsAttribute(){
        return $this->roles() 
        ->with('permissions') 
        ->get() 
        ->pluck('permissions') // pluck only permissions attribute from all records
        ->flatten() // flatten results and get me only permissions collections
        ->unique(); // filter unique records (since many roles can share the same permission)
    }
    public function bCommandeinterne()
    {
        return $this->hasMany(BCInterne::class, 'user_id');
    }
    public function structures()
    {
        return $this->belongsToMany(Structure::class, 'structure_user');
    }
}