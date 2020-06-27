<?php

namespace App\Providers;

use App\ApiClients\Contracts\PokemonApiInterface;
use App\ApiClients\Pokeapi;
use App\Translators\Contracts\TranslatorInterface;
use App\Translators\Shakespeare;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            ClientInterface::class,
            Client::class
        );

        $this->app->bind(
            TranslatorInterface::class,
            Shakespeare::class
        );

        $this->app->bind(
            PokemonApiInterface::class,
            Pokeapi::class
        );
    }
}
