<?php

namespace WalkerChiu\MallOrder;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use WalkerChiu\MallOrder\Models\Entities\Order;
use WalkerChiu\MallOrder\Models\Observers\OrderObserver;

class OrderTest extends \Orchestra\Testbench\TestCase
{
    use RefreshDatabase;

    /**
     * Setup the test environment.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->loadMigrationsFrom(__DIR__ .'/../migrations');
        $this->withFactories(__DIR__ .'/../../src/database/factories');
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
     * A basic functional test on Order.
     *
     * For WalkerChiu\MallOrder\Models\Entities\Order
     * 
     * @return void
     */
    public function testOrder()
    {
        // Config
        Config::set('wk-core.onoff.core-lang_core', 0);
        Config::set('wk-mall-order.onoff.core-lang_core', 0);
        Config::set('wk-core.lang_log', 1);
        Config::set('wk-mall-order.lang_log', 1);
        Config::set('wk-core.soft_delete', 1);
        Config::set('wk-mall-order.soft_delete', 1);

        $faker = \Faker\Factory::create();

        DB::table(config('wk-core.table.user'))->insert([
            'name'     => $faker->username,
            'email'    => $faker->email,
            'password' => $faker->password
        ]);
        DB::table(config('wk-core.table.mall-shelf.stocks'))->insert([
            'quantity' => 10
        ]);

        // Give
        $db_morph_1 = factory(Order::class)->create();
        $db_morph_2 = factory(Order::class)->create();
        $db_morph_3 = factory(Order::class)->create();

        // Get records after creation
            // When
            $records = Order::all();
            // Then
            $this->assertCount(3, $records);

        // Delete someone
            // When
            $db_morph_2->delete();
            $records = Order::all();
            // Then
            $this->assertCount(2, $records);

        // Resotre someone
            // When
            Order::withTrashed()
                   ->find($db_morph_2->id)
                   ->restore();
            $record_2 = Order::find($db_morph_2->id);
            $records = Order::all();
            // Then
            $this->assertNotNull($record_2);
            $this->assertCount(3, $records);
    }
}
