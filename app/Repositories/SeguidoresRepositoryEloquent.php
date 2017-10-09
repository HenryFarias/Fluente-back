<?php

namespace App\Repositories;

use App\Interfaces\SeguidoresRepository;
use App\Models\Seguidores;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;

/**
 * Class SeguidoreRepositoryEloquent
 * @package namespace App\Repositories;
 */
class SeguidoresRepositoryEloquent extends BaseRepository implements SeguidoresRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Seguidores::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
