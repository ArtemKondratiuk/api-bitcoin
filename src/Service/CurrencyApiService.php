<?php

declare(strict_types=1);

namespace App\Service;

final class CurrencyApiService
{
    public const API_URL = 'https://blockchain.info/ticker';

    public function getCurrencies()
    {
        $json = file_get_contents(self::API_URL);

        return json_decode($json, true);
    }
}
