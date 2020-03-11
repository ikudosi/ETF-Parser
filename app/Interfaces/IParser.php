<?php

namespace App\Interfaces;

use App\Models\Fund;
use PHPHtmlParser\Dom;

interface IParser
{
    public function baseUrl();

    public function getAllETFs();

    public function parseTop10Holdings(Dom $dom,Fund $fund);

    public function parseSectors(Dom $dom, Fund $fund);

    public function parseGeographyBreakdown(Dom $dom, Fund $fund);
}
