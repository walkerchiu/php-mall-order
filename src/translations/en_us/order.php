<?php

return [

    /*
    |--------------------------------------------------------------------------
    | MallOrder: Order
    |--------------------------------------------------------------------------
    |
    */

    'header' => 'My Order',

    'id'            => '#',
    'host_type'     => 'Host Type',
    'host_id'       => 'Host ID',
    'channel_id'    => 'Channel ID',
    'identifier'    => 'Order Number',
    'note'          => 'Order Note',
    'note_placeholder' => 'For example, shipping information or other needs.',
    'data'          => 'Order Data',
    'security_code' => 'Security Code',

    'user'    => 'Orderer',
    'user_id' => 'User ID',

    'review_user' => 'Reviewer',
    'state'       => 'State',
    'state_note'  => 'State Note',

    'contact'   => 'Contact',
    'recipient' => 'Recipient',
    'bill'      => 'Bill',
    'invoice'   => 'Invoice',

    'list' => 'Order List',
    'edit' => 'Review Order',

    'item' => [
        'order_id' => 'Order ID',
        'stock_id' => 'Stock ID',
        'stock'    => 'Stock',
        'nums'     => 'Nums',
        'binding'  => 'Binding'
    ],
    'stock' => [
        'items'       => 'Item List',
        'stock'       => 'Stock',
        'product'     => 'Product',
        'sku'         => 'SKU',
        'name'        => 'Name',
        'abstract'    => 'abstract',
        'description' => 'description',
        'price'       => 'Price',
        'cost'        => 'Cost',
        'nums'        => 'Nums',
        'total'       => 'Total'
    ],
    'catalog' => [
        'serial'      => 'Serial',
        'name'        => 'Name',
        'description' => 'Description',
        'color'       => 'Color',
        'size'        => 'Size',
        'material'    => 'Material',
        'taste'       => 'Taste',
        'weight'      => 'Weight',
        'length'      => 'Length',
        'width'       => 'Width',
        'height'      => 'Height'
    ],

    'coupon' => [
        'name'        => 'Coupon',
        'placeholder' => 'Coupon Code',
        'tip'         => 'If you have a coupon, please apply it.',
        'apply'       => 'Apply'
    ],
    'point' => [
        'name'     => 'Reward Point',
        'tip'      => 'You can use your points to offset the cost.',
        'nums_now' => 'You have',
        'nums_use' => 'Want to use',
        'nums_get' => 'You will get',
        'apply'    => 'Apply'
    ],

    'expense_list' => 'Expense List',
    'subtotal' => 'Subtotal',
    'fee'      => 'Fee',
    'tax'      => 'Tax',
    'tip'      => 'Tip',
    'discount' => [
        'name'     => 'Discount',
        'coupon'   => 'Coupon Discount',
        'point'    => 'Point Discount',
        'shipment' => 'Shipment Discount',
        'custom'   => 'Custom Discount',
        'total'    => 'Total'
    ],
    'grandtotal' => 'Grand Total',
    'checkout'  => [
        'header'       => 'Checkout',
        'basic'        => 'Order Detail',
        'additional'   => 'Additional Information',
        'confirmation' => 'Order Confirmation',
        'warning'      => 'Your personal data will be used to process the order, your experience throughout this linksite, and for other purposes described in our privacy policy.',
        'agree'        => 'I have read and agree to the store terms and conditions.',
        'preview'      => 'Preview Order',
        'order'        => 'Place Order',
        'back'         => 'Back to Checkout',
        'confirm' => [
            'header' => 'Warning: Checkout Confirm!',
            'body'   => 'This order will be sent soon, please confirm the following information is correct again.'
        ],
        'complete' => [
            'header' => 'Tip: Order Completed!',
            'body'   => 'This order has been sent, please be patient. The goods you purchased will be picked and shipped as soon as possible after the order is confirmed.'
        ],
        'awaiting_pay' => [
            'header' => 'Tip: Awaiting Payment',
            'body'   => 'The order has been established, please pay as soon as possible. The goods you purchased will be picked and shipped after the order is confirmed.'
        ],
        'pay_error' => [
            'header' => 'Tip: Payment Error',
            'body'   => 'Payment failed, please confirm that the payment method you used is correct. We will also check whether the related functions are working properly.'
        ]
    ],
    'payment' => [
        'name'             => 'Payment Method',
        'tip'              => 'Please choose your preferred method.',
        'bill_to_other'    => 'Billing to mobile phones and landlines',
        'cash_on_delivery' => 'Cash on Delivery',
        'credit_card'      => 'Credit Card',
        'debit_card'       => 'Debit Card',
        'e_money'          => 'Electronic Money',
        'free'             => 'Free',
        'gift_card'        => 'Gift Card',
        'point'            => 'Point'
    ],
    'shipment' => [
        'name'             => 'Shipment Method',
        'tip'              => 'Please choose your preferred method.',
        'direct_shipping'  => 'Direct Shipping',
        'drop_shipping'    => 'Drop Shipping',
        'in_site_pickup'   => 'In-Store Pickup',
        'pickup_in_person' => 'Pick up in Person',
        'ship_to'          => 'Ship To',
        'send_to'          => 'Send To',
        'bill_to'          => 'Bill To',
        'invoice_to'       => 'Invoice To'
    ],
    'currency' => [
        'id'           => 'Currency ID',
        'abbreviation' => 'Currency Abbreviation'
    ],
    'invoice' => [
        'name'  => 'Invoice',
        'info'  => 'Invoice Information',
        'gui'   => 'Government Uniform Invoice',
        'gui_e' => 'e-Government Uniform Invoice'
    ],
    'detail' => [
        'header'   => 'Detail',
        'spread'   => 'Spread',
        'collapse' => 'Collapse'
    ],
    'button' => [
        'agree'           => 'Agree',
        'agree_change'    => 'Agree the Change',
        'agree_order'     => 'Agree the Order',
        'agree_request'   => 'Agree the Request',
        'cancel'          => 'Cancel',
        'cancel_change'   => 'Cancel the Change',
        'cancel_order'    => 'Cancel the Order',
        'cancel_request'  => 'Cancel the Request',
        'confirm'         => 'Confirm',
        'confirm_change'  => 'Confirm the Change',
        'confirm_order'   => 'Confirm the Order',
        'confirm_request' => 'Confirm the Request',
        'refund'          => 'Refund',
        'reject'          => 'Reject',
        'reject_change'   => 'Reject the Change',
        'reject_order'    => 'Reject the Order',
        'reject_request'  => 'Reject the Request',
        'reorder'         => 'Reorder',
        'return'          => 'Return',
        'return_order'    => 'Return the Order',
        'return_request'  => 'Return the Request'
    ],
    'free_return_within' => 'Free return within :num days',
    'can_return_within'  => 'Can be returned within :num days',



    'information' => [
        'header'  => 'Information',
        'basic'   => 'Basic info',
        'review'  => [
            'header'        => 'Review',
            'caption'       => 'Review Log',
            'state'         => 'State',
            'state_setting' => 'Status setting',
            'state_note'    => 'State Note',
        ]
    ],
    'items' => [
        'header'    => 'What items are in this order?',
        'stock'     => 'Product List',
        'promotion' => 'Applicable offers'
    ],
    'comments' => [
        'header'    => 'Note & Comments',
        'note'      => 'Note',
        'comment'   => 'Comments'
    ],
    'profile' => [
        'header'    => 'Orderer (Contact)',
        'basic'     => 'Profile',
        'contact'   => 'Contact'
    ],
    'addresses' => [
        'header'    => 'Addresses (Contact, Recipient, Bill, Invoice)',
        'contact'   => 'Contact',
        'recipient' => 'Recipient',
        'bill'      => 'Bill',
        'invoice'   => 'Invoice'
    ],

    'delete' => [
        'btn'    => 'Delete This Order',
        'header' => 'Delete Order',
        'body'   => 'Are you sure you want to delete this Order?'
    ]
];
