<?php

namespace Tests\Feature;

use App\Models\Fund;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ETFApiTest extends TestCase
{
    /**
     * @throws \Exception
     */
    public function test_it_returns_etf_symbols()
    {
        $this->withoutMiddleware();

        $amount = random_int(10,30);

        // Act
        $response = $this->json('get', route('api.etfs.symbols'));
        $response->assertJsonCount(0, 'data');

        factory(Fund::class, $amount)->create();

        // Assert
        $response = $this->json('get', route('api.etfs.symbols'));
        $response->assertStatus(200);
        $response->assertJsonCount($amount,'data');
    }

    public function test_it_shows_etf_data()
    {
        $this->withoutMiddleware();
        $fund = factory(Fund::class)->create();

        // Act
        $response = $this->json('get', route('api.etfs.show', ['symbol' => $fund->symbol]));

        // Assert
        $response->assertStatus(200);
        $this->assertTrue($fund->symbol === $response->json('data.symbol'));
        $response->assertJsonStructure([
            'data' => [
                'holdings', 'indexSectors', 'geographyBreakdown'
            ]
        ]);
    }
}
