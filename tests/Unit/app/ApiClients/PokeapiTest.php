<?php

namespace Test\Unit\app\ApiClients;

use App\ApiClients\Pokeapi;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Psr7\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Test\TestCase;

class PokeapiTest extends TestCase
{
    public function test_getPokemonDescription_with_name_should_return_pokemon_description(): void
    {
        $filters = [
            'language' => 'en',
            'version' => 'ruby'
        ];

        $descriptions = json_encode( [
            'flavor_text_entries' => [
                [
                    'flavor_text' => 'pokemon description',
                    'language' => [
                        'name' => 'en'
                    ],
                    'version' => [
                        'name' => 'ruby'
                    ]
                ],
                [
                    'flavor_text' => 'pokemon desçription',
                    'language' => [
                        'name' => 'fr'
                    ],
                    'version' => [
                        'name' => 'ruby'
                    ]
                ]
            ]
        ]);

        $client = $this->createMock(ClientInterface::class);
        $client->method('request')
            ->withAnyParameters()
            ->willReturn(new Response(200, [], $descriptions));

        $sut = new Pokeapi($client);

        $description = $sut->getPokemonDescription("name", $filters);

        $this->assertEquals(
            'pokemon description',
            $description
        );
    }

    public function test_getPokemonDescription_with_empty_filters_should_throw_NotFoundHttpException(): void
    {
        $filters = [
            'language' => '',
            'version' => ''
        ];

        $descriptions = json_encode( [
            'flavor_text_entries' => [
                [
                    'flavor_text' => 'pokemon description',
                    'language' => [
                        'name' => 'en'
                    ],
                    'version' => [
                        'name' => 'ruby'
                    ]
                ],
                [
                    'flavor_text' => 'pokemon desçription',
                    'language' => [
                        'name' => 'fr'
                    ],
                    'version' => [
                        'name' => 'ruby'
                    ]
                ]
            ]
        ]);

        $client = $this->createMock(ClientInterface::class);
        $client->method('request')
            ->withAnyParameters()
            ->willReturn(new Response(200, [], $descriptions));

        $sut = new Pokeapi($client);

        $this->expectException(NotFoundHttpException::class);

        $sut->getPokemonDescription("name", $filters);
    }

    public function test_getPokemonDescription_with_empty_response_should_throw_NotFoundHttpException(): void
    {
        $filters = [
            'language' => 'en',
            'version' => 'ruby'
        ];

        $emptyResponse = json_encode([]);

        $client = $this->createMock(ClientInterface::class);
        $client->method('request')
            ->withAnyParameters()
            ->willReturn(new Response(200, [], $emptyResponse));

        $sut = new Pokeapi($client);

        $this->expectException(NotFoundHttpException::class);

        $sut->getPokemonDescription("name", $filters);
    }

    public function test_getPokemonDescription_with_response_has_no_descriptions_should_throw_NotFoundHttpException(): void
    {
        $filters = [
            'language' => 'en',
            'version' => 'ruby'
        ];

        $responseWithNoDescriptions = json_encode( [
            'flavor_text_entries' => []
        ]);

        $client = $this->createMock(ClientInterface::class);
        $client->method('request')
            ->withAnyParameters()
            ->willReturn(new Response(200, [], $responseWithNoDescriptions));

        $sut = new Pokeapi($client);

        $this->expectException(NotFoundHttpException::class);

        $sut->getPokemonDescription("name", $filters);
    }

    public function test_getPokemonDescription_with_english_language_should_return_the_description_in_english(): void
    {
        $filters = [
            'language' => 'en',
            'version' => 'ruby'
        ];

        $descriptions = json_encode( [
            'flavor_text_entries' => [
                [
                    'flavor_text' => 'pokemon description in english language',
                    'language' => [
                        'name' => 'en'
                    ],
                    'version' => [
                        'name' => 'ruby'
                    ]
                ],
                [
                    'flavor_text' => 'pokemon desçription',
                    'language' => [
                        'name' => 'fr'
                    ],
                    'version' => [
                        'name' => 'ruby'
                    ]
                ]
            ]
        ]);

        $client = $this->createMock(ClientInterface::class);
        $client->method('request')
            ->withAnyParameters()
            ->willReturn(new Response(200, [], $descriptions));

        $sut = new Pokeapi($client);

        $description = $sut->getPokemonDescription("name", $filters);

        $this->assertEquals('pokemon description in english language', $description);
    }

