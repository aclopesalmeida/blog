<?php

namespace App\Repositories;

use App\Models\Comentario;
use App\Interfaces\IComentarioRepository;

class ComentarioRepository extends GenericRepository implements IComentarioRepository
{
    public function __construct(Comentario $model)
    {
        $this->model = $model;
    }
}