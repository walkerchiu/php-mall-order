<?php

namespace WalkerChiu\MallOrder\Models\Repositories;

use Illuminate\Support\Facades\App;
use WalkerChiu\Core\Models\Exceptions\NotFoundEntityException;
use WalkerChiu\Core\Models\Constants\Language;
use WalkerChiu\Core\Models\Forms\FormHasHostTrait;
use WalkerChiu\Core\Models\Repositories\Repository;
use WalkerChiu\Core\Models\Repositories\RepositoryHasHostTrait;
use WalkerChiu\MorphComment\Models\Repositories\CommentRepositoryTrait;
use WalkerChiu\MorphImage\Models\Repositories\ImageRepositoryTrait;

class OrderRepository extends Repository
{
    use FormHasHostTrait;
    use RepositoryHasHostTrait;
    use CommentRepositoryTrait;
    use ImageRepositoryTrait;

    protected $entity;

    public function __construct()
    {
        $this->entity = App::make(config('wk-core.class.mall-order.order'));
    }

    /**
     * @param String  $host_type
     * @param Int     $host_id
     * @param String  $code
     * @param Array   $data
     * @param Int     $page
     * @param Int     $nums per page
     * @param String  $target
     * @param Boolean $target_is_enabled
     * @return Array
     */
    public function list($host_type, $host_id, String $code, Array $data, $page = null, $nums = null, $target = null, $target_is_enabled = null)
    {
        $this->assertForPagination($page, $nums);

        if (empty($host_type) || empty($host_id)) {
            $entity = $this->entity;
        } else {
            $entity = $this->baseQueryForRepository($host_type, $host_id, $target, $target_is_enabled);
        }
        $data = array_map('trim', $data);

        $records = $entity->with('reviews')
                          ->when($data, function ($query, $data) {
                                return $query->unless(empty($data['id']), function ($query) use ($data) {
                                            return $query->where('id', $data['id']);
                                        })
                                        ->unless(empty($data['site_id']), function ($query) use ($data) {
                                            return $query->where('site_id', $data['site_id']);
                                        })
                                        ->unless(empty($data['user_id']), function ($query) use ($data) {
                                            return $query->where('user_id', $data['user_id']);
                                        })
                                        ->unless(empty($data['identifier']), function ($query) use ($data) {
                                            return $query->where('identifier', $data['identifier']);
                                        })
                                        ->unless(empty($data['grandtotal']), function ($query) use ($data) {
                                            return $query->where('grandtotal', $data['grandtotal']);
                                        })
                                        ->unless(empty($data['grandtotal_min']), function ($query) use ($data) {
                                            return $query->where('grandtotal', '>=', $data['grandtotal_min']);
                                        })
                                        ->unless(empty($data['grandtotal_max']), function ($query) use ($data) {
                                            return $query->where('grandtotal', '<=', $data['grandtotal_max']);
                                        })
                                        ->unless(empty($data['subtotal']), function ($query) use ($data) {
                                            return $query->where('subtotal', $data['subtotal']);
                                        })
                                        ->unless(empty($data['subtotal_min']), function ($query) use ($data) {
                                            return $query->where('subtotal', '>=', $data['subtotal_min']);
                                        })
                                        ->unless(empty($data['subtotal_max']), function ($query) use ($data) {
                                            return $query->where('subtotal', '<=', $data['subtotal_max']);
                                        })
                                        ->unless(empty($data['review_user']), function ($query) use ($data) {
                                            return $query->whereHas('reviews', function($query) use ($data) {
                                                $query->ofCurrent()
                                                      ->where('user_id', $data['review_user']);
                                            });
                                        })
                                        ->unless(empty($data['state']), function ($query) use ($data) {
                                            return $query->whereHas('reviews', function($query) use ($data) {
                                                $query->ofCurrent()
                                                      ->where('state', $data['state']);
                                            });
                                        });
                              })
                            ->orderBy('updated_at', 'DESC')
                            ->get()
                            ->when(is_integer($page) && is_integer($nums), function ($query) use ($page, $nums) {
                                return $query->forPage($page, $nums);
                            });
        $list = [];
        foreach ($records as $record) {
            $data = $record->toArray();

            $obj = json_decode($record);
            $user_name = ($record->user_id) ? $record->user->name
                                            : $obj->addresses->contact->email;

            array_push($list,
                array_merge($data, [
                    'user'       => $user_name,
                    'state'      => $record->reviews->last()->state,
                    'stateText'  => $record->stateText(),
                    'stateNote'  => $record->reviews->last()->state_note,
                    'updated_at' => $record->reviews->last()->created_at
                ])
            );
        }

        return $list;
    }

