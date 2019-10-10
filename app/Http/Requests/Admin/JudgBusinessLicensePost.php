<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class JudgBusinessLicensePost extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = $this->route('user');
        // ログイン必須
        return \Auth::check('admin') && $user->isWaiting4BusinessIdentification();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return \App\Models\User\BusinessLicenseDoc::judgeValidate();
    }
}
