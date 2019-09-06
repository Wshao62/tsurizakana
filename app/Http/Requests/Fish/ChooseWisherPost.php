<?php

namespace App\Http\Requests\Fish;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Fish;

class ChooseWisherPost extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $fish = $this->route('fish');
        // ログイン必須かつ、該当の売魚が公開ステータスであること、該当売魚の販売主であること
        return (\Auth::check('user') && $fish->isPublish() && $fish->isOwner());
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'wisher_id' => ['required', 'int', 'min:1'],
        ];
    }
}
