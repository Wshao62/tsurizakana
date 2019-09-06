<?php

namespace App\Http\Requests\Fish;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Order;

class BuyPost extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $fish = $this->route('fish');
        return $fish->canOrder();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return Order::validate();
    }
}
