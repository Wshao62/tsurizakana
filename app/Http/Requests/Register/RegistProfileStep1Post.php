<?php

namespace App\Http\Requests\Register;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\TempRegist;
use App\Models\User;
use Session;
use Illuminate\Http\Request;

class RegistProfileStep1Post extends FormRequest
{

    public $user;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $token = $this->route('token');

        if (!Session::has('registering_user')
         || Session::get('registering_user')['token'] != $token) {
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
        $step = 1;
        if (Request::isMethod('get')
         && Session::has('registering_profile_1')) {
            // Step2のエラーからの戻りの場合
            return [];
        }
        return User::validate($step);
    }
}
