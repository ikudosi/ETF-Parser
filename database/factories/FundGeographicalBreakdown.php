<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\FundGeographicalBreakdown;
use Faker\Generator as Faker;

$factory->define(FundGeographicalBreakdown::class, function (Faker $faker) {
    return [
        'fund_id' => function () {
            return factory(\App\Models\Fund::class)->create()->id;
        },
        'country_name' => function () use ($faker) {
            return $faker->country;
        },
        'weight' => function () {
            return random_int(1,100);
        }
    ];
});
