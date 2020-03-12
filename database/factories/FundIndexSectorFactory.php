<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\FundIndexSector;
use Faker\Generator as Faker;

$factory->define(FundIndexSector::class, function (Faker $faker) {
    return [
        'fund_id' => function () {
            return factory(\App\Models\Fund::class)->create()->id;
        },
        'name' => function () {
            return \Illuminate\Support\Str::random(10);
        },
        'weight' => function () {
            return random_int(1,100);
        }
    ];
});
