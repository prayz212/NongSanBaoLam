<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class RegisterRequest extends FormRequest
{
    protected $errorBag = 'register';

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
            'username' => ['required', 'min:6', 'max:55'],
            'email' => ['required', 'email', 'max:255'],
            'password' => ['required', 'min:8']
        ];
    }

    public function messages()
    {
        return [
            'username.required' => 'Yêu cầu nhập tên tài khoản',
            'email.required' => 'Yêu cầu nhập địa chỉ email',
            'password.required' => 'Yêu cầu nhập mật khẩu',
            'email.email' => 'Địa chỉ email không hợp lệ',
            'username.min' => 'Tên tài khoản phải có tối thiểu 6 ký tự',
            'username.max' => 'Tên tài khoản có tối đa 55 ký tự',
            'password.min' => 'Mật khẩu phải có tối thiểu 8 ký tự',
        ];
    }
}
