<?php

namespace App\Translators\Contracts;

interface TranslatorInterface {

    public function translate(string $text): string;

}
