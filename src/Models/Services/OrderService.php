<?php

namespace WalkerChiu\MallOrder\Models\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use WalkerChiu\Core\Models\Exceptions\NotExpectedEntityException;
use WalkerChiu\Core\Models\Exceptions\NotFoundEntityException;
use WalkerChiu\Core\Models\Services\CheckExistTrait;

class OrderService
{
    use CheckExistTrait;

    protected $repository;



    /**
     * Create a new service instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->repository = App::make(config('wk-core.class.mall-order.orderRepository'));
    }

    /*
    |--------------------------------------------------------------------------
    | Get Order
    |--------------------------------------------------------------------------
    */

    /**
     * @param String  $order_id
     * @return Order
     *
     * @throws NotFoundEntityException
     */
    public function find(string $order_id)
    {
        $entity = $this->repository->find($order_id);

        if (empty($entity))
            throw new NotFoundEntityException($entity);

        return $entity;
    }

    /**
     * @param Order|String  $source
     * @return Order
     *
     * @throws NotExpectedEntityException
     */
    public function findBySource($source)
    {
        if (is_string($source))
            $entity = $this->find($source);
        elseif (is_a($source, config('wk-core.class.mall-order.order')))
            $entity = $source;
        else
            throw new NotExpectedEntityException($source);

        return $entity;
    }



    /*
    |--------------------------------------------------------------------------
    | Operation
    |--------------------------------------------------------------------------
    */

    /**
     * @param String  $data
     * @param String  $security_code
     * @return Bool
     */
    public function verify(string $data, string $security_code): bool
    {
        return Hash::check($data, $security_code);
    }

    /**
     * @param Int     $length
     * @param String  $prefix
     * @param String  $suffix
     * @return String
     */
    public function createOrderNumber(?int $length, $prefix = '', $suffix = ''): string
    {
        if (is_null($length))
            $identifier = Carbon::now()->timestamp;
        else
            $identifier = substr(Carbon::now()->timestamp, 0, $length);

        do {
            $result = config('wk-core.class.mall-order.order')
                ::where('identifier', $identifier)
                ->exists();
            if (!$result)
                break;

            if (is_null($length))
                $identifier = Carbon::now()->timestamp;
            else
                $identifier = substr(Carbon::now()->timestamp, 0, $length);
        } while (true);

        return $prefix.$identifier.$suffix;
    }

    /**
     * @param String  $host_type
     * @param String  $host_id
     * @param String  $user_id
     * @param Mixed   $note
     * @param String  $data
     * @param String  $security_code
     * @param String  $state
     * @param String  $state_note
     * @param Int     $length
     * @param String  $prefix
     * @param String  $suffix
     * @return Order
     */
    public function order(string $host_type, string $host_id, ?string $user_id, ?string $note, string $data, string $security_code, string $state, ?string $state_note, ?int $length, $prefix = '', $suffix = '')
    {
        DB::beginTransaction();
            try {
                $identifier = $this->createOrderNumber($length, $prefix, $suffix);
                $order = $this->repository->order($host_type, $host_id, $identifier, $user_id, $note, $data, $security_code);
                $review = $this->repository->createReview($order->id, $order->user_id, $state, $state_note);

                if (config('wk-mall-order.onoff.mall-shelf')) {
                    $items = current($order->data['items']);
                    foreach ($items as $item) {
                        $stock_id = $item['stock']['id'];
                        $nums     = $item['nums'];

                        $stock = config('wk-core.class.mall-shelf.stock')::find($stock_id);
                        if (!is_null($stock->quantity)) {
                            $stock->quantity -= $nums;
                            $stock->save();
                        }
                    }
                }
                DB::commit();
            } catch (\Exception $e) {
                if (!app()->environment('production')) dd($e);
                DB::rollback();
            }

        return $order;
    }
}
