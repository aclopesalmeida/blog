<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{

    protected $fillable = ['titulo', 'introducao', 'corpo', 'imagem', 'utilizador_id'];
    

    public function categorias()
    {
        return $this->belongsToMany('App\Models\Categoria')->withTimestamps();
    }

    public function comentarios()
    {
        return $this->hasMany('App\Models\Comentario');
    }
}
