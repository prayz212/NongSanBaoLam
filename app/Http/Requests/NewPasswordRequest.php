<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NewPasswordRequest extends FormRequest
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
            'oldPassword' => ['required', 'min:8'],
            'newPassword' => ['required', 'min:8'],
            'confirmPassword' => ['required', 'min:8', 'same:newPassword'],
        ];
    }

    public function messages()
    {
        return [
            'oldPassword.required' => 'Yêu cầu nhập mật khẩu cũ',
            'oldPassword.min' => 'Mật khẩu cũ phải có tối thiểu 8 ký tự',
            'newPassword.required' => 'Yêu cầu nhập mật khẩu mới',
            'newPassword.min' => 'Mật khẩu mới phải có tối thiểu 8 ký tự',
            'confirmPassword.required' => 'Yêu cầu nhập mật khẩu xác nhận',
            'confirmPassword.min' => 'Mật khẩu xác nhận phải có tối thiểu 8 ký tự',
            'confirmPassword.same' => 'Mật khẩu xác nhận không giống với mật khẩu mới',
        ];
    }
}
