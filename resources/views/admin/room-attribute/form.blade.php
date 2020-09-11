@extends('layouts.app')
@push('header-post-scripts')
    <link rel="stylesheet" href="{{ asset('css/bootstrap-iconpicker.min.css') }}"/>
@endpush

@section('content')
    <div class="row">
        <div class="col-md-6 offset-3">
            <div class="card mb-5">
                <div
                    class="card-header">{{ isset($member) ? __('Edit') : __('Create') }} {{ __('Room Attribute') }}</div>
                <div class="card-body">
                    <form method="POST"
                          action="{{ isset($roomAttribute) ? route('admin.room-attribute.update', $roomAttribute) : route('admin.room-attribute.store') }}">
                        @csrf
                        @isset($roomAttribute)
                            @method('PUT')
                        @endisset
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label" for="name">{{ __('Name') }}</label>
                            <div class="col-sm-10">
                                <input class="form-control" id="name" type="text" placeholder="{{ __('Name') }}"
                                       name="name" required
                                       value="{{ old('name', isset($roomAttribute) ? $roomAttribute->name : null) }}">
                                @error('name')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label" for="unit">{{ __('Unit') }}</label>
                            <div class="col-sm-10">
                                <select name="unit" id="unit" class="form-control" required>
                                    <option></option>
                                    @foreach(\App\Models\RoomAttribute::listUnits() as $key => $value)
                                        <option
                                            value="{{ $key }}" {{ old('unit', isset($roomAttribute) ? $roomAttribute->unit : null) == $key ? 'selected' : '' }}>{{ $value }}</option>
                                    @endforeach
                                </select>
                                @error('unit')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label" for="price">{{ __('Price') }}</label>
                            <div class="col-sm-10">
                                <input class="form-control" id="price" type="number" min="0" step="0.1"
                                       placeholder="{{ __('Price') }}" name="price"
                                       value="{{ old('price', isset($roomAttribute) ? $roomAttribute->price : 0) }}">
                                @error('price')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-sm-10">
                                <button class="btn btn-{{ isset($roomAttribute) ? 'warning' : 'primary' }}"
                                        type="submit">{{ isset($roomAttribute) ? __('Update') : __('Create') }}</button>
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
