<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    public function user(){
        return $this->belongsTo(User::class);
    }

    public function getGetTitleAttribute() //empieza con get termina con Attribute
    {
        return ucfirst($this->title);
    }
    public function setTitleAttribute($value) //empieza con get termina con Attribute
    {
        $this->attributes['title'] = strtolower($value);
    }
}
