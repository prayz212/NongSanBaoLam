<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
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
            'id' => ['required'],
            'images.*'  => ['image', 'mimes:jpeg,jpg,png', 'max:5000'], //maximun: 5mb
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
            'id.required' => 'Mã sản phẩm là bắt buộc',
            'images.required' => 'Yêu cầu chọn hình ảnh sản phẩm',
            'images.*.max' => 'Ảnh sản phẩm có dung lượng tối đa 5Mb',
            'images.*.mimes' => 'Ảnh sản phẩm không hợp lệ',
            'name.required' => 'Yêu cầu nhập tên sản phẩm',
            'type.required' => 'Yêu cầu chọn thể loại sản phẩm',
            'price.required' => 'Yêu cầu nhập giá tiền sản phẩm',
            'description.required' => 'Yêu cầu nhập mô tả sản phẩm',
            'name.max' =>  'Tên sản phẩm có tối đa 255 ký tự',
            'price.numeric' => 'Giá sản phẩm không hợp lệ',
            'price.min' => 'Giá sản phẩm tối thiểu phải 1000',
            'discount.between' => 'Giá trị phải nằm trong khoảng từ 0 đến 100',
            'description.max' => 'Mô tả sản phẩm có tối đa 1000 ký tự',
        ];
    }
}
