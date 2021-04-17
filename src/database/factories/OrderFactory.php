<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use WalkerChiu\MallOrder\Models\Entities\Order;

$factory->define(Order::class, function (Faker $faker) {
    return [
        'host_type'  => 'WalkerChiu\Site\Models\Entities\Site',
        'host_id'    => 1,
        'user_id'    => 1,
        'identifier' => $faker->slug
    ];
});
