<?php

namespace App\ApiClients;

use App\ApiClients\Contracts\PokemonApiInterface;
use GuzzleHttp\ClientInterface;
use Illuminate\Http\Response;
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

    public function getPokemonDescription(string $name, $filters): string
    {
        $descriptions = $this->getPokemonDescriptions($name);

        $descriptions = $this->filterDescriptionsByLanguage($descriptions, $filters['language']);

        $descriptions = $this->filterDescriptionsByVersion($descriptions, $filters['version']);

        $this->validateDescriptionsCount($descriptions);

        return $descriptions[0]['flavor_text'];
    }

    private function getPokemonDescriptions(string $name): array
    {
        $response = $this->httpClient->request('GET', "{$this->baseUri}/api/v2/pokemon-species/$name");

        $content = $response->getBody()->getContents();

        $data = json_decode($content, true);

        $flavorTextEntries = $data['flavor_text_entries'] ?? [];

        $this->validateDescriptionsCount($flavorTextEntries);

        return $flavorTextEntries;
    }

        /**
     * validate that a pokemon has descriptions
     * @param array $descriptions
     * @return void
     */
    private function validateDescriptionsCount(array $descriptions): void
    {
        if (empty($descriptions)) {
            throw new NotFoundHttpException(
                "Sorry we don't have any description for this pokemon",
                null,
                Response::HTTP_NOT_FOUND
            );
        }
    }

    /**
     * filter descriptions by language
     *
     * @param array $descriptions
     * @return array
     */
    private function filterDescriptionsByLanguage(array $descriptions, string $language): array
    {
        return array_values(
            array_filter($descriptions, function ($description) use ($language) {
                return $description['language']['name'] == $language;
            })
        );
    }

    /**
     * filter descriptions by version
     *
     * @param array $descriptions
     * @return array
     */
    private function filterDescriptionsByVersion(array $descriptions, string $version): array
    {
        return array_values(
            array_filter($descriptions, function ($description) use ($version) {
                return $description['version']['name'] == $version;
            })
        );
    }

}
