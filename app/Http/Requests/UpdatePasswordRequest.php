<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePasswordRequest extends FormRequest
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
            'password' => ['required', 'min:8'],
            'confirmPassword' => ['required', 'min:8', 'same:password'],
        ];
    }

    public function messages()
    {
        return [
            'password.required' => 'Yêu cầu nhập mật khẩu',
            'password.min' => 'Mật khẩu phải có tối thiểu 8 ký tự',
            'confirmPassword.required' => 'Yêu cầu nhập mật khẩu xác nhận',
            'confirmPassword.min' => 'Mật khẩu xác nhận phải có tối thiểu 8 ký tự',
            'confirmPassword.same' => 'Mật khẩu xác nhận không giống với mật khẩu',
        ];
    }
}
