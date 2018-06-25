<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Interfaces\ICategoriaRepository;
use Illuminate\Support\Facades\Validator;

class CategoriasController extends Controller
{
    public $categoriaRepo;

    public function __construct(ICategoriaRepository $categoria) {
        $this->categoriaRepo = $categoria;
    }

    public function categorias(Request $request)
    {
        return ['categorias' => $this->categoriaRepo->getAll()];
    }

    public function criar(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'designacao' => 'required|string'
        ]);

        if($validator->fails())
            return ['erro' => $validator->errors()];


        $this->categoriaRepo->criar(['designacao' => $request['designacao']]);

        return ['mensagem' => 'Categoria criada com sucesso!'];
    }
    

    public function editar(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'designacao' => 'required|string'
        ]);

        if($validator->fails())
            return ['erro' => $validator->errors()];

        $categoria = $this->categoriaRepo->get($request['id']);
        if(is_null($categoria))
            return ['erro' => 'redirecionar'];

        $this->categoriaRepo->editar($request['id'], $request->all());

        return ['mensagem' => 'Categoria editada com sucesso!'];
    }


    public function apagar(Request $request)
    {
        $categoria = $this->categoriaRepo->get($request['id']);
        $this->categoriaRepo->apagar($request['id']);
        return ['mensagem' => 'Categoria removida!'];
    }
}
