<?php

namespace WalkerChiu\MallOrder\Models\Observers;

class OrderObserver
{
    /**
     * Handle the entity "retrieved" event.
     *
     * @param  $entity
     * @return void
     */
    public function retrieved($entity)
    {
        //
    }

    /**
     * Handle the entity "creating" event.
     *
     * @param  $entity
     * @return void
     */
    public function creating($entity)
    {
        $entity->identifier = date('YmdHis').substr(explode('.', explode(" ", microtime())[0])[1], 0, 6);
    }

    /**
     * Handle the entity "created" event.
     *
     * @param  $entity
     * @return void
     */
    public function created($entity)
    {
        if (in_array('A', config('wk-mall-order.state_supported'))) {
            config('wk-core.class.mall-order.review')::create([
                'order_id' => $entity->id,
                'state'    => 'A'
            ]);
        }
    }

    /**
     * Handle the entity "updating" event.
     *
     * @param  $entity
     * @return void
     */
    public function updating($entity)
    {
        //
    }

    /**
     * Handle the entity "updated" event.
     *
     * @param  $entity
     * @return void
     */
    public function updated($entity)
    {
        //
    }

    /**
     * Handle the entity "saving" event.
     *
     * @param  $entity
     * @return void
     */
    public function saving($entity)
    {
        if (config('wk-core.class.mall-order.order')::where('id', '<>', $entity->id)
                                                    ->where('identifier', $entity->identifier)
                                                    ->exists())
            return false;
    }

    /**
     * Handle the entity "saved" event.
     *
     * @param  $entity
     * @return void
     */
    public function saved($entity)
    {
        //
    }

    /**
     * Handle the entity "deleting" event.
     *
     * @param  $entity
     * @return void
     */
    public function deleting($entity)
    {
        //
    }

    /**
     * Handle the entity "deleted" event.
     *
     * @param  $entity
     * @return void
     */
    public function deleted($entity)
    {
        if ($entity->isForceDeleting()) {
        }
    }

    /**
     * Handle the entity "restoring" event.
     *
     * @param  $entity
     * @return void
     */
    public function restoring($entity)
    {
        if (config('wk-core.class.mall-order.order')::where('id', '<>', $entity->id)
                                                    ->where('identifier', $entity->identifier)
                                                    ->exists())
            return false;
    }

    /**
     * Handle the entity "restored" event.
     *
     * @param  $entity
     * @return void
     */
    public function restored($entity)
    {
        //
    }
}
