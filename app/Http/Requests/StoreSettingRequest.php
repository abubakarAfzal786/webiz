<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSettingRequest extends FormRequest
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
            'key' => 'required|alpha_dash|max:191|unique:settings',
            'value' => 'nullable|max:191',
            'title' => 'nullable|string|max:191',
            'additional' => 'nullable|string',
        ];

        if ($this->route('setting')) {
            $rules['key'] .= ',key,' . $this->route('setting')->id;
        }

        return $rules;
    }
}
