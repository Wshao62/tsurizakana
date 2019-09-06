<?php

namespace App\Http\Requests\Fish;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Fish\Reject;

class RejectPost extends FormRequest
{
    protected $fish;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $this->fish = $this->route('fish');
        // 売主か買主で、キャンセルができること
        return ($this->fish->isOwner() || $this->fish->isBuyer()) && $this->fish->canCancelTransaction();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $this->redirect = url('/mypage/fish', $this->fish->id). '#mess_stop';
        return Reject::validate();
    }
}
