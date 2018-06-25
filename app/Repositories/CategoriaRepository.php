<?php

namespace App\Repositories;

use App\Models\Categoria;
use App\Interfaces\ICategoriaRepository;

class CategoriaRepository extends GenericRepository implements ICategoriaRepository
{
    public function __construct(Categoria $model)
    {
        $this->model = $model;
    }
}