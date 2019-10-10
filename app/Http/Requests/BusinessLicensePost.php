<?php

namespace App\Http\Requests;

use App\Models\User\BusinessLicenseDoc;
use Illuminate\Foundation\Http\FormRequest;
use Session;

class BusinessLicensePost extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return \Auth::check('user') && !\Auth::user()->isBusinessIdentified() && !\Auth::user()->isWaiting4BusinessIdentification();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return BusinessLicenseDoc::validate();
    }
}
