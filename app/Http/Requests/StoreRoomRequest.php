<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'type_id' => 'required|exists:room_types,id',
        ];

        return $rules;
    }
}
