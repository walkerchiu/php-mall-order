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
    public static function getStateSupported() {
        return config('wk-mall-order.state_supported');
    }

    public static function getCodes()
    {
        $items = [];
        $states = self::all();
        foreach ($states as $code=>$state) {
            array_push($items, $code);
        }

        return $items;
    }

    public static function all()
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

    public static function getDirections(String $state)
    {
        $state_supported = self::getCodes();

        $items = [$state];
        switch ($state) {
            case 'A':  $items = array_merge($items, ['B', 'Y']);               break;
            case 'B':  $items = array_merge($items, ['C1', 'C2', 'D2', 'Y']);  break;
            case 'C1': $items = array_merge($items, ['D1', 'D2']);             break;
            case 'C2': $items = array_merge($items, ['B']);                    break;
            case 'D1': $items = array_merge($items, ['D2', 'E1', 'E2', 'E3']); break;
            case 'D2': $items = array_merge($items, ['K', 'Y']);               break;
            case 'E1': $items = array_merge($items, ['D2', 'E2', 'E3', 'F']);  break;
            case 'E2': $items = array_merge($items, ['K']);                    break;
            case 'E3': $items = array_merge($items, ['D2', 'E1', 'E2']);       break;
            case 'F':  $items = array_merge($items, ['G']);                    break;
            case 'G':  $items = array_merge($items, ['H', 'Z']);               break;
            case 'H':  $items = array_merge($items, ['I']);                    break;
            case 'I':  $items = array_merge($items, ['J']);                    break;
            case 'J':  $items = array_merge($items, ['K']);                    break;
            case 'K':  $items = array_merge($items, ['L']);                    break;
            case 'L':  $items = array_merge($items, ['K', 'Z']);               break;
        }

        return array_intersect($state_supported, $items);
    }

    public static function findOptions(String $state, $onlyKey = false)
    {
        $state_supported = self::getCodes();

        $items = [$state];
        switch ($state) {
            case 'B':  $items = array_merge($items, ['C1', 'D2']);             break;
            case 'C1': $items = array_merge($items, ['D1', 'D2']);             break;
            case 'D1': $items = array_merge($items, ['D2', 'E1', 'E2', 'E3']); break;
            case 'D2': $items = array_merge($items, ['K']);                    break;
            case 'E1': $items = array_merge($items, ['D2', 'E2', 'F']);        break;
            case 'E2': $items = array_merge($items, ['K']);                    break;
            case 'E3': $items = array_merge($items, ['D2', 'E1', 'E2']);       break;
            case 'F':  $items = array_merge($items, ['G']);                    break;
            case 'G':  $items = array_merge($items, ['H', 'Z']);               break;
            case 'H':  $items = array_merge($items, ['I']);                    break;
            case 'I':  $items = array_merge($items, ['J']);                    break;
            case 'J':  $items = array_merge($items, ['K']);                    break;
            case 'K':  $items = array_merge($items, ['L']);                    break;
            case 'L':  $items = array_merge($items, ['K', 'Z']);               break;
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

    public static function findOptionsForCustomer(String $state, $onlyKey = false)
    {
        $state_supported = self::getCodes();

        $items = [$state];
        switch ($state) {
            case 'B':  $items = array_merge($items, ['D2']); break;
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
