<?php

namespace App\Http\Requests;

use App\Models\Booking;
use Illuminate\Foundation\Http\FormRequest;

class StoreBookingRequest extends FormRequest
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
            'room_id' => 'required|exists:rooms,id',
            'member_id' => 'required|exists:members,id',
            'start_date' => 'required|date_format:' . Booking::DATE_TIME_LOCAL,
            'end_date' => 'required|date_format:' . Booking::DATE_TIME_LOCAL . '|after:start_date',
            'price' => 'nullable|numeric',
            'status' => 'nullable|in:' . implode(',', array_keys(Booking::listStatuses())),
        ];
    }
}
