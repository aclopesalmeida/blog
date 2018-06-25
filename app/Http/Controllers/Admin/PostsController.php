<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Interfaces\IPostRepository;
use App\Helpers\GerirImagens;

class PostsController extends Controller
{
    public $postRepo;
    
    public function __construct(IPostRepository $post)
    {
        $this->postRepo = $post;
    }

    public function posts(Request $request)
    {
        $posts = $this->postRepo->getAll(['comentarios', 'categorias']);
        
        return ['posts' => $posts];
    }


    public function criar(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'titulo' => 'required',
            'introducao' => 'required',
            'corpo' => 'required',
            'categorias' => 'nullable',
            'imagem' => 'nullable|image|max:3000|mimes:jpeg,png,jpg'
        ]);
        
        if($validator->fails())
        {
            return ['erro' => $validator->errors()];
        }

        $dados = [
            'titulo' => $request['titulo'],
            'corpo' => $request['corpo'],
            'introducao' => $request['introducao'],
            'utilizador_id' => 1
        ];

        if(!is_null($request['imagem']))
        {
            $img = GerirImagens::guardar($request['imagem']);
            $dados['imagem'] = $img;
        }
        
        $post = $this->postRepo->criar($dados);


        if(!is_null($request['categorias']))
        {
            $categorias = json_decode($request['categorias']);
            $this->postRepo->gerirCategorias($post->id, $categorias);
        }

        return ['mensagem' => 'Post criado com sucesso!'];
    }

    public function editar(Request $request)
    {
       $regras = [
        'titulo' => 'required',
        'introducao' => 'required',
        'corpo' => 'required',
        'categorias' => 'nullable',
        'imagem' => is_string($request['imagem']) ? '' : 'nullable|image|max:3000|mimes:jpeg,png,jpg'
    ];
        $validator = Validator::make($request->all(), $regras);
        
        if($validator->fails())
        {
            return ['erro' => $validator->errors()];
        }
        
        $post = $this->postRepo->get($request['id']);
        $dados = $request->except('__token');
        if( !is_null($request['imagem']) && !is_string($request['imagem']))
        {
            if(!is_null($post->imagem)) {
                GerirImagens::apagar($post->imagem);
            }
            $img = GerirImagens::guardar($request['imagem']);
            $dados['imagem'] = $img;
        }

        $this->postRepo->editar($post->id, $dados);
        if(!is_null($request['categorias']))
        {
            $categorias = json_decode($request['categorias']);
            // $this->postRepo->gerirCategorias($post->id, $categorias);
        }

        return ['mensagem' => 'Post editado com sucesso!'];


    }

    public function apagar(Request $request)
    {

        $post = $this->postRepo->get($request['id']);
        $this->postRepo->apagar($request['id']);
        if(!is_null($post->imagem)) {
            GerirImagens::apagar($post->imagem);
        }

        return ['mensagem' => 'Post removido com sucesso!'];
        
    }

}
