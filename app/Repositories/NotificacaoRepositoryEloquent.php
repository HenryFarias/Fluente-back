<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\NotificacaoRepository;
use App\Models\Notificacao;

/**
 * Class NotificacaoRepositoryEloquent
 * @package namespace App\Repositories;
 */
class NotificacaoRepositoryEloquent extends BaseRepository implements NotificacaoRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Notificacao::class;
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
}
