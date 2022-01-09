<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PaymentRequest extends FormRequest
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
            'email' => ['required', 'max:255'],
            'address' => ['required'],
            'phone' => ['required', 'digits:10'],
            'paymentType' => ['required'],
            // 'cardNumber' => 'required_if:paymentType,==,CreditCard|integer',
            // 'validDate' => 'required_if:paymentType,==,CreditCard|integer',
            // 'secretNumber' => 'required_if:paymentType,==,CreditCard|integer',
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
            'paymentType.required' => 'Yêu cầu chọn phương thức thanh toán',
            'cardNumber.required' => 'Yêu cầu nhập số thẻ',
            'validDate.required' => 'Yêu cầu nhập thời gian hết hạn',
            'secretNumber.required' => 'Yêu cầu nhập mã số bí mật',
            'cardNumber.digits' => 'Số thẻ không hợp lệ',
            'validDate.after' => 'Thời gian hết hạn không hợp lệ',
            'secretNumber.digits' => 'Mã số bí mật không hợp lệ',
        ];
    }

    protected function getValidatorInstance() {
        $validator = parent::getValidatorInstance();
        $validator->sometimes('cardNumber', 'required|digits:16', function($input) {
            return $input->paymentType == 'CreditCard';
        });

        $validator->sometimes('validDate', 'required|after:today', function($input) {
            return $input->paymentType == 'CreditCard';
        });

        $validator->sometimes('secretNumber', 'required|digits:3', function($input) {
            return $input->paymentType == 'CreditCard';
        });
        return $validator;
    }
}
