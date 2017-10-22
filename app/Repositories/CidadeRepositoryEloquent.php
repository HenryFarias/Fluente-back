<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\CidadeRepository;
use App\Models\Cidade;
use App\Validators\CidadeValidator;

/**
 * Class CidadeRepositoryEloquent
 * @package namespace App\Repositories;
 */
class CidadeRepositoryEloquent extends BaseRepository implements CidadeRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Cidade::class;
    }

    public function getModel()
    {
        return new $this->model;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
