<?php

namespace WalkerChiu\MallOrder\Models\Entities;

trait UserTrait
{
    /**
     * @param String $host_type
     * @param String $host_id
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orders($host_type = null, $host_id = null)
    {
        return $this->hasMany(config('wk-core.class.mall-order.order'), 'user_id', 'id')
                    ->when($host_type, function ($query, $host_type) {
                                return $query->where('host_type', $host_type);
                            })
                    ->when($host_id, function ($query, $host_id) {
                                return $query->where('host_id', $host_id);
                            });
    }
}
