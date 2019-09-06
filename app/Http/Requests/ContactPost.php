<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactPost extends FormRequest
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
    public function rules($is_required = "nullable")
    {
        $contact_required = "required";

        if (strpos(url()->previous(), '/seller') !== false
            || strpos(url()->previous(), '/buyer') !== false) {
            $this->redirect = url()->previous() . '#contact';
            $is_required = "required";
            $contact_required = "nullable";
        }

        return [
        'contact_type' => [$contact_required, 'string'],
        'name' => ['required', 'string', 'max:20'],
        'tel1' => [$is_required, 'numeric', 'digits_between:2,5'],
        'tel2' => [$is_required, 'numeric', 'digits_between:1,4'],
        'tel3' => [$is_required, 'numeric', 'digits_between:3,4'],
        'contact_email' => ['required', 'email', 'max:255', ],
        'description' => ['required', 'string', 'max:1000'],
        'form_company' => ['nullable', 'string', 'max:50'],
        'postal_code' => ['nullable', 'digits:7'],
        'prefect' => ['nullable', 'string', 'max:5'],
        'addr1' => ['nullable', 'string', 'max:100'],
        'addr2' => ['nullable', 'string', 'max:100'],
        'agreement' => [$contact_required, 'bool'],
        ];
    }
}
