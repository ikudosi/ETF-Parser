<?php

namespace App\Repositories;

use App\Interfaces\IParser;
use App\Models\Fund;
use App\Models\Holdings;
use GuzzleHttp\Client;
use PHPHtmlParser\Dom;

class SSGA implements IParser
{
    public function baseUrl()
    {
        return 'https://www.ssga.com';
    }

    /**
     * @return array
     */
    public function getAllETFs(): array
    {
        $data =  json_decode((new Client)->request('GET', "{$this->baseUrl()}/bin/v1/ssmp/fund/fundfinder", [
            'query' => [
                'country' => 'us',
                'language' => 'en',
                'role' => 'individual',
                'product' => 'etfs',
                'ui' => 'fund-finder'
            ]
        ])->getBody(), true);

        // Iterate through the data and filter out only Equity Assets
        $targetFundKeys = explode('|', $data['data']['us']['funds']['etfs']['categories']['0']['subCategories']['1']['funds']);
        $targetFunds = [];

        foreach ($data['data']['us']['funds']['etfs']['documents']['datas'] as $data) {
            if (!in_array($data['fundTicker'], $targetFundKeys)) {
                continue;
            }
            $targetFunds[] = [
                'name' => $data['fundTicker'],
                'target_url' => "{$this->baseUrl()}/{$data['fundUri']}"
            ];
        }

        return $targetFunds;
    }

    public function parseTop10Holdings(Dom $dom, Fund $fund)
    {
        $fund->holdings()->delete();

        $dom->find('.fund-top-holdings > table > tbody > tr')->each(function ($tableRow) use ($fund) {
            $cells = $tableRow->find('td');

            $fund->holdings()->create([
                'name' => $cells[0]->innerHtml(),
                'shares_held' => str_replace(',','',$cells[1]->innerHtml()),
                'weight' => str_replace('%','',$cells[2]->innerHtml())
            ]);
        });
    }
}
