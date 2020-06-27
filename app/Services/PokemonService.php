<?php

namespace App\Services;

use App\Structs\Pokemon;
use App\ApiClients\Contracts\PokemonApiInterface;
use App\Translators\Contracts\TranslatorInterface;

class PokemonService
{
    /**
     * text translator
     *
     * @var TranslatorInterface
     */
    private $translator;

    /**
     * pokemon source
     *
     * @var PokemonApiInterface
     */
    private $pokemonApi;

    function __construct(TranslatorInterface $translator, PokemonApiInterface $pokemonApi)
    {
        $this->translator = $translator;

        $this->pokemonApi = $pokemonApi;
    }

    /**
     * get pokemon object that contains name and description
     *
     * @param string $name
     * @return Pokemon
     * @throws GuzzleException
     */
    public function getPokemon(string $name): Pokemon
    {
        $description = $this->pokemonApi->getPokemonDescription($name);
        $descriptionTranslated = $this->translator->translate($description);

        return new Pokemon(
            $name,
            $descriptionTranslated
        );
    }
}
