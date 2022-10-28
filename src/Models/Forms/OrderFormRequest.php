<?php

namespace WalkerChiu\MallOrder\Models\Forms;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Illuminate\Validation\Rule;
use WalkerChiu\Core\Models\Forms\FormRequest;

class OrderFormRequest extends FormRequest
{
    /**
     * @Override Illuminate\Foundation\Http\FormRequest::getValidatorInstance
     */
    protected function getValidatorInstance()
    {
        $request = Request::instance();
        $data = $this->all();
        if (
            $request->isMethod('put')
            && empty($data['id'])
            && isset($request->id)
        ) {
            $data['id'] = (string) $request->id;
            $this->getInputSource()->replace($data);
        }
        if (
            $request->isMethod('put')
            && empty($data['identifier'])
            && isset($request->identifier)
        ) {
            $data['identifier'] = $request->identifier;
            $this->getInputSource()->replace($data);
        }

        return parent::getValidatorInstance();
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return Array
     */
    public function attributes()
    {
        return [
            'host_type'  => trans('php-mall-order::order.host_type'),
            'host_id'    => trans('php-mall-order::order.host_id'),
            'channel_id' => trans('php-mall-order::order.channel_id'),

            'note' => trans('php-mall-order::order.note'),

            'coupon' => trans('php-mall-order::order.coupon'),
            'point'  => trans('php-mall-order::order.point'),

            'data'          => trans('php-mall-order::order.data'),
            'security_code' => trans('php-mall-order::order.security_code'),

            'contact_phone'         => trans('php-morph-address::system.phone'),
            'contact_email'         => trans('php-morph-address::system.email'),
            'contact_area'          => trans('php-morph-address::system.area'),
            'contact_name'          => trans('php-morph-address::system.name'),
            'contact_address_line1' => trans('php-morph-address::system.address_line1'),
            'contact_address_line2' => trans('php-morph-address::system.address_line2'),
            'contact_guide'         => trans('php-morph-address::system.guide'),

            'recipient_phone'         => trans('php-morph-address::system.phone'),
            'recipient_email'         => trans('php-morph-address::system.email'),
            'recipient_area'          => trans('php-morph-address::system.area'),
            'recipient_name'          => trans('php-morph-address::system.name'),
            'recipient_address_line1' => trans('php-morph-address::system.address_line1'),
            'recipient_address_line2' => trans('php-morph-address::system.address_line2'),
            'recipient_guide'         => trans('php-morph-address::system.guide'),

            'bill_phone'         => trans('php-morph-address::system.phone'),
            'bill_email'         => trans('php-morph-address::system.email'),
            'bill_area'          => trans('php-morph-address::system.area'),
            'bill_name'          => trans('php-morph-address::system.name'),
            'bill_address_line1' => trans('php-morph-address::system.address_line1'),
            'bill_address_line2' => trans('php-morph-address::system.address_line2'),
            'bill_guide'         => trans('php-morph-address::system.guide'),

            'invoice_phone'         => trans('php-morph-address::system.phone'),
            'invoice_email'         => trans('php-morph-address::system.email'),
            'invoice_area'          => trans('php-morph-address::system.area'),
            'invoice_name'          => trans('php-morph-address::system.name'),
            'invoice_address_line1' => trans('php-morph-address::system.address_line1'),
            'invoice_address_line2' => trans('php-morph-address::system.address_line2'),
            'invoice_guide'         => trans('php-morph-address::system.guide'),

            'payment'               => trans('php-mall-order::order.payment.name'),
            'shipment'              => trans('php-mall-order::order.shipment.name'),
            'currency_id'           => trans('php-mall-order::order.currency.id'),
            'currency_abbreviation' => trans('php-mall-order::order.currency.abbreviation')
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return Array
     */
    public function rules()
    {
        $rules = [
            'host_type'  => 'required_with:host_id|string',
            'host_id'    => 'required_with:host_type|string',
            'channel_id' => 'required|string',
            'user_id'    => ['required_without_all:contact_area,recipient_area,bill_area,invoice_area','string','exists:'.config('wk-core.table.user').',id'],

            'note' => '',

            'coupon' => 'nullable|string',
            'point'  => 'nullable|numeric|min:0|not_in:0',

            'data'          => 'required|string',
            'security_code' => 'required|string',

            'contact_phone'         => '',
            'contact_email'         => 'email',
            'contact_area'          => ['required_with:contact_name', Rule::in(config('wk-core.class.core.countryZone')::getCodes())],
            'contact_name'          => 'required_with:contact_address_line1|string|max:255',
            'contact_address_line1' => 'required_with:contact_name|string|max:255',
            'contact_address_line2' => 'nullable|string|max:255',
            'contact_guide'         => 'nullable|string|max:255',

            'recipient_phone'         => '',
            'recipient_email'         => 'nullable|email',
            'recipient_area'          => ['required_with:recipient_name', Rule::in(config('wk-core.class.core.countryZone')::getCodes())],
            'recipient_name'          => 'required_with:recipient_address_line1|string|max:255',
            'recipient_address_line1' => 'required_with:recipient_name|string|max:255',
            'recipient_address_line2' => 'nullable|string|max:255',
            'recipient_guide'         => 'nullable|string|max:255',

            'bill_phone'         => '',
            'bill_email'         => 'nullable|email',
            'bill_area'          => ['nullable','required_with:bill_name', Rule::in(config('wk-core.class.core.countryZone')::getCodes())],
            'bill_name'          => 'nullable|required_with:bill_address_line1|max:255',
            'bill_address_line1' => 'nullable|required_with:bill_name|max:255',
            'bill_address_line2' => '',
            'bill_guide'         => '',

            'invoice_phone'         => '',
            'invoice_email'         => 'nullable|email',
            'invoice_area'          => ['nullable','required_with:invoice_name', Rule::in(config('wk-core.class.core.countryZone')::getCodes())],
            'invoice_name'          => 'nullable|required_with:invoice_address_line1|max:255',
            'invoice_address_line1' => 'nullable|required_with:invoice_name|max:255',
            'invoice_address_line2' => '',
            'invoice_guide'         => '',

            'payment'  => '',
            'shipment' => '',
            'currency_id'           => '',
            'currency_abbreviation' => 'required'
        ];

        if (config('wk-mall-order.onoff.point')) {
            $rules = array_merge($rules, [
            ]);
        }

        $request = Request::instance();
        if (
            $request->isMethod('put')
            && isset($request->id)
        ) {
            $rules = array_merge($rules, ['id' => ['required','string','exists:'.config('wk-core.table.mall-order.orders').',id']]);
        }
        if (
            $request->isMethod('put')
            && isset($request->identifier)
        ) {
            $rules = array_merge($rules, ['identifier' => ['required','exists:'.config('wk-core.table.mall-order.orders').',identifier']]);
        }

        return $rules;
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return Array
     */
    public function messages()
    {
        return [
            'id.required'              => trans('php-core::validation.required'),
            'id.string'                => trans('php-core::validation.string'),
            'id.exists'                => trans('php-core::validation.exists'),
            'host_type.required_with'  => trans('php-core::validation.required_with'),
            'host_type.string'         => trans('php-core::validation.string'),
            'host_id.required_with'    => trans('php-core::validation.required_with'),
            'host_id.string'           => trans('php-core::validation.string'),
            'host_id.min'              => trans('php-core::validation.min'),
            'channel_id.required'      => trans('php-core::validation.required'),
            'channel_id.string'        => trans('php-core::validation.string'),
            'user_id.required_without' => trans('php-core::validation.required_without'),
            'user_id.string'           => trans('php-core::validation.string'),
            'user_id.exists'           => trans('php-core::validation.exists'),

            'coupon.string' => trans('php-core::validation.string'),
            'point.numeric' => trans('php-core::validation.numeric'),
            'point.min'     => trans('php-core::validation.min'),
            'point.not_in'  => trans('php-core::validation.not_in'),

            'data.required'          => trans('php-core::validation.required'),
            'data.string'            => trans('php-core::validation.string'),
            'security_code.required' => trans('php-core::validation.required'),
            'security_code.string'   => trans('php-core::validation.string'),

            'contact_email.email'                 => trans('php-core::validation.email'),
            'contact_area.required_with'          => trans('php-core::validation.required_with'),
            'contact_area.in'                     => trans('php-core::validation.in'),
            'contact_name.required_with'          => trans('php-core::validation.required_with'),
            'contact_name.string'                 => trans('php-core::validation.string'),
            'contact_name.max'                    => trans('php-core::validation.max'),
            'contact_address_line1.required_with' => trans('php-core::validation.required_with'),
            'contact_address_line1.string'        => trans('php-core::validation.string'),
            'contact_address_line1.max'           => trans('php-core::validation.max'),
            'contact_address_line2.string'        => trans('php-core::validation.string'),
            'contact_address_line2.max'           => trans('php-core::validation.max'),
            'contact_guide.string'                => trans('php-core::validation.string'),
            'contact_guide.max'                   => trans('php-core::validation.max'),

            'recipient_email.email'                 => trans('php-core::validation.email'),
            'recipient_area.required_with'          => trans('php-core::validation.required_with'),
            'recipient_area.in'                     => trans('php-core::validation.in'),
            'recipient_name.required_with'          => trans('php-core::validation.required_with'),
            'recipient_name.string'                 => trans('php-core::validation.string'),
            'recipient_name.max'                    => trans('php-core::validation.max'),
            'recipient_address_line1.required_with' => trans('php-core::validation.required_with'),
            'recipient_address_line1.string'        => trans('php-core::validation.string'),
            'recipient_address_line1.max'           => trans('php-core::validation.max'),
            'recipient_address_line2.string'        => trans('php-core::validation.string'),
            'recipient_address_line2.max'           => trans('php-core::validation.max'),
            'recipient_guide.string'                => trans('php-core::validation.string'),
            'recipient_guide.max'                   => trans('php-core::validation.max'),

            'bill_email.email'                 => trans('php-core::validation.email'),
            'bill_area.required_with'          => trans('php-core::validation.required_with'),
            'bill_area.in'                     => trans('php-core::validation.in'),
            'bill_name.required_with'          => trans('php-core::validation.required_with'),
            'bill_name.max'                    => trans('php-core::validation.max'),
            'bill_address_line1.required_with' => trans('php-core::validation.required_with'),
            'bill_address_line1.max'           => trans('php-core::validation.max'),

            'invoice_email.email'                 => trans('php-core::validation.email'),
            'invoice_area.required_with'          => trans('php-core::validation.required_with'),
            'invoice_area.in'                     => trans('php-core::validation.in'),
            'invoice_name.required_with'          => trans('php-core::validation.required_with'),
            'invoice_name.max'                    => trans('php-core::validation.max'),
            'invoice_address_line1.required_with' => trans('php-core::validation.required_with'),
            'invoice_address_line1.max'           => trans('php-core::validation.max'),

            'currency_abbreviation.required'      => trans('php-core::validation.required')
        ];
    }

    /**
     * Configure the validator instance.
     *
     * @param \Illuminate\Validation\Validator  $validator
     * @return void
     */
    public function withValidator($validator)
    {
        if ( !empty(config('wk-core.class.site-mall.site')) ) {
            $validator->after( function ($validator) {
                $data = $validator->getData();
                if (
                    isset($data['host_type'])
                    && isset($data['host_id'])
                ) {
                    if (
                        config('wk-mall-order.onoff.site-mall')
                        && !empty(config('wk-core.class.site-mall.site'))
                        && $data['host_type'] == config('wk-core.class.site-mall.site')
                    ) {
                        $result = DB::table(config('wk-core.table.site-mall.sites'))
                                    ->where('is_enabled', 1)
                                    ->where('id', $data['host_id'])
                                    ->exists();
                        if (!$result)
                            $validator->errors()->add('host_id', trans('php-core::validation.exists'));

                    }
                }
                if (isset($data['channel_id'])) {
                    if (
                        config('wk-mall-order.onoff.mall-cart')
                        && !empty(config('wk-core.class.mall-cart.channel'))
                    ) {
                        $result = config('wk-core.class.mall-cart.channel')
                                     ::where('is_enabled', 1)
                                     ->where('id', $data['channel_id'])
                                     ->exists();
                        if (!$result)
                            $validator->errors()->add('channel_id', trans('php-core::validation.exists'));

                    }
                }
                if (isset($data['identifier'])) {
                    $result = config('wk-core.class.mall-order.order')::where('identifier', $data['identifier'])
                                    ->when(isset($data['host_type']), function ($query) use ($data) {
                                        return $query->where('host_type', $data['host_type']);
                                      })
                                    ->when(isset($data['host_id']), function ($query) use ($data) {
                                        return $query->where('host_id', $data['host_id']);
                                      })
                                    ->when(isset($data['id']), function ($query) use ($data) {
                                        return $query->where('id', '<>', $data['id']);
                                      })
                                    ->exists();
                    if ($result)
                        $validator->errors()->add('identifier', trans('php-core::validation.unique', ['attribute' => trans('php-mall-order::order.identifier')]));
                }
                if (isset($data['data'])) {
                    $obj = json_decode($data['data']);
                    if (
                        $obj->grandtotal < 0
                        || $obj->subtotal_discount < 0
                        || $obj->fee < 0
                        || $obj->tax < 0
                        || $obj->tip < 0
                    ) {
                        $validator->errors()->add('data', trans('php-core::validation.not_allowed'));
                    } elseif (
                        $obj->discount_coupon > 0
                        || $obj->discount_point > 0
                    ) {
                        $validator->errors()->add('data', trans('php-core::validation.not_allowed'));
                    }

                    $map = [];
                    foreach ($obj->items as $items) {
                        foreach ($items as $item) {
                            $map[$item->stock->id] = $item->nums;
                            if (empty($item->binding))
                                continue;
                            foreach ($item->binding as $binding) {
                                $binding = is_string($binding) ? json_decode($binding) : $binding;

                                if (!isset($map[$binding->stock_id])) {
                                    $map[$binding->stock_id] = $binding->nums;
                                } else {
                                    $map[$binding->stock_id] += $binding->nums;
                                }
                            }
                        }
                        break;
                    }

                    foreach ($map as $key => $value) {
                        $stock = config('wk-core.class.mall-shelf.stock')
                                    ::where('is_sellable', 1)
                                    ->where('is_enabled', 1)
                                    ->where('id', $key)
                                    ->first();
                        if ($stock) {
                            if (!is_null($stock->quantity)) {
                                if ($stock->quantity < $value)
                                    $validator->errors()->add('data', trans('php-mall-order::validation.insufficient_available_inventory'));
                                elseif ($stock->quantity - $value < 0)
                                    $validator->errors()->add('data', trans('php-mall-order::validation.insufficient_available_inventory'));
                            }
                        } else {
                            $validator->errors()->add('data', trans('php-mall-order::validation.insufficient_available_inventory'));
                        }
                    }
                }
            });
        }
    }
}
