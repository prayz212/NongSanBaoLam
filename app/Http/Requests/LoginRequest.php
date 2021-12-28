<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    protected $errorBag = 'login';
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
            'username' => ['required', 'max:55'],
            'password' => ['required', 'min:8']
        ];
    }

    public function messages()
    {
        return [
            'username.required' => 'Yêu cầu nhập tên tài khoản',
            'password.required' => 'Yêu cầu nhập mật khẩu',
            'username.max' => 'Tên tài khoản có tối đa 55 ký tự',
            'password.min' => 'Mật khẩu phải có tối thiểu 8 ký tự',
        ];
    }
}
