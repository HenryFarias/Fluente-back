<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\SeguidoreRepository;
use App\Models\Seguidore;
use App\Validators\SeguidoreValidator;

/**
 * Class SeguidoreRepositoryEloquent
 * @package namespace App\Repositories;
 */
class SeguidoreRepositoryEloquent extends BaseRepository implements SeguidoreRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Seguidore::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
