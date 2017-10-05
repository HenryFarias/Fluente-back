<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\UserIdiomaRepository;
use App\Models\UserIdioma;
use App\Validators\UserIdiomaValidator;

/**
 * Class UserIdiomaRepositoryEloquent
 * @package namespace App\Repositories;
 */
class UserIdiomaRepositoryEloquent extends BaseRepository implements UserIdiomaRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return UserIdioma::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
