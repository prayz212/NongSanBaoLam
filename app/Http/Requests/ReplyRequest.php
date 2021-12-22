<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReplyRequest extends FormRequest
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
            'product_id' => ['required'],
            'comment_id' => ['required'],
            'content' => ['required', 'max:255']
        ];
    }

    public function messages()
    {
        return [
            'product_id.required' => 'Id bình luận là bắt buộc',
            'comment_id.required' => 'Id bình luận là bắt buộc',
            'content.required' => 'Yêu cầu nhập nội dung bình luận',
            'content.max' => 'Nội dung bình luận có tối đa 255 ký tự',
        ];
    }
}
