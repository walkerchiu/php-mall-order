<?php

return [

    /*
    |--------------------------------------------------------------------------
    | MallOrder: Order
    |--------------------------------------------------------------------------
    |
    */

    'header' => '我的訂單',

    'id'            => '#',
    'host_type'     => '母體種類',
    'host_id'       => '母體 ID',
    'channel_id'    => '管道 ID',
    'identifier'    => '訂單編號',
    'note'          => '訂單備註',
    'note_placeholder' => '例如運送資訊或其它的需求。',
    'data'          => '結帳資料',
    'security_code' => '安全碼',

    'user'    => '訂購人帳號',
    'user_id' => '使用者 ID',

    'review_user' => '提交者',
    'state'       => '目前狀態',
    'state_note'  => '狀態備註',

    'contact'   => '聯絡人',
    'recipient' => '收件者',
    'bill'      => '帳單',
    'invoice'   => '發票',

    'list' => '訂單清單',
    'edit' => '審視訂單',

    'item' => [
        'order_id' => '訂單 ID',
        'stock_id' => '庫存品 ID',
        'stock'    => '商品名稱',
        'nums'     => '數量',
        'binding'  => '綁定對象'
    ],
    'stock' => [
        'items'       => '訂購清單',
        'stock'       => '商品',
        'product'     => '商品',
        'sku'         => 'SKU',
        'name'        => '商品名稱',
        'abstract'    => '摘要',
        'description' => '描述',
        'price'       => '價格',
        'cost'        => '花費',
        'nums'        => '數量',
        'total'       => '小計'
    ],
    'catalog' => [
        'serial'      => '編號',
        'name'        => '商品名稱',
        'description' => '描述',
        'color'       => '顏色',
        'size'        => '尺寸',
        'material'    => '材質',
        'taste'       => '口味',
        'weight'      => '重量',
        'length'      => '長度',
        'width'       => '寬度',
        'height'      => '高度'
    ],

    'coupon' => [
        'name'        => '優惠券',
        'placeholder' => '優惠券代碼',
        'tip'         => '如果你有優惠券的話，可以在這裡輸入',
        'apply'       => '確認'
    ],
    'point' => [
        'name'     => '獎勵點數',
        'tip'      => '請輸入欲折抵的點數',
        'nums_now' => '擁有點數',
        'nums_use' => '欲使用點數',
        'nums_get' => '將獲得點數',
        'apply'    => '確認'
    ],

    'expense_list' => '購物車結算',
    'subtotal' => '小計',
    'fee'      => '手續費',
    'tax'      => '稅金',
    'tip'      => '小費',
    'discount' => [
        'name'     => '折扣資料',
        'coupon'   => '優惠券折抵',
        'point'    => '點數折抵',
        'shipment' => '運送優惠折抵',
        'custom'   => '其它優惠折抵',
        'total'    => '共折抵'
    ],
    'grandtotal' => '總計花費',
    'checkout'  => [
        'header'       => '結帳資訊',
        'basic'        => '訂單內容',
        'additional'   => '額外資訊',
        'confirmation' => '訂單確認',
        'warning'      => '您的資料將被用來處理這份訂單、改善您的使用體驗與其他規範在本站隱私政策裡的事項。',
        'agree'        => '我已閱讀並同意本站的隱私政策與使用規定。',
        'preview'      => '預覽訂單',
        'order'        => '送出訂單',
        'back'         => '重新結帳',
        'confirm' => [
            'header' => '警告：訂單送出確認',
            'body'   => '即將送出這份訂單，請再次確認以下資料是否正確無誤。'
        ],
        'complete' => [
            'header' => '提示：訂購完成',
            'body'   => '訂單已經被送出了，敬請耐心等候。您所購買的商品將在訂單被確認後盡速為您揀貨並寄出。'
        ],
        'awaiting_pay' => [
            'header' => '提示：尚未付款',
            'body'   => '訂單已經成立，敬請儘速付款。您所購買的商品將在訂單被確認後盡速為您揀貨並寄出。'
        ],
        'pay_error' => [
            'header' => '提示：付款過程發生錯誤',
            'body'   => '付款失敗，請確認您所使用的付款方式是否正確。我們也將檢查相關功能是否正常運作。'
        ]
    ],
    'payment' => [
        'name'             => '付款方式',
        'tip'              => '請選擇您想要的付款方式。',
        'bill_to_other'    => '帳單付款',
        'cash_on_delivery' => '貨到付款',
        'credit_card'      => '信用卡',
        'debit_card'       => '金融卡',
        'e_money'          => '電子貨幣',
        'free'             => '免費',
        'gift_card'        => '禮物卡',
        'point'            => '點數支付'
    ],
    'shipment' => [
        'name'             => '運送方式',
        'tip'              => '請選擇您想要的運送方式。',
        'direct_shipping'  => '直接寄送',
        'drop_shipping'    => '第三方運送',
        'in_site_pickup'   => '到店取貨',
        'pickup_in_person' => '親自取貨',
        'ship_to'          => '運送至',
        'send_to'          => '寄送至',
        'bill_to'          => '帳單送至',
        'invoice_to'       => '發票送至'
    ],
    'currency' => [
        'id'           => '貨幣 ID',
        'abbreviation' => '貨幣簡稱'
    ],
    'invoice' => [
        'name'  => '發票',
        'info'  => '發票資訊',
        'gui'   => '統一發票',
        'gui_e' => '電子發票'
    ],
    'detail' => [
        'header'   => '詳細資料',
        'spread'   => '展開',
        'collapse' => '收合'
    ],
    'button' => [
        'agree'           => '同意',
        'agree_change'    => '同意變更',
        'agree_order'     => '同意訂購',
        'agree_request'   => '同意要求',
        'cancel'          => '取消',
        'cancel_change'   => '取消變更',
        'cancel_order'    => '取消訂購',
        'cancel_request'  => '撤回要求',
        'confirm'         => '確認',
        'confirm_change'  => '確認變更',
        'confirm_order'   => '確認訂單',
        'confirm_request' => '確認要求',
        'refund'          => '退款',
        'reject'          => '拒絕',
        'reject_change'   => '拒絕變更',
        'reject_order'    => '拒絕訂單',
        'reject_request'  => '拒絕要求',
        'reorder'         => '再次訂購',
        'return'          => '退回',
        'return_order'    => '要求退貨',
        'return_request'  => '退回要求'
    ],
    'free_return_within' => '鑑賞期 :num 天',
    'can_return_within'  => ':num 天內可退貨',



    'information' => [
        'header'  => '訂單資訊',
        'basic'   => '基本資訊',
        'review'  => [
            'header'        => '處理訂單',
            'caption'       => '狀態歷程',
            'state'         => '狀態',
            'state_setting' => '狀態設定',
            'state_note'    => '狀態備註',
        ]
    ],
    'items' => [
        'header'    => '訂購內容',
        'stock'     => '訂購清單',
        'promotion' => '適用優惠'
    ],
    'comments' => [
        'header'    => '備註與問答',
        'note'      => '備註',
        'comment'   => '問答紀錄'
    ],
    'profile' => [
        'header'    => '訂購人資訊',
        'basic'     => '帳號資訊',
        'contact'   => '聯絡資訊'
    ],
    'addresses' => [
        'header'    => '寄送資訊',
        'contact'   => '聯絡資訊',
        'recipient' => '收件人資訊',
        'bill'      => '帳單資訊',
        'invoice'   => '發票資訊'
    ],

    'delete' => [
        'btn'    => '刪除訂單',
        'header' => '刪除訂單',
        'body'   => '確定要刪除這張訂單嗎？'
    ]
];
