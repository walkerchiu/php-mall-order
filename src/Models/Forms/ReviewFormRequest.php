<?php

namespace WalkerChiu\MallOrder\Models\Forms;

use Illuminate\Support\Facades\Request;
use Illuminate\Validation\Rule;
use WalkerChiu\Core\Models\Forms\FormRequest;

class ReviewFormRequest extends FormRequest
{
    /**
     * @Override Illuminate\Foundation\Http\FormRequest::getValidatorInstance
     */
    protected function getValidatorInstance()
    {
        $request = Request::instance();
        $data = $this->all();
        if (
            (!isset($data['order_id']) || empty($data['order_id']))
            && isset($request->id)
        ) {
            $data['order_id'] = (string) $request->id;
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
            'order_id'   => trans('php-mall-order::order.item.order_id'),
            'user_id'    => trans('php-mall-order::order.review_user'),
            'state'      => trans('php-mall-order::order.state'),
            'state_note' => trans('php-mall-order::order.state_note')
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return Array
     */
    public function rules()
    {
        $data = $this->all();
        if (isset($data['order_id'])) {
            $state = config('wk-core.class.mall-order.review')::where('order_id', $data['order_id'])
                        ->orderBy('id', 'DESC')
                        ->first()
                        ->state;
            $options = config('wk-core.class.mall-order.orderState')::findOptions($state, true);

            $rules = [
                'order_id'   => ['required','string','exists:'.config('wk-core.table.mall-order.orders').',id'],
                'user_id'    => ['nullable','string','exists:'.config('wk-core.table.user').',id'],
                'state'      => ['required', Rule::in($options)],
                'state_note' => '',
            ];

            if ($data['state'] == $state) {
                $rules['state_note'] = 'required|string|min:2';
            }

            return $rules;
        } else {
            $rules = [
                'order_id'   => ['required','string','exists:'.config('wk-core.table.mall-order.orders').',id'],
                'user_id'    => ['nullable','string','exists:'.config('wk-core.table.user').',id'],
                'state'      => ['required'],
                'state_note' => '',
            ];

            return $rules;
        }
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return Array
     */
    public function messages()
    {
        return [
            'order_id.required'   => trans('php-core::validation.required'),
            'order_id.integer'    => trans('php-core::validation.integer'),
            'order_id.min'        => trans('php-core::validation.min'),
            'order_id.exists'     => trans('php-core::validation.exists'),
            'user_id.integer'     => trans('php-core::validation.integer'),
            'user_id.min'         => trans('php-core::validation.min'),
            'user_id.exists'      => trans('php-core::validation.exists'),
            'state.required'      => trans('php-core::validation.required'),
            'state.max'           => trans('php-core::validation.in'),
            'state_note.required' => trans('php-core::validation.required'),
            'state_note.string'   => trans('php-core::validation.string'),
            'state_note.min'      => trans('php-core::validation.min')
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
    }
}
