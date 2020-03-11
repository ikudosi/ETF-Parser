<?php

namespace App\Jobs;

use App\Interfaces\IParser;
use App\Models\Fund;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use PHPHtmlParser\Dom;

class ParseSpecificFund implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $target_url;
    public $repository;
    public $fund;

    /**
     * ParseSpecificFund constructor.
     * @param  IParser  $repository
     * @param  Fund  $fund
     * @param $target_url
     */
    public function __construct(IParser $repository, Fund $fund, $target_url)
    {
        $this->repository = $repository;
        $this->target_url = $target_url;
        $this->fund = $fund;
    }

    /**
     * @throws \PHPHtmlParser\Exceptions\ChildNotFoundException
     * @throws \PHPHtmlParser\Exceptions\CircularException
     * @throws \PHPHtmlParser\Exceptions\CurlException
     * @throws \PHPHtmlParser\Exceptions\StrictException
     */
    public function handle()
    {
        $dom = new Dom;
        $dom->loadFromUrl($this->target_url);

        // Top 10 Holdings
        $this->repository->parseTop10Holdings($dom, $this->fund);
    }
}
