<?php

namespace WalkerChiu\MallOrder\Models\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use WalkerChiu\Core\Models\Entities\DateTrait;

class Review extends Model
{
    use DateTrait;
    use SoftDeletes;

    protected $fillable = [
        'order_id', 'user_id',
        'state', 'state_note',
        'is_current'
    ];

    protected $hidden = [
        'deleted_at'
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];
    protected $casts = [
        'is_current' => 'boolean'
    ];

    /**
     * @param array $attributes
     */
    public function __construct(array $attributes = array())
    {
        $this->table = config('wk-core.table.mall-order.reviews');

        parent::__construct($attributes);
    }

    public function stateText()
    {
        return trans('php-mall-order::state.'.$this->state).
               trans('php-core::punctuation.parentheses.BLR', ['value' => $this->state]);
    }

    /**
     * @param $query
     * @param Boolean $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOfCurrent($query)
    {
        return $query->where('is_current', 1);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function order()
    {
        return $this->belongsTo(config('wk-core.class.mall-order.order'), 'order_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(config('wk-core.class.user'), 'user_id', 'id');
    }
}
