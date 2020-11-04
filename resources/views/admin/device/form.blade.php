@extends('layouts.app')
@push('header-post-scripts')
    <link rel="stylesheet" href="{{ asset('css/bootstrap-iconpicker.min.css') }}"/>
@endpush

@section('content')
    <div class="row">
        <div class="col-md-6 offset-3">
            <div class="card mb-5">
                <div
                    class="card-header">{{ isset($device) ? __('Edit') : __('Create') }} {{ $room->name . ': ' .  __('Device') }}</div>
                <div class="card-body">
                    <form method="POST"
                          action="{{ isset($device) ? route('admin.devices.update', ['room_id' => $room->id, 'device' => $device]) : route('admin.devices.store', ['room_id' => $room->id]) }}">
                        @csrf
                        @isset($device)
                            @method('PUT')
                        @endisset
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label" for="type_id">{{ __('Type') }}</label>
                            <div class="col-sm-10">
                                <select name="type_id" id="type_id" class="form-control" required>
                                    <option></option>
                                    @foreach($types as $key => $value)
                                        <option
                                            value="{{ $key }}" {{ old('type_id', isset($device) ? $device->type_id : null) == $key ? 'selected' : '' }}>{{ $value }}</option>
                                    @endforeach
                                </select>
                                @error('type_id')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>


                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label" for="device_id">{{ __('Device ID') }}</label>
                            <div class="col-sm-10">
                                <input class="form-control" id="device_id" type="text"
                                       placeholder="{{ __('Device ID') }}"
                                       name="device_id" required
                                       value="{{ old('device_id', isset($device) ? $device->device_id : null) }}">
                                @error('device_id')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label" for="description">{{ __('Description') }}</label>
                            <div class="col-sm-10">
                                <input class="form-control" id="description" type="text"
                                       placeholder="{{ __('Description') }}"
                                       name="description"
                                       value="{{ old('description', isset($device) ? $device->description : null) }}">
                                @error('description')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{--                        TODO state--}}

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label"
                                   for="additional_information">{{ __('Additional') }}</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" id="additional_information" type="text"
                                          placeholder="{{ __('Additional') }}"
                                          name="additional_information">{{ old('additional_information', isset($device) ? $device->additional_information : null) }}</textarea>
                                @error('additional_information')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-sm-10">
                                <button class="btn btn-{{ isset($device) ? 'warning' : 'primary' }}"
                                        type="submit">{{ isset($device) ? __('Update') : __('Create') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script type="text/javascript" src="{{ asset('js/bootstrap-iconpicker.bundle.min.js') }}"></script>
@endpush
