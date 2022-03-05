<?php

/** @var \Illuminate\Database\Eloquent\Factory  $factory */

use Faker\Generator as Faker;
use WalkerChiu\MallOrder\Models\Constants\OrderState;
use WalkerChiu\MallOrder\Models\Entities\Review;

$factory->define(Review::class, function (Faker $faker) {
    return [
        'order_id' => 1,
        'state'    => $faker->randomElement(OrderState::getCodes())
    ];
});
