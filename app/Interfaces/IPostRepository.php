<?php

namespace App\Interfaces;

interface IPostRepository extends IGenericRepository 
{
    function getUltimosPosts(array $relacoes = null);
    function getPostsPorCategoria(int $categoria_id, int $quantidade_posts);
    function gerirCategorias(int $post_id, array $categorias);

}