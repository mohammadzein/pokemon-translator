<?php

namespace Test\Unit\app\Translator;

use App\Translators\Shakespeare;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Psr7\Response;
use Test\TestCase;

class ShakespeareTest extends TestCase
{
    public function test_translate_with_text_should_return_translated_text()
    {
        $response = json_encode([
            'success' => [
                'total' => 1
            ],
            "contents" => [
                "translated" => "To beest trnanslated",
                "text" => "to be trnanslated",
                "translation" => "shakespeare"
            ]
        ]);

        $client = $this->createMock(ClientInterface::class);
        $client->method('request')
            ->withAnyParameters()
            ->willReturn(new Response(200, [], $response));

        $sut = new Shakespeare($client);

        $description = $sut->translate("to be trnanslated");

        $this->assertEquals(
            'To beest trnanslated',
            $description
        );
    }

}
