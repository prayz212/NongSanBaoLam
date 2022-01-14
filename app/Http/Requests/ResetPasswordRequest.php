<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ResetPasswordRequest extends FormRequest
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
            'email' => ['required', 'max: 255']
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'Yêu cầu nhập địa chỉ email',
            'email.max' => 'Email có tối đa 255 ký tự',
        ];
    }
}
