<?php

namespace App\ApiClients;

use App\ApiClients\Contracts\PokemonApiInterface;
use GuzzleHttp\ClientInterface;
use Illuminate\Http\Response;
use InvalidArgumentException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Pokeapi implements PokemonApiInterface
{
    /**
     * @var ClientInterface
     */
    private $httpClient;

    private $baseUri;

    public function __construct(ClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;

        $this->baseUri = "https://pokeapi.co";
    }

    public function getPokemonDescription(string $name): string
    {
        $descriptions = $this->getPokemonDescriptions($name);

        $this->validateDescriptionsCount($descriptions);

        $englishDescriptions = $this->filterDescriptionsByEnglish($descriptions);

        $this->validateDescriptionsCount($englishDescriptions);

        return $this->getRandomDescription($englishDescriptions);
    }

    private function getPokemonDescriptions(string $name): array
    {
        $response = $this->httpClient->request('GET', "{$this->baseUri}/api/v2/pokemon-species/$name");

        $content = $response->getBody()->getContents();

        $data = json_decode($content, true);

        $flavorTextEntries = $data['flavor_text_entries'];

        if (empty($flavorTextEntries)) {
            throw new NotFoundHttpException();
        }

        return $flavorTextEntries;
    }

        /**
     * validate that a pokemon has descriptions
     * @param array $descriptions
     * @return void
     */
    private function validateDescriptionsCount(array $descriptions): void
    {
        if (count($descriptions) === 0) {
            throw new InvalidArgumentException(
                "Sorry we don't have any description for this pokemon",
                Response::HTTP_NOT_FOUND
            );
        }
    }

    /**
     * get a random description from a list of descriptions
     *
     * @param array $descriptions
     * @return string
     */
    private function getRandomDescription(array $descriptions): string
    {
        return $descriptions[array_rand($descriptions)]['flavor_text'];
    }

    /**
     * get english descriptions only
     *
     * @param array $descriptions
     * @return array
     */
    private function filterDescriptionsByEnglish(array $descriptions): array
    {
        return array_values(
            array_filter($descriptions, function ($description) {
                return $description['language']['name'] == 'en';
            })
        );
    }

}