    /**
     * @param Int    $id
     * @param String $code
     * @return Array
     */
    public function showById(Int $id, $code)
    {
        $order = $this->find($id);
        if (empty($order)) throw new NotFoundEntityException($id);

        return $this->show($order, $code);
    }

    /**
     * @param String $identifier
     * @param String $code
     * @return Array
     */
    public function showByIdentifier(String $identifier, $code)
    {
        $order = $this->findByIdentifier($identifier);
        if (empty($order)) throw new NotFoundEntityException($identifier);

        return $this->show($order, $code);
    }

    /**
     * @param Order   $order
     * @param String  $code
     * @param Boolean $customer
     * @return Array
     */
    public function show($order, $code, $customer = false)
    {
        $data = $customer ? $order->makeHidden(['host_type', 'host_id'])->toArray()
                          : $order->toArray();
        $data = array_merge($data, [
            'state'         => $order->reviews->last()->state,
            'stateText'     => $order->stateText(),
            'stateNote'     => $order->reviews->last()->state_note,
            'state_options' => $order->stateOptions($customer),
            'updated_at'    => $order->reviews->last()->created_at
        ]);

        $reviews = [];
        foreach ($order->reviews as $review) {
            array_push($reviews, [
                'id'            => $review->id,
                'user_id'       => $review->user_id,
                'state'         => $review->stateText(),
                'state_note'    => $review->state_note,
                'created_at'    => $review->created_at
            ]);
        }

        $profile = [];
        if ($order->user_id) {
            $contact = $order->user->addresses('contact')->first();
            $profile = [
                'name'     => $order->user->name,
                'email'    => $order->user->email,
                'language' => $order->user->profile->languageText(),
                'gender'   => $order->user->profile->genderText(),
                'contact'  => [
                    'phone'         => empty($contact) ? '' : $contact->phone,
                    'email'         => empty($contact) ? '' : $contact->email,
                    'area'          => empty($contact) ? '' : $contact->area,
                    'name'          => empty($contact) ? '' : $contact->name,
                    'address_line1' => empty($contact) ? '' : $contact->address_line1,
                    'address_line2' => empty($contact) ? '' : $contact->address_line2,
                    'guide'         => empty($contact) ? '' : $contact->guide
                ]
            ];
        }

        if (config('wk-mall-order.onoff.morph-comment')) {
            return array_merge($data, [
                'reviews'   => $reviews,
                'profile'   => $profile,
                'addresses' => $order->data['addresses'],
                'items'     => $order->data['items'],
                'comments'  => $this->getlistOfComments($order)
            ]);
        } else {
            return array_merge($data, [
                'reviews'   => $reviews,
                'profile'   => $profile,
                'addresses' => $order->data['addresses'],
                'items'     => $order->data['items']
            ]);
        }
    }

    /**
     * @param String $host_type
     * @param Int    $host_id
     * @param String $identifier
     * @param Int    $user_id
     * @param String $note
     * @param String $data
     * @param String $security_code
     * @return Entity
     */
    public function order(String $host_type, Int $host_id, String $identifier, $user_id, $note, String $data, String $security_code)
    {
        $obj = json_decode($data);

        return config('wk-core.class.mall-order.order')::create([
            'host_type'         => $host_type,
            'host_id'           => $host_id,
            'identifier'        => $identifier,
            'user_id'           => $user_id,
            'note'              => $note,
            'grandtotal'        => $obj->grandtotal,
            'subtotal'          => $obj->subtotal_discount,
            'fee'               => $obj->fee,
            'tax'               => $obj->tax,
            'tip'               => $obj->tip,
            'discount_coupon'   => $obj->discount_coupon,
            'discount_point'    => $obj->discount_point,
            'discount_shipment' => $obj->discount_shipment,
            'discount_custom'   => $obj->discount_custom,
            'data'              => $obj,
            'security_code'     => $security_code
        ]);
    }

    /**
     * @param Int    $order_id
     * @param String $state
     * @param String $state_note
     * @return Entity
     */
    public function createReview(Int $order_id, $user_id, String $state, $state_note = null)
    {
        return config('wk-core.class.mall-order.review')::create([
            'order_id'   => $order_id,
            'user_id'    => $user_id,
            'state'      => $state,
            'state_note' => $state_note
        ]);
    }
}
