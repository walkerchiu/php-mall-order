<?php

/**
 * @license MIT
 * @package WalkerChiu\MallOrder
 */

return [

    /*
    |--------------------------------------------------------------------------
    | Switch association of package to On or Off
    |--------------------------------------------------------------------------
    |
    | When you set someone On:
    |     1. Its Foreign Key Constraints will be created together with data table.
    |     2. You may need to change the corresponding class settings in the config/wk-core.php.
    |
    | When you set someone Off:
    |     1. Association check will not be performed on FormRequest and Observer.
    |     2. Cleaner and Initializer will not handle tasks related to it.
    |
    | Note:
    |     The association still exists, which means you can still access related objects.
    |
    */
    'onoff' => [
        'coupon'        => 0,
        'mall-shelf'    => 0,
        'morph-comment' => 0,
        'point'         => 0,
        'site'          => 0
    ],

    /*
    |--------------------------------------------------------------------------
    | Output Data Format from Repository
    |--------------------------------------------------------------------------
    |
    | null:                  Query.
    | query:                 Query.
    | collection:            Query collection.
    | collection_pagination: Query collection with pagination.
    | array:                 Array.
    | array_pagination:      Array with pagination.
    |
    */
    'output_format' => null,

    /*
    |--------------------------------------------------------------------------
    | Pagination
    |--------------------------------------------------------------------------
    |
    */
    'pagination' => [
        'pageName' => 'page',
        'perPage'  => 15
    ],

    /*
    |--------------------------------------------------------------------------
    | Soft Delete
    |--------------------------------------------------------------------------
    |
    | 0: Disable.
    | 1: Enable.
    |
    */
    'soft_delete' => 1,

    /*
    |--------------------------------------------------------------------------
    | Command
    |--------------------------------------------------------------------------
    |
    | Location of Commands.
    |
    */
    'command' => [
        'cleaner' => 'WalkerChiu\MallOrder\Console\Commands\MallOrderCleaner'
    ],

    /*
    |--------------------------------------------------------------------------
    | Unsigned Decimal
    |--------------------------------------------------------------------------
    |
    | A precision (total digits) and scale (decimal digits).
    |
    */
    'unsigned_decimal' => [
        'precision' => 20,
        'scale'     => 2
    ],

    /*
    |--------------------------------------------------------------------------
    | State supported
    |--------------------------------------------------------------------------
    |
    */
    'state_supported' => [
        'A', 'B',
        'C1', 'C2', 'D1', 'D2', 'E1', 'E2', 'E3',
        'F', 'G', 'H', 'I', 'J', 'K', 'L',
        'Y', 'Z'
    ]
];
