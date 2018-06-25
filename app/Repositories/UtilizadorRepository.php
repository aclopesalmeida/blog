<?php

namespace App\Repositories;

use App\Models\Utilizador;
use App\Interfaces\IUtilizadorRepository;


class UtilizadorRepository extends GenericRepository implements IUtilizadorRepository
{
    public function __construct(Utilizador $model)
    {
        $this->model = $model;
    }
}