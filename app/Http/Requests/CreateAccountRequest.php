<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateAccountRequest extends FormRequest
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
            'username' => ['required', 'min: 6', 'max: 55'],
            'fullname' => ['required'],
            'password' => ['required', 'min:8'],
            'phone' => ['required', 'digits:10'],
            'email' => ['required', 'max:255'],
            'address' => ['required']
        ];
    }

    public function messages()
    {
        return [
            'username.required' => 'Yêu cầu nhập tên tài khoản',
            'username.min' => 'Tên tài khoản phải có tối thiểu 6 ký tự',
            'username.max' => 'Tên tài khoản có tối đa 55 ký tự',
            'fullname.required' => 'Yêu cầu nhập họ tên',
            'phone.required' => 'Yêu cầu nhập số điện thoại',
            'email.required' => 'Yêu cầu nhập địa chỉ email',
            'address.required' => 'Yêu cầu nhập địa chỉ',
            'phone.digits' => 'Số điện thoại không hợp lệ',
            'email.max' => 'Email có tối đa 255 ký tự',
            'password.required' => 'Yêu cầu nhập mật khẩu',
            'password.min' => 'Mật khẩu phải có tối thiểu 8 ký tự',
        ];
    }
}
