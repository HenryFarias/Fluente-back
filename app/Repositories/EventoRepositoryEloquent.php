<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\EventoRepository;
use App\Models\Evento;
use App\Validators\EventoValidator;

/**
 * Class EventoRepositoryEloquent
 * @package namespace App\Repositories;
 */
class EventoRepositoryEloquent extends BaseRepository implements EventoRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Evento::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
