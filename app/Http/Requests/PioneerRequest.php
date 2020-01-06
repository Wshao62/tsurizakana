<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PioneerRequest extends FormRequest
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
            'last_name' => ['required'],
            'first_name' => ['required'],
            'email' => ['required', 'email'],
            'shop_type' => ['required'],
            'shop_name' => ['required'],
            'tel' => ['required'],
        ];
    }
}
