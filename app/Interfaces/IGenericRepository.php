<?php

namespace App\Interfaces;

interface IGenericRepository 
{
    function get(int $id, array $relacoes = null);
    function getAll(array $relacoes = null,  int $paginacao = null);
    function criar(array $dados);
    function editar(int $id, array $dados);
    function apagar(int $id);


}