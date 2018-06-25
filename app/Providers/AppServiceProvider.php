<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('App\Interfaces\IUtilizadorRepository', 'App\Repositories\UtilizadorRepository');
        $this->app->bind('App\Interfaces\IPostRepository', 'App\Repositories\PostRepository');
        $this->app->bind('App\Interfaces\ICategoriaRepository', 'App\Repositories\CategoriaRepository');
        $this->app->bind('App\Interfaces\ICargoRepository', 'App\Repositories\CargoRepository');
        $this->app->bind('App\Interfaces\IComentarioRepository', 'App\Repositories\ComentarioRepository');
    }
}
