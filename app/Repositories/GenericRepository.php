<?php


namespace App\Repositories;

use App\Interfaces\IGenericRepository;

class GenericRepository implements IGenericRepository
{
    protected $model;

    public function __construct(Model $model) 
    {
        $this->model = $model;
    }

    protected function adicionarJoins($query, array $relacoes)
    {        
        foreach($relacoes as $relacao) 
        {
            if(is_array($relacao))
            {
                foreach($relacao as $k => $v)
                {
                    $query = $query->with([$relacao => function($q) use ($k, $v) {
                        $q->where($k, $v);
                    }]);
                }
            }
            else {
                $query = $query->with([$relacao]);
            }
        }
        return $query;

    }



    public function get(int $id, array $relacoes = null)
    {
        $query = $this->model->where('id', $id);

        if(is_null($relacoes))
        {
            return $query->first();
        }
        else {
            $query = $this->adicionarJoins($query, $relacoes);
            return $query->first();
        }
    }


    public function getAll(array $relacoes = null, int $paginacao = null)
    {
        $query = $this->model;

        if(is_null($relacoes))
        {
            return is_null($paginacao) ? $query->all() : $query->paginate($paginacao);
        }
        else {
            $query = $this->adicionarJoins($query, $relacoes);
            return is_null($paginacao) ? $query->get() : $query->paginate($paginacao);
        }
    }

    public function criar(array $dados)
    {
        return $this->model->create($dados);
    }

    public function editar(int $id, array $dados)
    {
        $this->model->find($id)->update($dados);
    }

    public function apagar(int $id)
    {
        $this->model->find($id)->delete();
    }
}