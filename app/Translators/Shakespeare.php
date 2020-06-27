<?php

namespace App\Translators;

use App\Translators\Contracts\TranslatorInterface;
use GuzzleHttp\ClientInterface;

class Shakespeare implements TranslatorInterface {

    private $httpClient;

    private $baseUri;

    public function __construct(ClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;

        $this->baseUri = 'https://api.funtranslations.com';
    }

    public function translate(string $text): string
    {
        $response = $this->httpClient->request(
            "POST",
            "{$this->baseUri}/translate/shakespeare.json", [
            'json' => ['text' => $text]
        ]);
        $jsonResponse = json_decode($response->getBody()->getContents(), true);
        return $jsonResponse['contents']['translated'];
    }
}
