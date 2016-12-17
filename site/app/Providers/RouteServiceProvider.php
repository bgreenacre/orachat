<?php

namespace Ora\Chat\Providers;

use Illuminate\Routing\Router;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'Ora\Chat\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        $router = $this->app->make(Router::class);
        $router->pattern('chat_id', '[0-9]+');
        
        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        $router = $this->app->make(Router::class);
        $router->group([
            'middleware' => 'api',
            'namespace' => $this->namespace,
            'prefix' => 'api',
        ], function ($router) {
            $router->get('users/me', 'UsersController@me');
            $router->put('users/me', 'UsersController@edit');
            $router->post('users/login', 'UsersController@login');
            $router->post('users/register', 'UsersController@register');
            $router->get('chats/{chat_id}/messages', 'MessagesController@list');
            $router->post('chats/{chat_id}/messages', 'MessagesController@create');
            $router->get('chats', 'ChatsController@list');
            $router->post('chats', 'ChatsController@create');
        });
    }
}
