<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\ComentarioRepository;
use App\Validators\ComentarioValidator;
use App\Models\Comentario;

/**
 * Class ComentarioRepositoryEloquent
 * @package namespace App\Repositories;
 */
class ComentarioRepositoryEloquent extends BaseRepository implements ComentarioRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Comentario::class;
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
