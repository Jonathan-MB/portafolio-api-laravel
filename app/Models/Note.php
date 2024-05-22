<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'text'
    ];

    public function user(){
        
        return $this->belongsTo(User::class);

    }

    public function state(){
        
        return $this->belongsTo(State::class);

    }

    public function visibility(){
        
        return $this->belongsTo(Visibility::class);

    }

}
