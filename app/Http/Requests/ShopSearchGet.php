<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ShopSearchGet extends FormRequest
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
        $this->redirect = url('/shop');

        return [
            'keyword' => ['nullable', 'string','max:100'],
            'area' => ['nullable', 'string', 'max:100'],
            'limit' => ['nullable', 'integer', 'between:1,40'],
            // 'order' => ['nullable', 'string', Rule::in(['new', 'low_price', 'heigh_price', 'name'])],
        ];
    }
}
