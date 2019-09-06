<?php

namespace App\Http\Requests\Fish;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SearchGet extends FormRequest
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
        $this->redirect = url('/fish');

        return [
            'keyword' => ['nullable', 'string','max:100'],
            'user_id' => ['nullable', 'integer', 'min:1'],
            'category_id' => ['nullable', 'integer', 'min:1'],
            'area' => ['nullable', 'string', 'max:100'],
            'limit' => ['nullable', 'integer', 'between:1,40'],
            'order' => ['nullable', 'string', Rule::in(['new', 'low_price', 'heigh_price', 'name'])],
            'is_open' => ['nullable', 'bool'],
        ];
    }
}
