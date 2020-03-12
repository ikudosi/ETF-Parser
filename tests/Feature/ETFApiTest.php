<?php

namespace Tests\Feature;

use App\Models\Fund;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class ETFApiTest extends TestCase
{
    public function test_all_symbols_api_is_not_public()
    {
        // Act
        $response = $this->json('get', route('api.etfs.symbols'));

        // Assert
        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    public function test_show_etf_data_api_is_not_public()
    {
        // Prep
        $fund = factory(Fund::class)->create();

        // Act
        $response = $this->json('get', route('api.etfs.show', ['symbol' => $fund->symbol]));

        // Assert
        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    public function test_etf_api_list_is_not_public()
    {
        // Act
        $response = $this->json('get', route('api.etfs.index'));

        // Assert
        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    /**
     * @throws \Exception
     */
    public function test_it_returns_etf_symbols()
    {
        // Prep
        $this->withoutMiddleware();
        $amount = random_int(10,30);
        factory(Fund::class, $amount)->create();

        // Assert
        $response = $this->json('get', route('api.etfs.symbols'));
        $response->assertStatus(200);
        $response->assertJsonCount($amount,'data');
    }

    public function test_it_shows_etf_data()
    {
        // Prep
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
