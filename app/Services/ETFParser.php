<?php

namespace App\Services;

use App\Interfaces\IParser;
use App\Jobs\ParseSpecificFund;
use App\Models\Fund;

class ETFParser
{
    private $repository;

    public function handle(IParser $repository)
    {
        // First let's get all necessary data
        $data = $repository->getAllETFs();

        // Iterate and dispatch
        foreach ($data as $fund) {
            $fundModel = Fund::firstOrCreate(['name' => $fund['name'], 'url' => $fund['target_url']]);

            dispatch(new ParseSpecificFund($repository, $fundModel, $fund['target_url']));
        }
    }
}
