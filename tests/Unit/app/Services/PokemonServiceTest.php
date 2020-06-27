<?php

namespace Test\Unit\app\Services;

use App\ApiClients\Contracts\PokemonApiInterface;
use App\Services\PokemonService;
use App\Structs\Pokemon;
use App\Translators\Contracts\TranslatorInterface;
use Test\TestCase;

class PokemonServiceTest extends TestCase
{

    public function test_getPokemon_with_name_should_return_Pokemon_object_with_translated_description(): void
    {
        $pokemonApi = $this->createMock(PokemonApiInterface::class);
        $pokemonApi->method('getPokemonDescription')
            ->withAnyParameters()
            ->willReturn('pokemon description');

        $translator = $this->createMock(TranslatorInterface::class);
        $translator->method('translate')
            ->withAnyParameters()
            ->willReturn('pokemon translated description');


        $sut = new PokemonService($pokemonApi, $translator);

        $result = $sut->getPokemon('pokemon name');

        $this->assertEquals(
            new Pokemon('pokemon name', 'pokemon translated description'),
            $result
        );
    }
}
