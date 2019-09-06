<?php

namespace App\Http\Requests\Fish;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Fish;

class AddPost extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return \Auth::user()->isIdentified();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return Fish::validate();
    }
}
