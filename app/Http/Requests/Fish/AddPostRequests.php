<?php

namespace App\Http\Requests\Fish;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\FishRequests;

class AddPostRequests extends FormRequest
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
        return FishRequests::validate();
    }
}
