<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Fund;
use Illuminate\Http\Request;

class ETFController extends Controller
{
    private $api_limit = 100;

    /**
     * @param  Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $data = Fund::query();

        $data = $this->filterDataLayer($data, $request);

        return response()->json([
            'data' => $data->get()
        ]);
    }

    /**
     * @param $symbol
     * @param  Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($symbol, Request $request)
    {
        $data = Fund::bySymbol($symbol);

        $data = $this->filterDataLayer($data, $request);

        return response()->json([
            'data' => $data->firstOrFail()
        ]);
    }

    /**
     * @param  Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function listAllSymbols(Request $request)
    {
        return response()->json([
            'data' => Fund::pluck('symbol')
        ]);
    }

    /**
     * @param $dataLayer
     * @param  Request  $request
     * @return mixed
     */
    public function filterDataLayer($dataLayer, Request $request)
    {
        $dataLayer->select( $request->input('fields', '*') );

        $dataLayer->limit($request->input('limit', $this->api_limit));

        if ($relations = $request->input('relations') ) {
            if (is_string($relations)) {
                $relations = explode(',', $relations);
            }
            $dataLayer->with($relations);
        }

        return $dataLayer;
    }
}
