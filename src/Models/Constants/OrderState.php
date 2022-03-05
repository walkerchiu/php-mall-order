<?php

namespace WalkerChiu\MallOrder\Models\Constants;

/**
 * @license MIT
 * @package WalkerChiu\MallOrder
 *
 *
 */

class OrderState
{
    /**
     * @return Array
     */
    public static function getStateSupported(): array
    {
        return config('wk-mall-order.state_supported');
    }

    /**
     * @return Array
     */
    public static function getCodes(): array
    {
        $items = [];
        $states = self::all();
        foreach ($states as $code => $state) {
            array_push($items, $code);
        }

        return $items;
    }

    /**
     * @return Array
     */
    public static function all(): array
    {
        $state_all = [
            'A'  => 'submitting',
            'B'  => 'awaiting_payment',
            'C1' => 'payment_accepted',
            'C2' => 'payment_error',
            'D1' => 'preparing',
            'D2' => 'cancel',
            'E1' => 'picked',
            'E2' => 'reject',
            'E3' => 'backorder',
            'F'  => 'shipping',
            'G'  => 'delivered',
            'H'  => 'return',
            'I'  => 'confirming',
            'J'  => 'confirmed',
            'K'  => 'refund',
            'L'  => 'refunded',
            'Y'  => 'abort',
            'Z'  => 'finished'
        ];
        $state_supported = self::getStateSupported();

        $data = [];
        foreach ($state_supported as $state) {
            $data = array_merge($data, [
                $state => $state_all[$state]
            ]);
        }
        return $data;
    }

    /**
     * @param String  $state
     * @return Array
     */
    public static function getDirections(string $state): array
    {
        $state_supported = self::getCodes();

        $items = [$state];
        switch ($state) {
            case 'A':
                $items = array_merge($items, ['B', 'Y']);
                break;
            case 'B':
                $items = array_merge($items, ['C1', 'C2', 'D2', 'Y']);
                break;
            case 'C1':
                $items = array_merge($items, ['D1', 'D2']);
                break;
            case 'C2':
                $items = array_merge($items, ['B']);
                break;
            case 'D1':
                $items = array_merge($items, ['D2', 'E1', 'E2', 'E3']);
                break;
            case 'D2':
                $items = array_merge($items, ['K', 'Y']);
                break;
            case 'E1':
                $items = array_merge($items, ['D2', 'E2', 'E3', 'F']);
                break;
            case 'E2':
                $items = array_merge($items, ['K']);
                break;
            case 'E3':
                $items = array_merge($items, ['D2', 'E1', 'E2']);
                break;
            case 'F':
                $items = array_merge($items, ['G']);
                break;
            case 'G':
                $items = array_merge($items, ['H', 'Z']);
                break;
            case 'H':
                $items = array_merge($items, ['I']);
                break;
            case 'I':
                $items = array_merge($items, ['J']);
                break;
            case 'J':
                $items = array_merge($items, ['K']);
                break;
            case 'K':
                $items = array_merge($items, ['L']);
                break;
            case 'L':
                $items = array_merge($items, ['K', 'Z']);
                break;
        }

        return array_intersect($state_supported, $items);
    }

    /**
     * @param String  $state
     * @param Bool    $onlyKey
     * @return Array
     */
    public static function findOptions(string $state, $onlyKey = false): array
    {
        $state_supported = self::getCodes();

        $items = [$state];
        switch ($state) {
            case 'B':
                $items = array_merge($items, ['C1', 'D2']);
                break;
            case 'C1':
                $items = array_merge($items, ['D1', 'D2']);
                break;
            case 'D1':
                $items = array_merge($items, ['D2', 'E1', 'E2', 'E3']);
                break;
            case 'D2':
                $items = array_merge($items, ['K']);
                break;
            case 'E1':
                $items = array_merge($items, ['D2', 'E2', 'F']);
                break;
            case 'E2':
                $items = array_merge($items, ['K']);
                break;
            case 'E3':
                $items = array_merge($items, ['D2', 'E1', 'E2']);
                break;
            case 'F':
                $items = array_merge($items, ['G']);
                break;
            case 'G':
                $items = array_merge($items, ['H', 'Z']);
                break;
            case 'H':
                $items = array_merge($items, ['I']);
                break;
            case 'I':
                $items = array_merge($items, ['J']);
                break;
            case 'J':
                $items = array_merge($items, ['K']);
                break;
            case 'K':
                $items = array_merge($items, ['L']);
                break;
            case 'L':
                $items = array_merge($items, ['K', 'Z']);
                break;
        }

        $items = array_intersect($state_supported, $items);

        if ($onlyKey)
            return $items;

        $list = [];
        foreach ($items as $item) {
            $list = array_merge($list, [
                $item => trans('php-mall-order::state.'.$item).
                         trans('php-core::punctuation.parentheses.BLR', ['value' => $item])
            ]);
        }

        return $list;
    }

    /**
     * @param String  $state
     * @param Bool    $onlyKey
     * @return Array
     */
    public static function findOptionsForCustomer(string $state, $onlyKey = false): array
    {
        $state_supported = self::getCodes();

        $items = [$state];
        switch ($state) {
            case 'B':
                $items = array_merge($items, ['D2']);
                break;
        }

        $items = array_intersect($state_supported, $items);

        if ($onlyKey)
            return $items;

        $list = [];
        foreach ($items as $item) {
            $list = array_merge($list, [
                $item => trans('php-mall-order::state.'.$item)
            ]);
        }

        return $list;
    }
}
