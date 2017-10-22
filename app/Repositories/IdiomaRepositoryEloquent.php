<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\IdiomaRepository;
use App\Models\Idioma;
use App\Validators\IdiomaValidator;

/**
 * Class IdiomaRepositoryEloquent
 * @package namespace App\Repositories;
 */
class IdiomaRepositoryEloquent extends BaseRepository implements IdiomaRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Idioma::class;
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
