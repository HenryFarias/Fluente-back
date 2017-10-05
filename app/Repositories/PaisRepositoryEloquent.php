<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\PaiseRepository;
use App\Models\Pais;

/**
 * Class PaiseRepositoryEloquent
 * @package namespace App\Repositories;
 */
class PaisRepositoryEloquent extends BaseRepository implements PaisRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Pais::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
