<?php

namespace App\Services;

use App\Contracts\IParser;
use App\Jobs\ParseSpecificFund;
use App\Models\Fund;

/**
 * Class ETFParser
 * @package App\Services
 */
class ETFParser
{
    /**
     * @param  IParser  $repository
     */
    public function handle(IParser $repository)
    {
        // First let's get all necessary data
        $data = $repository->getAllETFs();

        // Iterate and dispatch
        foreach ($data as $fund) {
            $fundModel = Fund::firstOrCreate(['symbol' => $fund['symbol'], 'url' => $fund['target_url']]);

            dispatch(new ParseSpecificFund($repository, $fundModel, $fund['target_url']));
        }
    }
}
