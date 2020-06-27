<?php

namespace Test\Unit\app\ApiClients;

use App\ApiClients\Pokeapi;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Psr7\Response;
use InvalidArgumentException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Test\TestCase;

class PokeapiTest extends TestCase
{
    public function test_getPokemonDescription_with_name_should_return_pokemon_description(): void
    {
        $descriptions = json_encode( [
            'flavor_text_entries' => [
                [
                    'flavor_text' => 'pokemon description',
                    'language' => [
                        'name' => 'en'
                    ]
                ],
                [
                    'flavor_text' => 'pokemon desçription',
                    'language' => [
                        'name' => 'fr'
                    ]
                ]
            ]
        ]);

        $client = $this->createMock(ClientInterface::class);
        $client->method('request')
            ->withAnyParameters()
            ->willReturn(new Response(200, [], $descriptions));

        $sut = new Pokeapi($client);

        $description = $sut->getPokemonDescription("name");

        $this->assertEquals(
            'pokemon description',
            $description
        );
    }

    public function test_getPokemonDescription_with_empty_response_should_throw_NotFoundHttpException(): void
    {
        $emptyResponse = json_encode([]);

        $client = $this->createMock(ClientInterface::class);
        $client->method('request')
            ->withAnyParameters()
            ->willReturn(new Response(200, [], $emptyResponse));

        $sut = new Pokeapi($client);

        $this->expectException(NotFoundHttpException::class);

        $sut->getPokemonDescription("name");
    }

    public function test_getPokemonDescription_with_response_has_no_descriptions_should_throw_NotFoundHttpException(): void
    {
        $responseWithNoDescriptions = json_encode( [
            'flavor_text_entries' => []
        ]);
        $client = $this->createMock(ClientInterface::class);
        $client->method('request')
            ->withAnyParameters()
            ->willReturn(new Response(200, [], $responseWithNoDescriptions));

        $sut = new Pokeapi($client);

        $this->expectException(NotFoundHttpException::class);

        $sut->getPokemonDescription("name");
    }

    public function test_getPokemonDescription_with_response_has_multiple_languages_should_return_only_the_description_in_english(): void
    {
        $descriptions = json_encode( [
            'flavor_text_entries' => [
                [
                    'flavor_text' => 'pokemon description',
                    'language' => [
                        'name' => 'en'
                    ]
                ],
                [
                    'flavor_text' => 'pokemon desçription',
                    'language' => [
                        'name' => 'fr'
                    ]
                ]
            ]
        ]);

        $client = $this->createMock(ClientInterface::class);
        $client->method('request')
            ->withAnyParameters()
            ->willReturn(new Response(200, [], $descriptions));

        $sut = new Pokeapi($client);

        $description = $sut->getPokemonDescription("name");

        $this->assertEquals('pokemon description', $description);
    }

    public function test_getPokemonDescription_with_response_has_not_english_language_should_throw_InvalidArgumentException(): void
    {
        $descriptions = json_encode( [
            'flavor_text_entries' => [
                [
                    'flavor_text' => 'pokemon desçription',
                    'language' => [
                        'name' => 'fr'
                    ]
                ],
                [
                    'flavor_text' => 'pokemon desçription',
                    'language' => [
                        'name' => 'fr'
                    ]
                ]
            ]
        ]);

        $client = $this->createMock(ClientInterface::class);
        $client->method('request')
            ->withAnyParameters()
            ->willReturn(new Response(200, [], $descriptions));

        $this->expectException(InvalidArgumentException::class);

        $sut = new Pokeapi($client);

        $description = $sut->getPokemonDescription("name");

        $this->assertEquals('pokemon description', $description);
    }

}
