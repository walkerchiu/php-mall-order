<?php

namespace WalkerChiu\MallOrder\Models\Observers;

class OrderObserver
{
    /**
     * Handle the model "retrieved" event.
     *
     * @param Model  $model
     * @return void
     */
    public function retrieved($model)
    {
        //
    }

    /**
     * Handle the model "creating" event.
     *
     * @param Model  $model
     * @return void
     */
    public function creating($model)
    {
        $model->identifier = date('YmdHis').substr(explode('.', explode(" ", microtime())[0])[1], 0, 6);
    }

    /**
     * Handle the model "created" event.
     *
     * @param Model  $model
     * @return void
     */
    public function created($model)
    {
        if (in_array('A', config('wk-mall-order.state_supported'))) {
            config('wk-core.class.mall-order.review')::create([
                'order_id' => $model->id,
                'state'    => 'A'
            ]);
        }
    }

    /**
     * Handle the model "updating" event.
     *
     * @param Model  $model
     * @return void
     */
    public function updating($model)
    {
        //
    }

    /**
     * Handle the model "updated" event.
     *
     * @param Model  $model
     * @return void
     */
    public function updated($model)
    {
        //
    }

    /**
     * Handle the model "saving" event.
     *
     * @param Model  $model
     * @return void
     */
    public function saving($model)
    {
        if (
            config('wk-core.class.mall-order.order')
                ::where('id', '<>', $model->id)
                ->where('identifier', $model->identifier)
                ->exists()
        )
            return false;
    }

    /**
     * Handle the model "saved" event.
     *
     * @param Model  $model
     * @return void
     */
    public function saved($model)
    {
        //
    }

    /**
     * Handle the model "deleting" event.
     *
     * @param Model  $model
     * @return void
     */
    public function deleting($model)
    {
        //
    }

    /**
     * Handle the model "deleted" event.
     *
     * @param Model  $model
     * @return void
     */
    public function deleted($model)
    {
        if (!config('wk-mall-order.soft_delete')) {
            $model->forceDelete();
        }

        if ($model->isForceDeleting()) {
        }
    }

    /**
     * Handle the model "restoring" event.
     *
     * @param Model  $model
     * @return void
     */
    public function restoring($model)
    {
        if (
            config('wk-core.class.mall-order.order')
                ::where('id', '<>', $model->id)
                ->where('identifier', $model->identifier)
                ->exists()
        )
            return false;
    }

    /**
     * Handle the model "restored" event.
     *
     * @param Model  $model
     * @return void
     */
    public function restored($model)
    {
        //
    }
}
