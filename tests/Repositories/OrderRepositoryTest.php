<?php

namespace WalkerChiu\MallOrder;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use WalkerChiu\MallOrder\Models\Constants\OrderState;
use WalkerChiu\MallOrder\Models\Entities\Order;
use WalkerChiu\MallOrder\Models\Repositories\OrderRepository;
use WalkerChiu\MallOrder\Models\Observers\OrderObserver;

class OrderRepositoryTest extends \Orchestra\Testbench\TestCase
{
    use RefreshDatabase;

    protected $repository;

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

        $this->repository = $this->app->make(OrderRepository::class);
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
                \WalkerChiu\MallOrder\MallOrderServiceProvider::class,
                \WalkerChiu\MorphAddress\MorphAddressServiceProvider::class];
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
     * A basic functional test on OrderRepository.
     *
     * For WalkerChiu\Core\Models\Repositories\Repository
     *
     * @return void
     */
    public function testOrderRepository()
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

        // Give
        $faker = \Faker\Factory::create();

        $id_list = [];
        for ($i=1; $i<=3; $i++) {
            $record = $this->repository->save([
                'user_id'    => 1,
                'identifier' => $faker->slug,
                'state'      => $faker->randomElement(OrderState::getCodes())
            ]);
            array_push($id_list, $record->id);
        }

        // Get and Count records after creation
            // When
            $records = $this->repository->get();
            $count   = $this->repository->count();
            // Then
            $this->assertCount(3, $records);
            $this->assertEquals(3, $count);

        // Find someone
            // When
            $record = $this->repository->first();
            // Then
            $this->assertNotNull($record);

            // When
            $record = $this->repository->find($faker->uuid());
            // Then
            $this->assertNull($record);

        // Delete someone
            // When
            $this->repository->deleteByIds([$id_list[0]]);
            $count = $this->repository->count();
            // Then
            $this->assertEquals(2, $count);

            // When
            $this->repository->deleteByExceptIds([$id_list[2]]);
            $count = $this->repository->count();
            $record = $this->repository->find($id_list[2]);
            // Then
            $this->assertEquals(1, $count);
            $this->assertNotNull($record);

            // When
            $count = $this->repository->where('id', '>', 0)->count();
            // Then
            $this->assertEquals(1, $count);

            // When
            $count = $this->repository->whereWithTrashed('id', '>', 0)->count();
            // Then
            $this->assertEquals(3, $count);

            // When
            $count = $this->repository->whereOnlyTrashed('id', '>', 0)->count();
            // Then
            $this->assertEquals(2, $count);

        // Force delete someone
            // When
            $this->repository->forcedeleteByIds([$id_list[2]]);
            $records = $this->repository->get();
            // Then
            $this->assertCount(0, $records);

        // Restore records
            // When
            $this->repository->restoreByIds([$id_list[0], $id_list[1]]);
            $count = $this->repository->count();
            // Then
            $this->assertEquals(2, $count);
    }

    /**
     * Unit test about Query List on OrderRepository.
     *
     * For WalkerChiu\Core\Models\Repositories\RepositoryTrait
     *     WalkerChiu\MallOrder\Models\Repositories\OrderRepository
     *
     * @return void
     */
    public function testQueryList()
    {
        // Config
        Config::set('wk-core.onoff.core-lang_core', 0);
        Config::set('wk-mall-order.onoff.core-lang_core', 0);
        Config::set('wk-core.lang_log', 1);
        Config::set('wk-mall-order.lang_log', 1);
        Config::set('wk-core.soft_delete', 1);
        Config::set('wk-mall-order.soft_delete', 1);

        $faker = \Faker\Factory::create();

        // Give
        $db_morph_1 = factory(Order::class)->create();
        $db_morph_2 = factory(Order::class)->create();
        $db_morph_3 = factory(Order::class)->create();
        $db_morph_4 = factory(Order::class)->create();

        // Get query
            // When
            sleep(1);
            $this->repository->find($db_morph_3->id)->touch();
            $records = $this->repository->get()
                                        ->sortByDESC('updated_at');
            // Then
            $this->assertCount(4, $records);

            // When
            $record = $records->first();
            // Then
            $this->assertArrayNotHasKey('deleted_at', $record->toArray());
            $this->assertEquals($db_morph_3->id, $record->id);

        // Get query of trashed records
            // When
            $this->repository->deleteByIds([$db_morph_4->id]);
            $this->repository->deleteByIds([$db_morph_1->id]);
            $records = $this->repository->ofTrash(null, null)->get();
            // Then
            $this->assertCount(2, $records);

           // When
            $record = $records->first();
            // Then
            $this->assertArrayHasKey('deleted_at', $record);
            $this->assertEquals($db_morph_1->id, $record->id);
    }

    /**
     * Unit test about Show Order on OrderRepository.
     *
     * For WalkerChiu\Core\Models\Repositories\RepositoryTrait
     *     WalkerChiu\MallOrder\Models\Repositories\OrderRepository
     *
     * @return void
     */
    public function testShowOrder()
    {
        // Config
        Config::set('wk-core.onoff.core-lang_core', 0);
        Config::set('wk-mall-order.onoff.core-lang_core', 0);
        Config::set('wk-core.lang_log', 1);
        Config::set('wk-mall-order.lang_log', 1);
        Config::set('wk-core.soft_delete', 1);
        Config::set('wk-mall-order.soft_delete', 1);

        $faker = \Faker\Factory::create();

        // Give
        $db_order = factory(Order::class)->create();
        // When
        $order = $this->repository->showById($db_order->id, 'en_us');
        // Then
        $this->assertArrayHasKey('profile', $order);
        $this->assertArrayHasKey('addresses', $order);
        $this->assertArrayHasKey('items', $order);

        $this->assertCount(3, $order['addresses']);
        $this->assertArrayHasKey('recipient', $order['addresses']);
        $this->assertArrayHasKey('bill', $order['addresses']);
        $this->assertArrayHasKey('invoice', $order['addresses']);
    }
}
