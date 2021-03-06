@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-6 offset-3">
            <div class="card mb-5">
                <div class="card-header">{{ isset($booking) ? __('Edit') : __('Create') }} {{ __('Booking') }}</div>
                <div class="card-body">
                    <form method="POST"
                          action="{{ isset($booking) ? route('admin.bookings.update', $booking) : route('admin.bookings.store') }}">
                        @csrf
                        @isset($booking)
                            @method('PUT')
                        @endisset

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label" for="room_id">{{ __('Room') }}</label>
                            <div class="col-sm-10">
                                <select name="room_id" id="room_id" class="form-control select2" required>
                                    <option></option>
                                    @foreach($rooms as $key => $value)
                                        <option
                                            value="{{ $key }}" {{ old('room_id', isset($booking) ? $booking->room_id : null) == $key ? 'selected' : '' }}>{{ $value }}</option>
                                    @endforeach
                                </select>
                                @error('room_id')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label" for="member_id">{{ __('Member') }}</label>
                            <div class="col-sm-10">
                                <select name="member_id" id="member_id" class="form-control select2" required>
                                    <option></option>
                                    @foreach($members as $key => $value)
                                        <option
                                            value="{{ $key }}" {{ old('member_id', isset($booking) ? $booking->member_id : null) == $key ? 'selected' : '' }}>{{ $value }}</option>
                                    @endforeach
                                </select>
                                @error('member_id')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label" for="status">{{ __('Status') }}</label>
                            <div class="col-sm-10">
                                <select name="status" id="status" class="form-control select2" required>
                                    <option value="10" {{ old('status', isset($booking->status) ? $booking->status : null) == 10 ? 'selected' : '' }}>{{ __('Pending') }}</option>
                                    <option value="20" {{ old('status', isset($booking->status) ? $booking->status : null) == 20 ? 'selected' : '' }}>{{ __('Active') }}</option>
                                    <option value="30" {{ old('status', isset($booking->status) ? $booking->status : null) == 30 ? 'selected' : '' }}>{{ __('Completed') }}</option>
                                    <option value="40" {{ old('status', isset($booking->status) ? $booking->status : null) == 40 ? 'selected' : '' }}>{{ __('Extended') }}</option>
                                    <option value="50" {{ old('status', isset($booking->status) ? $booking->status : null) == 50 ? 'selected' : '' }}>{{ __('Canceled') }}</option>

                                </select>
                                @error('status')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label" for="start_date">{{ __('Start Date') }}</label>
                            <div class="col-sm-10">
                                <input class="form-control" id="start_date" type="datetime-local" name="start_date"
                                       required
                                       value="{{ old('start_date', isset($booking) ? $booking->toDateTimeLocal('start_date', true) : null) }}">
                                @error('start_date')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label" for="end_date">{{ __('End Date') }}</label>
                            <div class="col-sm-10">
                                <input class="form-control" id="end_date" type="datetime-local" name="end_date"
                                       required
                                       value="{{ old('end_date', isset($booking) ? $booking->toDateTimeLocal('end_date', true) : null) }}">
                                @error('end_date')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <br>
                        <h5 class="text-center">Room Attributes</h5>
                        @foreach($roomAttributes as $roomAttribute)
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label"
                                       for="quantity[{{ $roomAttribute->id }}]">{{ $roomAttribute->name . ' (' . $roomAttribute->price . '/'. $roomAttribute->unit_name . ')' }}</label>
                                <div class="col-sm-10">
                                    <input class="form-control" id="quantity[{{ $roomAttribute->id }}]" type="number"
                                           name="quantity[{{ $roomAttribute->id }}]" min="0"
                                           value="{{ old('quantity.' . $roomAttribute->id, ($bookingAttributes[$roomAttribute->id] ?? 0)) }}">
                                    @error('quantity['.$roomAttribute->id.']')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        @endforeach

                        <div class="form-group row">
                            <div class="col-sm-10">
                                <button class="btn btn-{{ isset($booking) ? 'warning' : 'primary' }}"
                                        type="submit">{{ isset($booking) ? __('Update') : __('Create') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function () {
            $('.form-control.select2').select2({
                placeholder: "Select an option",
                allowClear: true,
            });
        });
    </script>
@endpush
