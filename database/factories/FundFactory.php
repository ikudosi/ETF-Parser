<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Fund;
use Faker\Generator as Faker;

$factory->define(Fund::class, function (Faker $faker) {
    return [
        'symbol' => \Illuminate\Support\Str::random(4),
        'description' => $faker->sentence,
        'url' => $faker->url
    ];
});

$factory->afterCreating(Fund::class, function (Fund $fund, $faker) {
    factory(\App\Models\Holdings::class)->create([
        'fund_id' => $fund->id
    ]);
    factory(\App\Models\FundIndexSector::class)->create([
        'fund_id' => $fund->id
    ]);
    factory(\App\Models\FundGeographicalBreakdown::class)->create([
        'fund_id' => $fund->id
    ]);
});
