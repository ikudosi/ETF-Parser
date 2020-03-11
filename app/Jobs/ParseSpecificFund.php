<?php

namespace App\Jobs;

use App\Contracts\IParser;
use App\Models\Fund;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Mockery\Exception;
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

        // Get description
        try {
            $this->repository->parseDescription($dom, $this->fund);
        }  catch (Exception $exception) {
            Log::error($exception);
        }

        // Top 10 Holdings
        try {
            $this->repository->parseTop10Holdings($dom, $this->fund);
        } catch (Exception $exception) {
            Log::error($exception);
        }

        // Sector Breakdown
        try {
            $this->repository->parseSectors($dom, $this->fund);
        } catch (Exception $exception) {
            Log::error($exception);
        }

        // Geography Breakdown
        try {
            $this->repository->parseGeographyBreakdown($dom, $this->fund);
        } catch (Exception $exception) {
            Log::error($exception);
        }
    }
}
