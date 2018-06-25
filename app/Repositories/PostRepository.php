<?php

namespace App\Repositories;

use App\Interfaces\IPostRepository;

use App\Models\Post;

class PostRepository extends GenericRepository implements IPostRepository
{
    public function __construct(Post $model)
    {
        $this->model = $model;
    }

    public function getUltimosPosts(array $relacoes = null, int $quantidade_posts = null)
    {
        $quantidade = $quantidade_posts;
        $query = $this->model->orderBy('created_at', 'desc')->take($quantidade);
        if(is_null($relacoes))
        {
            return $query->get();
        }

        return  $this->adicionarJoins($query, $relacoes)->get();
    }

    public function getPostsPorCategoria(int $categoria_id, int $quantidade_posts = null)
    {
        $condicao = function($q) use ($categoria_id)
        {
            $q->where('categoria_id', $categoria_id);
        };

        return $this->model->orderBy('created_at', 'desc')->with(['categorias' => $condicao])->whereHas('categorias',$condicao)->take($quantidade_posts)->get();
    }


    public function gerirCategorias(int $post_id, array $categorias)
    {
        $post = $this->model->find($post_id);
        $postCategorias = $post->categorias()->pluck('id')->toArray();      
        // $categorias = array de objetos; vamos extrair apenas a coluna 'id' do array de objetos (1º converter objetos em array)
        $categorias = array_column(json_decode(json_encode($categorias), true), 'id');


        foreach($postCategorias as $postCategoria)
        {
            if(!in_array($postCategoria, $categorias))
            {
                $post->categorias()->detach($postCategoria);
            }
        }

        foreach($categorias as $categoria)
        {
            if(!in_array($categoria, $postCategorias))
            {
                $post->categorias()->attach($categoria);
            }
        }
    }
}