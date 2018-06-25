<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Interfaces\IComentarioRepository;

class ComentariosController extends Controller
{

    public $comentarioRepo;

    public function __construct(IComentarioRepository $comentario)
    {
        $this->comentarioRepo = $comentario;
    }

    public function comentarios(Request $request)
    {
        return $this->comentarioRepo->getAll();
    }


    public function apagar(Request $request)
    {
        $comentario = $this->comentarioRepo->get($request['id']);
        if(is_null($comentario))
        {
            return ['erro' => 'redirecionar'];
        }

        $this->comentarioRepo->apagar($comentario->id);
        return ['mensagem' => 'Comentário removido com sucesso!'];
    }
    //
}
