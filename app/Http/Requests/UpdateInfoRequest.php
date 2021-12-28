<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateInfoRequest extends FormRequest
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
            'fullname' => ['required'],
            'phone' => ['required', 'digits:10'],
            'email' => ['required', 'max:255'],
            'address' => ['required']
        ];
    }

    public function messages()
    {
        return [
            'fullname.required' => 'Yêu cầu nhập họ tên',
            'phone.required' => 'Yêu cầu nhập số điện thoại',
            'email.required' => 'Yêu cầu nhập địa chỉ email',
            'address.required' => 'Yêu cầu nhập địa chỉ',
            'phone.digits' => 'Số điện thoại không hợp lệ',
            'email.max' => 'Email có tối đa 255 ký tự',
        ];
    }
}
