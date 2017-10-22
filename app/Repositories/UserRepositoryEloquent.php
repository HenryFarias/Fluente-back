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

    public function getAllForEventos($id)
    {
        return App::make('App\\Repositories\\UserRepository')->findWhereNotIn('id', [$id]);
    }

    public function getAllProfessores()
    {
        $professores = [];

        $users = $this->model->with(['perfil' => function($q) {
            $q->where('name', 'Professor');
        }])->get()->toArray();

        foreach ($users as $user) {
            if ($user['perfil']['name'] == 'Professor') {
                $professores[] = $user;
            }
        }

        return $professores;
    }
}
