<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateProductRequest extends FormRequest
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
            'images' => ['required'],
            'images.*'  => ['image', 'mimes:jpeg,jpg,png'],
            'name' => ['required', 'max:255'],
            'type' => ['required'],
            'price' => ['required', 'numeric', 'min:1000'],
            'discount' => ['numeric', 'between:0,100'],
            'description' => ['required', 'max: 1000'],
        ];
    }

    public function messages()
    {
        return [
            'images.required' => 'Yêu cầu chọn hình ảnh sản phẩm',
            'images.*.mimes' => 'Ảnh sản phẩm không hợp lệ',
            'name.required' => 'Yêu cầu nhập tên sản phẩm',
            'type.required' => 'Yêu cầu chọn thể loại sản phẩm',
            'price.required' => 'Yêu cầu nhập giá tiền sản phẩm',
            'description.required' => 'Yêu cầu nhập mô tả sản phẩm',
            'name.max' =>  'Tên sản phẩm có tối đa 255 ký tự',
            'price.numeric' => 'Giá sản phẩm không hợp lệ',
            'price.min' => 'Giá sản phẩm tối thiểu phải 1000',
            'discount.numeric' => 'Chiết khẩu không hợp lệ',
            'discount.between' => 'Giá trị phải nằm trong khoảng từ 0 đến 100',
            'description.max' => 'Mô tả sản phẩm có tối đa 1000 ký tự',
        ];
    }
}
