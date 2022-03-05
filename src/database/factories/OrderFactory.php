<?php

/** @var \Illuminate\Database\Eloquent\Factory  $factory */

use Faker\Generator as Faker;
use WalkerChiu\MallOrder\Models\Entities\Order;

$factory->define(Order::class, function (Faker $faker) {
    return [
        'identifier' => $faker->slug,
        'data'       => [
            "items"     => [],
            "addresses" => [
                "bill"      => [],
                "invoice"   => [],
                "recipient" => [],
            ],
            "grandtotal"        => $faker->numberBetween(200, 1000),
            "subtotal_discount" => $faker->numberBetween(100, 999),
            "fee"               => $faker->randomDigit(),
            "fax"               => $faker->randomDigit(),
            "tip"               => $faker->randomDigit(),
            "discount_coupon"   => $faker->randomDigit(),
            "discount_point"    => $faker->randomDigit(),
        ],
        'security_code' => $faker->slug,
    ];
});
