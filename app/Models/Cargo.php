<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cargo extends Model
{
    protected $fillable = ['designacao'];
    public $table = 'roles';


    public function utilizadores()
    {
        return $this->hasMany('App\Models\Utilizador', 'role_id');
    }
}
