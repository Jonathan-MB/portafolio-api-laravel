<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens ;

    protected $table = 'users';

    protected $fillable = [
        'name',
        'email',
        'rol_id',
        'password'
    ];

    public function setPassword($password){
        $this->attributes['password'] = Hash::make($password);
    }

    public function rol(){
        
        return $this->belongsTo(Rol::class);

    }

    public function notes(){
        
        return $this->hasMany(Note::class);

    }


}
