<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Holdings;
use Faker\Generator as Faker;

$factory->define(Holdings::class, function (Faker $faker) {
    return [
        'fund_id' => function () {
            return factory(\App\Models\Fund::class)->create()->id;
        },
        'name' => function () use ($faker) {
            return \Illuminate\Support\Str::random(10);
        },
        'shares_held' => function () {
            return random_int(1000,10000);
        },
        'weight' => function () {
            return random_int(1,100);
        }
    ];
});
