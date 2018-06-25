<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    protected $fillable = ['designacao'];
    

    public function posts()
    {
        return $this->belongsToMany('App\Models\Post')->withTimestamps();
    }
}