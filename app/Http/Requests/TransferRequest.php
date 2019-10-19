<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TransferRequest extends FormRequest
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
            'user_id' => ['required'],
            'price' => ['required', 'min:1000', 'numeric'],
            'fee' => ['required'],
            // 'transfer_price' => ['required'],
        ];
    }

    public function attributes()
    {
        return [
            'price' => '振込申請額',
            'fee' => '手数料',
        ];
    }
}
