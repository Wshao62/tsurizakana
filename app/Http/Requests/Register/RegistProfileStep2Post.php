<?php

namespace App\Http\Requests\Register;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\User;
use Session;

class RegistProfileStep2Post extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $token = $this->route('token');

        if (!Session::has('registering_user')
         || Session::get('registering_user')['token'] != $token
         || !Session::has('registering_profile_1')
         || empty(Session::get('registering_profile_1')['name'])) {
            return false;
        }
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $step = 2;
        return User::validate($step);
    }
}
