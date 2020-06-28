<?php

namespace App\Http\Controllers;

use App\Services\PokemonService;
use Illuminate\Http\JsonResponse;

class PokemonController extends Controller
{
    private $pokemonService;

    public function __construct(PokemonService $pokemonService)
    {
        $this->pokemonService = $pokemonService;
    }

    public function get(string $name): JsonResponse
    {
        $pokemon = $this->pokemonService->getPokemon(
            strtolower($name),
            [
                'language' => request()->get('language', 'en'),
                'version' => request()->get('version', 'ruby'),
            ]
        );

        return response()->json([
            'name' => $pokemon->getName(),
            'description' => $pokemon->getDescription()
        ]);
    }

}
