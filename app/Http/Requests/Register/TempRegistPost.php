<?php

namespace App\Http\Requests\Register;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\TempRegist;

class TempRegistPost extends FormRequest
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
        if (strpos(url()->previous(), '/register') === false) {
            $this->redirect = url()->previous() . '#registration_form';
        }
        return TempRegist::validate();
    }
}