    public function test_getPokemonDescription_with_red_version_should_return_the_description_in_red_version(): void
    {
        $filters = [
            'language' => 'en',
            'version' => 'red'
        ];

        $descriptions = json_encode( [
            'flavor_text_entries' => [
                [
                    'flavor_text' => 'pokemon description',
                    'language' => [
                        'name' => 'en'
                    ],
                    'version' => [
                        'name' => 'ruby'
                    ]
                ],
                [
                    'flavor_text' => 'pokemon description of the red version',
                    'language' => [
                        'name' => 'en'
                    ],
                    'version' => [
                        'name' => 'red'
                    ]
                ]
            ]
        ]);

        $client = $this->createMock(ClientInterface::class);
        $client->method('request')
            ->withAnyParameters()
            ->willReturn(new Response(200, [], $descriptions));

        $sut = new Pokeapi($client);

        $description = $sut->getPokemonDescription("name", $filters);

        $this->assertEquals('pokemon description of the red version', $description);
    }

    public function test_getPokemonDescription_with_invalid_language_should_throw_NotFoundHttpException(): void
    {
        $filters = [
            'language' => 'invalid',
            'version' => 'ruby'
        ];

        $descriptions = json_encode( [
            'flavor_text_entries' => [
                [
                    'flavor_text' => 'pokemon description',
                    'language' => [
                        'name' => 'en'
                    ],
                    'version' => [
                        'name' => 'ruby'
                    ]
                ],
                [
                    'flavor_text' => 'pokemon desçription',
                    'language' => [
                        'name' => 'fr'
                    ],
                    'version' => [
                        'name' => 'ruby'
                    ]
                ]
            ]
        ]);

        $client = $this->createMock(ClientInterface::class);
        $client->method('request')
            ->withAnyParameters()
            ->willReturn(new Response(200, [], $descriptions));

        $this->expectException(NotFoundHttpException::class);

        $sut = new Pokeapi($client);

        $description = $sut->getPokemonDescription("name", $filters);

        $this->assertEquals('pokemon description', $description);
    }

    public function test_getPokemonDescription_with_invalid_version_should_throw_NotFoundHttpException(): void
    {
        $filters = [
            'language' => 'en',
            'version' => 'invalid'
        ];

        $descriptions = json_encode( [
            'flavor_text_entries' => [
                [
                    'flavor_text' => 'pokemon description',
                    'language' => [
                        'name' => 'en'
                    ],
                    'version' => [
                        'name' => 'ruby'
                    ]
                ],
                [
                    'flavor_text' => 'pokemon desçription',
                    'language' => [
                        'name' => 'fr'
                    ],
                    'version' => [
                        'name' => 'ruby'
                    ]
                ]
            ]
        ]);

        $client = $this->createMock(ClientInterface::class);
        $client->method('request')
            ->withAnyParameters()
            ->willReturn(new Response(200, [], $descriptions));

        $this->expectException(NotFoundHttpException::class);

        $sut = new Pokeapi($client);

        $description = $sut->getPokemonDescription("name", $filters);

        $this->assertEquals('pokemon description', $description);
    }

    public function test_getPokemonDescription_with_invalid_version_and_invalid_language_should_throw_NotFoundHttpException(): void
    {
        $filters = [
            'language' => 'invalid',
            'version' => 'invalid'
        ];

        $descriptions = json_encode( [
            'flavor_text_entries' => [
                [
                    'flavor_text' => 'pokemon description',
                    'language' => [
                        'name' => 'en'
                    ],
                    'version' => [
                        'name' => 'ruby'
                    ]
                ],
                [
                    'flavor_text' => 'pokemon desçription',
                    'language' => [
                        'name' => 'fr'
                    ],
                    'version' => [
                        'name' => 'ruby'
                    ]
                ]
            ]
        ]);

        $client = $this->createMock(ClientInterface::class);
        $client->method('request')
            ->withAnyParameters()
            ->willReturn(new Response(200, [], $descriptions));

        $this->expectException(NotFoundHttpException::class);

        $sut = new Pokeapi($client);

        $description = $sut->getPokemonDescription("name", $filters);

        $this->assertEquals('pokemon description', $description);
    }

}
