<?php

namespace App\ApiClients\Contracts;

interface PokemonApiInterface {
    public function getPokemonDescription(string $name): string;
}
