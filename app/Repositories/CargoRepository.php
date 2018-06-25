<?php

namespace App\Repositories;

use App\Models\Cargo;
use App\Interfaces\ICargoRepository;


class CargoRepository extends GenericRepository implements ICargoRepository
{
    public function __construct(Cargo $model)
    {
        $this->model = $model;
    }
}