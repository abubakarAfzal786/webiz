<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDeviceRequest extends FormRequest
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
        return [
            'type_id' => 'required|exists:device_types,id',
            'device_id' => 'required|string|max:191',
            'description' => 'nullable|string|max:191',
//            'state' => 'nullable|integer',
            'additional_information' => 'nullable|string',
        ];
    }
}
