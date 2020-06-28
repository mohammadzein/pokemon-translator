<?php

namespace App\Services;

use App\Structs\Pokemon;
use App\ApiClients\Contracts\PokemonApiInterface;
use App\Translators\Contracts\TranslatorInterface;

class PokemonService
{
    /**
     * pokemon api
     *
     * @var PokemonApiInterface
     */
    private $pokemonApi;

    /**
     * text translator
     *
     * @var TranslatorInterface
     */
    private $translator;

    function __construct(PokemonApiInterface $pokemonApi, TranslatorInterface $translator)
    {
        $this->pokemonApi = $pokemonApi;

        $this->translator = $translator;
    }

    /**
     * get pokemon object that contains name and description
     *
     * @param string $name
     * @param array $filters
     * @return Pokemon
     */
    public function getPokemon(string $name, array $filters): Pokemon
    {
        $description = $this->pokemonApi->getPokemonDescription($name, $filters);
        $descriptionTranslated = $this->translator->translate($description);

        return new Pokemon(
            $name,
            $descriptionTranslated
        );
    }
}
