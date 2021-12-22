<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CommentRequest extends FormRequest
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
            'name' => ['required', 'max:255'],
            'content' => ['required', 'max:255']
        ];
    }

    public function messages()
    {
        return [
            'id.required' => 'Id sản phẩm là bắt buộc',
            'name.required' => 'Yêu cầu nhập tên khách hàng',
            'name.max' => 'Tên khách hàng có tối đa 255 ký tự',
            'content.required' => 'Yêu cầu nhập nội dung bình luận',
            'content.max' => 'Nội dung bình luận có tối đa 255 ký tự',
        ];
    }
}
