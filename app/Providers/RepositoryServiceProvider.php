<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(\App\Repositories\UserIdiomaRepository::class, \App\Repositories\UserIdiomaRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\UserEventoRepository::class, \App\Repositories\UserEventoRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\UserRepository::class, \App\Repositories\UserRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\SeguidoreRepository::class, \App\Repositories\SeguidoreRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\QuestionarioRepository::class, \App\Repositories\QuestionarioRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\PerfiRepository::class, \App\Repositories\PerfiRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\PaiseRepository::class, \App\Repositories\PaiseRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\NotificacoRepository::class, \App\Repositories\NotificacoRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\NivelEventoRepository::class, \App\Repositories\NivelEventoRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\NiveiRepository::class, \App\Repositories\NiveiRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\IdiomaRepository::class, \App\Repositories\IdiomaRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\EventoRepository::class, \App\Repositories\EventoRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\EstadoRepository::class, \App\Repositories\EstadoRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\ComentarioRepository::class, \App\Repositories\ComentarioRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\CidadeRepository::class, \App\Repositories\CidadeRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\AssuntoRepository::class, \App\Repositories\AssuntoRepositoryEloquent::class);
        //:end-bindings:
    }
}
