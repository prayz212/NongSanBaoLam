<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RatingRequest extends FormRequest
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
            'productId' => ['required'],
            'billId' => ['required'],
            'rating' => ['required', 'integer', 'between:1,5'],
        ];
    }

    public function messages()
    {
        return [
            'productId.required' => 'Mã số sản phẩm là bắt buộc',
            'billId.required' => 'Mã số hoá đơn là bắt buộc',
            'rating.required' => 'Chỉ số đánh giá là bắt buộc',
            'rating.integer' => 'Chỉ số đánh giá bắt buộc là số',
            'rating.between' => 'Chỉ số đánh giá bắt buộc trong khoảng 1 đến 5',
        ];
    }
}
