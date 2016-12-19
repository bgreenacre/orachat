<?php

namespace Ora\Chat\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Routing\ResponseFactory as Response;

class AppServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $response = $this->app->make(Response::class);
        $response->macro(
            'payload',
            function(array $data, $success = true, $status = 200) use ($response)
            {
                $payload = [
                    'success' => ( ! $success === true) ? false : true,
                    'data'    => $data,
                ];

                return $response->json($payload, $status);
            }
        );

        $this->bindObservers()
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    protected function bindObservers()
    {
        \Ora\Chat\Users\UserModel::observe($this->app->make(\Ora\Chat\Users\UserValidator::class));
    }

}
