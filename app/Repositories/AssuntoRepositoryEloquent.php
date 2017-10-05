<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\AssuntoRepository;
use App\Models\Assunto;
use App\Validators\AssuntoValidator;

/**
 * Class AssuntoRepositoryEloquent
 * @package namespace App\Repositories;
 */
class AssuntoRepositoryEloquent extends BaseRepository implements AssuntoRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Assunto::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
