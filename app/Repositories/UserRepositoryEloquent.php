<?php

namespace App\Repositories;

use Illuminate\Support\Facades\App;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Models\User;

/**
 * Class UserRepositoryEloquent
 * @package namespace App\Repositories;
 */
class UserRepositoryEloquent extends BaseRepository implements UserRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return User::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    public function getAllForEventos($id)
    {
        return App::make('App\\Repositories\\UserRepository')->findWhereNotIn('id', [$id]);
    }

    public function getAllProfessores()
    {
        return $this->getModel()->where("formacao", "!=", "null")->get();
    }
}
