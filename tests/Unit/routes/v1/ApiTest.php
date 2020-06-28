<?php

namespace Test\Unit\routes\v1;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Test\TestCase;

class ApiTest extends TestCase {

    public function test_pokemon_route_with_a_numeric_param_should_return_not_found_message()
    {
        $response = $this->call('GET', 'pokemon/1');
        $response->assertJson([
            'message' => 'Not Found',
            'code' => 404,
        ]);
    }

    public function test_pokemon_route_with_a_numeric_param_should_return_404_status_code()
    {
        $response = $this->call('GET', 'pokemon/1');
        $response->json();
        $response->assertStatus(404);
    }

    public function test_pokemon_route_with_charizard_name_should_return_the_expected_result()
    {
        $response = $this->call('GET', 'pokemon/charizard');
        $response->assertJson([
            'name' => 'charizard',
            'description' => "Charizard flies 'round the sky in search of powerful opponents. 't breathes fire of such most wondrous heat yond 't melts aught. However,  't nev'r turns its fiery breath on any opponent weaker than itself.",
        ]);
    }

    public function test_pokemon_route_with_charizard_name_should_return_200_status_code()
    {
        $response = $this->call('GET', 'pokemon/charizard');
        $response->assertJson([
            'name' => 'charizard',
            'description' => "Charizard flies 'round the sky in search of powerful opponents. 't breathes fire of such most wondrous heat yond 't melts aught. However,  't nev'r turns its fiery breath on any opponent weaker than itself.",
        ]);

        $this->assertResponseOk();
    }
}
