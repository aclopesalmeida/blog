<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Interfaces\IPostRepository;
use App\Interfaces\ICategoriaRepository;

class PostsController extends Controller
{
    public $postRepo;
    public $categoriaRepo;
    
    public function __construct(IPostRepository $post, ICategoriaRepository $categoria)
    {
        $this->postRepo = $post;
        $this->categoriaRepo = $categoria;
    }    

    public function posts(Request $request)
    {
        $quantidade = $request['quantidade'] ?? 6;
        $posts = $this->postRepo->getUltimosPosts(['comentarios', 'categorias'], $quantidade);

        return ['posts' => $posts];
    }


    public function ver(Request $request)
    {
        if(is_null($request['id'])) {
            return ['error', 'error'];
        }
        $post = $this->postRepo->get($request['id'], ['comentarios', 'categorias']);
        return ['post' => $post];
    }
    

    public function postsCategoria(Request $request)
    {
        $quantidadePosts = $request['quantidade'] ?? 6;

        $posts = $this->postRepo->getPostsPorCategoria($request['id'], $quantidadePosts);
        $categoria = $this->categoriaRepo->get($request['id']);
        return ['posts' => $posts, 'categoria' => $categoria];
    
    }
}
