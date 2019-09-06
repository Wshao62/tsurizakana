<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\User\IdentificationDoc;
use Session;

class IdentificationPost extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return \Auth::check('user') && !\Auth::user()->isIdentified() && !\Auth::user()->isWaiting4Identification();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return IdentificationDoc::validate();
    }
}
