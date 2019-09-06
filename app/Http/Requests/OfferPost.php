<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OfferPost extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // ログイン必須
        return \Auth::check('user');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'message' => ['required', 'string', 'max:1000'],
            'fish_id' => ['required', 'array'],
            'fish_id.*' => ['required', 'integer', 'min:1', 'exists:fish,id'],
        ];
    }
}
