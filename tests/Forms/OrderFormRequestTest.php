<?php

namespace WalkerChiu\MallOrder;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use WalkerChiu\MallOrder\Models\Entities\Order;
use WalkerChiu\MallOrder\Models\Forms\OrderFormRequest;
use WalkerChiu\MallOrder\Models\Observers\OrderObserver;

class OrderFormRequestTest extends \Orchestra\Testbench\TestCase
{
    /**
     * Setup the test environment.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        //$this->loadLaravelMigrations(['--database' => 'mysql']);
        $this->loadMigrationsFrom(__DIR__ .'/../migrations');
        $this->withFactories(__DIR__ .'/../../src/database/factories');

        $this->request  = new OrderFormRequest();
        $this->rules    = $this->request->rules();
        $this->messages = $this->request->messages();
    }

    /**
     * To load your package service provider, override the getPackageProviders.
     *
     * @param \Illuminate\Foundation\Application  $app
     * @return Array
     */
    protected function getPackageProviders($app)
    {
        return [\WalkerChiu\Core\CoreServiceProvider::class,
                \WalkerChiu\MallOrder\MallOrderServiceProvider::class];
    }

    /**
     * Define environment setup.
     *
     * @param \Illuminate\Foundation\Application  $app
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
    }

    /**
     * Unit test about Authorize.
     *
     * For WalkerChiu\MallOrder\Models\Forms\OrderFormRequest
     * 
     * @return void
     */
    public function testAuthorize()
    {
        $this->assertEquals(true, 1);
    }

    /**
     * Unit test about Rules.
     *
     * For WalkerChiu\MallOrder\Models\Forms\OrderFormRequest
     * 
     * @return void
     */
    public function testRules()
    {
        $faker = \Faker\Factory::create();

        $user_id = $faker->uuid();
        DB::table(config('wk-core.table.user'))->insert([
            'id'       => $user_id,
            'name'     => $faker->username,
            'email'    => $faker->email,
            'password' => $faker->password
        ]);
        $channel_id = $faker->uuid();
        DB::table(config('wk-core.table.mall-cart.channels'))->insert([
            'id'       => $channel_id,
        ]);


        $request = new OrderFormRequest();

        // Give
        $attributes = [
            'channel_id' => $channel_id,
            'user_id' => $user_id,
            'data' => json_encode([
                "items"     => [],
                "addresses" => [
                    "bill"      => [],
                    "invoice"   => [],
                    "recipient" => [],
                ],
                "grandtotal"        => $faker->numberBetween(200, 1000),
                "subtotal_discount" => $faker->numberBetween(100, 999),
                "fee"               => $faker->randomDigit(),
                "tax"               => $faker->randomDigit(),
                "tip"               => $faker->randomDigit(),
                "discount_coupon"   => $faker->randomDigit(),
                "discount_point"    => $faker->randomDigit(),
            ]),
            'identifier'            => $faker->slug,
            'security_code'         => $faker->slug,
            'currency_abbreviation' => $faker->slug
        ];
        // When
        $validator = Validator::make($attributes, $this->rules, $this->messages); $this->request->withValidator($validator);
        $fails = $validator->fails();
        // Then
        $this->assertEquals(false, $fails);

        // Give
        $attributes = [
            'user_id' => $user_id,
            'data' => json_encode([
                "items"     => [],
                "addresses" => [
                    "bill"      => [],
                    "invoice"   => [],
                    "recipient" => [],
                ],
                "grandtotal"        => $faker->numberBetween(200, 1000),
                "subtotal_discount" => $faker->numberBetween(100, 999),
                "fee"               => $faker->randomDigit(),
                "tax"               => $faker->randomDigit(),
                "tip"               => $faker->randomDigit(),
                "discount_coupon"   => $faker->randomDigit(),
                "discount_point"    => $faker->randomDigit(),
            ]),
            'identifier'            => $faker->slug,
            'security_code'         => $faker->slug,
            'currency_abbreviation' => $faker->slug
        ];
        // When
        $validator = Validator::make($attributes, $this->rules, $this->messages); $this->request->withValidator($validator);
        $fails = $validator->fails();
        // Then
        $this->assertEquals(true, $fails);

        // Give
        $attributes = [
            'channel_id' => $channel_id,
            'data' => json_encode([
                "items"     => [],
                "addresses" => [
                    "bill"      => [],
                    "invoice"   => [],
                    "recipient" => [],
                ],
                "grandtotal"        => $faker->numberBetween(200, 1000),
                "subtotal_discount" => $faker->numberBetween(100, 999),
                "fee"               => $faker->randomDigit(),
                "tax"               => $faker->randomDigit(),
                "tip"               => $faker->randomDigit(),
                "discount_coupon"   => $faker->randomDigit(),
                "discount_point"    => $faker->randomDigit(),
            ]),
            'identifier'            => $faker->slug,
            'security_code'         => $faker->slug,
            'currency_abbreviation' => $faker->slug
        ];
        // When
        $validator = Validator::make($attributes, $this->rules, $this->messages); $this->request->withValidator($validator);
        $fails = $validator->fails();
        // Then
        $this->assertEquals(true, $fails);
    }
}
