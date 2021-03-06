<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property mixed status
 */
class StoreRoomRequest extends FormRequest
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
            'price' => 'required|numeric|min:0',
            'seats' => 'required|integer|min:0',
            'overview' => 'required|string|min:2',
            'facilities' => 'array',
            'facilities.*' => 'exists:room_facilities,id',
            'location' => 'required|string|min:2|max:191',
            'lat' => 'nullable',
            'lon' => 'nullable',
            'status' => 'nullable',
            'images' => 'array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:3072',
            'type_id' => 'required|exists:room_types,id',
            'wifi_ssid' => 'nullable|string|min:2|max:191',
            'wifi_pass' => 'nullable|string|min:2|max:191',
            'number' => 'nullable|integer|min:0',
            'monthly' => 'nullable',
            'company_id' => 'required_with:monthly|exists:companies,id',
        ];

        return $rules;
    }
}
