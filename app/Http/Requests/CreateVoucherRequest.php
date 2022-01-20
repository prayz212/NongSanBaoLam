<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateVoucherRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'code' => ['required'],
            'discount' => ['required', 'numeric', 'min:1000'],
            'start_at' => ['required'],
            'end_at' => ['required'],
            'quantity' => ['required', 'numeric', 'between:1,10000'],
        ];
    }

    public function messages()
    {
        return [
            'code.required' => 'Yêu cầu nhập mã voucher',
            'discount.required' => 'Yêu cầu nhập chiết khấu',
            'discount.numeric' => 'Chiết khấu phải là số',
            'discount.min' => 'Chiết khấu tối thiểu phải là 1000 đồng',
            'start_at.required' => 'Yêu cầu chọn ngày bắt đầu',
            'end_at.required' => 'Yêu cầu chọn ngày bắt đầu',
            'quantity.required' => 'Yêu cầu số lượng voucher',
            'quantity.numeric' => 'Số lượng voucher phải là số',
            'quantity.between' => 'Số lượng voucher phải nằm trong khoảng 1-10000',
        ];
    }
}
