<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BankRequest extends FormRequest
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
            'bank_name' => ['required'],
            'bank_branch_code' => ['required'],
            'bank_number' => ['required'],
            'bank_user_name' => ['required'],
            'bank_type' => ['required'],
        ];
    }

    public function attributes()
    {
        return [
            'price' => '振込申請額',
            'fee' => '手数料',
        ];
    }

    protected function getRedirectUrl()
    {
        return url('/mypage/sales/application/get-bank');
    }
}
