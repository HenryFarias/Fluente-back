<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\PerfilRepository;
use App\Models\Perfil;

/**
 * Class PerfiRepositoryEloquent
 * @package namespace App\Repositories;
 */
class PerfilRepositoryEloquent extends BaseRepository implements PerfilRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Perfil::class;
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
