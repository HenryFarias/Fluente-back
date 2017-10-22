<?php

namespace App\Repositories;

use Illuminate\Support\Facades\App;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\EventoRepository;
use App\Models\Evento;

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

    public function getAllForMaps($idUser)
    {
        $user = App::make('App\\Repositories\\UserRepository')->find($idUser);
        $eventosPrivados = $user->eventos()->with('endereco')->where('publico_ou_privado','privado')->get();
        $eventosPublicos = App::make('App\\Repositories\\EventoRepository')->with(['endereco'])->findByField('publico_ou_privado','publico');

        return array_merge($eventosPrivados->toArray(), $eventosPublicos->toArray());
    }

    public function getAll($idUser)
    {
        $user = App::make('App\\Repositories\\UserRepository')->find($idUser);
        $eventos = $user->eventos()->get();
        $eventosDono = $user->eventosDono()->get()->toArray();

        foreach ($eventosDono as $index => $evento) {
            $eventosDono[$index]['dono'] = $user->toArray();
        }

        return array_merge($eventos->toArray(), $eventosDono);
    }
}
