<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Interfaces\ICargoRepository;

class CargosController extends Controller
{

    public $cargoRepo;

    public function __construct(ICargoRepository $cargo)
    {
        $this->cargoRepo = $cargo;
    }

    public function cargos(Request $request)
    {
        return ['cargos' => $this->cargoRepo->getAll()];
    }

    public function ver(Request $request)
    {
        return ['cargo' => $this->cargoRepo->get($request['id'])];
    }


    public function criar(Request $request)
    {
       $validator = Validator::make($request->all(), [
            'designacao' => 'required'
        ]);

        if($validator->fails() ) 
        {
            return ['erro' => $validator->errors()];
        }

        $this->cargoRepo->criar(['designacao' => $request['designacao']]);

        return ['mensagem' => 'Cargo criado com sucesso!'];
    }



    public function editar(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'designacao' => 'required'
        ]);

        if($validator->fails() ) 
        {
            return ['erro' => $validator->errors()];
        }

        $cargo = $this->cargoRepo->get($request['id']);

        $this->cargoRepo->editar($cargo->id, ['designacao' => $request['designacao']]);

        return ['mensagem' => 'Cargo editado com sucesso!'];
    }


    public function apagar(Request $request)
    {
        if(is_null($request['id']))
        {
            return ['erro' => 'redirecionar'];
        }

        $this->cargoRepo->apagar($request['id']);

        return ['mensagem' => 'Cargo removido com sucesso!'];
    }
    
}
