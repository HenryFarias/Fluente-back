<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\NivelEventoRepository;
use App\Models\NivelEvento;
use App\Validators\NivelEventoValidator;

/**
 * Class NivelEventoRepositoryEloquent
 * @package namespace App\Repositories;
 */
class NivelEventoRepositoryEloquent extends BaseRepository implements NivelEventoRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return NivelEvento::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
