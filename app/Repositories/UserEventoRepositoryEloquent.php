<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\UserEventoRepository;
use App\Models\UserEvento;
use App\Validators\UserEventoValidator;

/**
 * Class UserEventoRepositoryEloquent
 * @package namespace App\Repositories;
 */
class UserEventoRepositoryEloquent extends BaseRepository implements UserEventoRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return UserEvento::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
