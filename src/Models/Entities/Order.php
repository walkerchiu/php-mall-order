<?php

namespace WalkerChiu\MallOrder\Models\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use WalkerChiu\Core\Models\Entities\DateTrait;
use WalkerChiu\MallOrder\Models\Constants\OrderState;

class Order extends Model
{
    use DateTrait;
    use SoftDeletes;

    protected $fillable = [
        'host_type', 'host_id',
        'user_id',
        'identifier',
        'note',
        'grandtotal',
        'subtotal', 'tip', 'fee', 'tax',
        'discount_coupon', 'discount_point', 'discount_shipment', 'discount_custom',
        'data', 'security_code'
    ];

    protected $casts = [
        'data' => 'json'
    ];

    protected $hidden = [
        'deleted_at'
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    /**
     * @param array $attributes
     */
    public function __construct(array $attributes = array())
    {
        $this->table = config('wk-core.table.mall-order.orders');

        parent::__construct($attributes);
    }

    public function stateText()
    {
        return trans('php-mall-order::state.'.$this->reviews->last()->state); 
    }

    public function stateDirections()
    {
        return config('wk-core.class.mall-order.orderState')::getDirections($this->reviews->last()->state);
    }

    /**
     * @param Boolean $customer
     */
    public function stateOptions($customer = false)
    {
        if ($customer)
            return config('wk-core.class.mall-order.orderState')::findOptionsForCustomer($this->reviews->last()->state);
        else
            return config('wk-core.class.mall-order.orderState')::findOptions($this->reviews->last()->state);
    }

    /**
     * Get the owning host model.
     */
    public function host()
    {
        return $this->morphTo();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(config('wk-core.class.user'), 'user_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function reviews()
    {
        return $this->hasMany(config('wk-core.class.mall-order.review'), 'order_id', 'id');
    }

    /**
     * Get all of the comments for the stock.
     *
     * @param Int $user_id
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function comments($user_id = null) {
        return $this->morphMany(config('wk-core.class.morph-comment.comment'), 'morph')
                    ->when($user_id, function ($query, $user_id) {
                                return $query->where('user_id', $user_id);
                            });
    }

    /**
     * @param $type
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function addresses($type = null) {
        return $this->morphMany(config('wk-core.class.morph-address.address'), 'morph')
                    ->when($type, function ($query, $type) {
                                return $query->where('type', $type);
                            });
    }
}
