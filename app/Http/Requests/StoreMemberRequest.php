<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMemberRequest extends FormRequest
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
        $rules = [
            'name' => 'required|string|min:2|max:191',
            'email' => 'required|email|unique:members',
            'phone' => 'required|integer|regex:/^\+[1-9]\d{1,14}$/|unique:members',
            'balance' => 'nullable|numeric|min:0',
        ];

        if ($this->route('member')) {
            $rules['email'] .= ',email,' . $this->route('member')->id;
            $rules['phone'] .= ',phone,' . $this->route('member')->id;
        }

        return $rules;
    }
}
