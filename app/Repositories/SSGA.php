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

    /**
     * @param  Dom  $dom
     * @param  Fund  $fund
     * @throws \PHPHtmlParser\Exceptions\ChildNotFoundException
     * @throws \PHPHtmlParser\Exceptions\NotLoadedException
     */
    public function parseTop10Holdings(Dom $dom, Fund $fund)
    {
        $fund->holdings()->delete();

        $dom->find('.fund-top-holdings table > tbody > tr')->each(function ($tableRow) use ($fund) {
            $label = $tableRow->find('td.label')[0]->innerHtml();
            $weight = str_replace('%','',$tableRow->find('td.weight')[0]->innerHtml());
            $data = str_replace(',','',$tableRow->find('td[data-label="Shares Held:"]')[0]->innerHtml());

            $fund->holdings()->create([
                'name' => $label,
                'shares_held' => $data,
                'weight' => $weight
            ]);
        });
    }

    /**
     * @param  Dom  $dom
     * @param  Fund  $fund
     * @throws \PHPHtmlParser\Exceptions\ChildNotFoundException
     * @throws \PHPHtmlParser\Exceptions\NotLoadedException
     */
    public function parseSectors(Dom $dom, Fund $fund)
    {
        $fund->indexSectors()->delete();

        $dom->find('.index-sector-breakdown table > tbody > tr')->each(function ($tableRow) use ($fund) {
            $label = $tableRow->find('td.label')[0]->innerHtml();
            $data = str_replace('%','',$tableRow->find('td.data')[0]->innerHtml());

            $fund->indexSectors()->create([
                'name' => $label,
                'weight' => $data
            ]);
        });
    }

    /**
     * @param  Dom  $dom
     * @param  Fund  $fund
     * @throws \PHPHtmlParser\Exceptions\ChildNotFoundException
     * @throws \PHPHtmlParser\Exceptions\NotLoadedException
     */
    public function parseGeographyBreakdown(Dom $dom, Fund $fund)
    {
        $fund->geographyBreakdown()->delete();

        $input = $dom->find('#fund-geographical-breakdown')[0];

        if (!$input) {
            return;
        }

        $data = json_decode(str_replace('&#34;', '"', $input->getAttribute('value')), true);

        collect($data['attrArray'])->each(function ($tableRow) use ($fund) {
            $label = $tableRow['name']['value'];
            $data =  str_replace('%','',$tableRow['weight']['value']);

            $fund->geographyBreakdown()->create([
                'country_name' => $label,
                'weight' => $data
            ]);
        });
    }
}
