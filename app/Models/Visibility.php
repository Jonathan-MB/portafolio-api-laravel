<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visibility extends Model
{
    use HasFactory;
    protected $fillable = [
        'visibility_name'
    ];


    public function Notes(){
        
        return $this->hasMany(Note::class);

    }

}
